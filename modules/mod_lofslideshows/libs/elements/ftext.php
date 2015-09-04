<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');
if( !class_exists("LofParams") ){
	class LofParams {
		var $params;
		function __construct( $params ){
				$this->params = $params;
		}
		static function getInstance( $params ){
			static $instance; 
			if( !$instance ){
				$instance = new LofParams( $params );

			}
			return $instance;
		}
		function get($name1,$name2, $default=''){
			$val = $this->params->getValue($name1, 'params', $default);
			return is_array($val)&& isset($val[$name2])? $val[$name2]:$default;
		}
	}
}

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldFText extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'FText';
	
	var $_type = 'text';
	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 * @since   11.1
	 */
	function __getValue($name1,$name2, $default=''){
		$val = $this->form->getValue($name1, 'params', $default);
		return is_array($val)&& isset($val[$name2])? $val[$name2]:$default;
	}
	
	protected function getInput()
	{	
		$this->_type='text';
		if(  isset($this->element['is_hidden']) ){ 
			$this->value = '';
			$this->_type ='hidden';
		}
	
		$lofparams = LofParams::getInstance( $this->form );
	 	 	
		$this->value = $this->__getValue('theme_config', 'style1-myname');
	
		$this->name = str_replace( "][","][theme_config][", $this->name );
//		echo $this->name;die;
		if(  !isset($this->element['is_hidden']) ){ 
			$name1 = explode("][", $this->name.'[');
			
			$name1 = $name1[count($name1)-2];
	 	
			$this->value = $lofparams->get('theme_config',$name1,$this->element['default']);

		//	echo 	$this->value;die;
		}

		
		//  echo $this->name;die;
		// Initialize some field attributes.
		$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$maxLength	= $this->element['maxlength'] ? ' maxlength="'.(int) $this->element['maxlength'].'"' : '';
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		// Initialize JavaScript field attributes.
		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		return '<input type="'.$this->_type.'" name="'.$this->name.'" id="'.$this->id.'"' .
				' value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"' .
				$class.$size.$disabled.$readonly.$onchange.$maxLength.'/>';
	}
	
	public function getLabel(){
 
		if( $this->_type=='hidden'){
			return ;
		}
		return parent::getLabel();
	}
}
