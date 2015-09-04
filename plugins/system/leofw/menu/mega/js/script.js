/*------------------------------------------------------------------------
 # Leo Template Framework - 
 # ------------------------------------------------------------------------
 # author    LeoTheme
 # copyright Copyright (C) 2010 leotheme.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.leotheme.com
 # Technical Support:  Forum - http://www.leotheme.com/forum.html
-------------------------------------------------------------------------*/
/**
 * Class LeoMegaMenu
 */
var LeoMegaMenu = new Class( {
							
	/**
	 * constructor 
	 */						
	initialize:function( wrapper, options){	
		this.options = $extend({	
			transition:Fx.Transitions.Sine.easeInOut,
			duration:800,
			delay:400,
			effect:"simple"
		}, options || {} );
		$(wrapper).getElements( 'li' ).each( function(item) {
			item.addEvents( {"mouseenter":function(){ item.addClass('hover') },"mouseleave":function(){  item.removeClass('hover')  } } );
		} );
		
		this.objEffect = {
			transition:this.options.transition,
			duration:this.options.duration
		};
		$(wrapper).getElements( '.menusub_mega' ).each( function( item, i ){
			var id = item.id.split("_");
			if( id[2] != null ) { 
				var classSuffix = "_" + id[1] + "_" + id[2];   
				var megaboxes = $(document.body).getElements('[id$=' +classSuffix + ']');
				switch( this.options.effect ){
			 		case "sliding":
						this.slidingEffect( megaboxes, classSuffix ); break;
					case "fade":
						this.fadeEffect( megaboxes, classSuffix ); break;
					default:
						this.simpleEffect( megaboxes, classSuffix ); break;
						
				}
			};
		}.bind(this) );
	},
	
	/**
	 * Sliding Fade Effect 
	 */
	slidingEffect:function( megaboxes, classSuffix ){
		var height=[];
		this.timmerDelay = 0;
		megaboxes.each(function(item, i) {					
			var current = item.getProperty('id');  
			current = current.replace('' + classSuffix + '', '');
			height[i] = $(item).getSize().x;  	
			
			if( item.hasClass("level0") ){
				item.getChildren().setStyles( {'margin-top':-height[i],'opacity':0} );	
			} else {
				item.getChildren().setStyles( {'margin-left': -$(item).getSize().y,'opacity':0}  );	
			}
			item.timer = null;
			$(current).addEvent('mouseenter', function(){
				$clear(item.timer); item.timer = null;this.timmerDelay=0;												   
				item.setStyle("overflow","hidden").getChildren().set( "morph", $extend(this.objEffect,{onComplete:function(){ 
					if( item.retrieve( "active" ) == 'show' ) {
						item.setStyle("overflow","visible");
					}else {
						item.setStyle("left","-999em");	
					}
				} }) );
			
				item.store( "active", "show" );
				// apply the sliding down effect for menu level firstest.
				item = this.setCurrentMenuPosition( item, current, 0, 0 );
			 	if( item.hasClass("level0") ){
					item.getChildren().morph( {'margin-top':0,opacity:1}  );	
				} else {
					item.getChildren().morph( {'margin-left':0,opacity:1}  );	
				}
			}.bind(this) );
			
			$(current).addEvent('mouseleave', function(){								   
				if( item.hasClass("level0") ){
					if( this.timmerDelay > 0 ){
						item.timer = (function(){
							item.getChildren().morph( {'margin-top':-height[i],opacity:0} );
							item.setStyle( "overflow","hidden" ).store( "active", "hide" );
							this.timmerDelay=0;
						}).delay(this.timmerDelay, this);
					} else {
						item.getChildren().morph( {'margin-top':-height[i],opacity:0} );
						item.setStyle( "overflow","hidden" ).store( "active", "hide" );
						this.timmerDelay = 0;
					}
				} else { 
					item.setStyle("overflow","hidden").store( "active", "hide" );
					item.getChildren().morph( {'margin-left':-$(item).getSize().y,opacity:0}  );
					// set delay timer to make sure all parent is closed done.
					this.timmerDelay = this.options.delay;
				}
			}.bind(this) );
			
		}.bind(this) );
	},
	
	/**
	 * Simple Effect to show Mega Menu Item
	 */
	simpleEffect: function( megaboxes, classSuffix ){
	
		megaboxes.each(function(item, i) {
			var current = item.getProperty('id');  
			current = current.replace('' + classSuffix + '', '');
			$(current).addEvent('mouseenter', function(){
				 megaboxes.hide();
				 item.show();
				 this.setCurrentMenuPosition( item, current, 0, 0 );
			}.bind(this) );
			$(current).addEvent('mouseleave', function(){
				  megaboxes.hide();
			});
			
		}.bind(this) );
	},
	
	/**
	 * Simple Effect to show Mega Menu Item
	 */
	fadeEffect: function( megaboxes, smartBoxSuffix ){
		megaboxes.each(function(item, i) {
			item.set("tween", this.objEffect );					
			var current = item.getProperty('id');  
			current = current.replace('' + smartBoxSuffix + '', '');
			megaboxes.setStyle("opacity",0).tween( "opacity",0 );
			$(current).addEvent('mouseenter', function(){
				 megaboxes.setStyle("opacity",0).tween( "opacity",0 );
				 item.tween("opacity", 1 );
				 this.setCurrentMenuPosition( item, current, 0, 0 );
			}.bind(this) );
			$(current).addEvent('mouseleave', function(){
				 megaboxes.tween( "opacity",0 );
			});
			
		}.bind(this) );
	},
	
	/**
	 * Caculate Menu Item Before Visable
	 */
	setCurrentMenuPosition:function( item, current, xOffset, yOffset ){
		
		item.setStyles({   position: 'absolute' }).setStyle('z-index', '999');
		var windowWith 		= window.getWidth();
		var boxSize 		= item.getSize();
		var currentPos 		= $(current).getCoordinates();
		var currentCd 		= $(current).getPosition();
		var currentSize 	= $(current).getSize();
		var currentBotPos 	= currentPos.top + currentSize.y;
		var currentLeftPos 	= currentPos.left + xOffset;
		var currentRightPos = currentPos.right;
		var leftOffset 		= currentCd.x + xOffset;
		
		
		if(item.getProperty('id').split("_")[2] == 'sub0') {
			item.setStyle( 'top', currentBotPos );
			if( windowWith - currentLeftPos - boxSize.x > 0 ) {
				item.setStyle( 'left', currentLeftPos );
				item.store("pos","right");
			} else if( currentRightPos > boxSize.x ) {
				item.setStyle( 'left', currentRightPos - boxSize.x );
			} else {
				item.setStyle('left', ( windowWith - boxSize.x)/2 );
			}
		} else {
			if( windowWith - currentRightPos - boxSize.x > 0 ) {
				item.setStyle('left', currentSize.x );
			} else if( currentRightPos > boxSize.x ) {
				item.setStyle('left', -boxSize.x );
			} else {
				item.setStyle( 'left', -(windowWith - boxSize.x) );
			}
		}
		
		return  item;
	}

} );