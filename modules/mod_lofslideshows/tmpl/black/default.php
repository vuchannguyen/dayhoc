<?php 

// use item, navigator of the default layout.
	$itemLayout = dirname(dirname(__FILE__)).DS.'_item.php';
	$navigatorLayout =  dirname(dirname(__FILE__)).DS.'_navigator'.DS.$params->get('navigator_layout','mixed').'.php';
	$contentSliderLayout =  dirname(dirname(__FILE__)).DS.'_contentslider'.DS.$params->get('contentslider_layout','image-description').'.php';
	
	$class      = isset($themeConfig['black-navigator_pos']) ?'lof-'.$themeConfig['black-navigator_pos']:'';
	$navWidth   = isset($themeConfig['black-navitem_width']) ?$themeConfig['black-navitem_width']:310;
	$navHeight  = isset($themeConfig['black-navitem_height']) ?$themeConfig['black-navitem_height']:100;
	
?>

<div id="lofslideshow<?php echo $module->id; ?>" class="lof-slideshow-black" style="height:<?php echo $moduleHeight;?>; width:<?php echo $moduleWidth;?>">
<div class="lof-inner <?php echo $css3Class;?>">
    <div class="lof-container <?php echo $class;?> ">
        <?php if( $params->get('preload',1) ): ?>
            <div class="preload"><div></div></div>
        <?php endif; ?>
      <?php if( $class && $class != 'lof-bottom' ) : ?>
      <?php require( $navigatorLayout );?>
      <?php endif; ?>
      <!-- MAIN CONTENT -->
      <div class="lof-main-wapper" style="height:<?php echo (int)$params->get('main_height',300);?>px;width:<?php echo (int)$params->get('main_width',650);?>px;">
        <?php foreach( $list as $row ): ?>
        <div class="lof-main-item">
          <?php  require( $contentSliderLayout ) ; ?>
        </div>
        <?php endforeach; ?>
        <?php if( $params->get('display_button',1) ) : ?>
        <div class="lof-buttons-control">
          <div class="lof-previous"><?php echo JText::_('Previous');?></div>
          <div class="lof-next"><?php echo JText::_('Next');?></div>
        </div>
        <?php endif; ?>
         <div class="lof-startstop"><div></div></div>
        <div class="lof-proccessbar"></div>
      </div>
      <!-- END MAIN CONTENT -->
     
	  <?php if( $class && $class == 'lof-bottom' ) : ?>
      <?php require( $navigatorLayout );?>
      <?php endif; ?>
    </div>
</div>
</div>
