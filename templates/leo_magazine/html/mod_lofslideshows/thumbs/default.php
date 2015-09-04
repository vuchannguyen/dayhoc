<?php 

// use item, navigator of the default layout.
	$itemLayout = dirname(dirname(__FILE__)).DS.'_item.php';
	$navigatorLayout =  dirname(__FILE__).DS."mixed.php";
	$contentSliderLayout =  dirname(dirname(__FILE__)).DS.'_contentslider'.DS.$params->get('contentslider_layout','image-description').'.php';
	
	$class      = isset($themeConfig['thumbs-navigator_pos']) ?'lof-'.$themeConfig['thumbs-navigator_pos']:'';
	$navWidth   = isset($themeConfig['thumbs-navitem_width']) ?$themeConfig['thumbs-navitem_width']:310;
	$navHeight  = isset($themeConfig['thumbs-navitem_height']) ?$themeConfig['thumbs-navitem_height']:100;

	
?>

<div id="lofslideshow<?php echo $module->id; ?>" class="descslide" style="height:270px; width:auto;">
    <?php if( $params->get('preload',1) ): ?>
    <div class="preload">
      <div></div>
    </div>
    <?php endif; ?>
    
  <div class="lof-container <?php echo $class;?> ">

          <?php if( $params->get('display_button',1) ) : ?>
     
        <div class="lof-previous"><?php echo JText::_('Previous');?></div>
        <div class="lof-next"><?php echo JText::_('Next');?></div>
 
      <?php endif; ?>
    <!-- MAIN CONTENT -->
    <div class="lof-main-wapper <?php echo $css3Class;?>" style="height:<?php echo (int)$params->get('main_height',300);?>px;width:auto;">
      <!--<div class="lof-proccessbar"></div>-->
      <?php foreach( $list as $row ): ?>
      <div class="lof-main-item">
        <?php  require( $contentSliderLayout ) ; ?>
      </div>
      <?php endforeach; ?>
    <!--  <div class="lof-startstop">
        <div></div>
      </div>-->

    </div>
      
    <!-- END MAIN CONTENT -->
        <div class="lof-navigator-wrapper clearfix">
            <!-- NAVIGATOR -->
              <div class="lof-navigator-outer">
                    <ul class="lof-navigator lof-thumbnails">
                    <?php foreach( $list as $row ):?>
                        <li style="border:0">
                  				<div style="padding:<?php echo $thumbnailMargin;?>; height:<?php echo $thumbnailHeight;?>px; width:<?php echo $thumbnailWidth?>px;">
                                <span>
                            <img height="<?php echo $thumbnailHeight;?>" width="<?php echo $thumbnailWidth?>" style="" src="<?php echo $row->thumbnail;?>" title="<?php echo $row->title?>" /></span>
                             	</div>
                            </li>
                     <?php endforeach; ?> 		
                    </ul>
              </div>
            <!-- END NAVIGATOR //-->
        </div>    
  </div>

</div>
