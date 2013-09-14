<div class="sermon-wrapper">
		<div class="d-c">
			<a class="download" href="<?php echo URL_ROOT . $week; ?>" title="Download the files for this week"><span class="hide">Download Files</span></a>
		</div>
		<div class="block" style="margin-left:90px;" >
	   <p class="quiet"><?php echo date('F j, Y',strtotime($date)) ?></p>
	   <h4><div style="width:100px;float:left;">Series:</div> <span style="font-weight:normal;"><?php echo $series?></span></h4>
	   <h3><div style="width:100px;float:left;">Author:</div> <span style="font-weight:normal;color:#000;"><?php echo $author ?></span></h3>
		 <h4><div style="width:100px;float:left;">Title:</div> <span style="font-weight:normal;"><?php echo $title?></span></h4>
	   <p class="description">
	      <?php echo $summary; ?>
	      <a href="<?php echo URL_ROOT . $week; ?>" title="Download the files for this week">Download Files</a>.
	   </p>
	</div>	
</div>
