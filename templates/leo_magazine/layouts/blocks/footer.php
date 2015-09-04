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
?>
<div id="leo-footer" class="wrap" >
<div class="leo-container">
  <div class="leo-container-inner">
    <div id="leo-copyright">
      <?php if($this->getUserParam('leo_footer')) : ?>
      <?php echo $this->getUserParam('leo_footer_text'); ?>
      <?php else : ?>
      <p style="float: left;">Copyright &copy; 2011 
	  <a href="http://www.leotheme.com" title="Joomla Templates Club"><?php echo self::getSiteName(); ?></a>. All rights reserved.
      <?php endif; ?></p>
	  <p style="float:right;">Design by <a href="LeoTheme.com">LeoTheme</a></p>
    </div>
    <?php if($this->countModules('footer')) : ?>
    <div id="leo-footer-menu">
      <jdoc:include type="modules" name="footer"  style="leoxhtml" />
    </div>
    <?php endif; ?>
  </div>
</div>
</div>