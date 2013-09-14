<?php

/* Page Builder Class
* Starting off simple, then can add as I think of things, I suppose...
*/

class tmPager {
	
	var $path;
	var $pageTitle='Tina Marie Bridal Hair Design';
	var $metaKeys=null;
	var $metaDesc=null;
	var $styles=null;
	var $css= array();
	var $js= array();
	
	var $title_dir=null;
	
	// For development - boolean: show errors?
	var $showErrors= 1;
	
	function tmPager() {
		$this->path= ROOT . '/inc/';
	}
	
	
	function open() {
		if (file_exists($this->path . 'page_open.tpl.php')) {
			
			if ($this->pageTitle) { $pageTitle= $this->pageTitle; }
			if ($this->metaKeys) { $meta_keywords= $this->metaKeys; }
			if ($this->metaDesc) { $meta_description= $this->metaDesc; }
			if ($this->styles) { $styles= $this->styles; }
			if (count($this->css) > 0) { $cssArr= $this->css; }
			if (count($this->js) > 0) { $jsArr= $this->js; }
			
			include($this->path . 'page_open.tpl.php');
		}
		else {
			$error= '<p>Attention: The Page Open does not exist.  Please check the path.</p>
			<p>The current path is ' . $this->path . 'page_open.tpl.php' . '</p>' . "\n";
			
			if ($this->showErrors) {
				die($error);
			}
			else {
				return FALSE;
			}
		}
	}
	
	
	function popupOpen() {
		if (file_exists($this->path . 'popup_open.inc.php')) {
			
			if ($this->pageTitle) {
				$pageTitle= $this->pageTitle;
			}
			
			include($this->path . 'popup_open.inc.php');
		}
		else {
			$error= '<p>Attention: The Page Open does not exist.  Please check the path.</p>
			<p>The current path is ' . $this->path . 'popup_open.inc.php' . '</p>' . "\n";
			
			if ($this->showErrors) {
				die($error);
			}
			else {
				return FALSE;
			}
		}
	}

	
	function popupClose() {
		if (file_exists($this->path . 'popup_close.inc.php')) {
			include($this->path . 'popup_close.inc.php');
		}
		else {
			$error= '<p>Attention: The Page Close does not exist.  Please check the path.</p>
			<p>The current path is ' . $this->path . 'popup_close.inc.php' . '</p>' . "\n";
			
			if ($this->showErrors) {
				die($error);
			}
			else {
				return FALSE;
			}
		}
	}
	
	
	function close() {
		if (file_exists($this->path . 'page_close.tpl.php')) {
			include($this->path . 'page_close.tpl.php');
		}
		else {
			$error= '<p>Attention: The Page Close does not exist.  Please check the path.</p>
			<p>The current path is ' . $this->closePath . '</p>' . "\n";
			
			if ($this->showErrors) {
				die($error);
			}
			else {
				return FALSE;
			}
		}
	}
	
	
	function pageTitle($title) { $this->pageTitle= $this->pageTitle . ' :: ' . $title; }
	function getPageTitle() { return $this->pageTitle; }
	
	function metaKeys($keys) { $this->metaKeys= $keys; }
	function getMetaKeys() { return $this->metaKeys; }
	
	function metaDesc($desc) { $this->metaDesc= $desc; }
	function getMetaDesc() { return $this->metaDesc; }
	
	function styles($styles) { $this->styles= $styles; }
	function getStyles() { return $this->styles; }
	
	function addCSS($src) { $this->css[]= $src; }
	function getCSS() { return $this->css; }
	
	function addJS($src) { $this->js[]= $src; }
	function getJS() { return $this->js; }
	
	
	function includeFile($file) {
		if (file_exists($file)) {
			@require($file);
		}
		else {
			$error= '<p>Attention: ' . $file . ' does not exist.  Please check the path.</p>' . "\n";
			echo $error;
		}
	}
	
	
	function spacer($value) {
	/** Creates a DIV spacer **/
		echo '<div style="margin-bottom: ' . $value . 'px"></div>' . "\n";
	}
	
	
	
	/**
	* @access public
	* 
	* Title creation
	*/
	function h2($title) {
		if (!is_null($this->title_dir)) $t= new title($this->title_dir);
		else $t= new title();
		return $t->h2($title);
	}
	
	function h3($title) {
		if (!is_null($this->title_dir)) $t= new title($this->title_dir);
		else $t= new title();
		return $t->h3($title);
	}
}


/* Title Creation */
require_once('ImageText/Image.php');

class title extends ImageText {
	
	var $image_dimensions= null;
	var $image_name = null;
	
	var $margin_w = 2;
	var $margin_h = 10;
	
	
	function title($cachedir=null) {
		if (!is_null($cachedir)) $this->cacheDirectory($cachedir);
		else $this->cacheDirectory('./i/titles/');
		$this->fontDirectory(dirname(__FILE__) . '/fonts/');
	}
	
	
	
	// Call this for H1 titles
	function h2($title, $size=null) {
		if (!is_null($size)) $this->buildh1($title, $size);
		else $this->buildh2($title);
		$this->create();
		$output= '<img src="' . $this->imageName() . '" ' . $this->imageDimensions() . ' alt="' . $title . '" title="' . $title . '" />';
		return $output;
	}
	
	
	// Call this for H2 titles
	function h3($title) {
		$this->buildh3($title);
		$this->create();
		$output= '<img src="' . $this->imageName() . '" ' . $this->imageDimensions() . ' alt="' . $title . '" title="' . $title . '" />';
		return $output;
	}
	
	
	// ** PRIVATE **//
	// Builds an H1 sized title
	function buildH2($h1, $size=null) {
		if (!is_null($size)) $this->size($size);
		else $this->size(20);
		$this->addLine($h1);
	}
	
	
	// ** PRIVATE ** //
	// Builds an H2 sized title
	function buildH3($h2) {
		$this->color('#555');
		$this->size(18);
		$this->margin(2, 7);
		$this->addLine($h2);
	}
	
	
	// ** PRIVATE ** //
	// Does the actual creation of the image
	function create() {
	  $output= $this->renderCached();
	  $size= @getimagesize($output);
	  
	  $this->image_dimensions= $size[3];
	  $this->image_name= $output;
   }
   
   
   function imageDimensions() { return $this->image_dimensions; }
   function imageName() { return $this->image_name; }
   
}

?>
