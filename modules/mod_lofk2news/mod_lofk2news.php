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
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

/** SPLITING ITEM FOR EACH LAYOUTS **/
$leadingCount  	 = $params->get('leading-box',0)?(int)$params->get('leading_count',1):0;
$primaryCount 	 = $params->get('primary-box',0)?(int)$params->get('primary_count',5):0;
$secondaryCount  = $params->get('secondary-box',0)?(int)$params->get('secondary_count',5):0;
$totalItems      = $leadingCount+$primaryCount+$secondaryCount;
$positions       =  $params->get('define_positions','');
if( !is_array($positions) ){ $positions=array($positions);}
$themesSetting 	 = $params->get('theme_box_settings','');
$themesSetting   = is_array($themesSetting)?$themesSetting:array($themesSetting);	
/** LEADING LAYOUT SETTING **/
$lShowImage = $params->get('leading_showimage',1);			
$lShowDescription = $params->get('leadingdescription_max',100);	
$lShowImage = $params->get('leading_showimage',1);			
$lImageHeight = $params->get('leadingimage_height',197);
$lImageWidth = $params->get('leadingimage_width',300);
/** PRIMARY LAYOUT SETTING **/			
$pShowImage = $params->get('primary_showimage',0);			
$pShowDescription = $params->get('primary_showdescription',0);	
$pImageHeight = $params->get('primaryimage_height',70);
$pImageWidth = $params->get('primaryimage_width',90);
$pDescriptionMaxChars = $params->get( 'primarydescription_max', 100 );
/** SECOND LAYOUT SETTING **/
$sShowImage = $params->get('secondary_showimage',1);	
$sShowDescription = $params->get('secondary_showdescription',1);
$sImageHeight = $params->get('secondaryimage_height',70);
$sImageWidth = $params->get('secondaryimage_width',90);
$sDescriptionMaxChars = $params->get( 'secondarydescription_max', 100 );
/** GENERAL LAYOUT SETTING **/
$limitDescriptionBy = $params->get('limit_description_by','char');
$maxCatsShowed 		= (int)$params->get('maximum_categoriesshowed',5);
$tmp 				= $params->get( 'module_height', 'auto' );
$moduleHeight   	=  ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
$tmp 				= $params->get( 'module_width', 'auto' );
$moduleWidth    	=  ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
$openTarget 		= $params->get( 'open_target', 'parent' );
$class 				= $params->get( 'navigator_pos', 0 ) ? '':'lof-snleft';
$itemLayout     	= 'item'.DS.trim($params->get('content_slider','image-desc')).'.php';
$css3				= $params->get('enable_css3','1')? " lof-css3":"";
$isThumb       		= $params->get( 'auto_renderthumb',1); 
/** RENDER CONTENT FOR LAYOUT **/		
modLofK2News::loadMediaFiles( $params, $module );
$catids = $params->get( 'category',''); 

$catids = !is_array($catids) ? array($catids) :$catids;
$layoutModulePath = JModuleHelper::getLayoutPath($module->module);	

$categoriesInfo = modLofK2News::getCategoriesInfo( $catids );

foreach( $catids as $k=>$id ){
	// parent category information
	if( isset($categoriesInfo[$id]) ) { 
		$categoryInfo = $categoriesInfo[$id];  
		$themeBox 	  	=  array_key_exists($k, $themesSetting)?"lof-".$themesSetting[$k]:""; 
		$categories   	= modLofK2News::getListCategories( (int)$id );
		$showCategories = true;
		if( $maxCatsShowed <= 0 || count($categories['ids']) <= 1  ){$showCategories=false;}
		$items 	 		= modLofK2News::getList( $params, $categories['ids'], $totalItems );
		unset($categories['ids']);
		$leading 		= array_slice($items, 0, $leadingCount);
		$primary 		= array_slice($items, $leadingCount, $primaryCount);
		$secondary 		= array_slice($items, $leadingCount +  $primaryCount, $secondaryCount);	
		require( $layoutModulePath );
	}
}
?>
