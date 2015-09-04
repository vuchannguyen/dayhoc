<div class="lof-navigator-wrapper clearfix">
    <!-- NAVIGATOR -->
      <div class="lof-navigator-outer">
            <ul class="lof-navigator">
            <?php foreach( $list as $row ): // echo '<pre>'.print_r( $row,1); die; ?>
                <li style="width:<?php echo $navWidth;?>px; height:<?php echo $navHeight;?>px;">
          			<div style="padding:<?php echo $thumbnailMargin;?>">       
                   <?php if( $navEnableThumbnail ): ?>
                	<img src="<?php echo $row->thumbnail;?>" title="<?php echo $row->title?>" />
                   <?php endif; ?>
                   <?php if( $navEnableTitle && $row->title) : ?>
                    	<span class="lof-title"><?php echo $row->title; ?></span>
                    <?php endif; ?>
                    <?php if( isset($row->navdesc) &&  $row->navdesc ) :?>
                    <span><?php  echo $row->navdesc; ?></span>
                    <?php endif; ?>
                    <?php if( $navEnableDate && isset($row->date)) : ?>
                       <p><i><?php echo $row->date; ?></i></p>
                      <?php endif; ?>
                      <?php if( $navEnableDate && isset($row->catid)) :?>
                      <p >  <?php echo JText::_("Published in");?>
                     <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid));?>"><b><?php echo $row->category_title;?></b></a></p>
                     <?php endif; ?>
                 </div>               
            	</li>
                 
                 
             <?php endforeach; ?> 		
            </ul>
      </div>
 	<!-- END NAVIGATOR //-->
</div>    