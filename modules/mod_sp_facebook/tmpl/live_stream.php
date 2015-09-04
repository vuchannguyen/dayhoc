<?php
/*---------------------------------------------------------------
# SP Facebook - All in one facebook module for joomla 1.6
# ---------------------------------------------------------------
# Author - JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2011 JoomShaper.com. All Rights Reserved.
# license - PHP files are licensed under  GNU/GPL V2
# Websites: http://www.joomshaper.com - http://www.joomxpert.com
-----------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

$doc->addScript ('http://connect.facebook.net/'.$plg_lang.'/all.js#appId='.$livestream_appid.'&amp;xfbml=1');

echo '<div id="fb-root"></div>';
echo '<fb:live-stream event_app_id="'.$livestream_appid.'" width="'.$livestream_width.'" height="'.$livestream_height.'" xid="'.$livestream_xid.'" via_url="'.$livestream_attr_url.'" always_post_to_friends="'.$livestream_posttofrnd.'"></fb:live-stream>';
?>