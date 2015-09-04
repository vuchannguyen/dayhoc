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
jimport('joomla.language.helper');
jimport('joomla.plugin.plugin');

/**
 * Class plgSystemLeofw
 */
class plgSystemLeofw extends JPlugin{
	
	/**
	 * Constructor
	 */
	function __construct( &$subject, $config ) {
		parent::__construct($subject, $config);
		$app		= JFactory::getApplication();
		$currentTemplate = $app->getTemplate();  
		if( $app->isSite() && file_exists(JPATH_SITE.DS."templates".DS.$currentTemplate.DS."libs".DS."define.php") ){
			require_once( dirname(__FILE__).DS."libs".DS."classes".DS."joomla".DS."view.php" );
			require_once( dirname(__FILE__).DS."libs".DS."classes".DS."joomla".DS."modulehelper.php" );
			define( "_LEO_FRAMEWORK_ACTIVED_", true );	
		}	
 
	}
	
	/**
	 * Processing to clear JS,Css cache and rendering quick button
	 */
	function onBeforeRender(){
		$mainframe = JFactory::getApplication();
		if( $mainframe->isAdmin() || JDEBUG ) {
			if( JRequest::getVar("leoclear")=="cache" ){
				require_once( dirname(__FILE__).DS."libs".DS."compress".DS."compress.php" );
				LeoCompressHelper::clearCache() ;
				echo JText::_( "Clear JS, CSS Successfull!" );	
		 		$mainframe->close();
			}
			$document = JFactory::getDocument();	
			$document->addScript( JURI::root()."plugins/system/leofw/assets/script.js" );
			$document->addStyleSheet( JURI::root()."plugins/system/leofw/assets/style.css" );
		}
	}
	
	/**
	 * Rendering Menu Params in menu editting form
	 */
	function onContentPrepareForm( $form, $data )	{
		if($form->getName()=='com_menus.item')		{
			JForm::addFormPath( dirname(__FILE__).DS."admin".DS."menu" );
			$form->loadFile('params', false);
		}
	}
	
	
	/**
	 * Processing to clear JS,Css cache and rendering quick button
	 */
	function onAfterRender(){
	 	global  $_PROFILER;
		$mainframe = JFactory::getApplication();
		if( $mainframe->isAdmin() || JDEBUG ) {
			// display button clear cache 
			if( $this->params->get('button_clearcache','allow_admin') ){
				$this->_makeClearCacheButton();
			}
			return;
		}	
	}
	
	/**
	 * Insert a clear cache button beside logout link inside the administrator 
	 */
	function _makeClearCacheButton(){
		$body  = JResponse::getBody();
		$span   = '#<span([^\>]+)class="logout"(.*)>(.*)<\/span>#iU';
		preg_match( $span, $body, $match );	
		$title =  JText::_('Leo Framework')."::".JText::_('Click the button <br>to clear <b>Css,JS</b> cache');
		if( isset($match) && isset($match[0]) ){
			$link = JURI::base().'?leoclear=cache';
			$bg= 'style="background:url('.JURI::root().'/plugins/system/leofw/assets/clear.png'.') no-repeat;"';
			$body = str_replace( $match[0], $match[0] . '<span  '.$bg.' class="leobtnclearcache">'
							. '<a title="'.$title.'" class="mytip"  href="'.$link.'">'.JText::_('Clear Cache').'</a>'
							. '</span>',
					     $body );
		}
		JResponse::setBody( $body ); 
	}
}
?>