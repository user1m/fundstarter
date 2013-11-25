<div class="campaign-widget-preview">
	<h2 class="modal-title"><?php _e( 'Embed a widget on your site', 'fundify' ); ?></h2>

	<div class="campaign-widget-preview-widget">
		<iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink() ); ?>" width="260px" height="550px" frameborder="0" scrolling="no" /></iframe>
	</div>

	<div class="campaign-widget-preview-use">
		<p><?php _e( 'Help raise awareness for this campaign by sharing this widget. Simply paste the following HTML code most places on the web.', 'fundify' ); ?></p>

		<p><strong><?php _e( 'Embed Code', 'fundify' ); ?></strong></p>

		<pre>&lt;iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink() ); ?>" width="260px" height="500px" frameborder="0" scrolling="no" /&gt;&lt;/iframe&gt;</pre>
	</div>
</div>