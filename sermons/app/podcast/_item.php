<item>
   <title><?php echo $title; ?></title>
   <itunes:author><?php echo $author; ?></itunes:author>
   <itunes:summary><?php echo $summary; ?></itunes:summary>
   <description><?php echo $summary; ?></description>
   <enclosure url="<?php echo $file; ?>" length="<?php echo $length; ?>" type="audio/mpeg" />
   <itunes:duration><?php echo $duration; ?></itunes:duration>
   <itunes:explicit>clean</itunes:explicit>
   <guid>http://www.crossingscommunity.com<?php echo URL_ROOT . $index; ?></guid>
   <pubDate><?php echo date('r', strtotime($date)); ?></pubDate>
</item>
