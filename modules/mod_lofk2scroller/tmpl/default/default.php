<?php 
/*------------------------------------------------------------------------
 # mod_lofk2scroller - Lof K2Scroller Module
 # ------------------------------------------------------------------------
 # author    LandOfCoder
 # copyright Copyright (C) 2010 landofcoder.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.landofcoder.com
 # Technical Support:  Forum - http://www.landofcoder.com/forum.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );  
?>
<div id="lofk2scroller<?php echo $module->id; ?>" class="lof-sliding" style="height:<?php echo $moduleHeight;?>; width:<?php echo $moduleWidth;?>">
<div class="<?php echo $class;?> lof-container <?php echo $params->get('thumbnail_alignment','');?>">
<?php if( $displayButton && $totalPages  > 1  ) : ?>
    <a class="lof-previous"  href="" onclick="return false;"><?php echo JText::_('Previous');?></a>
    <a class="lof-next" href="" onclick="return false;"><?php echo JText::_('Next');?></a>
<?php endif; ?>
<?php if(  $params->get('navigator_pos','top') && $totalPages  > 1 ) : ?>
    <!-- NAVIGATOR -->    
      <div class="lof-navigator-outer">
            <ul class="lof-navigator lof-bullets">
            <?php foreach( $pages as $key => $row ): ?>
                <li><span><?php echo  $key+1;?></span></li>
             <?php endforeach; ?> 		
            </ul>
        </div>
   <?php endif; ?>


 <!-- MAIN CONTENT of ARTICLESCROLLER MODULE --> 
  <div class="lof-main-wapper" style="height:<?php echo $moduleHeight;?>;width:<?php echo $moduleWidth;?>">
 		<?php foreach( $pages as $key => $list ): ?>
  		<div class="lof-main-item page-<?php echo $key+1;?>">
        		<?php foreach( $list as $i => $row ): ?>
        		 <div class="lof-row" style="width:<?php echo $itemWidth;?>%">
                   <?php require(  $itemLayoutPath ); ?>
				</div>      
                <?php  if( ($i+1) % $maxItemsPerRow == 0 && $i < count($list)-1 ) : ?>
                	<div class="lof-clearfix"></div>
                <?php endif; ?>       
                <?php endforeach; ?>
        </div> 
   		<?php endforeach; ?>
  </div>
 </div> 
  <!-- END MAIN CONTENT of ARTICLESCROLLER MODULE --> 
 </div> 
