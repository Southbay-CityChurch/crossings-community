<div class="week">
	<h2>Files from "<?php echo $title ?>"</h2>
	<ul>

		<?php foreach($files as $file) { ?>

		<li><a href="<?php echo $file; ?>"> <?php echo Series::decode(basename($file)); ?></a></li>

		<?php } ?>

	</ul>
	<div class="instructions">
		<h3>How to Download the Files</h3>
		<p>To download the <?php echo pluralize(count($files),'file', 'any of the files') ?> above, move your mouse over the name of the file and right-click. Then, in the menu that shows up, select <q>Save file as...</q>, <q>Save link as...</q> or <q>Download Link target</q> depending on your browser.</p>
<?/*		<p>Don't want to be hassled with manually downloading each message? We are also podcasting, click to visit the <a href="<?php echo $itunes_podcast; ?>">Podcast</a> via iTunes.</p>*/?>
	</div>
</div>
