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
<?php if($this->countModules('right + right-bottom + right-left + right-right')) : ?>
<div id="leo-right">
  <div id="leo-right-inner">
  	<?php if($this->countModules('right')) : ?>
    <div class="right-top">
    	<jdoc:include type="modules" name="right" style="leoxhtml" />
    </div>
    <?php endif; ?>
    <?php if($this->countModules('right-left + right-right')) : ?>
    <div class="right-middle">
    	<div id="leo-rightleft">
			<jdoc:include type="modules" name="right-left" style="leoxhtml" />
        </div>
        <div id="leo-rightright">
        	<jdoc:include type="modules" name="right-right" style="leoxhtml" />
        </div>
    </div>
    <?php endif; ?>
    
    <?php if($this->countModules('right-bottom')) : ?>
    <div class="right-bottom">
    	<jdoc:include type="modules" name="right-bottom" style="leoxhtml" />
    </div>
    <?php endif; ?>
    
  </div>
</div>
<?php endif; ?> 