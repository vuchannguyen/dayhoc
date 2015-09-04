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
if( !defined('PhpThumbFactoryLoaded') ) {
	require_once dirname(__FILE__).DS.'libs'.DS.'phpthumb/ThumbLib.inc.php';
	define('PhpThumbFactoryLoaded',1);
}
if( !class_exists("LofSourceBase") ){
	require_once dirname(__FILE__).DS."libs".DS."source".DS."source_base.php";
}
/**
 * modLofSlideShowHelper Class 
 */
abstract class modLofSlideShowHelper {
	/**
	 *
	 */
	public static function getList( $params, $module ){
		return self::getListBySourceName( $params, $module->module );
	}
	/**
  	 * Get list of articles follow conditions user selected
     * 
     * @param JParameter $params
     * @return array containing list of article
     */ 
	public static function getListBySourceName( &$params, $moduleName ) {
	 	
	 	$tmppath = JPATH_SITE.DS.'cache';//.'lofthumbs';
		$moduleName = 'lofthumbs' ;
	 	$thumbPath = $tmppath.DS. $moduleName.DS;
		if( !file_exists($tmppath) ) {
			JFolder::create( $tmppath, 0777 );
		}; 
		if( !file_exists($thumbPath) ) {
			JFolder::create( $thumbPath, 0777 );
		}; 
		// get call object to process getting source
		$source =  $params->get('data_source','content');
		$path = dirname(__FILE__).DS."libs".DS."source".DS.$source.DS."source.php";
	
		if( !file_exists($path) ){
			return array();	
		}
		require_once $path;
		$objectName = "Lof".ucfirst($source)."DataSource";
	 	$object = new $objectName();
	 	$items= $object->setThumbPathInfo($thumbPath, JURI::base(). "cache/".$moduleName."/" )
			->setImagesRendered( array( 'mainImage' => array( (int)$params->get( 'main_width', 820 ), (int)$params->get( 'main_height', 280 )), 
									'thumbnail' => array( (int)$params->get( 'thumbnail_width', 60 ), (int)$params->get( 'thumbnail_height', 60 ) )																						
								)
										
			)->getList( $params );
  		return $items;
	}

	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module, $theme ){
		$document = &JFactory::getDocument();
	    if( $theme && $theme != -1 ){
	      $document->addStyleSheet( JURI::root(true). '/modules/'.$module->module.'/tmpl/'.$theme.'/assets/jstyle.css' );  
	    } else { 
			$document->addStyleSheet( JURI::root(true). '/modules/'.$module->module.'/assets/jstyle.css' );	
	    }
    	$document->addScript( JURI::root(true). '/modules/'.$module->module.'/assets/jscript.js' ); 
	}
	
	/**
	 * Get Layout of the item, if found the overriding layout in the current template, the module will use this file
	 * 
	 * @param string $moduleName is the module's name;
	 * @params string $theme is name of theme choosed
	 * @params string $itemLayoutName is name of item layout.
	 * @return string is full path of the layout
	 */
	public static function getItemLayoutPath($moduleName, $theme ='', $itemLayoutName='_item' ){
	
		$layout = trim($theme)?trim($theme).DS.'_contentslider'.DS.$itemLayoutName:'_contentslider'.DS.$itemLayoutName;	
		$path = JModuleHelper::getLayoutPath($moduleName, $layout);	
		if( trim($theme) && !file_exists($path) ){
			// if could not found any item layout in the theme folder, so the module will use the default layout.
			return JModuleHelper::getLayoutPath( $moduleName, '_contentslider'.DS.$itemLayoutName );
		}
		return $path;
	}
}
?>
