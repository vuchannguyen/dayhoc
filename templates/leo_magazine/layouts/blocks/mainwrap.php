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
 <div id="leo-mainwrap" class="wrap <?php echo $this->getPageClassSuffix(); ?>">
   <div class="leo-container">
     <div class="leo-container-inner">
       <div id="leo-mainwrap<?php // echo $leo_width; ?>" class="clearfix leo-layout<?php if($this->getUserParam('layout') =='-lcr' || $this->getUserParam('layout') =='-crl' || $this->getUserParam('layout') =='-rcl'){echo $this->getUserParam('layout');}else{echo $this->getParam('layout');}?>">
		<?php echo $this->renderBlock( "left" );?>       
         <div id="leo-content">
           <div id="leo-content-inner">
            <?php $this->renderBlock( "cols", array(  "name"=>"content-top", 'numcols'=>3, 'start'=>1, "id"=>"colspan1", 'wrapclass'=>"col-wrapper" ) ); ?>
             <div id="leo-maincontent" class="clearfix">
            	
			  <?php if( $this->countModules("content-left") ): ?> 	
                <div id="leo-content-left">
					<jdoc:include type="modules" name="content-left" style="leoxhtml" />
			   </div>
               <?php endif; ?>
                     
               <div id="leo-maincontent-inner">
                <?php if( $this->countModules("content-toptop") ): ?> 
                <div id="leo-content-toptop">
					<jdoc:include type="modules" name="content-toptop" style="leoxhtml" />
			   </div>
            	<?php endif; ?>
                <jdoc:include type="message" />
                <jdoc:include type="component" />
              </div>
            	
               <?php if( $this->countModules("content-right") ): ?> 
                <div id="leo-content-right">
					<jdoc:include type="modules" name="content-right" style="leoxhtml" />
			   </div>
            	<?php endif; ?>
            </div>
            <?php if( $this->countModules("content-bottombottom") ): ?> 
                <div id="leo-content-bottombottom">
					<jdoc:include type="modules" name="content-bottombottom" style="leoxhtml" />
			   </div>
            	<?php endif; ?>
            <?php $this->renderBlock( "cols", array(  "name"=>"content-bottom", 'numcols'=>3, 'start'=>1, "id"=>"colspan2", 'wrapclass'=>"col-wrapper" ) ); ?>
          </div>
        </div>
        <?php echo $this->renderBlock( "right" );?>
      </div>
    </div>
  </div>
</div>
