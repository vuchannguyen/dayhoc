<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<?php if(count($list)): ?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
 <?php foreach ($list as $key=>$item):	?>
    <li class="<?php echo ($key%2) ? "odd" : "even"; if(count($list)==$key+1) echo ' lastItem'; ?>">
       <div class="field-img">
<?php
 preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->introtext, $matches);
            $getimg = $matches[1][0];
       ?>    <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>" ><img alt="" src="<?php echo JURI::base().$getimg;?>" />
            
</a>
</div>

<div class="field-title">
		<a href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?></a>
 </div>
 <?php if( $params->get('itemAuthor',1) ) : ?>
              <div class="lof-author">  <?php echo JText::_('Author'); ?> : <?php echo $item->author; ?></div>
                <?php endif; ?>
 	         
	</li>
<?php endforeach; ?>
</ul>
  <?php endif; ?>