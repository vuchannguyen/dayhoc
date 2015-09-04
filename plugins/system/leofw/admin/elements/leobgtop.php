<?php
	/*
	 * $JA#COPYRIGHT$
	 */
  // no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');

//Upgraded by ThangNN
class JFormFieldLeobgtop extends JFormField {
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'leobgtop';
	
	function getInput(){
		
		$value = $this->value?$this->value:(string)$this->element['default'];
 	    $template = $this->template?$this->template:(string)$this->element['template'];
        
        $string ='<div class="clr clearfix"></div><div class="bgtops">';    
		$string .=  '<input type="hidden" value="'.$value.'" name="'.$this->name.'" id="'.$this->id.'" >';
	   
        $ppath = JPATH_ROOT.DS."templates".DS.$template.DS."images".DS."bgtop".DS;

        $partterns = array();
        if( is_dir($ppath) ){	
        	$bgtops = JFolder::files( $ppath, ".png|.gif|.jpg" );	
        }
        
     //   echo '<pre>'.print_r($partterns,1); die;
       
        foreach( $bgtops as $t ){
            $string .= '<a id="'.$t.'" href="#" onclick="return false;" style="background:url('.JURI::root()."templates/{$template}/images/bgtop/".$t.')">
                </a>';                
        }
        $string .='</div>';
 
        return $string;	
	}

}
?>