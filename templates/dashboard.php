<div class="wrap">
	<h1>Main Bryson Plugins</h1>
	
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Dashboard</a></li>
		<li><a href="#tab-2">Manage Settings</a></li>
		<li><a href="#tab-3">About</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Nulla quis lorem ut libero malesuada feugiat. Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Sed porttitor lectus nibh. Donec rutrum congue leo eget malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vivamus suscipit tortor eget felis porttitor volutpat. Cras ultricies ligula sed magna dictum porta. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p>
		</div>
		<div id="tab-2" class="tab-pane">
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'main_bryson_settings' );
					do_settings_sections( 'main_bryson_plugin' );
					submit_button();
				?>
			</form>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>About</h3>
		</div>
	</div>

</div>