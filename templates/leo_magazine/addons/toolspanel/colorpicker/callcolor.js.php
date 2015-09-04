
<script type="text/javascript">
	new LofColorPicker('leo-background-picker', {
    	id: 'leoInputBackground',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$$('body').setStyle('background-color', color.hex);
    		$('leoInputBackground').setStyle('background-color', color.hex);
    		$('leoInputBackground').value = color.hex;
    	},
    	onComplete: function(color){
    		$$('body').setStyle('background-color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputBackground').setStyle('background-color', color.hex);
    		$('leoInputBackground').value = color.hex;
    	}
    });
    
    new LofColorPicker('leo-body-text-picker', {
    	id: 'leoInputBodyText',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$$('body').setStyle('color', color.hex);
            $('leoInputBodyText').setStyle('background-color', color.hex);
    		$('leoInputBodyText').value = color.hex;
    	},
    	onComplete: function(color){
    		$$('body').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputBodyText').setStyle('background-color', color.hex);
    		$('leoInputBodyText').value = color.hex;
    	}
    });
    new LofColorPicker('leo-body-link-picker', {
    	id: 'leoInputBodyLink',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$$('body a').setStyle('color', color.hex);
            $('leoInputBodyLink').setStyle('background-color', color.hex);
    		$('leoInputBodyLink').value = color.hex;
    	},
    	onComplete: function(color){
    		$$('body a').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputBodyLink').setStyle('background-color', color.hex);
    		$('leoInputBodyLink').value = color.hex;
    	}
    });
    
    
    new LofColorPicker('leo-text-top', {
    	id: 'leoInputTextTop',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$('leo-toppos').setStyle('color', color.hex);
            $('leoInputTextTop').setStyle('background-color', color.hex);
    		$('leoInputTextTop').value = color.hex;
    	},
    	onComplete: function(color){
    		$('leo-toppos').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputTextTop').setStyle('background-color', color.hex);
    		$('leoInputTextTop').value = color.hex;
    	}
    });
    new LofColorPicker('leo-background-top', {
    	id: 'leoInputBackgroundTop',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$('leo-toppos').setStyle('background-color', color.hex);
            $('leoInputBackgroundTop').setStyle('background-color', color.hex);
    		$('leoInputBackgroundTop').value = color.hex;
    	},
    	onComplete: function(color){
    		$('leo-toppos').setStyle('background-color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputBackgroundTop').setStyle('background-color', color.hex);
    		$('leoInputBackgroundTop').value = color.hex;
    	}
    });
    new LofColorPicker('leo-background-bottom', {
    	id: 'leoInputBackgroundBottom',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$('leo-blockbottom').setStyle('background-color', color.hex);
            $('leoInputBackgroundBottom').setStyle('background-color', color.hex);
    		$('leoInputBackgroundBottom').value = color.hex;
    	},
    	onComplete: function(color){
    		$('leo-blockbottom').setStyle('background-color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputBackgroundBottom').setStyle('background-color', color.hex);
    		$('leoInputBackgroundBottom').value = color.hex;
    	}
    });
    new LofColorPicker('leo-link-top', {
    	id: 'leoInputLinkTop',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
            $$('#leo-toppos a').setStyle('color', color.hex);
            $('leoInputLinkTop').setStyle('background-color', color.hex);
    		$('leoInputLinkTop').value = color.hex;
    	},
    	onComplete: function(color){
    		$$('#leo-toppos a').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputLinkTop').setStyle('background-color', color.hex);
    		$('leoInputLinkTop').value = color.hex;
    	}
    });
    
    
    new LofColorPicker('leo-text-bottom', {
    	id: 'leoInputTextBottom',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
    		$('leo-blockbottom').setStyle('color', color.hex);
            $('leoInputTextBottom').setStyle('background-color', color.hex);
    		$('leoInputTextBottom').value = color.hex;
    	},
    	onComplete: function(color){
    		$('leo-blockbottom').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputTextBottom').setStyle('background-color', color.hex);
    		$('leoInputTextBottom').value = color.hex;
    	}
    });
    
    new LofColorPicker('leo-link-bottom', {
    	id: 'leoInputLinkBottom',
        imgPath: '<?php echo $this->getTemplateURI()."addons/toolspanel/colorpicker/images/";?>',
    	wheel: true,
    	onChange: function(color){
            $$('#leo-blockbottom a').setStyle('color', color.hex);
            $('leoInputLinkBottom').setStyle('background-color', color.hex);
    		$('leoInputLinkBottom').value = color.hex;
    	},
    	onComplete: function(color){
    		$$('#leo-blockbottom a').setStyle('color', '# <?php echo $this->getParam("bg_colorpicker",'E851E8');?>');
            $('leoInputLinkBottom').setStyle('background-color', color.hex);
    		$('leoInputLinkBottom').value = color.hex;
    	}
    });
</script>
