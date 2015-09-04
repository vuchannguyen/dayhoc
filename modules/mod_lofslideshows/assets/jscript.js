/**
 * @version		$Id:  $Revision
 * @package		mootool
 * @subpackage	lofslidernews
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website     http://landofcoder.com
 * @license		This plugin is dual-licensed under the GNU General Public License and the MIT License 
 */
 ////
if( typeof(LofSlideshow) == 'undefined' ){
	var LofSlideshow = new Class( {
		initialize:function( _lofmain, options ){
			this.setting = $extend({
				autoStart			: true,
				descStyle	    	: 'sliding',
				mainItemSelector    : 'div.lof-main-item',
				navSelector  		: 'li' ,
				navigatorEvent		: 'click',
				interval	  	 	:  2000,
				auto			    : false,
				navItemsDisplay		: 3,
				startItem			: 0,
				navItemHeight		: 100,
				navItemWidth 		: 310,
				onNavActived:function(){}
			}, options || {} );
			
			var eMain 	   = _lofmain.getElement('.lof-main-wapper');
			var eNavigator = _lofmain.getElement('.lof-navigator-outer .lof-navigator');
			var eNavOuter  = _lofmain.getElement('.lof-navigator-outer');	  
			this.currentNo  = 0;
			this.nextNo     = null;
			this.previousNo = null;
			this.fxItems	= [];	
			this.minSize 	= 0;
			this.onClick = false;
			if( $defined(eMain) ){
				this.slides	   = eMain.getElements( this.setting.mainItemSelector );
				this.maxWidth  = eMain.getStyle('width').toInt();
				this.maxHeight = eMain.getStyle('height').toInt();
				this.styleMode = this.__getStyleMode();  
				var fx =  $extend({waiting:false, onComplete:function(){ this.onClick=false}.bind(this) }, this.setting.fxObject );
				this.slides.each( function(item, index) {	
					item.setStyles( eval('({"'+this.styleMode[0]+'": index * this.maxSize,"'+this.styleMode[1]+'":Math.abs(this.maxSize),"display" : "block"})') );		
					this.fxItems[index] = new Fx.Morph( item,  fx );
				}.bind(this) );
				if( this.styleMode[0] == 'opacity' || this.styleMode[0] =='z-index' ){
					this.slides[0].setStyle(this.styleMode[0],'1');
				}
				if( this.styleMode[0] == 'opacity'){
					this.slides[0].setStyle('z-index',10);
				}
				eMain.addEvents( { 'mouseenter' : this.stop.bind(this),
							   	   'mouseleave' :function(e){ 
								    if(  this.setting.auto ){
										this.play( this.setting.interval,'next', true );
									} }.bind(this) } );
			}
			this.progressbar =  _lofmain.getElement(".lof-proccessbar");
			if( this.progressbar ){
				this.progressbar.fade('out');
				this.progressbar.set("morph",{
					'duration': this.setting.interval,
					'transition': 'linear'
				});
				this.progressbar.maxWidth = this.progressbar.offsetWidth;
			}
			if( $defined(eNavigator) && $defined(eNavOuter) ){
				var modes = {
					horizontal : ['margin-left', 'width', 'height', 'navItemWidth', 'navItemHeight'],
					vertical   : ['top', 'height', 'width', 'navItemHeight', 'navItemWidth']
				}
				var mode = ( this.setting.navPos == 'bottom' || this.setting.navPos == 'top' )?'horizontal' : 'vertical';	
		
				this.navigatorItems = eNavigator.getElements( this.setting.navSelector );
				if( this.setting.navItemsDisplay > this.navigatorItems.length ){
					this.setting.navItemsDisplay = this.navigatorItems.length;	
				}
				
				if( $defined(_lofmain.getElement(".lof-bullets"))  ){
					this.setting.navItemHeight = this.navigatorItems[0].offsetHeight;
					this.setting.navItemWidth  = this.navigatorItems[0].offsetWidth;
				} else if( $defined(_lofmain.getElement(".lof-thumbnails"))  ){ 
					 this.setting.navItemHeight = this.navigatorItems[0].getFirst().getSize().y ;
					 this.setting.navItemWidth = this.navigatorItems[0].getFirst().getSize().x ;
				}
				
				this.navigatorSlideSize = this.setting[modes[mode][3]];	 
				eNavOuter.setStyle(modes[mode][1], this.setting.navItemsDisplay * this.navigatorSlideSize);
                eNavOuter.setStyle(modes[mode][2], this.setting[modes[mode][4]] );
								
				this.navigatorMode = 	modes[mode][0];		
				this.navigatorFx = new Fx.Tween( eNavigator,{transition:Fx.Transitions.Sine.easeInOut,duration:900} );
					
					
				if( $defined( _lofmain.getElement(".lof-startstop") ) ) {
					_lofmain.getElement(".lof-startstop").addEvent('click', function(){
						if( _lofmain.getElement(".lof-startstop div").hasClass("lof-stop") ){
							this.setting.auto =true;
							this.play( this.setting.interval,'next', true );
							 _lofmain.getElement(".lof-startstop div").removeClass("lof-stop").addClass("lof-start");
						}else {
							this.setting.auto =false;
							this.stop();
							 _lofmain.getElement(".lof-startstop div").removeClass("lof-start").addClass("lof-stop");	
						}
					}.bind(this) );
				}
			

				this.navigatorItems.each( function(item,index) {
					item.addEvent( this.setting.navigatorEvent, function(){		
					if( this.onClick ) return ;
						this.jumping( index, true );
						this.setNavActive( index, item );	
					}.bind(this) ); 
	
						item.setStyles( { 'height' : this.setting.navItemHeight,
									  	  'width'  : this.setting.navItemWidth} );		
				}.bind(this) );
				// set default setting
				this.currentNo=this.setting.startItem.toInt()>this.slides.length?this.slides.length:this.setting.startItem.toInt();
				this.setNavActive( this.currentNo );
				this.slides.setStyle(this.styleMode[0] ,this.maxSize );
				this.slides[this.currentNo].setStyle(this.styleMode[0] ,this.minSize );
	
			}
		},
		navivationAnimate:function( currentIndex ) { 
			if (currentIndex <= this.setting.startItem 
				|| currentIndex - this.setting.startItem >= this.setting.navItemsDisplay-1) {
					this.setting.startItem = currentIndex - this.setting.navItemsDisplay+2;
					if (this.setting.startItem < 0) this.setting.startItem = 0;
					if (this.setting.startItem >this.slides.length-this.setting.navItemsDisplay) {
						this.setting.startItem = this.slides.length-this.setting.navItemsDisplay;
					}
			}		
			this.navigatorFx.cancel().start( this.navigatorMode,-this.setting.startItem*this.navigatorSlideSize );	
			this.setting.onNavActived( currentIndex, this.slides[currentIndex] );	
		},
		setNavActive:function( index, item ){
			if( $defined(this.navigatorItems) && $defined( this.navigatorItems[index] ) ){ 
				this.navigatorItems.removeClass('active');
				this.navigatorItems[index].addClass('active');	
				this.navivationAnimate( this.currentNo );
							
			}

		},
		__getStyleMode:function(){
			switch( this.setting.direction ){
				case 'opacity': this.maxSize=0; this.minSize=1; return ['opacity','opacity'];
				case 'replace': this.maxSize=0; this.minSize=1; return ['display','display'];
				case 'vrup':    this.maxSize=this.maxHeight;    return ['top','height'];
				case 'vrdown':  this.maxSize=-this.maxHeight;   return ['top','height'];
				case 'hrright': this.maxSize=-this.maxWidth;    return ['left','width'];
				case 'hrleft':
				default: this.maxSize=this.maxWidth; return ['left','width'];
			}
		},
		registerMousewheelHandler:function( element ){ 
			element.addEvents({
				'wheelup': function(e) {
					
					e = new Event(e).cancel(); 
						this.previous(true);
				}.bind(this),
			 
				'wheeldown': function(e) {
					e = new Event(e).cancel();
				
					this.next(true);
				}.bind(this)
			} );
		},
		registerButtonsControl:function( eventHandler, objects, isHover ){
			if( $defined(objects) && this.slides.length > 1 ){
				for( var action in objects ){ 
					if( $defined(this[action.toString()])  && $defined(objects[action]) ){ 
						objects[action].addEvent( eventHandler, this[action.toString()].bind(this, true) );
					}
				}
			}
			return this;	
		},
		start:function( isStart, obj ){
			this.setting.auto = isStart;
			// if use the preload image.
			if( obj ) {
				this.preloadImages(  obj );
			} else {
				if( this.setting.auto && this.slides.length > 1 ){
						this.play( this.setting.interval,'next', true );}	
			}
			
			if( $defined( _lofmain.getElement(".lof-startstop") ) ) {
				if( this.setting.auto ){
					_lofmain.getElement(".lof-startstop div").addClass("lof-start");	
				} else {
					_lofmain.getElement(".lof-startstop div").addClass("lof-stop");		
				}
			}
		},
		onComplete:function( obj ){
			(function(){																
				obj.fade('out');		
			}).delay(500);
			if( this.setting.auto && this.slides.length > 1 ){
				this.play( this.setting.interval,'next', true );}	
			
		},
		preloadImages:function( obj ){  
			var loaded=[];
			var counter=0;
			var self = this;
			var _length = this.slides.getElements('img').length;
			this.timer = setInterval( function(){
				if(counter >= _length) {	
						$clear(self.timer);
						self.onComplete( obj );
						return true;
				} 
			}, 200);
			this.slides.getElements('img').each( function(img, index){
				image = new Image();
				image.src=img.src;
				if( !image.complete ){				  
					image.onload =function(){
						counter++;
					}
					image.onerror =function(){ 
						counter++;
					}
				}else {
					counter++;
				}
			} );
		},
		onProcessing:function( manual, start, end ){	
			this.onClick = true;
			this.previousNo = this.currentNo + (this.currentNo>0 ? -1 : this.slides.length-1);
			this.nextNo 	= this.currentNo + (this.currentNo < this.slides.length-1 ? 1 : 1- this.slides.length);				
			return this;
		},
		finishFx:function( manual ){
			if( manual ) this.stop();
			if( manual && this.setting.auto ){	
				this.play( this.setting.interval,'next', true );
			}		
			this.setNavActive( this.currentNo );	
			if( this.setting.direction == 'opacity'){
				var i=0;
				this.slides.each(function(el,index){
					this.slides[i].setStyle('z-index',0);
					i++;
				}.bind(this));
				//var index1 = this.currentNo + 1; alert( this.currentNo);
				this.slides[ this.currentNo ].setStyle('z-index',10);
			}
		},
		getObjectDirection:function( start, end ){
			return eval("({'"+this.styleMode[0]+"':["+start+", "+end+"]})");	
		},
		fxStart:function( index, obj ){
			this.fxItems[index].cancel(true, false).start( obj );
			return this;
		},
		processbar:function(){  
			this.progressbar.morph({
				'width': [0,this.progressbar.maxWidth]
			});
			this.progressbar.fade('in');
		},
		jumping:function( no, manual ){
			this.stop();
			if( this.currentNo == no ) return;
			var object = this.onProcessing( null, manual, 0, this.maxSize );
			if( this.currentNo < no  ){
				object.fxStart( no, this.getObjectDirection(this.maxSize , this.minSize) );
				object.fxStart( this.currentNo, this.getObjectDirection(this.minSize,  -this.maxSize) );
			} else {
				object.fxStart( no, this.getObjectDirection(-this.maxSize , this.minSize) );
				object.fxStart( this.currentNo, this.getObjectDirection(this.minSize,  this.maxSize) );	
			}
			this.currentNo  = no;
			object.finishFx( manual );	
			
		},
		next:function( manual , item){
			if( this.onClick ) return ;
			this.currentNo += (this.currentNo < this.slides.length-1) ? 1 : (1 - this.slides.length);	
			this.onProcessing( item, manual, 0, this.maxSize )
				.fxStart( this.currentNo, this.getObjectDirection(this.maxSize ,this.minSize) )
				.fxStart( this.previousNo, this.getObjectDirection(this.minSize, -this.maxSize) )
				.finishFx( manual );
		},
		previous:function( manual, item ){
			if( this.onClick ) return ;
			this.currentNo += this.currentNo > 0 ? -1 : this.slides.length - 1;
			this.onProcessing( item, manual, -this.maxWidth, this.minSize )
				.fxStart( this.nextNo, this.getObjectDirection(this.minSize, this.maxSize) )
				.fxStart( this.currentNo,  this.getObjectDirection(-this.maxSize, this.minSize) )
				.finishFx( manual	);			
		},
		play:function( delay, direction, wait ){
			this.stop(); 
			 if( this.progressbar ){ this.processbar(); }
			if(!wait){ this[direction](false); }
			this.isRun = this[direction].periodical(delay,this,true);
		},stop:function(){ if( this.progressbar ){ this.progressbar.get("morph").stop(); }  $clear(this.isRun ); clearInterval(this.isRun); }
	} );
}
