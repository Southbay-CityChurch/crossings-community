<?php
// How to read the data

require_once(VENDOR_SPYC);


class Series {
   
   var $datas = array();
   var $data_directory = null;
   var $title = '';
   var $summary = '';
   
   var $path_lookup =   array(' ');
   var $path_replace =  array('%20');
   
   function load(){
      $yaml = Spyc::YAMLLoad(ROOT . URL_ROOT . '/data/series_data.yml');
      
      $this->data_directory = ROOT . URL_ROOT . $yaml['data_directory'];
      $this->data_url =       $yaml['data_url'];
      
      $this->title =          $yaml['series_title'];
      $this->summary =        $yaml['series_summary'];
      $this->itunes_podcast = $yaml['series_itunes_podcast'];
      
      
      
      foreach($yaml['series_data'] as $week_number => $data) {
         $data = $this->makeFullPathForFiles($data);
         $data = $this->makeFullURLForFiles($data);
         
         
         $series_data_entry = new SeriesDataEntry($week_number, $data);
         
         // echo '<!-- ';print_r($series_data_entry);  echo ' -->';
         
         $this->datas[$week_number] = $series_data_entry;
      }
      
      
      // reverse so now its in reverse-yaml order
      // The true, preserves the keys
      $this->datas = array_reverse($this->datas,true);
   }
   
   function getSeriesData($week = null) {
      if(is_null($week))      return $this->datas;
      else                    return $this->datas[$week];
         
   }
   
   function hasWeek($week_number) {
      return isset($this->datas[$week_number]);
   }
   
   function makeFullPathForFiles($data) {
      // boy this looks terribly ugly!
      
      $data['file_paths'] = $data['files'];

      if(is_array($data['file_paths']) && !empty($data['file_paths'])) {
         foreach($data['file_paths'] as $data_key => $file) {
            $data['file_paths'][$data_key]  = $this->data_directory . $file;
            if (!is_readable($this->data_directory . $file)) {
               unset($data['files'][$data_key]);
               unset($data['file_paths'][$data_key]);
            }
         }
      }
   
      return $data;

      
   }
   
   function makeFullURLForFiles($data) {
      // boy this looks terribly ugly!

      if(is_array($data['files']) && !empty($data['files'])) {
         foreach($data['files'] as $data_key => $file) {
            $data['files'][$data_key]  = $this->data_url . $this->encode($file);
         }
      }      
      return $data;
   }
   
   // substitute '%20' for ' '
   function encode($value) {
      return str_replace($this->path_lookup, $this->path_replace, $value);
   }
   
   function decode($value) {
      // if(!defined($this)){  
         $that = new Series();   // so it can be called statically
         return str_replace($that->path_replace, $that->path_lookup, $value);
      // } else {
      //    return str_replace($this->path_replace, $this->path_lookup, $value);
      // }
      
      // return   
   }
}
class SeriesDataEntry {
   
   var $week_number = 0;
   
   function SeriesDataEntry($week_number, $array_of_data){
      $this->week_number = $week_number ;
      
      foreach($array_of_data as $key => $value) {
         
         if($key == 'date') $value = date('m/d/y',strtotime($value));
         
         $this->$key = $value;
      }
      $this->getLength();
   }
   
   function getLength(){
      if(isset($this->file_paths['audio'])) {
         $this->audio_file_length = filesize($this->file_paths['audio']);
      }
   }
      
}


?>
