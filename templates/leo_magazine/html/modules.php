<?php
/**
 * @version		$Id: modules.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Module chrome that allows for rounded corners by wrapping in nested div tags
 */
function modChrome_leorounded($module, &$params, &$attribs)
{
	$titles = JString::strpos($module->title, ' ');
	$title = ($titles !== false) ? JString::substr($module->title, 0, $titles).'<span>'.JString::substr($module->title, $titles).'</span>' : $module->title;
?>
		<div class=" leo-module module<?php echo $params->get('moduleclass_sfx'); ?>">
			<div class="leo-tc">
				<div class="leo-tl"></div>
				<div class="leo-tr"></div>
			</div>
			<div class="leo-c">
				<div class="leo-c-inset"	>
					<?php if ($module->showtitle != 0) : ?>
						<h3 class="png"><?php echo $title; ?></h3>
					<?php endif; ?>
					<?php echo $module->content; ?>
					<br class="clearfix"/>
				</div>
			</div>
			<div class="leo-bc clearfix">
				<div class="leo-bl"></div>
				<div class="leo-br"></div>
			</div>
		</div>
<?php
}

function modChrome_leoxhtml($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
	<div class="leo-module moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
		<div class="leomodule">
			<?php if ($module->showtitle != 0) : ?>
				<h3 class="moduletitle"><span><?php echo $module->title; ?></span></h3>
			<?php endif; ?>
			<div class="modulecontent">
				<?php echo $module->content; ?>
			</div>
		</div>
	</div>
<?php endif;
}

function modChrome_leoxhtml2($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="leo-module moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<div class="leomodule">
				<?php if ($module->showtitle != 0) : ?>
					<h3 class="title"><?php echo $module->title; ?></h3>
				<?php endif; ?>
				<div class="modulecontent">
					<?php echo $module->content; ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php endif;
}

function modChrome_leoxhtml4($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
	<div class="leo-module moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
		<div class="leomodmenu">
			<?php if ($module->showtitle != 0) : ?>
				<h3 class="moduletitle"><span><?php echo $module->title; ?></span></h3>
			<?php endif; ?>
			<div class="modulecontent">
				<?php echo $module->content; ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<?php endif;
}

function modChrome_leomobile($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="leo-module moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($module->showtitle != 0) : ?>
			<div class="module-head clearfix">
				<div class="module-head-inner">
					<h3 class="moduletitle"><?php echo $module->title; ?></h3>
				</div>
			</div>
			<?php endif; ?>

			<div class="modulecontent clearfix">
				<?php echo $module->content; ?>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php endif;
}
?>
