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

$document = JFactory::getDocument();
// load system Css Files
$this->addStyleSheet($this->getBaseURI() . 'templates/system/css/system.css');
$this->addStyleSheet($this->getBaseURI() . 'templates/system/css/general.css');
// load css files of template
$this->addStyleSheet($this->getTemplateURI() . 'css/custom/virtuemart.css');
$this->addStyleSheet($this->getTemplateURI() . 'css/template.css');
$this->addStyleSheet($this->getTemplateURI() . 'css/fonts.css');
$this->addStyleSheet($this->getTemplateURI() . 'css/joomla.css');
$this->addStyleSheet($this->getTemplateURI() . 'css/extensions.css');
$this->addStyleSheet($this->getTemplateURI() . 'css/layout.css');
if( $this->getParam("enable_responsive",1) ) {
	$this->addStyleSheet($this->getTemplateURI() . 'css/responsive.css');
}
// if the template is enable Front Feature
if($this->getUserParam('leo_fontfeature')) {
	$this->addStyleSheet($this->getTemplateURI() . 'css/fonts.css');
}

//update code : 
$themeUser=$this->getUserParam("theme", "" ); 
$themeParam = $this->getParam("theme", ''); 
$theme = JRequest::getVar('theme', '') ? $themeUser : $themeParam[0]; 

// change to other theme color .
if( $this->isThemeExisted( $theme )  ){
	$this->addStyleSheet($this->getTemplateURI() . 'themes/'.$theme.'/css/template.css');	
	$this->addStyleSheet($this->getTemplateURI() . 'themes/'.$theme.'/css/extensions.css');	
	$this->addStyleSheet($this->getTemplateURI() . 'themes/'.$theme.'/css/joomla.css');	
	$this->addStyleSheet($this->getTemplateURI() . 'themes/'.$theme.'/css/k2.css');
	$this->addStyleSheet($this->getTemplateURI() . 'themes/'.$theme.'/css/menu/mega.css');		
}

// load global script file
$this->addScript($this->getTemplateURI() . 'js/global.js');

// automatic load all css files inside css/custom
$this->loadCusomCssFiles(); 
?>
<?php
	$this->renderCssJSFiles();	
	$this->renderCustomCssRules();
?>
<?php // echo $this->renderScriptTags();?>
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo $this->getTemplateURI(); ?>css/ie7.css" type="text/css" />
<![endif]-->

   
