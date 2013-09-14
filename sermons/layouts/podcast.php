<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
<channel>
   <title>Crossings Community Church | Sunday Sermons</title>
   <link>http://www.crossingscommunity.com<?php echo URL_ROOT; ?></link>
   <language>en-us</language>
   <copyright>&#x2117; &amp; &#xA9; 2010 Crossings Community Church</copyright>
   <itunes:subtitle>Current Series: Getting Established in the Gospel</itunes:subtitle>
   <itunes:author>Crossings Community Church</itunes:author>
   <itunes:summary></itunes:summary>
   <description></description>
   <itunes:explicit>clean</itunes:explicit>
   <itunes:owner>
      <itunes:name>Aaron Fraser</itunes:name>
      <itunes:email>aaron@crossingscommunity.com</itunes:email>
   </itunes:owner>
   <itunes:image href="http://crossingscommunity.com/sermons/public/images/sermons-album-art.gif" />
   <itunes:category text="Religion &amp; Spirituality">
      <itunes:category text="Christianity"/>
   </itunes:category>
   
   <?php $__layout->yield(); ?>
   
</channel>
</rss>
