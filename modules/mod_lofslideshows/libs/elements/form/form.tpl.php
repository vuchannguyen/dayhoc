<?php
/*------------------------------------------------------------------------
 # com_ick - Lof Ick Component
 # ------------------------------------------------------------------------
 # author    LandOfCoder
 # copyright Copyright (C) 2010 landofcoder.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.landofcoder.com
 # Technical Support:  Forum - http://www.landofcoder.com/forum.html
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
	foreach( $this->folders as $folder ) { 
		$file = $path.$folder.DS.$this->xmlConfigFile;
		if( file_exists($file) ){
		$string = '';  
		$options = array("control"=>"jform", 'file'=>$file );   	
		$paramsForm = &JForm::getInstance( 'jform'.$folder, $file,$options );
		$fieldSets = $paramsForm->getFieldsets('params');?>
<div class="my-elements" id="group-theme-<?php echo $folder; ?>">
<?php 
foreach ($fieldSets as $name => $fieldSet) : ?>

	<?php // echo JHtml::_('sliders.panel', JText::_($fieldSet->label), $fieldSet->name); ?>
	<fieldset class="adminform"><legend><?php echo JText::_("Configuration ". $folder);?></legend>
	<ul class="adminformlist">    
<?php	if (isset($fieldSet->description) && trim($fieldSet->description)) :
		echo '<p class="tip">'.JText::_($fieldSet->description).'</p>';
	endif;?>
		
	<?php $hidden_fields = ''; ?>
	<?php foreach ($paramsForm->getFieldset($name) as $field) : // echo $folder;die; //echo '<Pre>'.print_r($field->fieldname.'[theme]',1); die; ?>
	<?php if (!$field->hidden) : ?>
	<li>
		<?php echo $paramsForm->getLabel(  $field->fieldname,$field->group); ?>
		<?php echo $paramsForm->getInput( $field->fieldname,$field->group); ?>
	</li>
	<?php else : $hidden_fields.= $paramsForm->getInput($field->fieldname,$field->group); ?>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php echo $hidden_fields; ?>
    </ul>
</fieldset>
<?php endforeach; ?>
<?php // echo JHtml::_('sliders.end'); //    echo '<pre>'.print_r( $this->form,1); die;?>
</div>
<?php }} ?>