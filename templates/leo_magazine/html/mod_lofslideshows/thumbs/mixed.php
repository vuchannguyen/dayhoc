<div class="lof-navigator-wrapper clearfix">
    <!-- NAVIGATOR -->
      <div class="lof-navigator-outer">
            <ul class="lof-navigator">
            <?php foreach( $list as $row ): // echo '<pre>'.print_r( $row,1); die; ?>
                <li style="width:<?php echo $navWidth;?>px; height:<?php echo $navHeight;?>px;">
               		 <div class="lof-title">
                        <h3 style="margin:0">
                                <?php echo $row->title; ?>
                        </h3>
                    </div>
          			<div class="lof-navinfo"  >       
                        <?php if( $navEnableTitle && $row->title) : ?>
                        <h3><?php echo $row->title; ?></h3>
                        <?php endif; ?>
					   <?php if( $navEnableThumbnail ): ?>
                        <img src="<?php echo $row->thumbnail;?>" title="<?php echo $row->title?>" />
                       <?php endif; ?>
                
                        <?php if( isset($row->navdesc) ) :?>
                        <span><?php  echo $row->navdesc; ?></span>
                        <?php endif; ?>
                        <div class="clearfix clr">
                        <?php if( $navEnableDate && $row->date) : ?>
                        	<span><?php echo $row->date; ?></span>
                          <?php endif; ?>
                          <?php if( $navEnableDate && $row->catid) :?>
                          <span>- <?php echo JText::_("Published in");?>
                         <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid));?>"><b><?php echo $row->category_title;?></b></a></span>
                         <?php endif; ?>
                         </div>
                 </div>               
            	</li>
                 
                 
             <?php endforeach; ?> 		
            </ul>
      </div>
 	<!-- END NAVIGATOR //-->
</div>    