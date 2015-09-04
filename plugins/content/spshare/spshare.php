<?php
/*------------------------------------------------------------------------
# SP Share - Social Share plugin for Joomla by JoomShaper.com
# ------------------------------------------------------------------------
# Author    JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2012 JoomShaper.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomshaper.com
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.plugin.plugin');
jimport('joomla.html.parameter');

class plgContentSPShare extends JPlugin
{	
	var $_path;
	var $_url;
	var $_postID;
	var $position;
	
	// plugin core
	function plgContentSPShare(&$subject, $config)
	{
		parent::__construct($subject, $config);
		
		// load the plugin parameters
		$this->plugin 		= &JPluginHelper::getPlugin('content', 'spshare');
		$this->plgParams 	= new JParameter($this->plugin->params);
		$this->position 	= $this->getParam('position');	
	}

	function onContentAfterDisplay($context, &$article, &$params, $page = 0)
	{
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}
		if ($this->position == 2)
			return $this->getSPShare($context, $article);
	}	
	
	public function onContentAfterTitle($context, &$article, &$params, $page = 0){
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}	
		if ($this->position == 3 || $this->position == 4) 
			return $this->getSPShare($context, $article);		
	}
		
	// function to work when preparing the content on frontpage or listing pages
	function onContentBeforeDisplay($context, &$article, &$params, $page=0)
	{
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}		
		if (($this->getParam('show_intro',1)==1) && ($this->position == 3 || $this->position == 4)) {
			$params->set('show_intro',0);
			$article->params->set('show_intro',0);
		}//disable show_intro
				
		if ($this->position == 1)
			return $this->getSPShare($context, $article);
	}	
	
	function onK2BeforeDisplay( & $item, & $params, $page=0) {
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}	
		if ($this->position == 1)
			return $this->getSPShare('', $article);		
	}	
	
	function onK2AfterDisplay( & $item, & $params, $page=0) {
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}	
		if ($this->position == 2)
			return $this->getSPShare('', $article);
	}

	function onK2AfterDisplayTitle( & $item, & $params, $page=0) {
		$mainframe = JFactory::getApplication();
		if ($mainframe->isAdmin()) {
			return '';
		}	
		if ($this->position == 3 || $this->position == 4) 
			return $this->getSPShare('', $article);	
	}	
	
	function getSPShare($context, &$article)
	{
		global $option;

		if (!isset($article->catid)) {
			$article->catid = 0;
		}

		$option 	= JRequest::getCmd('option');
		
		//Joomla category
		$categories 		= array();
		$cats 				= $this->getParam('catids');
		
		if (is_array($cats)) {
			$categories 	= $cats;
		} else {
			$categories[] 	= $cats;
		}
		
		//K2 category
		$k2categories 		= array();
		$k2cats 			= $this->getParam('k2catids');
		
		if (is_array($k2cats)) {
			$k2categories 	= $k2cats;
		} else {
			$k2categories[] = $k2cats;
		}	

		//Parameters
		$layout_style		= $this->getParam('layout_style');
		$linkedin			= $this->getParam('linkedin');
		$twitter			= $this->getParam('twitter');
		$gplus				= $this->getParam('gplus');
		$digg				= $this->getParam('digg');
		$like_btn			= $this->getParam('like_btn');
		$fb_width 			= $this->getParam('fb_width');
		
		//Button Style
		$linkedin_style		= ($layout_style=='button_count') ? "right" : "top";
		$twitter_style		= ($layout_style=='button_count') ? "horizontal" : "vertical";
		$gplus_style		= ($layout_style=='button_count') ? "medium" : "tall";
		$digg_style			= ($layout_style=='button_count') ? "DiggCompact" : "DiggMedium";
		$like_btn_style		= ($layout_style=='button_count') ? "button_count" : "box_count";
		
		// enable commenting if everything is alright
		if (in_array($article->catid, $categories) || (in_array($article->catid, $k2categories) && !$this->isEmptyArr($k2categories))) {
			$output = "";
			
			if ($option == 'com_content') {
				$this->_path 	= JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid));
			} elseif($option == "com_k2") {
				$this->_path = K2HelperRoute::getItemRoute($article->id, $article->catid);	
			} else {
				$this->_path 	= JURI::base(true);
			}
			
			$this->_url 		= substr(JURI::base(), 0, -1)."/".strstr($this->_path, 'index.php');			
			
			//Javascript
			$doc = JFactory::getDocument();
			
			if ($linkedin)
				$doc->addScript('http://platform.linkedin.com/in.js');//Javascript for Linkedin share button
				
			if ($twitter)
				$doc->addScript('http://platform.twitter.com/widgets.js');//Javascript for Twitter Button
				
			if ($gplus)
				$doc->addScript('https://apis.google.com/js/plusone.js');//Javascript for The + Button
				
			if ($digg)
				$doc->addScriptDeclaration("
					(function() {
					  var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
					  s.type = 'text/javascript';
					  s.async = true;
					  s.src = 'http://widgets.digg.com/buttons.js';
					  s1.parentNode.insertBefore(s, s1);
					})();				
				");//Javascript for digg Button

			if ($like_btn != 3) {
				$doc->addScriptDeclaration("
					(function(d){
					  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
					  js = d.createElement('script'); js.id = id; js.async = true;
					  js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
					  d.getElementsByTagName('head')[0].appendChild(js);
					}(document));				
				");
				}//Javascript for Facebook Send Button
		
			//Output
			$output .="<div class='spshare'>";
			if ($linkedin)
				$output .= "<div class='sp_linkedin spshare_fltlft'><script type='IN/Share' data-url=" . $this->_url . " data-counter='" . $linkedin_style . "'></script></div>";
			
			if ($twitter)
				$output .= "<div class='sp_twitter spshare_fltlft'><a href='http://twitter.com/share' class='twitter-share-button' data-text='" . $article->title. "' data-url='" . $this->_url. "' data-count='" . $twitter_style . "'>Tweet</a></div>";

			if ($gplus)
				$output .= "<div class='sp_plusone spshare_fltlft'><g:plusone href='" . $this->_url . "' size='" . $gplus_style . "'></g:plusone></div>";
			
			if ($digg)
				$output .= "<div class='sp_digg spshare_fltlft'><a class='DiggThisButton " . $digg_style . "' href='http://digg.com/submit?url='".$this->_url."'></a></div>";
							
			if ($like_btn == 1) {
				$output .= "<div class='sp_fblike spshare_fltlft'><div class='fb-like' data-href='" . $this->_url . "' data-send='true' data-layout='" . $like_btn_style . "' data-width='" . $fb_width . "' data-show-faces='flase'></div></div>";
			} else if ($like_btn == 2) {
				$output .= "<div class='sp_fblike spshare_fltlft'><div class='fb-like' data-href='" . $this->_url . "' data-send='false' data-layout='" . $like_btn_style . "' data-width='" . $fb_width . "' data-show-faces='flase'></div></div>";			
			}
			
			$output .="<div style='clear:both'></div></div>";
			$this->getStyle();			
			
			return $output;		
		}

	}
	
	// short function to receive $_params value
	function getParam($param)
	{
		return $this->plgParams->get($param);
	}
	
	function isEmptyArr($arr = array())
	{
		if(!empty($arr))
		{
			$count = count($arr);
			$check = 0;
			foreach($arr as $id=>$item)
			{
				if(empty($item)) $check++;
			}
			if($check != $count) return false;
		}
		return true;
	}	
	
	//Get styles
	function getStyle() {
		if(defined('_SPSHARE')) 
			return;
		define ('_SPSHARE',1);	
		$doc 				 = JFactory::getDocument();
		$layout_style		 = $this->getParam('layout_style');
		$fb_width 			 = $this->getParam('fb_width');
		$styles 	     	 = ".spshare_fltlft {float:left}";
		if ($this->position==4) {
			$styles 		.= ".spshare {float:right; margin:10px 0 10px 10px}";
		} else {
			$styles 		.= ".spshare {margin:10px 0}";		
		}	
		$styles				.= ".sp_fblike {width:{$fb_width}px}";
		$styles 			.= ".sp_linkedin,.sp_digg {margin-right:10px}";
		$styles 			.= ($layout_style=='button_count') ? ".sp_plusone {width:70px}" : ".sp_plusone {width:62px}";
		$styles 			.= ($layout_style=='button_count') ? ".sp_twitter {width:106px}" : ".sp_twitter {width:66px}";
		$doc->AddStyledeclaration ($styles);
	}
}
?>