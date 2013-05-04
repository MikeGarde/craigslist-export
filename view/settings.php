<h2>craigslist export settings</h2>

 <form type="post" action="" id="craigslist-save-settings">
	<input type="hidden" name="action" value="craigslistSaveSettings"/>

	<label for="username">username:</label>
	<input name="username" type="text" value="<?php echo $cle['username']; ?>" />

	<label for="password">password:</label>
	<input name="password" type="text" value="<?php echo $cle['password']; ?>" />

	<label for="accountID">accountID:</label>
	<input name="accountID" type="text" value="<?php echo $cle['accountID']; ?>" />

	<hr />

	<h3>Select Post Type</h3>
	<select name="post_type">
<?php
		foreach($select_post_type as $key => $value) {
			$selected = ($cle['post_type'] == $key) ? ' selected' : '';

			echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';

		}
?>
	</select>

	<hr />
	<input type="submit" value="Save">

</form>
<div id="settings-result"></div>

<script type="text/javascript">

function ajaxSubmit(){

	var saveSettings = jQuery(this).serialize();

	jQuery.ajax({
		type: 'POST',
		url: '/wp-admin/admin-ajax.php',
		data: saveSettings,
		dataType: 'json',
		success:function(data){
			jQuery.each(data, function(index, value){

				switch (index) {
					case 'result':
						jQuery("#settings-result").html(value);
						break;
					case 'refresh':
						if(value == true)
							location.reload(true);
						break;

				}
			});
		}
	});
	return false;
}

jQuery('#craigslist-save-settings').submit(ajaxSubmit);
</script>

<?php print_a($active_post_type); ?>