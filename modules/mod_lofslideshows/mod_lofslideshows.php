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
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';
$list = modLofSlideShowHelper::getList( $params, $module );

$group = $params->get( 'group','content' );
$tmp = $params->get( 'module_height', 'auto' );
$moduleHeight   =  ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
$tmp = $params->get( 'module_width', 'auto' );
$moduleWidth    =  ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
$themeClass       = $params->get( 'theme' , '');
$openTarget   = $params->get( 'open_target', '_parent' );
$class      = !$params->get( 'navigator_pos', 0 ) ? '':'lof-'.$params->get( 'navigator_pos', 0 );
$themeConfig 		= JArrayHelper::fromObject ($params->get('theme_config', (new stdClass()) ));

$theme        =  $params->get( 'theme', '' ); 
$navigatorLayout = (($params->get( 'navigator_layout', 'default' )=='custom_layout')?'_custom_navigator':'_navigator').".php";
$navigatorPattern = $params->get( 'custom_layout', '%IMG %TITLE %DATE' );
$navHeight = (int)$params->get('navitem_height', 100);
$navWidth = (int)$params->get('navitem_width', 290);
$thumbnailWidth = (int)$params->get('thumbnail_width', 60);
$thumbnailHeight = (int)$params->get('thumbnail_height', 60);
$thumbnailMargin=$params->get('thumbnail_margin','10px 10px');
$showDescriptionBlock = $params->get( 'enable_blockdescription', 1 );
// navigator setting 
$navEnableThumbnail     = $params->get( 'enable_thumbnail', 1 );
$navEnableTitle         = $params->get( 'enable_navtitle', 1 );
$navEnableDate          = $params->get( 'enable_navdate', 1 );
$navEnableCate          = $params->get( 'enable_navcate', 1 );
$enableReadMore = $params->get('enable_readmore',0);

modLofSlideShowHelper::loadMediaFiles( $params, $module, $theme );
$contentSliderLayout = modLofSlideShowHelper::getItemLayoutPath($module->module, $theme, $params->get('contentslider_layout','image-description')  );
 
$css3Class = $params->get('enable_css3','1') ? ' lof-css3':'';
$moreInfor = trim($params->get("showinformation",""));
 
  $layout = trim($theme).DS.'default';

 require( JModuleHelper::getLayoutPath($module->module, $layout ) );
 $js =  JModuleHelper::getLayoutPath($module->module,  trim($theme).DS.'js' );

?>
<?php
if( file_exists($js) ){
	require_once($js);
}
?>