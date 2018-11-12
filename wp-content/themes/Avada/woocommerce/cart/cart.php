<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 


?>

<div id="gbsCheckout">
	<form class="woocommerce-cart-form gbs-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

		<p class="woocommerce-store-notice demo_store"> Su pedido es un compromiso de compra </p>
		<div class="datos_user_cart">

		<?php if( is_user_logged_in()  ) {
			//obtengo el usuario
			$user = wp_get_current_user(); ?>
			<div class="order-owner trescol"> Pedido de: <?php echo $user->user_firstname ." ". $user->user_lastname ?></div>

			<?php

				global $wpdb;
				$client_user_table = $wpdb->prefix .  ('clients_users_rel');
				$clients_table = $wpdb->prefix .  ('gs_clients');

				$select_datos_clientes = ("SELECT * FROM $clients_table RIGHT JOIN $client_user_table
	              ON $client_user_table.user_id = $user->ID
	              AND $client_user_table.client_id = $clients_table.Client_ID");

				$clientes = $wpdb->get_results($select_datos_clientes);
				if (sizeof($clientes) >= 1) {?>
					<div id="clienteSelection cuatrocol" style="margin-right:1%">
							<div>Seleccione la Razón Social:</div>
								<div id="clientesList">
									<select name="cliente_id" id ="cliente_id" required>
											<option  value="" disabled selected>Seleccione una Razón Social</option>
											<?php foreach ($clientes as $key => $cliente) { ?>
											<option value="<?php echo $cliente->Client_ID; ?>"><?php echo $cliente->Name?></option>
											<?php }?>
									</select>
								</div>
					</div>
					<?php	} else{ ?>
					<input type="hidden" name="cliente_id" value="gbs_noCliente">
					<?php }
					?> 
					<div class="target"></div>
					<?php
		} ?>
		</div>
				<?php
					$product_list = [];
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						$product_cat = get_the_terms($product_id, 'product_cat');
						$product_cat = $product_cat[0]->name;

						if (array_key_exists($product_cat, $product_list)){
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) )
								$product_list[$product_cat]['cant'] += $cart_item['quantity'];
						} else{
							$product_list[$product_cat] = [];
							$product_list[$product_cat]['name'] = $product_cat;
							$product_list[$product_cat]['cant'] = $cart_item['quantity'];
						}

					}
					$cant_total = 0;
					foreach ($product_list as $key => $category) {
					    $cant_total += $category['cant'];
					}
					?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<?php // ThemeFusion edit for Avada theme: change table layout and columns. ?>
					<th class="product-name"><?php _e( 'Category', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
			//echo json_encode(WC()->cart->get_cart());
				$product_list = [];
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					$product_cat = get_the_terms($product_id, 'product_cat');
					$product_cat = $product_cat[0]->name;

					if (array_key_exists($product_cat, $product_list)){
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) )
							$product_list[$product_cat]['cant'] += $cart_item['quantity'];
					} else{
						$product_list[$product_cat] = [];
						$product_list[$product_cat]['name'] = $product_cat;
						$product_list[$product_cat]['cant'] = $cart_item['quantity'];
					}

				}
				foreach ($product_list as $key => $category) { ?>
					<tr>
						<td class="product_name">
							<div class="product-info">
								<a href="#" class="product-title"><?php echo strtoupper($category['name']) ?> </span>
							</div>
						</td>
						<td class="product-quantity">
							<div class="quantity"><?php echo $category['cant'] ?></div>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<td></td>
					<td class="total-ordered">Total pedido: <?php echo $cant_total ?></td>
				</tr>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

				<tr class="avada-cart-actions">
					<td colspan="6" class="actions">

						<?php if ( wc_coupons_enabled() ) { ?>
							<div class="coupon">
								<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<?php } ?>

						<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
					</td>
				</tr>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>
		<div class="user-actions">
			<div class="save-order">
				<input type="radio" name="pedido" value="G" checked=""> Agrega pendientes
			</div>
    	<div class="null-order">
				<input type="radio" name="pedido" value="A"> Anular pendientes
			</div>

    </div>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>

	</form>
</div>
<div class="cart-collaterals">
	<?php
		/**
		 * woocommerce_cart_collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
	 //	do_action( 'woocommerce_cart_collaterals' );

	?>
</div>
<?php

do_action( 'woocommerce_after_cart' );
