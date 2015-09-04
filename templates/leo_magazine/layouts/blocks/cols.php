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

$setting = array( "name"	  => "user",
 			      "numcols"   => 4,
				  "start"     => 1,
				  "maxwidth"  => '',
				  "style"     => 'leoxhtml',
				  "wrapclass" => 'leo-container',
				  'id'		  =>'userpos');
if( is_array($args) ){
	$setting = array_merge( $setting, $args );
}
$cols = $this->calculateColsWidth( $setting );
?>
<?php if( !empty($cols) ) : ?> 
<div id="leo-<?php echo $setting['id'];?>" class="wrap" >  
    <div class="<?php echo $setting["wrapclass"];?>"><div class="<?php echo $setting["wrapclass"];?>-inner"> 
        <?php foreach( $cols as $pos => $col ) : ?>
        <div id="leo-<?php echo $pos;?>" class="leo-usercol leo-box<?php echo $col['class']; ?>" style="width: <?php echo $col['width']; ?>;">
            <div class="leo-box-inside">
                <jdoc:include type="modules" name="<?php echo $pos;?>" style=" <?php echo $setting['style'];?>" />
            </div>
        </div>
        <?php endforeach;  ?>
    </div></div>
</div>    
<?php endif; ?>
 