<?php 
/*------------------------------------------------------------------------
 # Leo Template Framework - 
 # ------------------------------------------------------------------------
 # author    LeoTheme
 # copyright Copyright (C) 2010 leotheme.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.leotheme.com
 # Technical Support:  Forum - http://www.leotheme.com/forum.html
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * LeoTemplateHelper Class
 */
class LeoTemplateHelper {
	
	/**
	 * @var $_currentTemplate is stored current actived Template
	 *
	 * @access protected
	 */
	 
	var $_currentTemplate = '';
	
	/**
	 * @var $_userParams is stored User Params setting
	 *
	 * @access protected;
	 */
	var $_userParams 	= null;
	
	/**
	 * @var $_fwPath is store real path of Leo Framework plugin
	 *
	 * @access protected
	 */
	var $_fwPath 	  = '';
	
	/**
	 * @var $_templatePath is real path of Current Template
	 *
	 * @access protected
	 */
	var $_templatePath = '';
	
	/**
	 * @var $_templatePath is real path of Current Template
	 *
	 * @access protected
	 */
	var $_templateName = '';
	
	/**
	 * @var $_templateURI is stored URI base of Current Template
	 *
	 * @access protected
	 */
	var $_templateURI = '';
	
	/**
	 * @var $_baseURI is URI calling via JURI::base()
	 *
	 * @access protected
	 */
	 
	var $_baseURI  	  = '';
	
	var $language = '';
	
	var $_customCss = array();
	var $_siteCss  = array();
	var $_siteJS = array();
	/**
	 * Constructor
	 */
	function __construct( $template, $customParams=null ){
	 	
		
		$this->_baseURI	      =  JURI::base();
		$this->objTemplate    =  $template;
		$this->_templateName  =  $template->template;
		$this->language 	  = $template->language;
		$this->_templateURI   =  $this->_baseURI . "templates/" . $template->template."/";
  		$this->_templatePath   =  JPATH_SITE.DS . "templates".DS.$template->template.DS;
		$this->_fwPath 		  =  JPATH_SITE.DS."plugins".DS."system".DS."leofw".DS;
		
		$this->initUserParams();
	}
	
	/**
	 * Get A Instance Of LeoTemplateHelper Object
	 */
	public static function getInstance( $template=null, $customParams=null ){
		static $_instance;
		if( !$_instance ){
			$_instance = new LeoTemplateHelper( $template, $customParams );
		}
		return $_instance; 
	}

	
	public function countModules( $positionName ){
		return $this->objTemplate->countModules( $positionName );
	}
	
	public function getTemplateName(){
		
	}
	
	public function getPageClassSuffix(){
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();
		return $active->params->get("pageclass_sfx") ;
	}
	public function isOP(){
		
	}
	
	/**
	 * This function is combined and used for the "cols" block, 
	 *  this support calculating width of fours columns ( as maximum coloums support)
	 *
	 * @param array $setting @format:
	 *
		 $setting = array( "name"	 => "user", // prefix of group module positions
 			      		   "numcols"  => 4,     // maximun columns would be to have
				  		   "start"    => 1,     // start column index, this number combines with prefix column to make position name, for example user1,user2,user3
				  		   "maxwidth" => '',
				  		   "style"    => 'xhtml', // modules style
				  		   "class"    => '' ,   // addition class 
 				 		   "id"		  =>"userpos" // is div is wrapping those coloumns
		);
	 */
	public function calculateColsWidth( $setting, $totalwidth=100, $unit="%", $firstwidth=0 ){
		$spotlight = array();
		for( $i = $setting['start']; $i < $setting['numcols']+$setting['start']; $i++  ){
			$spotlight[] = $setting['name'].$i;
		}
		
		$modules = array();
		$modpos = array();
		foreach ($spotlight as $position) {
			if( $this->countModules ($position) ){
				$modpos[] = $position;
				$modules[$position] = array('class'=>'-full', 'width'=>$totalwidth . $unit);		
			} 
		}

		if (!count($modpos)) return array();

		if ($firstwidth) {
			if (count($modpos)>1) {
				$width = round(($totalwidth-$firstwidth)/(count($modpos)-1),1) . $unit;
				$firstwidth = $firstwidth . $unit;
			}else{
				$firstwidth = $totalwidth . $unit;
			}
		}else{
			$width = round($totalwidth/(count($modpos)),1) . $unit;
			$firstwidth = $width;
		}

		if (count ($modpos) > 1){
			$modules[$modpos[0]]['class'] = "-left";
			$modules[$modpos[0]]['width'] = $firstwidth;
			$modules[$modpos[count ($modpos) - 1]]['class'] = "-right";
			$modules[$modpos[count ($modpos) - 1]]['width'] = $width;
			for ($i=1; $i<count ($modpos) - 1; $i++){
				$modules[$modpos[$i]]['class'] = "-center";
				$modules[$modpos[$i]]['width'] = $width;
			}
		}
		return $modules;
	}
	
	/**
	 *  Get Site name
	 */
	public static function getSiteName(){
		$config = new JConfig();
		return $config->sitename;
	}
	
	/**
	 * Get user setting parameter, those values are used for demo site
	 */
	public function getUserParam( $key, $value='' ){ 
		return isset($this->_userParams[$key])?$this->_userParams[$key]:$this->getParam( $key, $value );
	}
	
	/**
	 * Get value for parameter of actived template
	 * 
	 * @return unknow data type
	 */
	public function getParam( $key, $value='' ){
		return $this->objTemplate->params->get( $key, $value );
	}
	
	/**
	 * Get user setting parameter, those values are used for demo site
	 *
	 * @return unknow data type
	 */
	public function getUserParamsValue(){
		
	}
	
	public function initUserParams(){
		
		$this->addUserParam( "theme",  $this->getParam("theme") );
		$this->addUserParam( "font",   $this->getParam("leo_font") ); 
		$this->addUserParam( "layout", $this->getParam("layout") );
		$exp = time() + 60*60*24*355; 
		if ( isset($_COOKIE[$this->_templateName.'_tpl']) && $_COOKIE[$this->_templateName.'_tpl'] == $this->_templateName ){
			foreach($this->_userParams as $k=>$v) { 
				$kc = $this->_templateName."_".$k;
				if (isset($_GET[$k])){
					$v = $_GET[$k];
					$_COOKIE[$kc] = $v;
					setcookie ($kc, $v, $exp, '/');
				}else{
					if ( isset($_COOKIE[$kc])){
						$v = $_COOKIE[$kc];
					}
				} 
				$this->addUserParam($k, $v);
						
			}

		}else{ 
			@setcookie ($this->_templateName.'_tpl', $this->_templateName, $exp, '/');
		}
		if( JRequest::getVar("leoaction")=="save" ){
		//	$app = JFactory::getApplication();
		//	$app->redirect( JURI::base() );
			//$app->close();
		}
		if( JRequest::getVar("leoaction")=="reset" ){
			$this->clearAllUserParams();
			$app = JFactory::getApplication();
			$app->redirect( JURI::base() );
			$app->close();
		}
	}
	
	/**
	 * clear user setting
	 */
	public function clearAllUserParams(){

		if(  isset($_COOKIE[$this->_templateName.'_tpl']) && is_array($this->_userParams) ){
			foreach( $this->_userParams as $k => $v ){
				$kc = $this->_templateName."_".$k;
				if( isset($_COOKIE[$kc]) ){
					setcookie( $kc, null, 10, '/');
					unset($_COOKIE[$kc]);
				}
			}
			
			return true;
		}
		return false;
		
	}
	
	/**
	 *
	 */
	public function addUserParam( $key, $value='' ){
		$this->_userParams[$key]=$value;
	}
	
	public function registerUserParam( $key, $value ){
		setcookie ( $this->_templateName."_".$key, $value,  time() + 60*60*24*355, '/');
		$this->addUserParam( $key, $value );	
	}
	/**
	 *
	 */
	public function getDetectedBrowser(){
		 
	}
	
 	public function isBrowser(){
		
	}
	
	public function getBaseURI(){
		return $this->_baseURI;
	}
	
	public function getTemplateURI(){
		return $this->_templateURI;			
	}
	
	public function isThemeExisted( $theme ){
		return file_exists( $this->_templatePath."themes".DS.$theme.DS."css".DS."template.css" ); 
	}
	
	public function loadCusomCssFiles(){
		$folder = $this->_templatePath."css".DS."custom".DS;
		$files = JFolder::files( $folder, ".css" );
	 	if( !empty($files) ){
			foreach( $files as $file ) {
				$this->addStyleSheet($this->getTemplateURI() . 'css/custom/'.$file );
			}
		}
		return ;
	}
	
	public function loadCustomJS(){
		
	}
	public function addCustomCssRule( $rule ){
		$this->_customCss[] = $rule;
	}
	
	public function renderCustomCssRules(){
		if( $this->_customCss ) {	
			$document = JFactory::getDocument();	
			$string  = implode( "  ", $this->_customCss );
			$document->addStyleDeclaration( $string );
		}
	}
	
	public function addScript( $file ){
		$this->_siteJS[] = $file;
		return $this;
	}
	public function addStyleSheet( $file ){
		$this->_siteCss[] = $file;
		return $this;
	}
	
	public function renderCssJSFiles(){
		$document = JFactory::getDocument();	
		
		foreach( $this->_siteCss as $css ){
			$document->addStyleSheet( $css );
		}
		
		foreach( $this->_siteJS as $css ){
			$document->addScript( $css );
		}
		
		if( $this->getParam('compress_css_template',0) ){
			$cssFiles = $document->_styleSheets;
			LeoCompressHelper::compressCss( $cssFiles, $document );
		}
		
		if( $this->getParam('compress_js_template',0) ){
			$jsFiles = $document->_scripts; 
			LeoCompressHelper::compressJS( $jsFiles, $document, $this->getParam('exclude_js_files',"core.js,mootools-core.js,mootools-more.js,jquery.js") );
		}
	}
	
	/**
	 * Include the selected layout to render Look and Feel of template
	 * Layouts put in Leo Framework plugin or current folder template 
	 */
	public function renderLayout( $path, $layout = 'default' ){
		JHtml::_('behavior.framework', true);
		include( $path . DS."layouts".DS.$layout.".php" );
	}
	
	/**
	 * A block is part to including in layout
	 * Blocks Files put in Leo Framework plugin or current folder template .
	 * And allow override core files by the block file of template.
	 */
	public function renderBlock( $name, $args=array() ){   
		if( file_exists($this->_templatePath."layouts".DS."blocks".DS.$name.".php") ){
			require(  $this->_templatePath."layouts".DS."blocks".DS.$name.".php" );
			return ;
		}
		require( $this->_fwPath. "layouts".DS."blocks".DS."{$name}.php" ); 
	}
	
	public function renderAddon( $name, $args=array() ){
		if( file_exists($this->_templatePath."addons".DS.$name.DS."{$name}.php") ){
			require( $this->_templatePath."addons".DS.$name.DS."{$name}.php" );
			return ;
		}
		require( $this->_fwPath. "addons".DS.$name.DS."{$name}.php" ); 	
	}
	
	/**
	 * Get Menu Object Based on Menu Type
	 *
	 * @param $menutype
	 * @param $templateName
	 * @param $params
	 */
	public function getMenu( $menutype, $templateName, $params ){
	
		if( file_exists($this->_fwPath."menu".DS.$menutype.DS.$menutype.".php") ){
			$class = "LeoMenu".ucfirst($menutype);
			require_once( $this->_fwPath."menu".DS.$menutype.DS.$menutype.".php" );
			if( class_exists( $class )  ){
				return new $class( $templateName, $params );
			}
		}
	}
	
	protected function calTemplateColumnsWidth(){
		// check and caculate width of Main Column : LEFT + MAIN + RIGHT
        $leftColumn = $this->countModules( 'left + left-bottom + left-left + left-right' );
        $rightColumn = $this->countModules( 'right + right-bottom + right-left + right-right' );
		if( $leftColumn && $rightColumn ) {
        	$this->addCustomCssRule('#leo-left { width: ' . $this->getParam('left_column_width', '20'). '%; }');
        	$this->addCustomCssRule('#leo-right { width: ' . $this->getParam('right_column_width', '25'). '%; }');
        	$this->addCustomCssRule('#leo-content { width: ' . (100 - ($this->getParam('left_column_width', '20') + $this->getParam('right_column_width', '25'))) . '%; }');
        } elseif (  $leftColumn ) {
        	$this->addCustomCssRule('#leo-left { width: ' . $this->getParam('left_column_width', '20'). '%; }');
        	$this->addCustomCssRule('#leo-content { width: ' . (100 - $this->getParam('left_column_width', '20')) . '%; }');
        } elseif ( $rightColumn  ) {
        	$this->addCustomCssRule('#leo-right { width: ' . $this->getParam('right_column_width', '25'). '%; }');
        	$this->addCustomCssRule('#leo-content { width: ' . (100 - $this->getParam('right_column_width', '25')) . '%; }');
        } else {
			$this->addCustomCssRule('#leo-content { width: 100%; }');
		}
		
		// check width of content left and right 
		if( $this->countModules('content-left and content-right') ) {
			$this->addCustomCssRule('#content-left { width: ' . $this->getParam('content_left_width', '20'). '%; }');
        	$this->addCustomCssRule('#content-right { width: ' . $this->getParam('content_right_width', '20'). '%; }');
        	$this->addCustomCssRule('#leo-maincontent-inner { width: ' . (100 - ($this->getParam('content_left_width', '20') + $this->getParam('content_right_width', '20'))) . '%; }');
		}elseif( $this->countModules('content-left or content-right') ){
			if($this->countModules('content-left')) {
        		$this->addCustomCssRule('#content-left { width: ' . $this->getParam('content_left_width', '20'). '%; }');
        		$this->addCustomCssRule('#gkComponentWrap { width: ' . (100 - $this->getParam('content_left_width', '20')) . '%; }');
        	} else {
        		$this->addCustomCssRule('#content-right { width: ' . $this->getParam('content_right_width', '20'). '%; }');
        		$this->addCustomCssRule('#leo-maincontent-inner { width: ' . (100 - $this->getParam('content_right_width', '20')) . '%; }');
        	}
		}
	}
}
?>