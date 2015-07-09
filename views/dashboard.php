<div class="wrap">
	<div class="scis">
		<div class="scis-row">
			<div class="scis-col-4">
				<h2>Add New Code</h2><br />
				<form method="post" class="scis_form_new_code">
					<div class="display-message"></div>
					<input type="hidden" id="type" value="add" />
					<label for="codename">Name</label><br /><input type="text" id="code_name" maxlength="50" style="width: 100%;" /><br /><br />
				
					<label for="codedata">Code Data</label><br /><textarea id="code_data" style="width: 100%;height: 110px !important;"></textarea><br /><br />
				
					<input type="submit" id="SaveBtn" name="Save" value="Save" class="button button-primary" />						
				</form>
			</div>
			<div class="scis-col-8">
				<h2>Shortcodes Available</h2>

				<?php

					$newObj = new Scis_Admin();

					$data = $newObj->scis_all();

					
					echo '<div id="list-data" style="height: 200px; overflow-y: scroll">';
					echo '<table class="scis-table scis-table-striped scis-table-hover" style="width: 100%">
						<thead>
							<tr>
								<th>Shortcode ID</th>
								<th>Code Name</th>
								<th>Option</th>									
							</tr>
						</thead>
						<tbody>
			    	';

			    		foreach($data as $scis_data)
				    	{
				    		$scis_id = $scis_data->id;
				    		$scis_code_name = $scis_data->code_name;
				    		$scis_code_data = $scis_data->code_data;

				    		if(strlen($scis_code_name) > 25){

				    			$scis_code_name =  substr(wordwrap($scis_code_name), 0,25) . '...';
				    		}
				    		else{
				    			$scis_code_name = $scis_code_name;
				    		}


				    		echo '<tr>';
				    		echo '<td>'.$scis_id.'</td>';
				    		echo '<td>'.$scis_code_name.'</td>';
				    		echo '<td><a href="#" class="EditBtn" value="'.$scis_id.'">Edit</a> | <a href="#" class="DeleteBtn" value="'.$scis_id.'">Delete</a></td>';
				    		
				    		echo '</tr>';
				    	}
			    	echo '</tbody></table>';
			    	echo '</div>';
				?>				
			</div>
		</div>
	</div>
	<div class="scis-clear"><br /></div>

	<div class="scis">
		<div class="scis-row">
			<div class="scis-col-4">
				<h2>About SCI Shortcode Plugin</h2><br />
				<img src="<?php echo SCIS_PLUGIN_URL . '_inc/images/scis-logo.png' ?>" width="100" height="100" alt="SCI Shortcode Plugin" title="SCI Shortcode Plugin"/>				
				<hr />
				<p>Hi there. Thank you for using SCI Shortcode Plugin.</p>
				<p>I created this WP Plugin for personal use but I decided to publish and share it to everyone.</p>
				<p>I know this is not yet perfect. If you have any suggestions feel free to contact me below.</p>
				<p>Need Help or Feedback? <a href="http://www.developersnote.net/contact/" rel="nofollow" target="_blank">Contact Author</a></p>				
			</div>
			<div class="scis-col-8">
				<div id="dialog-edit-message"></div>	
				<div class="display-message-modify"></div>											
			</div>
		</div>
	</div>
</div>