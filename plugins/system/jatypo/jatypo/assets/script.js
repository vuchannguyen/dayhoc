/**
 * ------------------------------------------------------------------------
 * JA Typo plugin For Joomla 1.7
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 JoomlArt.com. All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * Author: JoomlArt.com
 * Websites: http://www.joomlart.com - http://www.joomlancers.com.
 * ------------------------------------------------------------------------
 */
var JATypo = new Class ({
	initialize: function(options) {
		this.options = $extend({
			offsets: {x:10, y: 10}
		}, options || {});
		
		this.overlay = new Element ('div', {'id':'jatypo-overlay'}).inject ($(document.body));
		this.overlay.setStyles ({'width':window.getScrollWidth(), 'height': window.getScrollHeight()});
		this.wrapper = $('jatypo-wrap');		
		if (!this.wrapper) return;		
		var button2 = new Element ('div', {'class':'button2-right jatypo-btn'});
		
		if (isBrowserIE()) {
			button2.innerHTML = '<a href="#" onclick="IeCursorFix(); return false;"><span>JATypo</span></a>';
		}
		else
		{
			button2.innerHTML = '<span>JATypo</span>';
		}

		this.button = new Element ('div', {'class':'button2-left'}).adopt(button2).injectBefore($('editor-xtd-buttons'));
		
		this.typos = this.wrapper.getElements ('.typo');
		this.typos.addEvents ({
			'mouseenter': function (){
				this.addClass ('typo-over');
				//detect popup position
				var wrapper = $('jatypo-wrap');
				var sample = this.getElement ('.sample');
				var pos_s = findPos (sample);
				var pos_w = findPos (wrapper);
				var scroll_w = {x: wrapper.scrollLeft, y: wrapper.scrollTop};
				
				var x0 = pos_w.x + scroll_w.x;
				var y0 = pos_w.y + scroll_w.y;
				var w0 = wrapper.offsetWidth;
				var h0 = wrapper.offsetHeight;
				var x1 = pos_s.x;
				var y1 = pos_s.y;
				var w1 = sample.offsetWidth;
				var h1 = sample.offsetHeight;
				
				//Detect class need to add to ajdust the position of sample popup
				if (y1<y0) {this.addClass ('typo-top').removeClass ('typo-bottom')}
				if (y1+h1>y0+h0) {this.addClass ('typo-bottom').removeClass ('typo-top')}
				if (x1<x0) {this.addClass ('typo-left').removeClass ('typo-right')}
				if (x1+w1>x0+w0) {this.addClass ('typo-right').removeClass ('typo-left')}
				
			},			
			
			'mouseleave': function (){this.removeClass ('typo-over');},
			'click': function (){
				var sample = this.getElement ('.sample');
				var html = sample.innerHTML;
				if ($('jform_content')) {
					jInsertEditorText(html, 'jform_content');
				}
				else {
					jInsertEditorText(html, 'jform_articletext');
				}
				$('jatypo-wrap').style.display ='none';
			}
		});
		this.wrapper.injectAfter (this.overlay);
		this.button.addEvent ('click', function (event) {
			event = new Event(event);
			//this.locate (event);
			this.position();
			event.stop();
		}.bind (this));
		this.overlay.addEvent ('click', function () {this.wrapper.style.display = 'none';this.overlay.style.display='none';}.bind(this));
		
		//Typo css into editor (tinymce)
		//var doc = $('text_ifr')?($('text_ifr').contentWindow?$('text_ifr').contentWindow.document:$('text_ifr').contentDocument):null;
		//Typo css into editor (tinymce)->article
		var doc = null;
		if ($('jform_articletext_ifr')) {
			doc = $('jform_articletext_ifr').contentWindow.document;
		}
		
		//Typo css into editor (tinymce)->custom
		if ($('jform_content_ifr')) {
			doc = $('jform_content_ifr').contentWindow.document;
		}
		if (doc) {
			var head = doc.getElementsByTagName('head')[0];
			var css = doc.createElement ('link');
			css.rel = 'stylesheet';
			css.type = 'text/css';
			css.href = this.options.typocss;
			head.appendChild (css);		
		}		
	},
	
	locate: function(event){
		var win = {'x': window.getWidth(), 'y': window.getHeight()};
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var pwin = {'x': this.wrapper.offsetWidth, 'y': this.wrapper.offsetHeight};
		var prop = {'x': 'left', 'y': 'top'};
		for (var z in prop){
			var pos = event.page[z] + this.options.offsets[z];
			if ((pos + pwin[z] - scroll[z]) > win[z]) pos = event.page[z] - this.options.offsets[z] - pwin[z];
			this.wrapper.style.prop[z]= pos;
		};
		
		this.wrapper.style.display = 'block';
		this.overlay.style.display = 'block';
	}, 
	
	position: function () {
		this.wrapper.style.display = 'block';
		this.overlay.style.display = 'block';
		var pos = this.button.getPosition();
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var pwin = {'x': this.wrapper.offsetWidth, 'y': this.wrapper.offsetHeight};
		this.wrapper.setStyles({
			'left': pos.x + this.options.offsets.x,
			'top': pos.y + this.options.offsets.y - pwin.y
		});
	}
	
});
function findPos (obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}

	return {x:curleft,y:curtop};
}