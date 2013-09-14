<?php
//require_once('../inc/config.inc.php');
require_once('tspager.model.php');

class pager extends tsPager {
	
	var $title_dir=null;
	var $pageTitle= 'Orbital Data Customer Support Site';
	
	function pager() {
		if (extranet::sessionArea()) $this->pageTitle= 'Customer Support Site ' . extranet::sessionArea();
		$this->tsPager();
	}
	
	
	/** ---------- Title Creation ---------- **/
	function setTitleDirectory($path) {
		$this->title_dir=$path;
	}
	
	
	function h1($title) {
		if (!is_null($this->title_dir)) $t= new title($this->title_dir);
		else $t= new title();
		return $t->h1($title);
	}
	
	function smallH1($title) {
		if (!is_null($this->title_dir)) $t= new title($this->title_dir);
		else $t= new title();
		return $t->h1($title, 13);
	}
	
	function h2($title) {
		if (!is_null($this->title_dir)) $t= new title($this->title_dir);
		else $t= new title();
		return $t->h2($title);
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
		else $this->cacheDirectory('./images/titles/');
		$this->fontDirectory(dirname(__FILE__) . '/fonts/');
	}
	
	
	
	// Call this for H1 titles
	function h1($title, $size=null) {
		if (!is_null($size)) $this->buildh1($title, $size);
		else $this->buildh1($title);
		$this->create();
		$output= '<img src="' . $this->imageName() . '" ' . $this->imageDimensions() . ' alt="' . $title . '" title="' . $title . '" />';
		return $output;
	}
	
	
	// Call this for H2 titles
	function h2($title) {
		$this->buildh2($title);
		$this->create();
		$output= '<img src="' . $this->imageName() . '" ' . $this->imageDimensions() . ' alt="' . $title . '" title="' . $title . '" />';
		return $output;
	}
	
	
	// ** PRIVATE **//
	// Builds an H1 sized title
	function buildH1($h1, $size=null) {
		if (!is_null($size)) $this->size($size);
		else $this->size(20);
		$this->addLine($h1);
	}
	
	
	// ** PRIVATE ** //
	// Builds an H2 sized title
	function buildH2($h2) {
		$this->color('#555');
		$this->size(14);
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
