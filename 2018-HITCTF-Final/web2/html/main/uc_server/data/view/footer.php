<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php if(UC_DEBUG) { ?>
	<style type="text/css">
	#debuginfo {width: 60%;margin-left: 2em;}
	fieldset {margin-top: 2em; display: block;}
	</style>
	<div style="text-align: left;" id="debuginfo">
		Processed in <span id="debug_time"></span> s
		<fieldset>
			<legend><b>GET:</b></legend>
			<?php echo '<pre>'.print_r($_GET, TRUE).'</pre>';?>
		</fieldset>
		<fieldset>
			<legend><b>POST:</b></legend>
			<?php echo '<pre>'.print_r($_POST, TRUE).'</pre>';?>
		</fieldset>
		<fieldset>
			<legend><b>COOKIE:</b></legend>
			<?php echo '<pre>'.print_r($_COOKIE, TRUE).'</pre>';?>
		</fieldset>
		<fieldset>
			<legend><b>SQL:</b> <?php echo $dbquerynum;?></legend>
			<?php foreach((array)$dbhistories as $dbhistory) {?>
				 <li><?php echo $dbhistory;?></li>
			<?php } ?>
		</fieldset>
		<fieldset>
			<legend><b>Include:</b> <?php echo count(get_included_files());?></legend>
			<?php echo '<pre>'.print_r(get_included_files(), TRUE).'</pre>';?>
		</fieldset>
	</div>
<?php } ?>

</body>
</html>