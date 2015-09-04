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
 * class LeoMenuMega
 */
class LeoMenuComboBox implements ILeoMenu {
 
	/**
	 * var string $_suffix
	 */
	var $_suffix 	= null;
	
	/**
	 * var string $_type
	 */
	var $_type 		= null;
	
	/**
	 * var string $Itemid
	 */
	var $Itemid 	= null;
 
 
	/**
	 * var string $Itemid
	 */
	function __construct( $template_name, $params ) {
	
		$fancy 			= $params->get('fancy', 0);
		$transition		= $params->get('transition', 'Fx.Transitions.linear');
		$duration		= $params->get('duration', 500);
		$xdelay			= $params->get('xdelay', 700);
		$xduration		= $params->get('xduration', 2000);
		$xtransition	= $params->get('xtransition', 'Fx.Transitions.Bounce.easeOut');
		$menutype  = "mainmenu";
 
		$this->_suffix 		= "";
		$this->_type 		= $menutype;
		$this->Itemid = JRequest::getVar('Itemid');
		$document 			= JFactory::getDocument();
	 
	}
	
	public function preProcess(){ return $this; }
 
	public function render( $startLevel=0, $endLevel = 14 ) {
		 
		$my           = JFactory::getUser();
		$nav          = array();
		$app		  = JFactory::getApplication();
		$menu		  = $app->getMenu(); 
		$options 		  = $menu->getItems( 'menutype', $this->_type );
	 	 
		$output = array();
		$string = '';
		foreach( $options as $i =>$item ){ 
				$item->url  = $item->link;
			switch ( $item->type )	{
				case 'separator':
					$item->_index 	= count($list_menu);
					$list_menu[] 	= $item;
					$nav[$parent] 		= $list_menu;
					continue;
				case 'url':
					// If this is an internal Joomla link, ensure the Itemid is set.
					if((strpos($item->link, 'index.php?') !== false) &&(strpos($item->link, 'Itemid=') === false)){
						$item->url = $item->link.'&Itemid='.$item->id;
					}
					else {
						$item->url = $item->link;
					}
					break;
				case 'alias':
					// If this is an alias use the item id stored in the parameters to make the link.
					$item->url = 'index.php?Itemid='.$item->params->get('aliasoptions');
					break;

				default:
					$router = JSite::getRouter();
					if ($router->getMode() == JROUTER_MODE_SEF) {
						$item->url = 'index.php?Itemid='.$item->id;
					}
					else {
						$item->url  .= '&Itemid='.$item->id;
					}
					break;
			}
		 
			if(strcasecmp(substr($item->url, 0, 4), 'http') &&(strpos($item->url, 'index.php?') !== false))	{
				$item->url = JRoute::_($item->url, true, $item->params->get('secure'));
			}
			else { 
				$item->url = JRoute::_($item->url);
			}
					
			$options[$i]->title = str_repeat('- ',$options[$i]->level).$options[$i]->title;
			$selected = $item->id==$this->Itemid?'selected="selected"':"";
			$string .= '<option value="'.$item->url.'" id="combom'.$item->id.'" '.$selected.' >'.$options[$i]->title."</option>";
		}
		echo '<select id="comboxrpmenu" name="comboxrpmenu" class="inputbox" onchange="window.location.href=this.value">'.$string.'</select>';
	}
 

	 
 
}