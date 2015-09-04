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
// no direct access
defined('_JEXEC') or die('Restricted access');
if(  !defined("_LEO_FRAMEWORK_ACTIVED_") ){  
	die( JText::_("TPL_LEO_TEMPLATE_MISSING_PLUGIN_DESC") );
}
// require framework
require_once( JPATH_PLUGINS.DS."system".DS."leofw".DS.'libs'.DS."classes".DS."framework.php" );
$customParams = array();
$LeoHelper = LeoTemplateHelper::getInstance( $this, $customParams );
$LeoHelper->renderLayout( dirname(__FILE__) );
?>
