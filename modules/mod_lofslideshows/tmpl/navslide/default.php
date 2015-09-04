<?php 

// use item, navigator of the default layout.
	$itemLayout = dirname(dirname(__FILE__)).DS.'_item.php';
	$navigatorLayout =  dirname(__FILE__).DS."mixed.php";
	$contentSliderLayout =  dirname(dirname(__FILE__)).DS.'_contentslider'.DS.$params->get('contentslider_layout','image-description').'.php';
	
	$class      = isset($themeConfig['navslide-navigator_pos']) ?'lof-'.$themeConfig['navslide-navigator_pos']:'';
	$navWidth   = isset($themeConfig['navslide-navitem_width']) ?$themeConfig['navslide-navitem_width']:235;
	$navHeight  = isset($themeConfig['navslide-navitem_height']) ?$themeConfig['navslide-navitem_height']:55;

	
?>

<div id="lofslideshow<?php echo $module->id; ?>" class="lof-slnavslide" style="height:<?php echo $moduleHeight;?>; width:<?php echo $moduleWidth;?>">

<div class="lof-container <?php echo $class;?> <?php echo $css3Class;?>">
	<?php if( $params->get('preload',1) ): ?>
        <div class="preload"><div></div></div>
    <?php endif; ?>
  <?php if( $class && $class != 'lof-bottom' ) : ?>
  <?php require( $navigatorLayout );?>
  <?php endif; ?>
  <!-- MAIN CONTENT -->
  <div class="lof-main-wapper" style="height:<?php echo (int)$params->get('main_height',300);?>px;width:<?php echo (int)$params->get('main_width',650);?>px;">
   <div class="lof-proccessbar"></div>
    <?php foreach( $list as $row ): ?>
    <div class="lof-main-item">
      <?php  require( $contentSliderLayout ) ; ?>
    </div>
    <?php endforeach; ?>
     <div class="lof-startstop"><div></div></div>
    <?php if( $params->get('display_button',1) ) : ?>
  	
      <div class="lof-previous"><?php echo JText::_('Previous');?></div>
      <div class="lof-next"><?php echo JText::_('Next');?></div>
 
    <?php endif; ?>
  </div>
  <!-- END MAIN CONTENT -->
  <?php if( $class && $class == 'lof-bottom' ) : ?>
  <?php require( $navigatorLayout );?>
  <?php endif; ?>
</div>

</div>
