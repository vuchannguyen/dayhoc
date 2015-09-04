<?php 
	$row->description = preg_replace("/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/","",$row->description);
?>
<?php if( $row->link ): ?>
<a href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>">
<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />
</a>
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
 
    <?php if( $row->description   && $row->description !="..."): ?>
      <div class="lof-desc">
		<?php echo $row->description;?>
        	<?php if( $enableReadMore ): ?>
            <a  href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>" class="readmore"><?php echo JText::_("READMORE...");?></a>
            <?php endif; ?>
       </div> 
	<?php endif; ?>
</div>
<?php endif; ?>