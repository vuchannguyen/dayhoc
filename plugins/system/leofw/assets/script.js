// JavaScript Document
 window.addEvent('load', function(){
	 var JTooltips = new Tips($$('.mytip'), { maxTitleChars: 50, fixed: false});
	if( $defined(document.getElement('.leobtnclearcache a')) ) {
		/**
		 * create a simple box
		 */
		var itbox = new Element('div', {'class':'leo-box'} );
		itbox.hide();
		var itmessage =  new Element('div', {'class':'leo-message'});
			itbox.adopt( itmessage );
			document.getElement('body').adopt(itbox);
		var top = itbox.getTop();
		document.getElement('.leobtnclearcache a').addEvent('click' , function(e){
			itmessage.set('html','<div class="loading">Loading...</div>');
			itbox.show();
			var ajx = new Request({url:this.href, method:'post',
				onSuccess: function(data){ 
					(itmessage.set('html', data));
						(function(){ 
 						 
							itbox.hide();

						} ).delay( 1200 );
				}
			}).send();
			return false;
		});	
		return false;
	}
	
});