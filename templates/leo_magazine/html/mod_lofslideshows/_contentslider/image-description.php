<?php 
	$row->description = preg_replace("/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/","",$row->description);
?>
<?php if( $row->link ): ?>
<div class="lof-image">
<a href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>">
<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />
</a></div>
<?php else: ?>
<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />

<?php endif; ?>

<?php if( $row->title && $showDescriptionBlock ) : ?>
<div class="lof-description">
	<?php if( $moreInfor && $moreInfor !="#" ): ?>
	 <div class="lof-info">
     <?php 
	 	$string = str_replace(  "#DATE", "<i>".$row->date."</i>", $moreInfor );
		$cat = '<a href="'.$row->catlink.'" title="'.$row->category_title.'">'.$row->category_title.'</a>';
		$string = str_replace( "#CAT", $cat, $string );
		echo $string;
	 ?>
     </div>
    <?php endif; ?> 
	
     <div class="lof-title">
		<a href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>"><?php echo $row->title; ?></a>
	</div>
    <div class="lof-information">

        <?php if( $navEnableDate && isset($row->date)) : ?>
           <div class="lof-date"><?php echo $row->date; ?></div>
          <?php endif; ?>

			<?php if($row->numOfComments>=0): 
			$row->numOfComments =  (int)$row->commentcount;?>
            <div class="lof-item-comment"">
                <?php echo $row->numOfComments; ?> 
            </div>
			<?php endif; ?>
          
  </div>        
 
    <?php if( $row->description   && $row->description !="..."): ?>
      <div class="lof-desc">
		<p><?php echo $row->description;?></p>
        	<?php if( $enableReadMore ): ?>
            <a  href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>" class="readmore"><?php echo JText::_("READMORE...");?></a>
            <?php endif; ?>
       </div> 
	<?php endif; ?>
</div>
<?php endif; ?>