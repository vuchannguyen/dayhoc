<?php
/**
 * $ModDesc
 * 
 * @version   $Id: $file.php $Revision
 * @package   modules
 * @subpackage  $Subpackage.
 * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
 /**
  * LofDataSourceBase Class
  */	
 if( !class_exists("LofDataSourceBase") ) { 
	 abstract class LofDataSourceBase{
		/**
		 * @var string $_thumbnailPath
		 * 
		 * @access protected;
		 */
		var $_thumbnailPath = "";
		
		/**
		 * @var string $_thumbnailURL;
		 * 
		 * @access protected;
		 */
		var $_thumbnaiURL = "";
		
		var $_imagesRendered = array( 'thumbnail'=>array(),'mainImage'=>array() );
		/**
		 * Set folder's path and url of thumbnail folder
		 * 
		 */
		function setThumbPathInfo( $path, $url ){
			$this->_thumbnailPath=$path;
			$this->_thumbnaiURL =$url;
			return $this;
		}
		
		public function setImagesRendered( $name=array() ){
			$this->_imagesRendered = $name;
			return $this;
		}
		/**
		 * parser a custom tag in the content of article to get the image setting.
		 * 
		 * @param string $text
		 * @return array if maching.
		 */
		public static function parserCustomTag( $text ){ 
			if( preg_match("#{lofimg(.*)}#s", $text, $matches, PREG_OFFSET_CAPTURE) ){ 
				return $matches;
			}	
			return null;
		}
		
		public function generateImages( $item, $isThumb = true ){
			$item = self::parseImages( $item ); 
			foreach($this->_imagesRendered as $key => $value ){ // echo '<pre>'.print_r($this->_imagesRendered,1);die;
				if( $item->{$key} &&  $image=$this->renderThumb($item->{$key}, $value[0], $value[1], $item->title, $isThumb) ){
					$item->{$key} = $image;
				}
			}
			return $item;
		}
		/**
		 *  check the folder is existed, if not make a directory and set permission is 755
		 *
		 * @param array $path
		 * @access public,
		 * @return boolean.
		 */
		public function renderThumb( $path, $width=100, $height=100, $title='', $isThumb=true ){
	
			$path = str_replace( JURI::base(), '', $path );
			$imagSource = JPATH_SITE.DS. str_replace( '/', DS,  $path );
			if( file_exists($imagSource)  ) {
				if(!$isThumb){ return 	JURI::base().$path;  }
				$tmp = explode("/", $path);
				$imageName = $width."x".$height."-".$tmp[count($tmp)-1];
				$thumbPath = $this->_thumbnailPath.$imageName;
				if( !file_exists($thumbPath) ) {	
					$thumb = PhpThumbFactory::create( $imagSource  );  		
					$thumb->adaptiveResize( $width, $height);
					$thumb->save( $thumbPath  ); 
				} 
				$path = $this->_thumbnaiURL.$imageName;
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
		 * @param.
		 * @return
		 */
		public static function parseImages( $row ){
			$row->images = json_decode( $row->images );
			if( isset($row->images->image_fulltext) && isset($row->images->image_intro) ){
				$row->thumbnail = $row->images->image_intro;
				$row->mainImage = $row->images->image_fulltext;	
				if( empty($row->images->image_fulltext) ){
					$row->mainImage = $row->images->image_intro;
				} 
				if( empty($row->images->image_intro) ){
					$row->thumbnail = $row->images->image_fulltext;	
				}
			}
			if( empty($row->thumbnail) &&   empty($row->mainImage) ){
				$text =  $row->introtext;
				$regex = "/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/";
				preg_match ($regex, $text, $matches); 
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
		 * Get a subtring with the max length setting.
		 * 
		 * @param string $text;
		 * @param int $length limit characters showing;
		 * @param string $replacer;
		 * @return tring;
		 */
		public static function substring( $text, $length = 100, $replacer='...', $isStriped=true ){
			$string = $isStriped ? strip_tags( $text ) : $text;
			return JString::strlen( $string ) > $length ?  JHtml::_('string.truncate', $string, $length ): $string;
		}
	}
}
?>