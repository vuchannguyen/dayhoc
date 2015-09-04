<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<ul class="static" style="margin: 0 0 10px 0">
<?php foreach ($list as $item) : ?>
<li>
<span class="color1"><?php echo $item->title ?> : </span> <strong class="color2"><?php echo $item->data ?> </strong><br />
</li>
<?php endforeach; ?>
</ul>
