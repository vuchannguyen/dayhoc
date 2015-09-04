<?php 
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) Octorber 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
$item = modLofK2News::onBeforeRender( $item, $sDescriptionMaxChars, $limitDescriptionBy, $params->get('itemAuthor',1) ); ?>
<li class="lof-item">
    
    <?php if( $sShowImage ) : ?>
      <?php  echo  modLofK2News::getImage( $item, $sImageWidth, $sImageHeight, $isThumb ); ?>
    <?php endif; ?>
   <h4><a href="<?php echo $item->link;?>"><?php echo $item->title ?></a></h4>
   <?php if($item->description && $item->description != "..." ): ?>
    <div class="lof-description">
    	<?php echo  $item->description;?>
    </div>
        <div class="lof-extrainfo">
  			<?php if( $params->get('itemCategory',1) ) : ?>
            <?php echo JText::_('Published In');?> 
                <a title="<?php echo $item->categoryname;?>" href="<?php echo $item->categoryLink;?>"><b><?php echo $item->categoryname;?></b></a>
            <?php endif; ?>
            <?php if( $params->get('itemDateCreated',1) ) : ?>
             -  <i><?php echo $item->date;?></i>
            <?php endif; ?> 
            <?php if( $params->get('itemAuthor',1) ) : ?>
            	- <span class="lof-author">  <?php echo JText::_('Author'); ?> : <a href="<?php echo $item->authorLink; ?>"><b><?php echo $item->author; ?></b></a></span>
            <?php endif; ?>
            <?php if( $params->get('itemReadMore',1) ): ?>
				 - <a class="lof-readmore" href="<?php echo $item->link;?>"><b><?php echo JText::_("Readmore");?></b></a> 
    		<?php endif; ?> 
    	</div>
	<div class="lof-counter">
		<?php if( $params->get('itemHits',1) ): ?>
            <div class="lof-item-hits"><b><?php echo $item->hits; ?></b></div>       
        <?php endif; ?>
        <?php if( $params->get('itemComments', 1) ): 	
                $item->numOfComments =  (int)$item->commentcount;
         ?>
         <div class="lof-item-comment"><b><?php echo $item->numOfComments; ?></b> 
        </div>
        <?php endif; ?>
     </div>    
   
        
    <?php endif; ?>
</li>