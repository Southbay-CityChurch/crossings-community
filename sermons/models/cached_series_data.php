<?php

require_once(VENDOR_CACHE);
require_once(SERIES_DATA_MODEL);

class CachedSeries extends Series {
   function load() {
      $options = array(
          'cacheDir' => ROOT . URL_ROOT . 'tmp/',
          'lifeTime' => 86400
      );
      // Create a Cache_Lite object
      $Cache_Lite = new Cache_Lite($options);   
      
      if ($object = unserialize($Cache_Lite->get(1))) {
         
         foreach(get_object_vars($object) as $variable => $value) {
            $this->$variable = $object->$variable;
         }
         
         // $this->data_directory = $object->data_directory;
         // $this->data_url =       $object->data_url;
         // $this->title =          $object->title;
         // $this->summary =        $object->summary;
         // $this->datas =          $object->datas;
         
      } else {
               
         parent::load();   // call the parent to actually get the data the thing
         $Cache_Lite->save(serialize($this));         
      }

   } 
}

?>