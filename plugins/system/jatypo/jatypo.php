<?php
/**
 * ------------------------------------------------------------------------
 * JA Typo plugin For Joomla 1.7
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 JoomlArt.com. All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * Author: JoomlArt.com
 * Websites: http://www.joomlart.com - http://www.joomlancers.com.
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemJATypo extends JPlugin
{


    function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }


    /**
     * readmore button
     * @return array A two element array of ( imageName, textToInsert )
     */
    function onAfterDispatch() // Fix for compatible both j16 & j17
    {
        global $mainframe;
        $mainframe = JFactory::getApplication();
        
        JHTML::_('stylesheet', JURI::root() . 'plugins/system/jatypo/jatypo/assets/style.css', array(), true);
        $javersion = new JVersion();
		if($javersion->RELEASE=='1.7'){
			JHtml::_('behavior.framework', true);
		}
		else{
			JHTML::_('behavior.mootools');
		}
        JHTML::_('script', JURI::root() . 'plugins/system/jatypo/jatypo/assets/script.js', false, true);
        //}
        JHTML::_('stylesheet', JURI::root() . 'plugins/system/jatypo/jatypo/typo/typo.css', array(), true);
    }


    function onAfterRender()
    {
        $mainframe = JFactory::getApplication();
        
        $jatypo = JRequest::getCmd('jatypo');
        //if (!$mainframe->isAdmin() && !$jatypo) return;
        

        $tmpl = dirname(__FILE__) . DS . 'jatypo' . DS . 'tmpl' . DS . 'default.php';
        $html = $this->loadTemplate($tmpl);
        
        $buffer = JResponse::getBody();
        //if($mainframe->isAdmin()) {
        if (preg_match('/id=\"editor-xtd-buttons\"/', $buffer)) {
            $buffer = preg_replace('/<\/body>/', "\n$html\n</body>", $buffer);
            JResponse::setBody($buffer);
        }
        return;
        //}
        

        //replace body by the sample
        $buffer = preg_replace('/<body([^>]*)>.*<\/body>/s', "<body\\1>$html</body>", $buffer);
        JResponse::setBody($buffer);
    }


    function loadTemplate($template)
    {
        if (!is_file($template))
            return '';
        ob_start();
        include ($template);
        $content = ob_get_clean();
        return $content;
    }
}