<?php
require_once('../../config/init.php');
require_once(LAYOUT_FRAMEWORK);

require_once(SERIES_DATA_MODEL);
require_once(CACHED_SERIES_DATA_MODEL);


header("Content-type: application/xml; charset=UTF-8"); 

define('LAYOUT', 'podcast');

// $series_data = new Series();
$series_data = new CachedSeries();
$series_data->load();

$i=1;
foreach($series_data->getSeriesData() as $week_data) {

   if (isset($week_data->file_paths['audio'])) {
      echo Render::partial('item', array( 'index' => $week_data->week_number,
                                          'week' => $week_data->week_number,
                                          'title' => $week_data->title,
                                          'date' => $week_data->date,
                                          'summary' => $week_data->summary,
                                          'duration' => $week_data->duration,
                                          'author' => $week_data->author,
                                          'file' => $week_data->files['audio'],
                                          'length' => $week_data->audio_file_length,
                                         ));
  }
}