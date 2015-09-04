<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
if( !class_exists('LofFileDataSource') ){  
	class LofFileDataSource extends LofDataSourceBase{
		/**
		 * @var string $__name;
		 *
		 * @access private
		 */
		var $__name = 'file';
 
		/**
		 * override method: get list image from articles.
		 */
		function getList( $params ){
			$maxFiles = 12;
			$thumbWidth    = (int)$params->get( 'thumbnail_width', 35 );
			$thumbHeight   = (int)$params->get( 'thumbnail_height', 60 );
			$imageHeight   = (int)$params->get( 'main_height', 300 ) ;
			$imageWidth    = (int)$params->get( 'main_width', 660 ) ;
			$isThumb       = $params->get( 'auto_renderthumb',1);
			
			$baseURI = JURI::base();
			$subbase = JURI::base(true);
			$path = '';
			if( $params->get('link_source','folder_path') =='folder_path' ){
					$path = $params->get('folder_path','').DS;
			}
			 $attributes = array(
					      "preview"     => ""   ,
					      "path"        => ""   , 
					      "title"       => ""   ,
						  "content"     =>''    ,
					   	  "link" 	    => ""   ,
					  	  'filetype'    => "image",
			
					  	  'imagepos'      => ""  ,
					  	  'time'  	    => "12",
						  'ispanned'   => '0'
						); 
						 
			 $output = array(); 
		
			 for( $i=1; $i<=$maxFiles; $i++ ){
 
				$obj = $params->get('file'.$i);
					
				if( is_object($obj) && $obj->enable  ){
 					
					$obj->realpath = $obj->path;
					$obj->path =  $baseURI.preg_replace("#^\/+#","",str_replace("//","/",str_replace( DS,"/",$path.$obj->path)));
					$obj->mainImage =  $baseURI.preg_replace("#^\/+#","",str_replace("//","/",str_replace( DS,"/",$path.$obj->preview)));
					if( isset($obj->mainImage) && trim($obj->realpath) ){
						$obj->thumbnail = $obj->path;	
					} else {
						$obj->thumbnail  = $obj->mainImage; 	
					}
					
					$obj->description = $obj->introtext = $obj->content;
					$obj->subtitle = $obj->title;

					$obj->introtext = $obj->content; 
					if( preg_match("/.png|.jpg|.gif/", strtolower($obj->mainImage) )  ) { 
						$obj = $this->generateImages( $obj, $isThumb );
					}
	
				
					$output[]=$obj;
			
				}
				
				
			 }
		
			return $output; 
		}
		public function generateImages( $item, $isThumb = true ){	
			foreach($this->_imagesRendered as $key => $value ){ 
		
			// echo '<pre>'.print_r($this->_imagesRendered,1);die;
				if( $item->{$key} &&  $image=$this->renderThumb($item->{$key}, $value[0], $value[1], $item->title, $isThumb) ){
					$item->{$key} = $image;
				}
			}
			return $item;
		}
	}
}
?>