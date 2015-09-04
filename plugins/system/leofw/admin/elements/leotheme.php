<?php
/*------------------------------------------------------------------------
 # Leo Template Framework - 
 # ------------------------------------------------------------------------
 # author    LeoTheme
 # copyright Copyright (C) 2010 leotheme.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.leotheme.com
 # Technical Support:  Forum - http://www.leotheme.com/forum.html
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die( 'Restricted access' );


/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldLeotheme extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'leotheme';

	function getInput()
	{ 
			
		$db = JFactory::getDBO();
		$query = " SELECT * FROM #__template_styles WHERE client_id=0 and home=1 " ;
		$db->setQuery( $query );
		
		$data = $db->loadObject();
		$templatePath = JPATH_SITE.DS."templates".DS.$data->template.DS."themes".DS; 
		$folders =  	JFolder::folders( $templatePath );
		
	
		$groupHTML = array();	
		$groupHTML[] = JHTML::_('select.option', "", JText::_("JDEFAULT"));
		if($folders && count($folders))		{
		foreach( $folders as $folder ) {
				$groupHTML[] = JHTML::_('select.option', $folder, JText::_("TPL_LEO_THEME_".strtoupper($folder)) );
		
		}
		
		}
		$lists = JHTML::_('select.genericlist', $groupHTML, $this->name.'[]', '  ', 'value', 'text', $this->value);
		return $lists;
	}
}
