<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />
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
	
     <span class="lof-title">
		<a href="<?php echo $row->link;?>" target="<?php echo $openTarget ;?>" title="<?php echo $row->title; ?>"><?php echo $row->title; ?></a>
	</span>
   <div class="lof-desc"> <?php if( $row->description   && $row->description !="..."): ?>
	<?php echo $row->description;?>
   </div> 
	<?php endif; ?>
</div>
<?php endif; ?>