<?php 
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) Octorber 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;

require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');

require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';
if( !defined('PhpThumbFactoryLoaded') ) {
	require_once dirname(__FILE__).DS.'libs'.DS.'phpthumb/ThumbLib.inc.php';
	define('PhpThumbFactoryLoaded',1);
}
require_once(JPATH_SITE.DS.  "components" . DS . "com_k2" .DS.'models'.DS.'itemlist.php' );
abstract class modLofK2News {
	/**
	 * @var static string $regex;
	 */
	static $regex = "#<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>#iU";	
	
	static $AID = '';
	
	static $CACHE_IMAGE_PATH;
	/**
	 * get list k2 items
	 */
	public static function getList( $params, $categories, $totalItems=0 ){
		$my 	       = &JFactory::getUser();
		self::$AID	       = $my->get( 'aid', 0 );
		self::setCacheImagePath('mod_lofk2news2');
		// if the cache option is enabed ?
		if ( $params->get('enable_cache') ) {
			$cache =& JFactory::getCache( 'mod_lofk2news2' );
			$cache->setCaching( true );
			$cache->setLifeTime( $params->get( 'cache_time', 30 ) * 60 );	
			return $cache->get( array(  'modLofK2News' , '_getList' ), array( $params,$categories, $totalItems) ); 
		} else {
			return self::_getList( $params, $categories, $totalItems );
		}		
	}
		
	/**
	 *
	 */
	public function setCacheImagePath( $moduleName ){
		
		self::$CACHE_IMAGE_PATH['path'] = JPATH_CACHE.DS.$moduleName; 
		self::$CACHE_IMAGE_PATH['uri'] = 'cache/'.$moduleName.'/';
		if( !is_dir(self::$CACHE_IMAGE_PATH['path'] )){
			JFolder::create( self::$CACHE_IMAGE_PATH['path'], 0755 );
		}
	}
	/**
	 * get Category information by ID
	 */
	public static function  getCategoriesInfo( $ids ){
	 	$db = JFactory::getDBO();
		$query = "SELECT * FROM #__k2_categories WHERE id IN ('".implode("','",$ids)."') and published=1 ";
		$db->setQuery( $query );
		$data = $db->loadObjectList();
		$output = array();
		foreach( $data as $category ){
			$output[$category->id]=$category;
		}
 
		return $output;
	}
	
	/**
	 * get list of subcategories by id
	 */
	public static function getListCategories( $id ){
		
		
		$model = new K2ModelItemlist();
		$ordering = '';
		
		if( method_exists( $model, "getCategoryFirstChildren") ){
			$data =  $model->getCategoryFirstChildren($id, $ordering);		
		} else {
			$data =  $model->getCategoryFirstChilds($id, $ordering);	
		}
		$ids = array($id);
		if( $data ){
			foreach( $data as $item ){
				$ids[] = (int)$item->id;
			}
		}
		$data['ids'] = $ids;// implode(',',$ids);
		return $data;
	}
	
	/**
	 * check K2 Existed ?
	 */
	public static function isK2Existed(){
		return is_file( JPATH_SITE.DS.  "components" . DS . "com_k2" . DS . "k2.php" );	
	}
	
	/**
	 * get the list of k2 items
	 * 
	 * @param JParameter $params;
	 * @return Array
	 */
	public static function _getList( $params, $categories, $totalItems ){
		global $mainframe;
		$maxTitle  	   = $params->get( 'max_title', '100' );
		$maxDesciption = $params->get( 'max_description', 100 );
		$openTarget    = $params->get( 'open_target', 'parent' );
		$formatter     = $params->get( 'style_displaying', 'title' );
		$titleMaxChars = $params->get( 'title_max_chars', '100' );
		$ordering      = $params->get( 'ordering', 'created_asc');
		$ordering      = str_replace( '-', '  ', $ordering );
		$aid= self::$AID;
		
			$user = &JFactory::getUser();	
		$limit = $totalItems;
		$db	    = &JFactory::getDBO();
		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		require_once ( JPath::clean(JPATH_SITE.'/components/com_k2/helpers/route.php') );
		$query = "SELECT a.*, cr.rating_sum/cr.rating_count as rating, c.name as categoryname,
						c.id as categoryid, c.alias as categoryalias, c.params as categoryparams, cc.commentcount as commentcount".
				" FROM #__k2_items as a".
					" LEFT JOIN #__k2_categories c ON c.id = a.catid" .
					" LEFT JOIN #__k2_rating as cr ON a.id = cr.itemid".
					" LEFT JOIN (select cm.itemid  as id, count(cm.id) as commentcount from #__k2_comments as cm
																where cm.published=1 group by cm.itemid) as cc on a.id = cc.id";
			
		$query .= " WHERE a.published = 1"
					. " AND a.access IN(".implode(',', $user->authorisedLevels()).") "
					. " AND a.trash = 0"
					. " AND c.published = 1"
					. " AND c.access IN(".implode(',', $user->authorisedLevels()).") "
					. " AND c.trash = 0 " ;	
		 $query .= " AND ( a.publish_up = ".$db->Quote($nullDate)." OR a.publish_up <= ".$db->Quote($now)." )";
		$query .= " AND ( a.publish_down = ".$db->Quote($nullDate)." OR a.publish_down >= ".$db->Quote($now)." )";		
			
			
		if( $params->get('show_featured','0') == 0 ){
			$query.= " AND a.featured != 1";
		} elseif(  $params->get('show_featured','0') == 2 ) {
			$query.= " AND a.featured = 1";
		}
		$condition = ' AND  a.catid IN( '.implode(",",$categories ).' )';
	 	 
		$query .=  $condition . ' ORDER BY ' . $ordering;	
		$query .=  $limit ? ' LIMIT ' . $limit : '';
		
		
		$db->setQuery($query);
		$data = $db->loadObjectlist();
 
		if( empty($data) ) return array();
		
		return $data;
	}
	
	/**
	 * get Icon's Class.
	 */
	public static  function getIcon( $item ){
		if( $item->featured ){return 'lof-icon-featured';}
		if( time()-strtotime($item->created) < 24 * 3600 ){  return 'lof-icon-news';}
		if( time()-strtotime($item->modified) < 24 * 3600 ){  return 'lof-icon-updated';}
		return '';
	}
	
	
	/**
	 * looking for image inside the media folder.
	 */
	public static function lookingForK2Image( &$item, $size='XL' ){
		//Image
		$item->imageK2Image='';
		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_'.$size.'.jpg'))
			$item->imageK2Image = JURI::root().'media/k2/items/cache/'.md5("Image".$item->id).'_'.$size.'.jpg';
		return $item; 
	}
	
	
	/**
	 * build condition query base parameter  
	 * 
	 * @param JParameter $params;
	 * @return string.
	 */
	public static  function buildConditionQuery( $params ){
		$source = trim($params->get( 'source', 'k2category' ) );
		if( $source == 'k2category' ){
			$catids = $params->get( 'category','');
			
			if( !$catids ){
				return '';
			}
			$catids = !is_array($catids) ? $catids : '"'.implode('","',$catids).'"';
			$condition = ' AND  a.catid IN( '.$catids.' )';
		} else {
			$ids = preg_split('/,/',$params->get( 'article_ids',''));	
			$tmp = array();
			foreach( $ids as $id ){
				$tmp[] = (int) trim($id);
			}
			$condition = " AND a.id IN('". implode( "','", $tmp ) ."')";
		}
		return $condition;
	}
	
	/**
	 * parser a custom tag in the content of article to get the image setting.
	 * 
	 * @param string $text
	 * @return array if maching.
	 */
	public static function parserCustomTag( $text ){ 
		if( preg_match("#{loftag(.*)}#s", $text, $matches, PREG_OFFSET_CAPTURE) ){ 
			return $matches;
		}	
		return null;
	}
	
 
	
	/**
	 *  check the folder is existed, if not make a directory and set permission is 755
	 *
	 *
	 * @param array $path
	 * @access public,
	 * @return boolean.
	 */
	public static function renderThumb( $path, $width=100, $height=100, $title='', $isThumb=true ){
		if( !preg_match("/.jpg|.png|.gif/",strtolower($path)) ) return  $path;
		$path = str_replace( JURI::base(), '', $path );
		if( $isThumb ){
			$imagSource = JPATH_SITE.DS. str_replace( '/', DS,  $path );
			if( file_exists($imagSource)  ) {
				$tmp = explode("/",$path);
				$imageName = $tmp[count($tmp)-1];
				$path =  $width."x".$height."_".$imageName;
				$thumbPath = self::$CACHE_IMAGE_PATH['path'].DS. str_replace( '/', DS,  $path );

				if( !file_exists($thumbPath) ) {
					$thumb = PhpThumbFactory::create( $imagSource  );  	
					$thumb->adaptiveResize( $width, $height );				
					$thumb->save( $thumbPath  );
				}
				$path = JURI::base().self::$CACHE_IMAGE_PATH['uri'].$path;
			} 
		}
		return $path;
	}
	
	/**
	 * get parameters from configuration string.
	 *
	 * @param string $string;
	 * @return array.
	 */
	public static function parseParams( $string ) {
		$string = html_entity_decode($string, ENT_QUOTES);
		$regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
		 $params = null;
		 if(preg_match_all($regex, $string, $matches) ){
				for ($i=0;$i<count($matches[1]);$i++){ 
				  $key 	 = $matches[1][$i];
				  $value = $matches[3][$i]?$matches[3][$i]:($matches[4][$i]?$matches[4][$i]:$matches[5][$i]);
				  $params[$key] = $value;
				}
		  }
		  return $params;
	}
	
	/**
	 * parser a image in the content of article.
	 *
	 * @param poiter $row .
	 * @return void
	 */
	public static function lookUpImages( $row ){
		$text =  $row->introtext.$row->fulltext;
		$data = self::parserCustomTag( $text );
		if( isset($data[1][0]) ){
			$tmp 			= self::parseParams( $data[1][0] );
			$row->mainImage = isset($tmp['main']) ? $tmp['main']:'';
			$row->thumbnail = isset($tmp['thumb']) ?$tmp['thumb']: $row->mainImage;
			$row->link 		= isset($tmp['link']) ?$tmp['link']: $row->link;
		} else {
			$row  = self::lookingForK2Image( $row );
			
			if( $row->imageK2Image != '' ){
				$row->thumbnail = $row->mainImage = $row->imageK2Image;	
				return $row;
			}
			preg_match ( self::$regex, $text, $matches); 
			$images = (count($matches)) ? $matches : array();
			if (count($images)){
				$row->mainImage = $images[1];
				$row->thumbnail = $images[1];
			} else {
				$row->thumbnail = '';
				$row->mainImage = '';	
			}
		}
		return $row;
	}
	
	/**
	 * get image tag.
	 */
	public function getImage( $item, $imageWidth, $imageHeight, $isThumb=true ){
		$item = self::lookUpImages( $item );
		if( $item->mainImage ){
			$path =  self::renderThumb( $item->mainImage, $imageWidth, $imageHeight, $item->title, $isThumb );
			return '<img src="'.$path.'" title="'.$item->title.'" width="'.$imageWidth.'" alt="'.$item->title.'" />';
		}
	}
	
	/**
	 * call back function for processing data before render
	 */
	public static function onBeforeRender( $item,  $descriptionMaxChars=100, $limitDescriptionBy='char', $isAuthor=false ){

		//Read more link
		$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
	 		
		$item->date = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); 
		if( $limitDescriptionBy=='word' ){
			$string 		   = preg_replace( "/\s+/", " ", strip_tags($item->introtext) );
			$tmp 			   = explode(" ", $string);
			$item->description = $descriptionMaxChars>count($tmp)?$string:implode(" ",array_slice($tmp, 0, $descriptionMaxChars));
		} else {
			$item->description = self::substring( $item->introtext, $descriptionMaxChars );	
		}
		$item->rating = (is_numeric($item->rating))?floatval($item->rating / 5 * 100):null;
		$item->categoryLink = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->categoryalias))));
		$item->authorLink = JRoute::_(K2HelperRoute::getUserRoute($item->created_by));
		if( $isAuthor ){
			if (! empty($item->created_by_alias)) {
				$item->author = $item->created_by_alias;
			} else {
				$author = &JFactory::getUser($item->created_by);
				$item->author = $author->name;
			}
		}
		return $item;
	}
	
	/**
	 * Load Modules Joomla By position's name
	 */
	public static function loadModulesByPosition( $position='' ){
		$modules = JModuleHelper::getModules( $position );
		if( $modules ) {
			$document = &JFactory::getDocument();
			$renderer = $document->loadRenderer('module');
			$output='';
			foreach( $modules  as $module ){
				$output .= '<div class="lof-module">'.$renderer->render( $module, array('style' => 'raw') ).'</div>';
			}
			return $output;
		}
		return ;
	}
	
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module ){
		$mainframe = JFactory::getApplication();
		// if the verion is equal 1.6.x
		if(file_exists(JPATH_BASE.DS.'templates/'.$mainframe->getTemplate().'/css/'.$module->module.'.css')){
			JHTML::stylesheet(  $module->module.'.css','templates/'.$template.'/css/' );
		}else {
			JHTML::stylesheet(  'style.css','modules/'.$module->module.'/assets/' );
		}
	}
	
	/**
	 * get a subtring with the max length setting.
	 * 
	 * @param string $text;
	 * @param int $length limit characters showing;
	 * @param string $replacer;
	 * @return tring;
	 */
	public function substring( $text, $length = 100, $isStripedTags=true,  $replacer='...' ){
		$string = $isStripedTags? strip_tags( $text ):$text;
		return JString::strlen( $string ) > $length ? JString::substr( $string, 0, $length ).$replacer: $string;
	}
}
?>