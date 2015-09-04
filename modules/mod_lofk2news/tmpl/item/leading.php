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
defined('_JEXEC') or die;  // echo '<pre>'.print_r($item,1); die;

$item = modLofK2News::onBeforeRender( $item, $lShowDescription, $limitDescriptionBy, $params->get('itemAuthor',1) ); ?>
<li class="lof-item">
    <?php if( $lShowImage ) : ?>
      <?php echo  modLofK2News::getImage( $item,$lImageWidth,$lImageHeight , $isThumb ); ?>
    <?php endif; ?>
	
	    <h4>
    	<a href="<?php echo $item->link;?>" class="<?php echo modLofK2News::getIcon($item);?>"><span><?php echo $item->title ?></span></a>
    	</h4>
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
            </div>    
    
    <?php if($item->description && $item->description != "..." ): ?>
    <div class="lof-description">
    	<?php echo  $item->description;?>
    </div>
    
	<?php if( $params->get('itemHits',1) ): ?>
    	<div class="lof-item-hits"><b><?php echo $item->hits; ?></b> <?php echo JText::_('Hits');?></div>       
    <?php endif; ?>
    <?php if( $params->get('itemComments', 1) ): 

			$item->numOfComments =  (int)$item->commentcount;
	 ?>
     <div class="lof-item-comment">
     	<b>
   		 <?php echo $item->numOfComments; ?>  </b><?php echo ($item->numOfComments>1) ? JText::_('comments') : JText::_('comment'); ?>
        
    </div>
    <?php endif; ?>
    	<?php if( $params->get('itemReadMore',1) ): ?>
			<a class="lof-readmore" href="<?php echo $item->link;?>"> <?php echo JText::_("Readmore");?> </a> 
    	<?php endif; ?>
	<?php endif; ?>
</li>