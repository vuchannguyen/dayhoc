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

interface ILeoMenu{
	public function render();
	public function preProcess();
}
require_once( dirname(dirname(__FILE__)).DS."compress".DS."compress.php" );
require_once( dirname(__FILE__).DS."template_helper.php" );
 
?>
