<?php

if( !class_exists('LofImageDataSource') ){  
	class LofImageDataSource extends LofDataSourceBase{
		/**
		 * @var string $__name;
		 *
		 * @access private
		 */
		var $__name = 'image';
		
		/**
		 * override method: get list image from articles.
		 */
		function getList( $params ){
			$subpath = trim( $params->get( 'image_folder', '' ) );
			if( empty($subpath) ) { return array(); }
			$tmpPath = str_replace( DS, '/', $subpath ).'/';
			$path = JPATH_SITE.DS.$subpath;
			$overrideLinks = array();
			if( $tmp = $params->get('override_links', '' ) ){
				foreach( $tmp as $titem ){
					$link  = explode("|", $titem );	
					if( count($link) > 1 ){
						$overrideLinks[trim(strtolower($link[0]))]=$link[1];
					}
				}
			}
			
			$files = JFolder::files( $path,'.jpg|.png|.gif' ); 
			if( is_array($files) ){
				$thumbWidth    = (int)$params->get( 'thumbnail_width', 35 );
				$thumbHeight   = (int)$params->get( 'thumbnail_height', 60 );
				$imageHeight   = (int)$params->get( 'main_height', 300 ) ;
				$imageWidth    = (int)$params->get( 'main_width', 660 ) ;
				$isThumb       = $params->get( 'auto_renderthumb',1);
				$ordering 	   = $params->get( 'image_ordering', '' );
				$limit 		   = (int)$params->get( 'limit_items', 5 );
				
				$categoryId    = (int)$params->get( 'image_category', '' );
				

				$content = $this->getContent( $categoryId );
				$extraURL 		= $params->get('open_target')!='modalbox'?'':'&tmpl=component'; 
				$tmp = $files;
				if( trim($ordering) == 'random' ){ 
					$rand = (array_rand($files, count($files)));
					$files = ( array_combine(  $rand , $files  ) );
				}
				$data = array();
				$i = 0;
				foreach( $tmp as $key => $file){
					$item = new stdClass();
					$item->link = '';
					$item->category_title ='';
					$item->catid='';
					$item->date='';
					if( isset($content[preg_replace("/\.(\w{3})$/",'',strtolower(trim($file)))]) ){
						$tmp = $content[preg_replace("/\.(\w{3})$/",'',strtolower(trim($file)))];
						$item = $tmp;
						$item->date = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2')); 
						$item->description = $tmp->introtext;
				
					} else {	
						$item->title = ""; //$file;
						$item->description = ""; $file;
						$item->introtext = "";$file;
					}
		
					if( isset($overrideLinks[strtolower(substr($file,0,strlen($file)-4))]) && $overrideLinks[strtolower(substr($file,0,strlen($file)-4))] ){
						$item->link = $overrideLinks[strtolower(substr($file,0,strlen($file)-4))];
					}

					$item->mainImage = $tmpPath.$files[$key];
					$item->thumbnail  = $tmpPath.$files[$key];
					$item = $this->generateImages( $item, $isThumb );
					$data[] = $item;
					$i++;
					if( $i>= $limit ){ break; }
					
				}
				return $data;
			}
			return array();
		}
		public function generateImages( $item, $isThumb = true ){
			foreach($this->_imagesRendered as $key => $value ){ // echo '<pre>'.print_r($this->_imagesRendered,1);die;
				if( $item->{$key} &&  $image=$this->renderThumb($item->{$key}, $value[0], $value[1], $item->title, $isThumb) ){
					$item->{$key} = $image;
				}
			}
			return $item;
		}
		
		function getContent( $categoryId ){
			$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
			$app = JFactory::getApplication();
	    	$appParams = $app->getParams();
	    	$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
	    	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	    	$model->setState('filter.access', $access);
	    
	    	$model->setState('params', $appParams);
	      	$model->setState('filter.published', 1);

	        $model->setState('filter.category_id',  $categoryId);
	      	$data = $model->getItems();
			// Access filter
	    	$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
	    	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	   		$output = array();
			foreach( $data as $key => $item ){	
				$item->slug = $item->id.':'.$item->alias;
	      		$item->catslug = $item->catid.':'.$item->category_alias;
	      	
				if ($access || in_array($item->access, $authorised)) {
		        	// We know that user has the privilege to view the article
		        	$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			    }
			    else {
			    	$item->link = JRoute::_('index.php?option=com_user&view=login');
			    }
				$item->introtext   = JHtml::_('content.prepare', $item->introtext);
				$item->date = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2')); 
				// $results = @$dispatcher->trigger('onPrepareContent', array (&$data[$key], & $params, 0));
				$tmp  = explode("|", $item->title );
				$item->title  = count($tmp) >= 2 ? $tmp[1]:$tmp[0];
				$output[strtolower(trim($tmp[0]))] = $data[$key];
			}
	//		echo '<Pre>'.print_r($output,1); die;
	      	return $output;
		}
		
	}
}