<?php

function fundify_is_crowdfunding() {
	if ( class_exists( 'Easy_Digital_Downloads' ) && class_exists( 'ATCF_Campaign' ) )
		return true;

	return false;
}

function fundify_reverse_purchase_button_location() {
	remove_action( 'edd_purchase_link_top', 'atcf_purchase_variable_pricing' );
	add_action( 'edd_purchase_link_end', 'atcf_purchase_variable_pricing' );
}
add_action( 'init', 'fundify_reverse_purchase_button_location', 12 );

/**
 * Plugin Notice
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_features_notice() {
	?>
	<div class="updated">
		<p><?php printf( 
					__( '<strong>Notice:</strong> To take advantage of all of the great features Fundify offers, please install the <a href="%s">Crowdfunding by Astoundify plugin</a>. <a href="%s" class="alignright">Hide this message.</a>', 'fundify' ), 
					wp_nonce_url( network_admin_url( 'update.php?action=install-plugin&plugin=appthemer-crowdfunding' ), 'install-plugin_appthemer-crowdfunding' ), 
					wp_nonce_url( add_query_arg( array( 'action' => 'fundify-hide-plugin-notice' ), admin_url( 'index.php' ) ), 'fundify-hide-plugin-notice' ) 
			); ?></p>
	</div>
<?php
}
if ( ( ! fundify_is_crowdfunding() ) && is_admin() && ! get_user_meta( get_current_user_id(), 'fundify-hide-plugin-notice', true ) )
	add_action( 'admin_notices', 'fundify_features_notice' );

/**
 * Hide plugin notice.
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_hide_plugin_notice() {
	check_admin_referer( 'fundify-hide-plugin-notice' );

	$user_id = get_current_user_id();

	add_user_meta( $user_id, 'fundify-hide-plugin-notice', 1 );
}
if ( is_admin() )
	add_action( 'admin_action_fundify-hide-plugin-notice', 'fundify_hide_plugin_notice' );

/**
 * Show campaigns on author archive.
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_post_author_archive( $query ) {
	if ( $query->is_author )
		$query->set( 'post_type', 'download' );
}
add_action( 'pre_get_posts', 'fundify_post_author_archive' );

function fundify_search_filter( $query ) {
	if ( ! $query->is_search() )
		return;

	$post_type = isset ( $_GET[ 'type' ] ) ? esc_attr( $_GET[ 'type' ] ) : null;

	if ( ! in_array( $post_type, array( 'download', 'post' ) ) )
		return;

	if ( ! $post_type )
		$post_type = 'post';

	$query->set( 'post_type', $post_type );

	return $query;
};
add_filter( 'pre_get_posts', 'fundify_search_filter' );

/**
 * Contribute notw list options
 *
 * @since Fundify 1.0
 *
 * @return void
 */
function fundify_campaign_contribute_options( $prices, $type, $download_id ) {
	$campaign = new ATCF_Campaign( $download_id );
?>
	<div class="edd_price_options <?php echo $campaign->is_active() ? 'active' : 'expired'; ?>" <?php echo $campaign->is_donations_only() ? 'style="display: none"' : null; ?>>
		<ul>
			<?php foreach ( $prices as $key => $price ) : ?>
				<?php
					$amount  = $price[ 'amount' ];
					$limit   = isset ( $price[ 'limit' ] ) ? $price[ 'limit' ] : '';
					$bought  = isset ( $price[ 'bought' ] ) ? $price[ 'bought' ] : 0;
					$allgone = false;

					if ( $bought == absint( $limit ) && '' != $limit )
						$allgone = true;

					if ( edd_use_taxes() && edd_taxes_on_prices() )
						$amount += edd_calculate_tax( $amount );
				?>
				<li <?php if ( $allgone ) : ?>class="inactive"<?php endif; ?> data-price="<?php echo edd_sanitize_amount( edd_format_amount( $amount ) ); ?>">
					<div class="clear">
						<h3><label><?php
							if ( $campaign->is_active() )
								if ( ! $allgone )
									printf(
										'<input type="radio" name="edd_options[price_id][]" id="%1$s" class="%2$s edd_price_options_input" value="%3$s"/>',
										esc_attr( 'edd_price_option_' . $download_id . '_' . $key ),
										esc_attr( 'edd_price_option_' . $download_id ),
										esc_attr( $key )
									);
						?> <?php printf( __( 'Pledge %s', 'fundify' ), edd_currency_filter( edd_format_amount( $amount ) ) ); ?></label></h3>

						<div class="backer-count">
							<i class="icon-user"></i> <?php printf( _nx( '1 Backer', '%1$s Backers', $bought, 'number of backers for pledge level', 'fundify' ), $bought ); ?>

							<?php if ( '' != $limit && ! $allgone ) : ?>
								<small class="limit"><?php printf( __( 'Limited (%d of %d left)', 'fundify' ), $limit - $bought, $limit ); ?></small>
							<?php elseif ( $allgone ) : ?>
								<small class="gone"><?php _e( 'All gone!', 'fundify' ); ?></small>
							<?php endif; ?>
						</div>
					</div>
					<?php echo wpautop( esc_html( $price[ 'name' ] ) ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div><!--end .edd_price_options-->
<?php
}
add_action( 'atcf_campaign_contribute_options', 'fundify_campaign_contribute_options', 10, 3 );

/**
 * Custom price field
 *
 * @since Fundify 1.3
 *
 * @return void
 */
function fundify_campaign_contribute_custom_price() {
	global $edd_options;
?>
	<h2><?php echo apply_filters( 'fundify_pledge_custom_title', __( 'Enter your pledge amount', 'fundify' ) ); ?></h2>

	<p class="fundify_custom_price_wrap">
	<?php if ( ! isset( $edd_options['currency_position'] ) || $edd_options['currency_position'] == 'before' ) : ?>
		<span class="currency left">
			<?php echo edd_currency_filter( '' ); ?>
		</span>

		<input type="text" name="fundify_custom_price" id="fundify_custom_price" class="left" value="" />
	<?php else : ?>
		<input type="text" name="fundify_custom_price" id="fundify_custom_price" class="right" value="" />
		<span class="currency right">
			<?php echo edd_currency_filter( '' ); ?>
		</span>
	<?php endif; ?>
	</p>
<?php
}
add_action( 'edd_purchase_link_top', 'fundify_campaign_contribute_custom_price', 5 );

/**
 * Expired campaign shim.
 *
 * When a campaign is inactive, we display the inactive pledge amounts,
 * but the lack of form around them messes with the styling a bit, and we
 * lose our header. This fixes that. 
 *
 * @since Fundify 1.3
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function fundify_contribute_modal_top_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	<div class="edd_download_purchase_form">
		<h2><?php printf( __( 'This %s has ended. No more pledges can be made.', 'fundify' ), edd_get_label_singular() ); ?></h2>
<?php
}
add_action( 'fundify_contribute_modal_top', 'fundify_contribute_modal_top_expired' );

/**
 * Expired campaign shim.
 *
 * @since Fundify 1.3
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function fundify_contribute_modal_bottom_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	</div>
<?php
}
add_action( 'fundify_contribute_modal_bottom', 'fundify_contribute_modal_bottom_expired' );

/**
 * Custom pledge level fix.
 *
 * If there is a custom price, figure out the difference
 * between that, and the price level they have chosen. Store
 * the differene in the cart item meta, so it can be added to
 * the total in the future.
 *
 * @since Fundify 1.3
 *
 * @param array $cart_item The current cart item to be added.
 * @return array $cart_item The modified cart item.
 */
function fundify_edd_add_to_cart_item( $cart_item ) {
	if ( isset ( $_POST[ 'post_data' ] ) ) {
		$post_data = array();
		parse_str( $_POST[ 'post_data' ], $post_data );

		$custom_price = $post_data[ 'fundify_custom_price' ];
	} else {
		$custom_price = $_POST[ 'fundify_custom_price' ];
	}

	$custom_price = edd_sanitize_amount( $custom_price );
	
	$price        = edd_get_cart_item_price( $cart_item[ 'id' ], $cart_item[ 'options' ] );

	if ( $custom_price > $price ) {
		$cart_item[ 'options' ][ 'atcf_extra_price' ] = $custom_price - $price;
	
		return $cart_item;
	}

	return $cart_item;
}
add_filter( 'edd_add_to_cart_item', 'fundify_edd_add_to_cart_item' );
add_filter( 'edd_ajax_pre_cart_item_template', 'fundify_edd_add_to_cart_item' );

/**
 * Calculate the cart item total based on the existence of
 * an additional pledge amount.
 *
 * @since Fundify 1.3
 *
 * @param int $price The current price.
 * @param int $item_id The ID of the cart item.
 * @param array $options Item meta for the current cart item.
 * @return int $price The updated price.
 */
function fundify_edd_cart_item_price( $price, $item_id, $options = array() ) {
	if ( isset ( $options[ 'atcf_extra_price' ] ) ) {
		$price = $price + $options[ 'atcf_extra_price' ];
	}

	return $price;
}
add_filter( 'edd_cart_item_price', 'fundify_edd_cart_item_price', 10, 3 );

/**
 * Toggle custom pledge on/off
 *
 * @since Fundify 1.4
 * 
 * @param $settings
 * @return $settings
 */
function fundify_crowdfunding_settings( $settings ) {
	$settings[ 'atcf_settings_custom_pledge' ] = array(
		'id'      => 'atcf_settings_custom_pledge',
		'name'    => __( 'Custom Pledging', 'fundify' ),
		'desc'    => __( 'Allow arbitrary amounts to be pledged.', 'fundify' ),
		'type'    => 'checkbox',
		'std'     => 1
	);

	return $settings;
}
add_filter( 'edd_settings_general', 'fundify_crowdfunding_settings', 100 );

function fundify_disable_custom_pledging() {
	global $edd_options;

	if ( isset ( $edd_options[ 'atcf_settings_custom_pledge' ] ) )
		return;

	remove_action( 'edd_purchase_link_top', 'fundify_campaign_contribute_custom_price', 5 );
	remove_filter( 'edd_add_to_cart_item', 'fundify_edd_add_to_cart_item' );
	remove_filter( 'edd_ajax_pre_cart_item_template', 'fundify_edd_add_to_cart_item' );
	remove_filter( 'edd_cart_item_price', 'fundify_edd_cart_item_price', 10, 3 );
	remove_action( 'init', 'fundify_reverse_purchase_button_location', 12 );
}
add_action( 'init', 'fundify_disable_custom_pledging' );