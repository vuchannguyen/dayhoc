<?php 
$partterns = array();
$bgtops = array();
$bgbottoms = array();
$ppath = $this->_templatePath.DS."images".DS."patterns".DS;
$tpath = $this->_templatePath.DS."images".DS."bgtop".DS;
$bpath = $this->_templatePath.DS."images".DS."bgbottom".DS;
if( is_dir($ppath) ){	
	$partterns = JFolder::files( $ppath, ".png|.gif|.jpg" );	
}
if( is_dir($tpath) ){	
	$bgtops = JFolder::files( $tpath, ".png|.gif|.jpg" );	
}
if( is_dir($bpath) ){	
	$bgbottoms = JFolder::files( $bpath, ".png|.gif|.jpg" );	
}
JHTML::stylesheet( $this->getTemplateURI()."addons/toolspanel/assets/style.css" );
JHTML::stylesheet( $this->getTemplateURI()."addons/toolspanel/colorpicker/colorpicker.css" );
JHTML::script( $this->getTemplateURI()."addons/toolspanel/colorpicker/colorpicker.js" );
$folders = (array)JFolder::folders( $this->_templatePath."themes" );
$customColor 	= $this->getParam('use_custom_color',1);
$customTopColor 	= $this->getParam('use_custom_top_color',1);
$customBottomColor 	= $this->getParam('use_custom_bottom_color',1);
$paramColor     = $this->getParam("bg_body",'befaf4');
$bodytextColor     = $this->getParam("body_text_picker",'000000');
$bodylinkColor     = $this->getParam("body_link_picker",'FFFFFF');
$toptextColor     = $this->getParam("leo_text_top",'FFFFFF');
$toplinkColor     = $this->getParam("leo_link_top",'FFFFFF');
$bottomtextColor     = $this->getParam("leo_text_bottom",'FFFFFF');
$bottomlinkColor     = $this->getParam("leo_link_bottom",'FFFFFF');
$bottombackgroundColor     = $this->getParam("bottom_bgcolor",'FFFFFF');
$topbackgroundColor     = $this->getParam("top_bgcolor",'032e28');

$customBody     = $this->getParam("enable_custom_body",1);
$customTop     = $this->getParam("enable_custom_tops",1);
$customBottom     = $this->getParam("enable_custom_bottoms",1);
?>
<div id="toolspanel" class="toolspanel" >
<form>
    <div id="toolspanelcontent" class="pn-content" style="min-height:300px; width:200px; left:-2064px;">
    	<div class="pn-button"><span></span> </div>
        <div id="template_theme">
           <h5><?php echo JText::_("PLG_LEO_TPL_THEME_LABEL"); ?></h5>
    		<select name="theme">
            	<option value=""><?php echo JText::_("JDEFAULT");?></option>
            	<?php foreach( $folders as $folder ): ?>
            	<option value="<?php echo $folder?>"><?php echo JText::_( "COLOR ".strtoupper($folder));?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="template_direction">
        	 <h5><?php echo JText::_("TPL_LEO_TEMPLATE_DIRECTION_LABEL"); ?></h5>
        	<select name="layout">
            		<option value="-lcr" <?php echo(JRequest::getVar("layout")=="-lcr" ?'selected="selected"':"") ?>><?php echo JText::_("TPL_LEO_TEMPLATE_LEFT_CONTENT_RIGHT");?></option>
					<option value="-rcl" <?php echo(JRequest::getVar("layout")=="-rcl" ?'selected="selected"':"") ?>><?php echo JText::_("TPL_LEO_TEMPLATE_RIGHT_CONTENT_LEFT");?></option>
					<option value="-crl" <?php echo(JRequest::getVar("layout")=="-crl" ?'selected="selected"':"") ?>><?php echo JText::_("TPL_LEO_TEMPLATE_CONTENT_RIGHT_LEFT");?></option>
            </select>
              <div class="clearfix"></div>
        </div>
        <div id="colorPicker">
         
    		<h5 class="pickerAccordionBody"><?php echo JText::_("LEO_TPL_BODY_LABEL"); ?></h5>
    		<div id="pickerElementBody">
                <div id="pnpartterns">
                    <span><?php echo JText::_("LEO_TPL_PATTERNS_LABEL"); ?></span>
                    <div>
                	<?php foreach( $partterns as $p ): ?>
                    	<a id="<?php echo $p?>" href="#" onclick="return false;" style="background:url('<?php echo $this->getTemplateURI()."images/patterns/".$p; ?>')">
                        </a>
                    <?php endforeach; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
          
                <div id="leo-background-picker">
                    <span><?php echo JText::_("LEO_TPL_PATTERNS_BACKGROUND_COLOR_LABEL"); ?></span>
                	<input id="leoInputBackground" value="<?php echo '#'.$paramColor;?>" style="background: <?php echo '#'.$paramColor;?>;border:1px #F1F1F1 solid;" name="leoInputBackground" type="text" size="13" />
                    <img id="leo-background" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-body-text-picker">
                    <span><?php echo JText::_("LEO_TPL_PATTERNS_TEXT_COLOR_LABEL"); ?></span>
                	<input id="leoInputBodyText" value="<?php echo '#'.$bodytextColor;?>" style="background: <?php echo '#'.$bodytextColor;?>;border:1px #F1F1F1 solid;" name="leoInputBodyText" type="text" size="13" />
                    <img id="leo-background" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-body-link-picker">
                    <span><?php echo JText::_("LEO_TPL_PATTERNS_LINK_COLOR_LABEL"); ?></span>
                	<input id="leoInputBodyLink" value="<?php echo '#'.$bodylinkColor;?>" style="background: <?php echo '#'.$bodylinkColor;?>;border:1px #F1F1F1 solid;" name="leoInputBodyLink" type="text" size="13" />
                    <img id="leo-body-link" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
        
            </div>
      
            
   
    		<h5 class="pickerAccordionTop"><?php echo JText::_("LEO_TPL_TOP_COLOR_LABEL"); ?></h5>
            <div id="pickerElementTop">
                <div id="pnpartterns_top">
                    <span><?php echo JText::_("LEO_TPL_TOP_IMAGE_LABEL"); ?></span>
                    <div>
                	<?php foreach( $bgtops as $t ): ?>
                    	<a id="<?php echo $t?>" href="#" onclick="return false;" style="background:url('<?php echo $this->getTemplateURI()."images/bgtop/".$t; ?>')">
                        </a>
                    <?php endforeach; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
    
    			<div id="leo-background-top">
                    <span><?php echo JText::_("LEO_TPL_BACKGROUND_TOP_COLOR_LABEL"); ?></span>
                    <input id="leoInputBackgroundTop" value="<?php echo '#'.$topbackgroundColor;?>" style="background: <?php echo '#'.$topbackgroundColor;?>;border:1px #F1F1F1 solid;" name="leoInputBackgroundTop" type="text" size="13" />
                    <img id="leo-background-top-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-text-top">
                    <span><?php echo JText::_("LEO_TPL_TEXT_TOP_COLOR_LABEL"); ?></span>
                    <input id="leoInputTextTop" value="<?php echo '#'.$toptextColor;?>" style="background: <?php echo '#'.$toptextColor;?>;border:1px #F1F1F1 solid;" name="leoInputTextTop" type="text" size="13" />
                    <img id="leo-text-top-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-link-top">
                    <span><?php echo JText::_("LEO_TPL_LINK_TOP_COLOR_LABEL"); ?></span>
                    <input id="leoInputLinkTop" value="<?php echo '#'.$toplinkColor;?>" style="background: <?php echo '#'.$toplinkColor;?>;border:1px #F1F1F1 solid;" name="leoInputLinkTop" type="text" size="13" />
                    <img id="leo-link-top-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                
    		</div>
         
      
  		  <h5 class="pickerAccordionBotom"><?php echo JText::_("LEO_TPL_BOTTOM_COLOR_LABEL"); ?></h5>
    		<div id="pickerElementBottom">
                <div id="pnpartterns_bottom">
                    <span><?php echo JText::_("LEO_TPL_BOTTOM_IMAGE_LABEL"); ?></span>
                    <div>
                	<?php foreach( $bgbottoms as $b ): ?>
                    	<a id="<?php echo $b?>" href="#" onclick="return false;" style="background:url('<?php echo $this->getTemplateURI()."images/bgbottom/".$b; ?>')">
                        </a>
                    <?php endforeach; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
        
                <div id="leo-background-bottom">
                    <span><?php echo JText::_("LEO_TPL_BACKGROUND_BOTTOM_COLOR_LABEL"); ?></span>
                    <input id="leoInputBackgroundBottom" value="<?php echo '#'.$bottombackgroundColor;?>" style="background: <?php echo '#'.$bottombackgroundColor;?>;border:1px #F1F1F1 solid;" name="leoInputBackgroundBottom" type="text" size="13" />
                    <img id="leo-background-bottom-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-text-bottom">
                    <span><?php echo JText::_("LEO_TPL_TEXT_BOTTOM_COLOR_LABEL"); ?></span>
                    <input id="leoInputTextBottom" value="<?php echo '#'.$bottomtextColor;?>" style="background: <?php echo '#'.$bottomtextColor;?>;border:1px #F1F1F1 solid;" name="leoInputTextBottom" type="text" size="13" />
                    <img id="leo-text-bottom-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
                <div id="leo-link-bottom">
                    <span><?php echo JText::_("LEO_TPL_LINK_BOTTOM_COLOR_LABEL"); ?></span>
                    <input id="leoInputLinkBottom" value="<?php echo '#'.$bottomlinkColor;?>" style="background: <?php echo '#'.$bottomlinkColor;?>;border:1px #F1F1F1 solid;" name="leoInputLinkBottom" type="text" size="13" />
                    <img id="leo-link-bottom-color" src="<?php echo $this->getTemplateURI();?>addons/toolspanel/colorpicker/images/imgcolorpicker.png" alt="[r]" width="16" height="16" />
                </div>
               
    		</div>
   
        </div>
        
        <div id="bottombox" class="clearfix">
        	<input type="hidden" name="leoaction" value="save" />
        	 <input type="submit" value="<?php echo JText::_("Apply");?>"  name="<?php echo JText::_("Apply");?>"/>
             <a href="<?php echo JURI::base()."?leoaction=reset";?>"><?php echo JText::_("TPL_LEO_TEMPLATE_RESET_TEXT");?></a>
        </div>
          <div class="clearfix"></div>
    </div>
   
   </form> 
</div>
<?php
    include($this->_templatePath."addons/toolspanel/colorpicker/callcolor.js.php");
?>

<script type="text/javascript">
window.addEvent('domready', function() {
 
    var pickerAccordionBody = new Fx.Slide('pickerElementBody');
    pickerAccordionBody.show();
    $$('.pickerAccordionBody').addEvent('click', function(event){
        event.stop();
        pickerAccordionBody.toggle();
    });
 
   
    var pickerAccordionTop = new Fx.Slide('pickerElementTop');
    pickerAccordionTop.hide();
    $$('.pickerAccordionTop').addEvent('click', function(event){
        event.stop();
        pickerAccordionTop.toggle();
    });
    
    var pickerAccordionBottom = new Fx.Slide('pickerElementBottom');
    pickerAccordionBottom.hide();
    $$('.pickerAccordionBotom').addEvent('click', function(event){
        event.stop();
        pickerAccordionBottom.toggle();
    });
   
});
</script>

<script type="text/javascript">
	
 	$("toolspanelcontent").set( "tween", { duration:600,
							   			   transition:Fx.Transitions.Quint.easeInOut,
										   onComplete:function() { 
										   	
										   	if( $("toolspanelcontent").getStyle("left").toInt()< 0 ){ 
												$$("#toolspanel .pn-button").addClass("close").removeClass("open");
												$("toolspanelcontent").addClass("inactive");
											}else { 
												$$("#toolspanel .pn-button").addClass("open").removeClass("close");
												$("toolspanelcontent").removeClass("inactive"); }  
												// $("toolspanelcontent").hide();
											}} );
	$("toolspanelcontent").tween( "left", -206 );
	$$("#toolspanel .pn-button").addEvent( "click", function(){ 
		if(  $("toolspanelcontent").hasClass("inactive")  )													 
			$("toolspanelcontent").tween( "left", 0 );
		else 
			$("toolspanelcontent").tween( "left", -206 );
		
	} );
    
    $$("#pnpartterns a").addEvent('click', function(){
        document.body.className = document.body.className.replace(/pattern\w*$/,"");
        $(document.body).addClass( $(this).id.replace(/\.\w+$/,"")  );
        
    });
    $$("#pnpartterns_bottom a").addEvent('click', function(){
        $("leo-blockbottom").className = $("leo-blockbottom").className.replace(/bg_bottom\w*$/,"");
        $("leo-blockbottom").addClass( $(this).id.replace(/\.\w+$/,"")  );
        
    });
    
    $$("#pnpartterns_top a").addEvent('click', function(){
        $("leo-toppos").className = $("leo-toppos").className.replace(/bg_top\w*$/,"");
        $("leo-toppos").addClass( $(this).id.replace(/\.\w+$/,"")  );
        
    });
</script>
