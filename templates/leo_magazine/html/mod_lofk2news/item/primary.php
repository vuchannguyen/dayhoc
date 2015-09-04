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
$item = modLofK2News::onBeforeRender( $item, $pDescriptionMaxChars, $limitDescriptionBy, $params->get('itemAuthor',0));
?>
<li class="lof-item">
    
    <?php if( $pShowImage ) : ?>
    <?php echo modLofK2News::getImage( $item, $pImageWidth, $pImageHeight, $isThumb ); ?>
    <?php endif; ?>
     <h4><a href="<?php echo $item->link;?>" class="<?php echo modLofK2News::getIcon($item);?>"><span><?php echo $item->title ?></span></a></h4>
   
   	    <div class="lof-extrainfo">
  			
            <?php if( $params->get('itemDateCreated',0) ) : ?>
            <span class="lof-itemDateCreated" ><?php echo $item->date;?></span>
            <?php endif; ?> 
             <?php if( $params->get('itemComments', 1) ): 
		$item->numOfComments =  (int)$item->commentcount;
	 ?>
     <div class="lof-item-comment">
   		 <?php echo $item->numOfComments; ?><?php //echo ($item->numOfComments>1) ? JText::_('comments') : JText::_('comment'); ?>
        
    </div>
    <?php endif; ?>
              <?php if( $params->get('itemHits',0) ): ?>
    	<div class="lof-item-hits"><?php echo $item->hits; ?> <?php echo JText::_('Hits');?></div>   
         
    <?php endif; ?>
  
            <?php if( $params->get('itemAuthor',0) ) : ?>
            	<span class="lof-author">  <?php echo JText::_('Author'); ?> : <a href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a></span><div class="clearfix">
                </div>

            <?php endif; ?>
			<?php if( $params->get('itemCategory',0) ) : ?>
            <?php echo JText::_('Published In');?> 
              <span class="lof-itemCategory" > <a title="<?php echo $item->categoryname;?>" href="<?php echo $item->categoryLink;?>"><?php echo $item->categoryname;?></a></span>
            

            <?php endif; ?>
            
    	</div>   
    
    <?php if($item->description && $item->description != "..." ): ?>
    <div class="lof-description">
    	<?php echo  $item->description;?>
    </div>
    <?php endif; ?>
    <?php if( $params->get('itemReadMore',0) ): ?>
				 <span><a class="lof-readmore" href="<?php echo $item->link;?>"><?php echo JText::_("Readmore");?></a> </span>
                

    		<?php endif; ?> 
    
</li>