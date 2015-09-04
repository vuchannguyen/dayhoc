<script type="text/javascript">
  var _lofmain =  $('lofslideshow<?php echo $module->id; ?>'); 
  var info =  _lofmain.getElements(".lof-description");
  var direction = '<?php echo ( isset($themeConfig['thumbs-descdirection']) ?$themeConfig['thumbs-descdirection']:"left");?>';
 	info.setStyle( direction,-500);
  var object = new LofSlideshow( _lofmain,
                  { 
                    fxObject:{
                    transition:<?php echo $params->get( 'effect', 'Sine.easeInOut' );?>,  
                    duration:<?php echo (int)$params->get('duration', '700')?>
                    },
                    startItem:<?php echo (int)$params->get('start_item',0);?>,
                    interval:<?php echo (int)$params->get('interval', '3000'); ?>,
                    direction :'<?php echo $params->get('layout_style','opacity');?>', 
                    navItemHeight:<?php echo $navHeight ?>,
                    navItemWidth:<?php echo $navWidth ?>,
                    navItemsDisplay:<?php echo $params->get('max_items_display', 3) ?>,
                    navPos:'bottom',
					onNavActived:function(index, currentSlider ){  
						if( info ) {info.tween(direction,-500);	} 
						(function(){
							if( $defined(currentSlider.getElement(".lof-description")) ) {
					 			currentSlider.getElement(".lof-description").set('tween', {duration: 'long',transition:Fx.Transitions.Sine.easeInOut} ).tween(direction,0);
							}
						}).delay(300);
					}
                  } );
  <?php if( $params->get('display_button', '') ): ?>
    object.registerButtonsControl( 'click', {next:_lofmain.getElement('.lof-next'),
                         previous:_lofmain.getElement('.lof-previous')} );
  <?php endif; ?>
    object.start( <?php echo $params->get('auto_start',1)?>, _lofmain.getElement('.preload') );
</script>