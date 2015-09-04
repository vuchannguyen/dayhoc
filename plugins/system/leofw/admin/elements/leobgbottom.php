<?php
	/*
	 * $JA#COPYRIGHT$
	 */
  // no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');

class JFormFieldLeobgbottom extends JFormField {
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'leobgbottom';
	
	function getInput(){
		
		$value = $this->value?$this->value:(string)$this->element['default'];
 	    $template = $this->template?$this->template:(string)$this->element['template'];
        
        $string ='<div class="clr clearfix"></div><div class="bgbottoms">';    
		$string .=  '<input type="hidden" value="'.$value.'" name="'.$this->name.'" id="'.$this->id.'" >';
	   
        $ppath = JPATH_ROOT.DS."templates".DS.$template.DS."images".DS."bgbottom".DS;
 
        $bgbottoms = array();
        if( is_dir($ppath) ){	
        	$bgbottoms = JFolder::files( $ppath, ".png|.gif|.jpg" );	
        }
        
     //   echo '<pre>'.print_r($partterns,1); die;
       
        foreach( $bgbottoms as $b ){
            $string .= '<a id="'.$b.'" href="#" onclick="return false;" style="background:url('.JURI::root()."templates/{$template}/images/bgbottom/".$b.')">
                </a>';                
        }
        $string .='</div>';
 
        return $string;	
	}

}
?>