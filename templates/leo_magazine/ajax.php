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
$config = new JConfig();
?>
<jdoc:include type="message" />
<jdoc:include type="component" />

<div id="leo-footer" class="wrap" >
<div class="leo-container">
  <div id="leo-container-inner">
    <div id="leo-copyright">
     <div id="leo-copyright-inner">
      <span>Copyright &copy; <?php echo date('Y');?> 
	  <a href="http://www.leotheme.com" title="Joomla Templates Club"><?php echo $config->sitename; ?></a>. All rights reserved.
     Design by <a href="http://www.leotheme.com">LeoTheme</a></span>
	  <span style="float:right;" class="logo-footer"> <a href="http://www.leotheme.com">LeoTheme</a></span>
    </div>
</div>
</div>
</div>
</div>
</div>