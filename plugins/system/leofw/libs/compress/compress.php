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
class LeoCompressHelper {
	
	
	public static function compressJS( $cssFiles, $document, $exFiles='' ){
		
		$cacheFile = md5(serialize($cssFiles)).".js";
		$content = '';
		$isExisted = self::isCacheExisted($cacheFile);
 		$exFiles = (array)preg_split("#\s*,\s*#", $exFiles);
		jimport('joomla.filesystem.file');
		$readded = array();
		foreach( $cssFiles as $rfile => $info  ){
			$file 	  = self::cleanUrl( $rfile );
			$subpath  = preg_replace("/^(\\".DS.")*/","",str_replace( '/', DS, $file ) );
			$fullpath = JPATH_ROOT.DS . $subpath;	
			$tmp = explode( "/", $rfile );
			if( (is_file($fullpath) && file_exists($fullpath)) && !in_array($tmp[count($tmp)-1],$exFiles) ){
				if( !$isExisted  ) {
					$content ." /* JS File: {$file} */\n ";
					$content .= (JFile::read( $fullpath ) );
				}
				unset( $document->_scripts[$rfile] );
			} 
		}
		$file = self::storeCache( $cacheFile, $content );
		$document->addScript( $file );
	}
	
	/**
	 *
	 */
	public static function compressCss( $cssFiles, $document, $exFiles='' ){
		
		$cacheFile = md5(serialize($cssFiles)).".css";
		$content = '';
		$isExisted = self::isCacheExisted( $cacheFile );
		$exFiles = (array)preg_split("#\s*,\s*#", $exFiles);
		
		jimport('joomla.filesystem.file');
		foreach( $cssFiles as $rfile => $info  ){
			$file 	  = self::cleanUrl( $rfile );
			$subpath  = preg_replace("/^(\\".DS.")*/","",str_replace( '/', DS, $file ) );
			$fullpath = JPATH_ROOT.DS . $subpath;
			$tmp = explode( "/", $rfile );
			if( file_exists($fullpath) && is_file($fullpath) &&  !in_array($tmp[count($tmp)-1],$exFiles) ){
				if( !$isExisted  ) {
					$content .= self::cleanCssContent(JFile::read( $fullpath ), $rfile );
					$content ." /* End Css File: {$file} */\n ";
				}
				unset(  $document->_styleSheets[$rfile] );	
			} 
		}
		$file = self::storeCache( $cacheFile, $content );
		$document->addStyleSheet( $file );
		
	}
	
	/**
	 *
	 */
	public static function isCacheExisted( $file ){
		return file_exists( JPATH_SITE . DS . 'cache' . DS . 'leo'.DS.$file);	
	}
	
	/**
	 *
	 */
	public function clearCache(){
		$path = JPATH_SITE . DS . 'cache' . DS . 'leo';
		jimport('joomla.filesystem.folder');
		if( is_dir($path) ){
			JFolder::delete( $path);
			return true;
		}
		return false; 
	}
	
	/**
	 *
	 */
	public function storeCache( $filename, $content ){
		
		$path = JPATH_SITE . DS . 'cache' . DS . 'leo';
        if (!is_dir($path)) @JFolder::create($path);
        $path = $path . DS . $filename;
        $url = JURI::base(true) . '/cache/leo/' . $filename;
		if( $content ){
        	@JFile::write( $path, $content );
		}
		return is_file($path) ? $url : false;
		
	}
	
	public static function cleanUrl( $strSrc ) {
        if (preg_match('/^https?\:/', $strSrc)) {
            if (!preg_match('#^' . preg_quote(JURI::base()) . '#', $strSrc)) return false; //external css
            $strSrc = str_replace(JURI::base(), '', $strSrc);
        } else {
            if (preg_match('/^\//', $strSrc)) {
                if (!preg_match('#^' . preg_quote(JURI::base(true)) . '#', $strSrc)) return false; //same server, but outsite website
                $strSrc = preg_replace('#^' . preg_quote(JURI::base(true)) . '#', '', $strSrc);
            }
		}
        $strSrc = str_replace('//', '/', $strSrc);
        $strSrc = preg_replace('/^\//', '', $strSrc);
        return $strSrc;
    }

	
	/**
	 *
	 */
	public static function cleanCssContent( $content , $url ){
		global $cssURL;   $cssURL = $url;
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $content);
        $content = preg_replace('/[ ]+([{};,:])/', '\1', $content);
        $content = preg_replace('/([{};,:])[ ]+/', '\1', $content);
        $content = preg_replace('/(\}([^\}]*\{\})+)/', '}', $content);
        $content = preg_replace('/<\?(.*?)\?>/mix', '', $content);
        $content = preg_replace_callback('/url\(([^\)]*)\)/', array('LeoCompressHelper', 'callbackReplaceURL'), $content);
		
        return $content;	
	}
	
	/**
	 *
	 */
	function callbackReplaceURL( $matches) {
        $url = str_replace(array('"', '\''), '', $matches[1]);
        global $cssURL;
        $url = self::converturl( $url, $cssURL );
        return "url('$url')";
    }
	
	/**
	 *
	 */
	function converturl($url, $cssurl) {
        $base = dirname($cssurl);
        if (preg_match('/^(\/|http)/', $url))
            return $url;
        /*absolute or root*/
        while (preg_match('/^\.\.\//', $url)) {
            $base = dirname($base);
            $url = substr($url, 3);
        }

        $url = $base . '/' . $url;
        return $url;
    }

	/**
	 * Load PHP Gzip Extension
	 *
	 * @param boolean $loadGzip
	 * @return boolean true if loaded.
	 */
	public static function loadGZip( $isGZ ) {		
		//$encoding = $this->clientEncoding();
		if (!$isGZ){
			$isGZ=false;
		}
		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			$isGZ=false;
		}
		return $isGZ; 
	}
	
}
?>