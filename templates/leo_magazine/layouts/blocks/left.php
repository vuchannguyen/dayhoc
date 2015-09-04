<?php 
/*------------------------------------------------------------------------
 # Leo Template Framework - 
 # ------------------------------------------------------------------------
 # author    LeoTheme
 # copyleft Copyleft (C) 2010 leotheme.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.leotheme.com
 # Technical Support:  Forum - http://www.leotheme.com/forum.html
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php if($this->countModules('left + left-bottom + left-left + left-right')) : ?>
<div id="leo-left">
  <div id="leo-left-inner">
  	<?php if($this->countModules('left')) : ?>
    <div class="left-top">
    	<jdoc:include type="modules" name="left" style="leoxhtml" />
    </div>
    <?php endif; ?>
    <?php if( $this->countModules('left-left + left-right') ) : ?>
    <div class="left-middle">
    	<div id="leo-leftleft">
			<jdoc:include type="modules" name="left-left" style="leoxhtml" />
        </div>
        <div id="leo-leftright">
        	<jdoc:include type="modules" name="left-right" style="leoxhtml" />
        </div>
        <div class="clearfix"></div>
    </div>
    <?php endif; ?>
    
    <?php if($this->countModules('left-bottom')) : ?>
    <div class="left-top">
    	<jdoc:include type="modules" name="left-bottom" style="leoxhtml" />
    </div>
    <?php endif; ?>
    
  </div>
</div>
<?php endif; ?> 