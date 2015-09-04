$(window).addEvent( 'load', function(){
								
	$$(".lof-cbktoggle").each( function(item){
		item.addEvent( 'click', function(){
			if(item.checked){
				$$("#toggle-"+item.id).show();
			} else {
				$$("#toggle-"+item.id).hide();
			}
		} );
		
		if(item.checked){
			$$("#toggle-"+item.id).show();
		} else {
			$$("#toggle-"+item.id).hide();
		}
			
			
	} );
			
	// add event addrow
	$$('.it-addrow-block .add').each( function( item, idx ){ 
		item.addEvent('click', function( ){
			var name   = "jform[params]["+item.getProperty('id').replace('btna-','')+"][]"
			var newrow = new Element('div', {'class':'row'} );	
			var input  = new Element('input', {'name':name,'type':'text'} );
			var span   = new Element('span',{'class':'remove'});
			var spantext   = new Element('span',{'class':'spantext'}); 
				newrow.adopt( spantext );	
				newrow.adopt( input );	
				newrow.adopt( span );			
			var parent = item.getParent().getParent();	
			parent.adopt( newrow );	
			spantext.innerHTML= parent.getElements('input').length;	
			span.addEvent('click', function(){ 
											
				if( span.getParent().getElement('input').value ) {
					if( confirm('Are you sure to remove this') ) {
						span.getParent().dispose(); 
					}
				} else {
					span.getParent().dispose(); 
				}
				setTimeout( function(){ $$('.jpane-slider ').setStyle( 'height', $$('.paramlist').offsetHeight );
																		parent.getElements('.spantext').each( function(tm,j){
																			tm.innerHTML=j+1;											   
																		});					
				}, 300 );
			} );				 
			setTimeout( function(){
				//	$E('.jpane-slider ').setStyle( 'height', $E('.paramlist').offsetHeight );
			//		parent.getElements('.spantext').each( function(tm,j){tm.innerHTML=j+1;});	
					
			}, 300 );
				    
		} );
	} );
	$$('.it-addrow-block .row').each(function( item ){
		item.getElement('.remove').addEvent('click', function() {
			if( item.getElement('input').value ) {
				if( confirm('Are you sure to remove this') ) {
					item.dispose();
				}
			}else {
				item.dispose();
			}
		//	setTimeout( function(){ $E('.jpane-slider ').setStyle( 'height', $E('.paramlist').offsetHeight );}, 300 );
		} );
	});
} );

