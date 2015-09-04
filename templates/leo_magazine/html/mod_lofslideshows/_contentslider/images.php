<?php if( $row->link ) : ?>
<a   target="<?php echo $openTarget ;?>"  href="<?php echo $row->link;?>" title="<?php echo $row->title;?>">
<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />
</a>
<?php else: ?>
<img src="<?php echo $row->mainImage;	?>" title="<?php echo $row->title;?>" />
<?php endif; ?>