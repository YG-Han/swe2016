<div class="wrap">
	<h2><?php _e( 'Customer Points', 'yith-woocommerce-points-and-rewards' ) ?></h2>

	<?php if ( isset( $_GET['action'] ) ): ?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<h2><?php printf( __( 'User #%d: %s', 'yith-woocommerce-points-and-rewards' ), $user_info->data->ID, $user_info->data->display_name ) ?></h2>
							<input type="text" value="<?php echo $points ?>" name="user_points" />
							<input type="hidden" name="action" value="save" />
							<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
							<?php wp_nonce_field( 'update_points', 'ywpar_update_points' ); ?>
							<input type="submit" class="ywpar_update_points button action" value="<?php _e( 'Update Points', 'yith-woocommerce-points-and-rewards' ) ?>" />

							<p><a href="<?php echo esc_url( $link ) ?>"><?php _e( 'Back to list', 'yith-woocommerce-points-and-rewards' ) ?></a></p>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	<?php else: ?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<input type="hidden" name="page" value="yith_woocommerce_points_and_rewards" />
							<?php $this->cpt_obj->search_box( 'search', 'search_id' ); ?>
						</form>
						<form method="post">
							<?php
							$this->cpt_obj->prepare_items();
							$this->cpt_obj->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	<?php endif; ?>
</div>