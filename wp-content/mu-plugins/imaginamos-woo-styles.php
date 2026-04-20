<?php
/**
 * Plugin Name: Imaginamos Woo Styles
 * Description: Estiliza Carrito y Checkout.
 * Author:      Hader Rentería
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	if ( ! function_exists( 'is_cart' ) || ! function_exists( 'is_checkout' ) ) {
		return;
	}

	$is_product_page = function_exists( 'is_product' ) && is_product();
	$should_load     = is_cart() || is_checkout() || $is_product_page;

	if ( ! $should_load && function_exists( 'is_singular' ) && is_singular() ) {
		$post = get_post();

		if ( $post ) {
			$has_cart_block     = function_exists( 'has_block' ) && has_block( 'woocommerce/cart', $post );
			$has_checkout_block = function_exists( 'has_block' ) && has_block( 'woocommerce/checkout', $post );
			$has_checkout_sc    = function_exists( 'has_shortcode' ) && has_shortcode( (string) $post->post_content, 'woocommerce_checkout' );

			$should_load = $has_cart_block || $has_checkout_block || $has_checkout_sc;
		}
	}

	if ( ! $should_load ) {
		return;
	}

	wp_register_style( 'imaginamos-woo-styles', false, array(), '1.1.0' );
	wp_enqueue_style( 'imaginamos-woo-styles' );
	wp_add_inline_style( 'imaginamos-woo-styles', imaginamos_woo_styles_css() );
}, 20 );

function imaginamos_woo_styles_css() {
	return <<<CSS
:root {
	--imgn-principal: #0F0F0F;
	--imgn-secundario: #525252;
	--imgn-texto: #404040;
	--imgn-enfasis: #FF6B00;
	--imgn-enfasis-hover: #E55A00;
	--imgn-gris: #A3A3A3;
	--imgn-borde: #E5E5E5;
	--imgn-radius: 8px;
	--imgn-radius-lg: 12px;
	--imgn-font-serif: "Fraunces", Georgia, "Times New Roman", serif;
	--imgn-font-sans: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

/* ---------- Tipografía base ---------- */
.wp-block-woocommerce-cart,
.wp-block-woocommerce-checkout {
	font-family: var(--imgn-font-sans);
	font-weight: 400;
	color: var(--imgn-texto);
}

/* ---------- Títulos en Fraunces 700 ---------- */
.wp-block-woocommerce-cart h1,
.wp-block-woocommerce-checkout h1,
.wp-block-woocommerce-cart h2,
.wp-block-woocommerce-checkout h2,
.wc-block-components-title,
.wc-block-cart__totals-title,
.wc-block-components-checkout-step__title {
	font-family: var(--imgn-font-serif) !important;
	font-weight: 700 !important;
	color: var(--imgn-principal) !important;
	letter-spacing: -0.01em;
}

/* ---------- Título de página ---------- */
.woocommerce-cart .entry-title,
.woocommerce-checkout .entry-title {
	font-family: var(--imgn-font-serif) !important;
	font-weight: 700 !important;
	color: var(--imgn-secundario) !important;
	letter-spacing: -0.01em;
	
}

/* ---------- Inputs, selects y textarea ---------- */
.wc-block-components-text-input input,
.wc-block-components-text-input .input-text,
.wc-block-components-select .wc-block-components-select__select,
.wc-block-components-combobox input,
.wc-block-components-textarea {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 400 !important;
	color: var(--imgn-texto) !important;
	border: 1px solid var(--imgn-borde) !important;
	border-radius: var(--imgn-radius) !important;
	transition: border-color .15s ease, box-shadow .15s ease;
}
.wc-block-components-text-input input:focus,
.wc-block-components-text-input .input-text:focus,
.wc-block-components-select .wc-block-components-select__select:focus,
.wc-block-components-combobox input:focus,
.wc-block-components-textarea:focus {
	border-color: var(--imgn-enfasis) !important;
	box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.15) !important;
	outline: none !important;
}
.wc-block-components-text-input label,
.wc-block-components-select label {
	color: var(--imgn-secundario) !important;
	font-family: var(--imgn-font-sans) !important;
}
.wc-block-components-text-input.is-active > label,
.wc-block-components-text-input input:focus + label {
	color: var(--imgn-enfasis) !important;
}

/* ---------- Botones primarios (Finalizar compra / Realizar pedido) ---------- */
.wc-block-cart__submit-button,
.wc-block-components-checkout-place-order-button,
.wc-block-components-button.contained {
	background-color: var(--imgn-principal) !important;
	color: #ffffff !important;
	font-family: var(--imgn-font-serif) !important;
	font-weight: 600 !important;
	font-size: 16px !important;
	border-radius: var(--imgn-radius-lg) !important;
	padding: 18px 28px !important;
	border: none !important;
	text-transform: none !important;
	letter-spacing: 0;
	transition: background-color .15s ease, transform .05s ease;
}
.wc-block-cart__submit-button:hover,
.wc-block-components-checkout-place-order-button:hover,
.wc-block-components-button.contained:hover {
	background-color: #000000 !important;
	color: #ffffff !important;
}
.wc-block-cart__submit-button:active,
.wc-block-components-checkout-place-order-button:active {
	transform: translateY(1px);
}

/* ---------- Checkout ---------- */
.wp-block-woocommerce-checkout .wc-block-components-checkout-place-order-button {
	background-color: transparent !important;
	color: #333333 !important;
	border: 1px solid #333333 !important;
	border-radius: var(--imgn-radius-lg) !important;
	font-family: var(--imgn-font-serif) !important;
	font-weight: 600 !important;
	font-size: 16px !important;
	text-transform: uppercase !important;
	padding: 15px 20px !important;
	transition: all 0.3s ease !important;
	text-align: center !important;
	display: block !important;
	text-decoration: none !important;
}

/* ---------- Carrito ---------- */
.wp-block-woocommerce-cart .wc-block-cart__submit-button,
.wp-block-woocommerce-cart .wc-block-components-button.contained {
	background-color: transparent !important;
	color: #333333 !important;
	border: 1px solid #333333 !important;
	border-radius: var(--imgn-radius-lg) !important;
	font-family: var(--imgn-font-serif) !important;
	font-weight: 600 !important;
	font-size: 16px !important;
	text-transform: uppercase !important;
	padding: 15px 20px !important;
	transition: all 0.3s ease !important;
	text-align: center !important;
	display: block !important;
	text-decoration: none !important;
}

.wp-block-woocommerce-cart .wc-block-cart__submit-button:hover,
.wp-block-woocommerce-cart .wc-block-components-button.contained:hover {
	background-color: #333333 !important;
	color: #ffffff !important;
}

.wp-block-woocommerce-cart,
.wp-block-woocommerce-cart.alignwide {
	width: min(1400px, calc(100% - 48px));
	margin-left: auto !important;
	margin-right: auto !important;
}

.wp-block-woocommerce-cart .wp-block-woocommerce-filled-cart-block {
	width: 100%;
}

.wp-block-woocommerce-cart .wc-block-components-sidebar-layout {
	display: grid !important;
	grid-template-columns: minmax(0, 1.6fr) minmax(360px, 460px);
	gap: 24px;
	align-items: start;
}

.wp-block-woocommerce-cart .wc-block-components-main,
.wp-block-woocommerce-cart .wc-block-components-sidebar {
	width: 100% !important;
	max-width: none !important;
	min-width: 0;
}

.wp-block-woocommerce-cart .wp-block-woocommerce-cart-items-block {
	min-width: 0;
}

.wp-block-woocommerce-cart .wp-block-woocommerce-cart-totals-block {
	width: 100%;
	position: sticky;
	top: 24px;
}

.wp-block-woocommerce-cart .wc-block-cart-items__row {
	padding: 20px 0;
}

.wp-block-woocommerce-cart .wc-block-components-product-image {
	background: #fafafa;
	border: 1px solid var(--imgn-borde);
	border-radius: 10px;
	padding: 8px;
}

.wp-block-woocommerce-cart .wc-block-components-product-image img {
	border-radius: 6px;
	display: block;
}

.wp-block-woocommerce-cart .wc-block-components-product-metadata,
.wp-block-woocommerce-cart .wc-block-components-product-details__description {
	color: var(--imgn-secundario) !important;
	font-size: 15px;
	line-height: 1.5;
}

.wp-block-woocommerce-cart .wc-block-components-quantity-selector {
	min-height: 42px;
	background: #ffffff;
}

.wp-block-woocommerce-cart .wc-block-components-quantity-selector__button {
	min-width: 38px;
	font-size: 20px;
	line-height: 1;
}

.wp-block-woocommerce-cart .wc-block-cart-item__remove-link {
	color: var(--imgn-secundario) !important;
	opacity: 0.85;
	transition: color .15s ease, opacity .15s ease;
}

.wp-block-woocommerce-cart .wc-block-cart-item__remove-link:hover {
	color: var(--imgn-principal) !important;
	opacity: 1;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-panel {
	border-top: 1px solid var(--imgn-borde);
	border-bottom: 1px solid var(--imgn-borde);
	padding: 2px 0;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-panel__button {
	padding: 14px 0;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-totals-wrapper {
	border-top: none !important;
	margin-top: 4px;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-totals-item {
	padding: 8px 0;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-totals-footer-item {
	border-top: none !important;
	padding-top: 18px !important;
	margin-top: 8px;
}

.wp-block-woocommerce-cart-order-summary-block .wc-block-components-totals-footer-item::before,
.wp-block-woocommerce-cart-order-summary-block .wc-block-components-totals-footer-item::after {
	content: none !important;
	display: none !important;
}

.wp-block-woocommerce-cart .wc-block-cart__submit-container {
	margin-top: 18px;
}

.wp-block-woocommerce-cart .wc-block-cart__submit-button {
	min-height: 56px;
	line-height: 1.2;
}

@media (max-width: 900px) {
	.wp-block-woocommerce-cart .wc-block-components-sidebar-layout {
		display: grid !important;
		grid-template-columns: 1fr;
		gap: 20px;
	}

	.wp-block-woocommerce-cart .wp-block-woocommerce-cart-totals-block {
		position: static;
	}
}

@media (max-width: 781px) {

	.wp-block-woocommerce-cart-order-summary-block {
		padding: 22px;
	}
}

/* ---------- Botón de soporte ---------- */
.imaginamos-soporte-btn {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 600 !important;
	padding: 18px 28px !important;
	margin-top: 12px !important;
	border-radius: var(--imgn-radius) !important;
}

/* ---------- Enlaces de producto ---------- */
.wc-block-components-product-name,
.wc-block-cart-items .wc-block-components-product-name {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 600 !important;
	color: var(--imgn-principal) !important;
	text-decoration: none !important;
	transition: color .15s ease;
}
.wc-block-components-product-name:hover {
	color: var(--imgn-enfasis) !important;
}

/* ---------- Precios / totales ---------- */
.wc-block-components-product-price,
.wc-block-components-totals-item__value,
.wc-block-formatted-money-amount {
	font-family: var(--imgn-font-serif) !important;
	font-weight: 700 !important;
	color: var(--imgn-principal) !important;
}

/* ---------- Sidebars (Totales / Resumen del pedido) ---------- */
.wp-block-woocommerce-cart-order-summary-block,
.wp-block-woocommerce-checkout-order-summary-block {
	background: #ffffff;
	border: 1px solid #D0D0D0;
	border-radius: 8px;
	padding: 28px;
}

/* ---------- Filas de totales ---------- */
.wc-block-components-totals-item {
	padding: 10px 0;
	color: var(--imgn-texto);
}
.wc-block-components-totals-item__label {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 500 !important;
	color: var(--imgn-secundario) !important;
}
.wc-block-components-totals-footer-item {
	border-top: 1px solid var(--imgn-borde);
	padding-top: 16px;
	margin-top: 8px;
}
.wc-block-components-totals-footer-item .wc-block-components-totals-item__label,
.wc-block-components-totals-footer-item .wc-block-components-totals-item__value {
	font-family: var(--imgn-font-serif) !important;
	font-weight: 700 !important;
	font-size: 18px !important;
	color: var(--imgn-principal) !important;
}

/* ---------- Checkout ---------- */
.wp-block-woocommerce-checkout-order-summary-block .wc-block-components-totals-wrapper {
	border-top: none !important;
}

.wp-block-woocommerce-checkout-order-summary-block .wc-block-components-totals-footer-item {
	padding-top: 22px !important;
	margin-top: 10px;
}

.wp-block-woocommerce-checkout-order-summary-block .wc-block-components-totals-footer-item::before,
.wp-block-woocommerce-checkout-order-summary-block .wc-block-components-totals-footer-item::after {
	content: none !important;
	display: none !important;
}

/* ---------- Selector de cantidad ---------- */
.wc-block-components-quantity-selector {
	border: 1px solid var(--imgn-borde) !important;
	border-radius: var(--imgn-radius) !important;
	overflow: hidden;
}
.wc-block-components-quantity-selector__input {
	color: var(--imgn-principal) !important;
	font-family: var(--imgn-font-sans) !important;
	font-weight: 600 !important;
}
.wc-block-components-quantity-selector__button {
	color: var(--imgn-secundario) !important;
}
.wc-block-components-quantity-selector__button:hover {
	color: var(--imgn-enfasis) !important;
}

/* ---------- Paneles desplegables (cupones, etc.) ---------- */
.wc-block-components-panel__button {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 600 !important;
	color: var(--imgn-principal) !important;
}
.wc-block-components-panel__button:hover {
	color: var(--imgn-enfasis) !important;
}

/* ---------- Divisores ---------- */
.wc-block-cart-items__header,
.wc-block-cart-items .wc-block-cart-items__row,
.wc-block-components-shipping-rates-control,
.wc-block-checkout__form .wc-block-components-checkout-step {
	border-color: var(--imgn-borde) !important;
}

/* ---------- Table headers del carrito ---------- */
.wc-block-cart-items__header-product,
.wc-block-cart-items__header-total,
.wc-block-cart-items__header span {
	font-family: var(--imgn-font-sans) !important;
	font-weight: 600 !important;
	color: var(--imgn-secundario) !important;
	letter-spacing: 0.04em;
	text-transform: uppercase;
	font-size: 13px !important;
}

/* ---------- Enlaces genéricos ---------- */
.wp-block-woocommerce-cart a:not(.wc-block-components-button):not(.imaginamos-soporte-btn),
.wp-block-woocommerce-checkout a:not(.wc-block-components-button):not(.imaginamos-soporte-btn) {
	color: var(--imgn-enfasis);
	text-decoration: none;
}
.wp-block-woocommerce-cart a:not(.wc-block-components-button):not(.imaginamos-soporte-btn):hover,
.wp-block-woocommerce-checkout a:not(.wc-block-components-button):not(.imaginamos-soporte-btn):hover {
	color: var(--imgn-enfasis-hover);
	text-decoration: underline;
}

/* ---------- Placeholder color ---------- */
.wp-block-woocommerce-cart input::placeholder,
.wp-block-woocommerce-checkout input::placeholder,
.wp-block-woocommerce-checkout textarea::placeholder {
	color: var(--imgn-gris) !important;
}

/* ---------- Notices ---------- */
.wc-block-components-notice-banner.is-success {
	border-left-color: var(--imgn-enfasis) !important;
}

/* ---------- Producto: detalle visual ---------- */
.single-product .site-main {
	width: min(1380px, calc(100% - 48px));
	margin-left: auto;
	margin-right: auto;
}

.single-product .woocommerce-breadcrumb {
	font-family: var(--imgn-font-sans);
	color: var(--imgn-secundario);
	font-size: 14px;
	margin-bottom: 22px;
}

.single-product .woocommerce-breadcrumb a {
	color: var(--imgn-secundario);
	text-decoration: none;
}

.single-product .woocommerce-breadcrumb a:hover {
	color: var(--imgn-enfasis);
}

.single-product div.product {
	display: grid;
	grid-template-columns: minmax(420px, 1.1fr) minmax(520px, 1fr);
	gap: 72px;
	align-items: start;
	margin-bottom: 60px;
}

.single-product div.product .images,
.single-product div.product .summary {
	width: 100% !important;
	max-width: none !important;
	float: none !important;
	margin: 0 !important;
}

.single-product div.product div.images .woocommerce-product-gallery__wrapper {
	background: #ffffff;
	border: 1px solid var(--imgn-borde);
	border-radius: 22px;
	padding: 18px;
}

.single-product div.product div.images img {
	border-radius: 14px;
}

.single-product div.product .summary {
	margin: 0;
	padding-top: 8px;
}

.single-product div.product .product_title {
	font-family: var(--imgn-font-serif);
	font-weight: 700;
	font-size: clamp(34px, 4vw, 52px);
	line-height: 1.08;
	letter-spacing: -0.02em;
	color: var(--imgn-principal);
	margin-bottom: 16px;
}

.single-product div.product p.price,
.single-product div.product span.price {
	font-family: var(--imgn-font-serif);
	font-weight: 700;
	font-size: clamp(28px, 2.5vw, 38px);
	line-height: 1.1;
	color: var(--imgn-principal);
	margin-bottom: 14px;
}

.single-product div.product .woocommerce-product-details__short-description {
	font-family: var(--imgn-font-sans);
	font-size: 17px;
	line-height: 1.6;
	color: var(--imgn-texto);
	margin-bottom: 24px;
}

.single-product div.product form.cart {
	display: flex !important;
	align-items: stretch;
	gap: 12px;
	flex-wrap: nowrap;
	margin: 24px 0;
	padding-top: 6px;
}

.single-product div.product form.cart .quantity,
.single-product div.product form.cart .single_add_to_cart_button {
	float: none !important;
	margin: 0 !important;
}

.single-product div.product form.cart .quantity .qty {
	min-height: 52px;
	min-width: 88px;
	padding: 0 10px;
	border: 1px solid var(--imgn-borde);
	border-radius: 999px;
	font-family: var(--imgn-font-sans);
	font-weight: 600;
	color: var(--imgn-principal);
	text-align: center;
}

.single-product div.product form.cart .single_add_to_cart_button {
	min-height: 52px;
	padding: 14px 30px;
	width: auto !important;
	white-space: nowrap;
	border-radius: 999px;
	border: 1px solid var(--imgn-principal);
	background: var(--imgn-principal);
	color: #ffffff;
	font-family: var(--imgn-font-sans);
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 0.02em;
	transition: background-color .2s ease, color .2s ease, border-color .2s ease;
}

.single-product div.product form.cart .single_add_to_cart_button:hover {
	background: #ffffff;
	color: var(--imgn-principal);
	border-color: var(--imgn-principal);
}

.single-product div.product .product_meta {
	font-family: var(--imgn-font-sans);
	font-size: 14px;
	line-height: 1.6;
	color: var(--imgn-secundario);
	padding-top: 14px;
	border-top: 1px solid var(--imgn-borde);
}

.single-product div.product .product_meta a {
	color: var(--imgn-principal);
	text-decoration: none;
}

.single-product div.product .product_meta a:hover {
	color: var(--imgn-enfasis);
}

.single-product div.product .woocommerce-tabs {
	background: #ffffff;
	border: 1px solid var(--imgn-borde);
	border-radius: 22px;
	padding: 30px;
	margin-top: 56px;
}

.single-product div.product .woocommerce-tabs ul.tabs {
	display: flex;
	gap: 12px;
	flex-wrap: wrap;
	border: 0;
	margin: 0 0 20px;
	padding: 0;
}

.single-product div.product .woocommerce-tabs ul.tabs::before,
.single-product div.product .woocommerce-tabs ul.tabs::after {
	display: none;
}

.single-product div.product .woocommerce-tabs ul.tabs li {
	border: 1px solid var(--imgn-borde);
	border-radius: 999px;
	background: #ffffff;
	margin: 0;
	padding: 0;
}

.single-product div.product .woocommerce-tabs ul.tabs li::before,
.single-product div.product .woocommerce-tabs ul.tabs li::after {
	display: none;
}

.single-product div.product .woocommerce-tabs ul.tabs li a {
	font-family: var(--imgn-font-sans);
	font-size: 14px;
	font-weight: 600;
	color: var(--imgn-secundario);
	padding: 10px 18px;
}

.single-product div.product .woocommerce-tabs ul.tabs li.active {
	border-color: var(--imgn-principal);
	background: var(--imgn-principal);
}

.single-product div.product .woocommerce-tabs ul.tabs li.active a {
	color: #ffffff;
}

.single-product div.product .woocommerce-tabs .panel {
	font-family: var(--imgn-font-sans);
	font-size: 16px;
	line-height: 1.7;
	color: var(--imgn-texto);
	margin: 0;
}

.single-product .related.products {
	margin-top: 64px;
	margin-bottom: 30px;
}

.single-product .related.products > h2 {
	font-family: var(--imgn-font-serif);
	font-weight: 700;
	font-size: clamp(28px, 3vw, 40px);
	letter-spacing: -0.01em;
	color: var(--imgn-principal);
	margin-bottom: 24px;
}

.single-product .related.products ul.products li.product {
	background: #ffffff;
	border: 1px solid var(--imgn-borde);
	border-radius: 16px;
	padding: 16px;
	transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
}

.single-product .related.products ul.products li.product:hover {
	transform: translateY(-2px);
	border-color: #d9d9d9;
	box-shadow: 0 8px 24px rgba(15, 15, 15, 0.08);
}

.single-product .related.products ul.products li.product img {
	border-radius: 12px;
	margin-bottom: 12px;
}

.single-product .related.products ul.products li.product .woocommerce-loop-product__title {
	font-family: var(--imgn-font-sans);
	font-weight: 600;
	font-size: 17px;
	color: var(--imgn-principal);
	line-height: 1.35;
}

.single-product .related.products ul.products li.product .price {
	font-family: var(--imgn-font-serif);
	font-weight: 700;
	font-size: 22px;
	color: var(--imgn-principal);
	margin-top: 8px;
}

@media (max-width: 980px) {
	.single-product div.product {
		grid-template-columns: minmax(0, 1fr);
		gap: 28px;
	}

	.single-product div.product .summary {
		padding-top: 0;
	}

	.single-product div.product form.cart {
		flex-wrap: wrap;
	}
}

@media (max-width: 640px) {
	.single-product .site-main {
		width: calc(100% - 24px);
	}

	.single-product div.product .woocommerce-tabs {
		padding: 20px;
		border-radius: 16px;
	}

	.single-product div.product form.cart {
		flex-direction: column;
	}

	.single-product div.product form.cart .quantity .qty,
	.single-product div.product form.cart .single_add_to_cart_button {
		width: 100%;
	}
}

CSS;
}
