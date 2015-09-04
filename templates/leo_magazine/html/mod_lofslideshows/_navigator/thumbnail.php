<div class="lof-navigator-wrapper clearfix">
    <!-- NAVIGATOR -->
      <div class="lof-navigator-outer">
            <ul class="lof-navigator lof-thumbnails">
            <?php foreach( $list as $row ):?>
                <li style="border:0">
          
                	<img height="<?php echo $thumbnailHeight;?>" width="<?php echo $thumbnailWidth?>" style="padding:<?php echo $thumbnailMargin;?>; margin:0px;" src="<?php echo $row->thumbnail;?>" title="<?php echo $row->title?>" />
                	 
                	</li>
             <?php endforeach; ?> 		
            </ul>
      </div>
 	<!-- END NAVIGATOR //-->
</div>    