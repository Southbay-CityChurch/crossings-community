<?php

// This class is dependent upon the prototype.js and scriptaculous.js files, so those should be included
// in the head of the page before these methods are called.


/* -- Example Usage --

$ajax= new ajax($path_to_processing_script);

$options= array('rows'=>'4', 'cols'=>'5', 'highlightcolor'=>'#ff0000');
$ajax->inlineEditor($field_id, $options);

	NOTE:		The $field_id variable is a combination of the fieldname and the id of the item being edited.
					The submitting script needs to put those values together
					Example: "name_2" where "name" is the DB field and "2" is the item's DB unique ID
*/

class ajax {
	
	var $processing_script_path;
	var $processing_script_field_name= 'f';
	var $processing_script_item_id= 'i';
	var $processing_script_vars='';
	
	
	
	// Path to the processing script (e.g. "/path/to/processor.php")
	function ajax($processing_script_path) {
		$this->processing_script_path= $processing_script_path;
	}
	
	
	
	// ** PRIVATE ** //
	function setProcessorVars($array) {
		foreach ($array as $key=>$val) {
			$this->processing_script_vars .= "&$key=$val";
		}
	}
	
	
	// Actual AJAX output for a form field
	// $options example: 
	//		array('rows'=>'4', 'cols'=>'5', 'highlightcolor'=>'#ff0000')
	//
	// $script_vars example:
	//		array('confirm'=>'true');  will output ?default_vars=value&confirm=true...
	//
	// See http://wiki.script.aculo.us/scriptaculous/show/Ajax.InPlaceEditor for more options
	function inlineEditor($field_id, $options=array(), $script_vars=array()) {
		if (count($script_vars) > 0) {
			$this->setProcessorVars($script_vars);
		}
		
		$count= count($options);
		if ($count > 0) {
			if ($count > 1) {
				$n=1;
				foreach ($options as $key=>$val) {
					$ajax_options .= "$key:$val";
					if ($n < $count) $ajax_options .= ", ";
					$n++;
				}
			} else {
				foreach ($options as $key=>$val) {
					$ajax_options = "$key:$val";
				}
			}
		} else {
			$ajax_options= "size:40";
		}
		
		$request= explode('_', $field_id);
		$field= $request[0];
		$id= $request[1];
		
		$ajax= "<script type=\"text/javascript\">
		new Ajax.InPlaceEditor('$field_id', 
		'" . $this->processing_script_path . "?" . $this->processing_script_field_name ."=" . $field . "&" . $this->processing_script_item_id . "=" . $id . $this->processing_script_vars . "', 
		{" . $ajax_options . "});
		</script>";
		
		return $ajax;
	}
	
	
	// This is the same as the Inline Text Input Editor above, but it's a Select field instead
	// $option_field needs an array of 'value'=>'text' - <option value="VALUE">TEXT</option>
	// Got the AJAX JS from http://dev.rubyonrails.org/ticket/2667
	function selectEditor($field_id, $option_field, $script_vars= array(), $aoptions= array()) {
		if (!is_array($option_field)) return FALSE;
		
		$option_values= "[' ',";
		$option_text= "['- Select -', ";
		
		$num_fields= count($option_field);
		
		$i=1;
		foreach ($option_field as $key=>$value) {
			$option_values .= "'$key'";
			$option_text .= "'$value'";
			if ($i < $num_fields) {
				$option_values .= ",";
				$option_text .= ",";
			}
			$i++;
		}
		
		$option_values .= "]";
		$option_text .= "]";
		
		if (count($script_vars) > 0) {
			$this->setProcessorVars($script_vars);
		}
		
		$count= count($aoptions);
		if ($count > 0) {
			if ($count > 1) {
				$n=1;
				foreach ($options as $key=>$val) {
					$ajax_options .= "$key:$val";
					if ($n < $count) $ajax_options .= ", ";
					$n++;
				}
			} else {
				foreach ($options as $key=>$val) {
					$ajax_options = "$key:$val";
				}
			}
		}
		
		$request= explode('_', $field_id);
		$field= $request[0];
		$id= $request[1];
		
		$ajax= "<script type=\"text/javascript\">
		new AjaxInPlaceSelect('$field_id', 
		'" . $this->processing_script_path . "?" . $this->processing_script_field_name ."=" . $field . "&" . $this->processing_script_item_id . "=" . $id . $this->processing_script_vars . "', 
		" . $option_values . ", " . $option_text;
		
		if (count($aoptions) > 0) $ajax .= ", {" . $ajax_options . "}";
		
		$ajax .= ")
		</script>";
		
		return $ajax;
	}
	
}

?>
