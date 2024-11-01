<div class="wrap">

	<form action="options.php" method="post">

		<h2><?php _e( 'Invoicexpress configuration', 'rc' ) ?></h2>

		<p>In order to communicate with the Invoicexpress server, we need some information first.</p>

		<input type="text" size="45" placeholder="Your domain" name="wpie_settings[domain]" value="<?php echo esc_attr($options['domain']); ?>">

		<input type="text" size="45" placeholder="Your API key" name="wpie_settings[api_key]" value="<?php echo esc_attr($options['api_key']); ?>">

		<p>
			Your API Key can be found under your <a terget="_blank" href="https://app.invoicexpress.com/accounts/details">account menu option</a>.
		</p>

		<?php
		settings_fields( 'pluginPage' );
		submit_button();
		?>

	</form>

	<?php RCCore::render('el_affiliate'); ?>

	<p align="right">Created by <a href="http://barbershop.pt">Barbershop</a>.</p>

</div>