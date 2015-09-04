<?php 

// use item, navigator of the default layout.
	$itemLayout = dirname(dirname(__FILE__)).DS.'_item.php';
	$navigatorLayout =  dirname(__FILE__).DS."mixed.php";
 
	
	$class      = isset($themeConfig['basic-navigator_pos']) ?'lof-'.$themeConfig['basic-navigator_pos']:'';
	
	$navWidth   = isset($themeConfig['navslide-navitem_width']) ?$themeConfig['navslide-navitem_width']:235;
	$navHeight  = isset($themeConfig['navslide-navitem_height']) ?$themeConfig['navslide-navitem_height']:55;
 
?>

<div id="lofslideshow<?php echo $module->id; ?>" class="lof-slnavslide" style="height:<?php echo $moduleHeight;?>; width:<?php echo $moduleWidth;?>">
  <?php if( $params->get('display_button',1) ) : ?>
  	
      <div class="lof-previous"><?php echo JText::_('Previous');?></div>
      <div class="lof-next"><?php echo JText::_('Next');?></div>
 
    <?php endif; ?>
<div class="lof-container <?php echo $class;?> <?php echo $css3Class;?>">
	<?php if( $params->get('preload',1) ): ?>
        <div class="preload"><div></div></div>
    <?php endif; ?>
 
  <!-- MAIN CONTENT -->
  
  <div class="lof-main-wapper" style="height:<?php echo (int)$params->get('main_height',300);?>px;width:<?php echo (int)$params->get('main_width',650);?>px;">
   <div class="lof-proccessbar"></div>
    <?php foreach( $list as $row ): ?>
    <div class="lof-main-item">
      <?php  require( $contentSliderLayout ) ; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <!-- END MAIN CONTENT -->
  <?php if( $class && $class == 'lof-bottom' ) : ?>
 	 <div class="lof-navigator-wrapper lof-bullets-wrapper clearfix">
       <div class="lof-startstop"><div></div></div>
        <!-- NAVIGATOR -->
        <div class="lof-navigator-outer lof-bullets">
            <ul class="lof-navigator ">
            <?php foreach( $list as $key => $row ):?>
                <li><div><?php echo $key+1;?></div></li>
             <?php endforeach; ?> 		
            </ul>
        </div>
        <!-- END NAVIGATOR //-->
        </div>  
  <?php endif; ?>
</div>
<div class="lof-shadow"></div>
</div>
