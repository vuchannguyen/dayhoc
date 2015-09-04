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
 
// No direct access.
defined('_JEXEC') or die;

$uri = JURI::getInstance();

$templateParams = JFactory::getApplication()->getTemplate(true)->params; 

$logo_image = ($templateParams->get('logo_image', '') == '') ? $uri->root().'templates/'.JFactory::getApplication()->getTemplate(true)->template.'/images/default/logo.png' : $templateParams->get('logo_image', '');
/**
 *  Get Site name
 */
$config = new JConfig();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<title><?php echo $this->error->getCode(); ?>-<?php echo $this->title; ?></title>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/error.css" type="text/css" />
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
</head>
<body id="leo-page">
<div id="page-container">
<div id="leo-blockheader" class="wrap" >
	<div class="inner-wrap">
      <div class="leo-container">
        <div class="leo-container-inner">
      <h1 class="logo">
            <a href="index.php"><img src="<?php echo $logo_image; ?>" alt="<?php echo $this->error->getMessage(); ?> <?php echo $this->error->getCode(); ?>" /></a>
      </h1>
      </div></div></div></div>
<div id="leo-content">
 <div class="leo-container">
        <div class="leo-container-inner">
      <div id="frame">
            <div id="errorNumber">
                  <h1><?php echo $this->error->getCode(); ?></h1>
                  <h2><?php echo $this->error->getMessage(); ?></h2>
            </div>
            <div id="errorboxbody">
                  <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
                  <ol>
                        <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
                  </ol>
                  <p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>
                  <ol>
                        <li>
                              <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
                        </li>
                  </ol>
            </div>
      </div>
      </div>
      </div>
</div>
<div class="wrap " id="leo-blockbottom">
		<div class="inner-wrap">
<div id="leo-footer" class="wrap" >
<div class="leo-container">
  <div id="leo-container-inner">
    <div id="leo-copyright">
     <div id="leo-copyright-inner">
      <span>Copyright &copy; <?php echo date('Y');?> 
	  <a href="http://www.leotheme.com" title="Joomla Templates Club"><?php echo $config->sitename; ?></a>. All rights reserved.
     Design by <a href="http://www.leotheme.com">LeoTheme</a></span>
	  <span style="float:right;" class="logo-footer"> Design by <a href="http://www.leotheme.com">LeoTheme</a></span>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>