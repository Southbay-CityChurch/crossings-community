<?php

require_once('../config/init.php');
require_once(LAYOUT_FRAMEWORK);
require_once(STRING_FRAMEWORK);

require_once(CACHED_SERIES_DATA_MODEL);
require_once(SERIES_DATA_MODEL);

define('LAYOUT',    'site');


$series_data = new CachedSeries();
$series_data->load();

if(isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
} else {
	$id = 0;
}

if ($id > 0 && $series_data->hasWeek($id)) {
   $week_data = $series_data->getSeriesData($id);
   
   echo Render::partial('files', array('week' => $week_data->week_number,
																	     'series' => $week_data->series,
																	     'title' => $week_data->title,
                                       'date' => $week_data->date,
                                       'author' => $week_data->author,
                                       'files' => $week_data->files,
                                       'itunes_podcast' => $series_data->itunes_podcast
                                      ));
                                      

} else {
   echo '<p id="series-summary">' . $series_data->summary;
      //echo '<br/> Click to visit the <a href="' . $series_data->itunes_podcast . '" title="Subscribe to the Sermon Series">Crossings Podcast</a> via iTunes.';
   echo '</p>';
   
   foreach($series_data->getSeriesData() as $week_data) {

        echo Render::partial('week', array( 'week' => $week_data->week_number,
          																	'series' => $week_data->series,
                                            'title' => $week_data->title,
                                            'summary' => $week_data->summary,
                                            'date' => $week_data->date,
                                            'author' => $week_data->author,
                                            'files' => $week_data->files,
                                           ));
     }
}


function pluralize($count,$text,$pluralized_text=null) {
   if($count != 1) {
      if (is_null($pluralized_text) )
         $text = Plurals::pluralize($text);
      else
         $text = $pluralized_text;
   }
   return $text;
}

?>