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

echo '<div id="fb-root"></div>';
echo '</script><fb:recommendations site="'.$rec_domain.'" width="'.$rec_width.'" height="'.$rec_height.'" header="'.$rec_showheader.'" colorscheme="'.$rec_colorscheme.'" font="'.$rec_font.'" border_color="'.$rec_border.'"></fb:recommendations>'; 
?>