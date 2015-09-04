<?php
	/*
	 * $JA#COPYRIGHT$
	 */
  // no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');

class JFormFieldLeopattern extends JFormField {
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$type = 'Leopattern';
	
	function getInput(){
		
		$value = $this->value?$this->value:(string)$this->element['default'];
 	    $template = $this->template?$this->template:(string)$this->element['template'];
        
        $string ='<div class="clr clearfix"></div><div class="bgpatterns">';    
		$string .=  '<input type="hidden" value="'.$value.'" name="'.$this->name.'" id="'.$this->id.'" >';
	   
        $ppath = JPATH_ROOT.DS."templates".DS.$template.DS."images".DS."patterns".DS;
 
        $partterns = array();
        if( is_dir($ppath) ){	
        	$partterns = JFolder::files( $ppath, ".png|.gif|.jpg" );	
        }
        
     //   echo '<pre>'.print_r($partterns,1); die;
       
        foreach( $partterns as $p ){
            $string .= '<a id="'.$p.'" href="#" onclick="return false;" style="background:url('.JURI::root()."templates/{$template}/images/patterns/".$p.')">
                </a>';                
        }
        $string .='</div>';
 
        return $string;	
	}

}
?>