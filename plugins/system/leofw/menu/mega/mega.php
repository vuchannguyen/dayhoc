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
class LeoMenuMega implements ILeoMenu {
 
	/**
	 *
	 */
	var $_suffix 	= null;
	
	/**
	 *
	 */
	var $_type 		= null;
	
	/**
	 *
	 */
	var $_nav 		= null;
	
	/**
	 *
	 */
	var $Itemid 	= null;
 	
	var $scriptCode = '';
	/**
	 *
	 */
	function __construct( $template_name, $params, $menutype="mainmenu" ) {
	
 
		$transition		= $params->get('transition', 'Fx.Transitions.linear');
		$duration		= (int)$params->get('duration', 500);
		$xdelay			= (int)$params->get('mdelay', 700);
		$xduration		= (int)$params->get('mduration', 2000);
		$xtransition	= $params->get('mtransition', 'Fx.Transitions.Bounce.easeOut');
		$this->_suffix 		= "";
		$this->_type 		= $menutype;
		$this->Itemid = JRequest::getVar('Itemid');
		$document 			= JFactory::getDocument();
 
		

		$document->addStyleSheet(JURI::base().'templates/'.$template_name.'/css/'.'menu/'.'mega.css');
		$document->addScript( JURI::base().'plugins/system/leofw/menu/mega/js/script.js' );
		$this->scriptCode = ' <script type="text/javascript">
						new LeoMegaMenu( $("menusys_mega"), {
											transition:'.	$xtransition.',
											duration:'.	$xduration.',
											delay:'.$xdelay.',
											effect:"'.$params->get("leo_menueffect","simple").'"
										} );
				  </script>	';
	}
	
	public function preProcess()	{

		$my           = JFactory::getUser();
		$nav          = array();
		$app		  = JFactory::getApplication();
		$menu		  = $app->getMenu(); 
		$items 		  = $menu->getItems( 'menutype', $this->_type );
		
		$mactive = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();
		$mpath		= $mactive->tree;
		if(count($items)){
		   foreach( $items as $key => $item ) {
				$item->active = in_array($item->id,$mpath)?true:false; 
				if( $item->access <= $my->get('gid', 1) ) {
					$parent 		= $item->parent_id;
					$list_menu 	= @($nav[$parent]) ? $nav[$parent] : array();
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

					$item->_index 	= count($list_menu);
					$list_menu[] 	= $item;
					$nav[$parent] 		= $list_menu;
				}
				 
			}
		}
		$this->_nav = $nav;
		
		return $this;
	}

	function _showMenuDetail($row, $level = 0)
	{
		$_temp 			= null;
		$title 			= "title=\"$row->title\"";
		$menu_params 	= new JParameter($row->params);

		if($menu_params->get('menu_image') && $menu_params->get('menu_image') != -1){
			$str = '<img src="'.JURI::base(true).'/'.$menu_params->get('menu_image').'" alt="'.$row->title.'" /><span class="menusys_name">'.$row->title.'</span>';
		}
		else {
			$str = '<span class="menusys_name">'.$row->title.'</span>';
		}

		$Class 	= $this->getClassActive($row, $level);
		$id		='id="menusys'.$row->id.'"';

		if(@$row->url != null)
		{
			if($row->browserNav == 0)
			{
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)
			{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2)
			{
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else {
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}
		echo $menuItem;
	}

	function render( $startLevel=0, $endLevel = 14 ) {
		
 
		echo "<div class=\"menusys_mega".$this->_suffix."\">";
			$pid=1;
			$level=0;
			if(@$this->_nav[$pid]) {
				$this->openWrapTag( NULL, "menusys_mega");
				$i = 0;
				foreach( $this->_nav[$pid] as $menu ) {
					$params	= $menu->params;
					$aclass	= $params->get("mega_class", '');
					$cols	= $params->get( "mega_cols", 1);

					if(@$this->_nav[$menu->id]){$class = "hasChild"; $id = "menu-".$menu->id;}
					else {$class = ""; $id = "";}

					if($i == 0) $class = "first-item $class";
					elseif($i == count($this->_nav[$pid]) - 1) $class = "last-item $class";
					else $class = $class;
				 
					$class .=($menu->active) ? " active" : "";
					$class .=($aclass != '') ? $aclass : "";

					$this->openTag($class, $id);
					$this->renderNormalItem( $menu, $level );
					if(@$this->_nav[$menu->id])
					{
						$this->openContainerTag("menusub_mega level{$level}", "menu-".$menu->id."_menusub_sub0");
							$this->showSubMegaMenu($menu, $menu->id, $level+1, $cols);
						$this->closeContainerTag();
					}
					$this->endCloseTag();
					$i++;
				}
				$this->closeWrapTag();
			}
			$this->outputMenu(  
				 $this->scriptCode 
				
			);
		echo "</div>";
	}

	function showMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			if($level == 0)
				$this->openWrapTag(NULL, "menusys_mega");
			else
				$this->openWrapTag();

			$i = 0;
			foreach($this->_nav[$pid] as $menu)
			{
				if(@$this->_nav[$menu->id]) $abc = " hasChild";
				else $abc = "";

				$class  =($menu->active) ? " active" : "";
				$id		=(@$this->_nav[$menu->id]) ? "menu-".$menu->id : '';

				if($i == 0) $this->openTag("first-item".$abc.$class, $id);
				elseif($i == count($this->_nav[$pid]) - 1) $this->openTag("last-item".$abc, $id);
				else $this->openTag($abc, $id);

				$this->_showMenuDetail($menu, $level);

				if(($level < $this->_end) &&(@$this->_nav[$menu->id]))
				{
					$this->showMenu($menu->id, $level+1);
				}
				$i++;
				$this->endCloseTag();
			}
			$this->closeWrapTag();
		}
	}

	function getItemClass( $menu, $level ) {
		return ($menu->active) ? " class=' active'" : " class=' item'";
	}

	function showSubMegaMenu($row, $pid, $level, $cols)	{
		$params	= $row->params;
		$swidth = $params->get( "mega_colw", '');
		$colxw	= $params->get( "mega_colxw", '');
		$colw 	= array();
		$width  = $params->get( "mega_width", '');
		$style	=($width != '') ? "width:$width" : "";

		if($colxw != '')
		{
			$colx  = explode("\n", $colxw);
			for($i = 0; $i < count($colx); $i++)
			{
				$col 	= explode("=", $colx[$i]);
				$colw[] = $col[1];
			}
		}


		$subs	= $this->_nav[$pid];
		$total	= count($subs);

		$count	= floor($total/$cols);
		$bal	= $total - $count*$cols;
		$m		= 0;

		$isgroup = $params->get( "mega_group", 0);

		if(!$isgroup) {
			if(strpos($width,'px'))
				$width_wrap = "width:".((str_replace('px','',$width)))."px";
			else
				$width_wrap = "width:".($width)."px";
		} else {
			if(strpos($width,'px'))
				$width_wrap = "width:".$width;
			else
				$width_wrap = "width:".$width."px";
		}

		$this->openContainerTag("submenu-wrapper", NULL);

		$isgroup = $params->get( "mega_group", 0);

		if(!$isgroup) {
			$this->openContainerTag("subarrowtop", NULL, NULL);
			$this->closeContainerTag();
			
			$this->openContainerTag("subwrap-inner", NULL, NULL);
			$this->openContainerTag("subwrap-inner2", NULL, NULL);
			$this->openContainerTag("menucontent-wrapper", NULL, "width:".$width);
		}

		for($i = 1; $i <= $cols; $i++)
		{
			$width	=(count($colw) == $cols) ? "width:".$colw[$i-1] :(($swidth !='') ? "width:".$swidth : NULL);
			$params	= $subs[$m]->params;
			$group	= $params->get("mega_group", 0);

			if($group)
			{
				for($g = 0; $g < $count; $g++)
				{
					$this->openContainerTag("megacol column$i", NULL, $width);
						$this->_rendeMenuItemContent($subs[$m], $level);
						//Show sub level
						$spid	= $subs[$m]->id;
						if(@$this->_nav[$spid])
						{
							$level	= $level + 1;
							$scols	= $this->getMenuParam($subs[$m]->params, "mega_cols", 1);
							$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
						}
					$this->closeContainerTag();
					$m ++;
				}
			}
			else
			{
				$this->openContainerTag("megacol column$i", NULL, $width);
					$this->openWrapTag("mega-ul ul");
						for($k = 0; $k < $count; $k++)
						{
							if($k == 0)
								$class	= "mega-li li first-item";
							elseif($k ==($count - 1))
								$class	= "mega-li li last-item";
							else
								$class	= "mega-li li";

							$spid	= $subs[$m]->id;
							if(@$this->_nav[$spid]){ $id = "menu-$spid"; $class .= " hasChild"; }
							else{$id = "";}

							$this->openTag($class, $id);
								$this->_rendeMenuItemContent($subs[$m], $level);
								//Show sub level
								if(@$this->_nav[$spid])
								{
									$level	= $level + 1;
									$scols	= $this->getMenuParam($subs[$m]->params, "mega_cols", 1);

									$this->openContainerTag("menusub_mega level{$level}", "menu-".$subs[$m]->id."_menusub_sub$level");
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									$this->closeContainerTag();
								}
							$this->endCloseTag();
							//Balance
							if($m == 0 && $bal !=0)
							for($b = 0; $b < $bal; $b++)
							{
								$m ++;
								$this->openTag("mega-li li");
									$this->_rendeMenuItemContent($subs[$m], $level);
									//Show sub level
									$spid	= $subs[$m]->id;
									if(@$this->_nav[$spid])
									{
										$level	= $level + 1;
										$scols	= $this->getMenuParam($subs[$m]->params, "mega_cols", 1);
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									}
								$this->endCloseTag();
							}
							$m ++;
						}
					$this->closeWrapTag();


				$this->closeContainerTag();
			}
		}

		if(!$isgroup) {
			$this->openContainerTag("clearfix", NULL, NULL);
			$this->closeContainerTag();
			$this->closeContainerTag();
			$this->closeContainerTag();
			$this->closeContainerTag();
	
		}

		$this->openContainerTag("clearfix", NULL, NULL);
		$this->closeContainerTag();
		$this->closeContainerTag();
	}
 
	function getMenuParam($params, $key, $default = 0)	{
		 return $params->def($key, $params->get($key, $default) );
	}

	function getModule($id=0, $name='')	{
		$Itemid = $this->Itemid;
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels());
		$db		= JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('id, title, module, position, content, showtitle, params, mm.menuid');
		$query->from('#__modules AS m');
		$query->join('LEFT','#__modules_menu AS mm ON mm.moduleid = m.id');
		$query->where('m.published = 1');
		$query->where('m.id = '.$id);

		$date 	= JFactory::getDate();
		$now 	= $date->toMySQL();
		$nullDate = $db->getNullDate();
		$query->where('(m.publish_up = '.$db->Quote($nullDate).' OR m.publish_up <= '.$db->Quote($now).')');
		$query->where('(m.publish_down = '.$db->Quote($nullDate).' OR m.publish_down >= '.$db->Quote($now).')');

		$clientid =(int) $app->getClientId();

		if(!$user->authorise('core.admin',1))
		{
			$query->where('m.access IN('.$groups.')');
		}

		$query->where('m.client_id = '. $clientid);

		if(isset($Itemid))
		{
			$query->where('(mm.menuid = '.(int) $Itemid .' OR mm.menuid <= 0)');
		}
		$query->order('position, ordering');

		// Filter by language
		if($app->isSite() && $app->getLanguageFilter())
		{
			$query->where('m.language in(' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		}

		// Set the query
		$db->setQuery($query);
		$cache 		= JFactory::getCache('com_modules', 'callback');
		$cacheid 	= md5(serialize(array($Itemid, $groups, $clientid, JFactory::getLanguage()->getTag(), $id)));

		$module = $cache->get(array($db, 'loadObject'), null, $cacheid, false);

		if(!$module) return null;

		$negId	= $Itemid ? -(int)$Itemid : false;
		// The module is excluded if there is an explicit prohibition, or if
		// the Itemid is missing or zero and the module is in exclude mode.
		$negHit	=($negId ===(int) $module->menuid) ||(!$negId &&(int)$module->menuid < 0);

		// Only accept modules without explicit exclusions.
		if(!$negHit)
		{
			//determine if this is a custom module
			$file				= $module->module;
			$custom				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
			$module->user		= $custom;
			// Custom module name is given by the title field, otherwise strip off "com_"
			$module->name		= $custom ? $module->title : substr($file, 4);
			$module->style		= null;
			$module->position	= strtolower($module->position);
			$clean[$module->id]	= $module;
		}
		return $module;
	}
	
	function renderNormalItem($row, $level = 0)	{
		$str	= "";
		$params	= $row->params;
		$image	= $params->get( "menu_image", -1);
			
		$stitle	= $params->get( "mega_showtitle", 0); 
		$desc	= $params->get( "mega_desc", '');
		$group	= $params->get( "mega_group", 0);
		$width	= $params->get( "mega_width", '');
		$colw	= $params->get( "mega_colw", '');
		$colxw	= $params->get("mega_colxw", '');

		$name			= '<span class="menu-title">'.$row->title.'</span>';
		$description	=($desc != '') ? '<span class="menu-desc">'.$desc.'</span>' : "";
		$title			=($stitle) ? " title=\"$row->title\"" : "";

		if( $image != -1 ) {
			$itembg 	= 'style="background-image:url('.JURI::base(true).'/'.$image.');"';
			$str	   	= "<span class=\"has-image\" $itembg>".$name.$description.'</span>';
		}
		else {
			$str		= "<span class=\"no-image\">".$name.$description.'</span>';
		}

		$Class 		= $this->getItemClass($row, $level);
		$id			= 'id="menusys'.$row->id.'"';
		$add_class	= $params->get( "mega_class", '');

		if(@$row->url != null)	{
			if($row->browserNav == 0){
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)	{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2){
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else {
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}

		if( $group )	{
			$menuItem = '<div class="mega-group'.$add_class.'">'.$menuItem.'</div>';
		}

		echo $menuItem;
	}

	function renderItemByModule($row, $level = 0, $mid, $style = 'xhtml') {
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$db			= JFactory::getDBO();

		if(count($mid))
		for($i = 0; $i < count($mid); $i++)
		{
			$module	= $this->getModule($mid[$i]);
			$this->openContainerTag("mega-module");
				echo $renderer->render($module, $params);
			$this->closeContainerTag();
		}
	}

	function renderItemByPosition( $row, $level = 0, $position, $style = 'xhtml' ){
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$contents 	= '';

		if(count($position))
		for($i = 0; $i < count($position); $i++)
		{
			$modules = JModuleHelper::getModules($position[$i]);
			if(count($modules))
			for($k = 0; $k < count($modules); $k++)
			{
				$this->openContainerTag("mega-module");
					echo $renderer->render($modules[$k], $params);
				$this->closeContainerTag();
			}
		}
	}

	function _rendeMenuItemContent($row, $level = 0) {
		$type	= $this->getMenuParam($row->params, 'mega_subcontent', 0);

		switch( $type ) {
			case "mod":
				$module		= $this->getMenuParam($row->params, 'mega_subcontent_mod_modules');
				$style		= $this->getMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->renderItemByModule($row, $level, $module, $style);
			break;
			case "pos":
				$position	= $this->getMenuParam($row->params, 'mega_subcontent_pos_positions');
				$style		= $this->getMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->renderItemByPosition($row, $level, $position, $style);
			break;
			default:
				$this->renderNormalItem($row, $level);
			break;
		}
	}

	/**
	 * Make Open|Close Tag for Wrapping Menu Items Block or more
	 */
	function openContainerTag( $class = '', $id = '', $style = '' )	{
	 	echo $this->_htmlTag( "div", $class, $id, $style );
	}
	function closeContainerTag() {	echo "</div>";	}

	/**
	 * Make Open|Close Tag for Wrapping List of Menu Item
	 */
	function openWrapTag( $class = '', $id = '', $style = '' ){
		echo $this->_htmlTag( "ul", $class, $id, $style );
	}
	function closeWrapTag() {	echo "</ul>";	}
	
	/**
	 * Make Open|Close Tag for Wrapper List of Menu Item
	 */
	function openTag($class = '', $id = '', $style = '' )	{
		echo $this->_htmlTag( "li", $class, $id, $style );
	}
	
	function endCloseTag() { echo "</li>";	}
	function outputMenu($text)	{  echo $text;	}
	function _htmlTag( $tag, $class = '', $id = '', $style = '' ){
		$class 	=($class) ? ' class="'.$class.'"' : '';
		$id		=($id) ? ' id="'.$id.'"' : '';
		$style	=($style) ? ' style="'.$style.'"' : '';
		return  '<'.$tag .$id.$class.$style.'>';
	}
}