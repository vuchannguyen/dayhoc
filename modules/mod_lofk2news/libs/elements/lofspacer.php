<?php 
/**
 * $ModDesc
 * 
 * @version   $Id: $file.php $Revision
 * @package   modules
 * @subpackage  $Subpackage.
 * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
 
// no direct access
defined('_JEXEC') or die;
/**
 * Get a collection of categories
 */
class JFormFieldLofspacer extends JFormField {
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'fgroup'; 	
	
	/**
	 * fetch Element 
	 */
	protected function getInput(){		
		if (!defined ('PIJ_MEDIA_CONTROL')) {
			define ('PIJ_MEDIA_CONTROL', 1);
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator/", "", $uri);	
			
			if( !preg_match("#http://#",$uri) ){
				$uri = str_replace("/modules","modules", $uri);
			}
			JHTML::stylesheet($uri."/media/".'form.css');
			JHTML::script($uri."/media/".'form.js');
		}
		
		

//    $text   = (string)$this->element['text']?(string)$this->element['text']:'';
 ///   return '<div class="lof-header">'.JText::_($text).'</div>';
	}	
	function getLabel(){
		if( isset($this->element['end']) ) {
			if( $this->element['isgroup']  ){
				$label = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
				$text  = '';
				if( isset($this->element['isgroup'])  ){
					$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
					$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
					$checked	= ((string) $this->element['value'] == $this->value) ? ' checked="checked"' : '';
					// Initialize JavaScript field attributes.
					$onclick	= $this->element['onclick'] ? ' onclick="'.(string) $this->element['onclick'].'"' : '';
					$text .= '<input  class="lof-cbktoggle" type="checkbox" name="'.$this->name.'" id="'.$this->id.'"' .
							' value="'.htmlspecialchars((string) $this->element['value'], ENT_COMPAT, 'UTF-8').'"' .
							$class.$checked.$disabled.$onclick.'/>';
				}
				return '<div style="clear:both" class="lof-label"><label>'.JText::_(strtoupper(str_replace("-","_",$label))).$text.'</label></div><ul style=" clear:both; width:100%" class="lof-group" id="toggle-'.$this->id.'"><li>';
			} else{  // die;
				return '<div style="clear:both"></div></li></ul><li><div style="clear:both"></div>';
			}
		//	return '<div style="clear:both">'.$this->value.'</div>';
		}
	}
}

?>
