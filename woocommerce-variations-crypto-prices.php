<?php /**
 * Plugin Name: Woocommerce Variations Crypto Prices
 * Plugin URI:
 * Description: Appends Bitcoin, Litecoin, Dogecoin and Dash prices to WooCommerce variations.
 * Author: Sinisa Nikolic
 * Author URI: http://www.themesbros.com
 * Text Domain: woocommerce-variations-crypto-prices
 * Version: 0.1.0
 *
 * @package Woocommerce_Variations_Crypto_Prices
 */ /* Basic security, prevents file from being loaded directly. */ defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' ); /* Filter 
product variations. */ add_filter( 'woocommerce_available_variation', 'wccp_append_prices', 10, 3 ); /**
 * Appends Bitcoin, Litecoin, Dogecoin and Dash price to WooCommerce price.
 *
 * @param array $data
 * @param object $product
 * @param object $variation
 * @return array
 */ function wccp_append_prices( $data, $product, $variation ) {
	if ( ! is_single() ) {
		return $data;
	}
	$original_price = $variation->get_price();
	$btc_course = wccp_get_rate( 'btc' );
	$ltc_course = wccp_get_rate( 'ltc' );
	$doge_course = wccp_get_rate( 'doge' );
	$dash_course = wccp_get_rate( 'dash' );
	$original_price = $variation->get_price();
    $data['price_html'] = '<span class="price">' . wc_price( $original_price ) . '</span>';
    if ( $btc_course ) {
    	$btc_price = $variation->get_price() / $btc_course;
    	$data['price_html'] .= '<br/><span class="price"><img src="https://s2.coinmarketcap.com/static/img/coins/16x16/1.png"> ' . 
wc_price( $btc_price, ['currency' => 'BTC', 'decimals' => 8] ) . ' BTC</span>';
    }
    if ( $ltc_course ) {
	    $ltc_price = $variation->get_price() / $ltc_course;
	    $data['price_html'] .= '<br/><span class="price"><img src="https://s2.coinmarketcap.com/static/img/coins/16x16/2.png"> ' 
.wc_price( $ltc_price, ['currency' => 'LTC', 'decimals' => 8] ) . ' LTC</span>';
    }
	
	if ( $doge_course ) {
	    $doge_price = $variation->get_price() / $doge_course;
	    $data['price_html'] .= '<br/><span class="price"><img src="https://s2.coinmarketcap.com/static/img/coins/16x16/74.png"> ' 
.wc_price( $doge_price, ['currency' => 'DOGE', 'decimals' => 8] ) . ' DOGE</span>';
    }
	 
	if ( $dash_course ) {
	    $dash_price = $variation->get_price() / $dash_course;
	    $data['price_html'] .= '<br/><span class="price"><img src="https://s2.coinmarketcap.com/static/img/coins/16x16/131.png"> ' 
.wc_price( $dash_price, ['currency' => 'DASH', 'decimals' => 8] ) . ' DASH</span>';
    }
    return $data;
}
/**
 * Returns current Bitcoin / Litecoin exchange rate.
 *
 * @param string $coin Can be btc or ltc.
 * @return float|bool
 */ function wccp_get_rate( $coin = 'btc' ) {
	$rate_api_url = 
'ADD API URL HERE';
	if ( 'ltc' == $coin ) {
		$rate_api_url = 
'ADD API URL HERE';
	}	
	
	if ( 'doge' == $coin ) {
		$rate_api_url = 
'ADD API URL HERE';
	}
	 
	if ( 'dash' == $coin ) {
		$rate_api_url = 
'ADD API URL HERE';
	}
	$rate_request = wp_remote_get( $rate_api_url );
	if ( 200 == $rate_request['response']['code'] ) {
		$current_currency = get_woocommerce_currency();
		$response = json_decode( $rate_request['body'], true );
		foreach ( $response as $key => $data ) {
			if ( $current_currency == $data['code'] ) {
				return $data['rate'];
			}
		}
	}
	return false;
}
/* Add custom currency. */ add_filter( 'woocommerce_currencies', 'wccp_currency' ); /**
 * Add Bitcoin & Litecoin currencies.
 * @param array $currencies
 * @return array
 */ function wccp_currency( $currencies ) {
     $currencies['BTC'] = esc_html__( 'Bitcoin', 'woocommerce' );
     $currencies['LTC'] = esc_html__( 'Litecoin', 'woocommerce' );
     $currencies['DOGE'] = esc_html__( 'Dogecoin', 'woocommerce' );
     $currencies['DASH'] = esc_html__( 'Dash', 'woocommerce' );
     return $currencies;
}
/* Add custom symbol. */ add_filter( 'woocommerce_currency_symbol', 'wccp_currency_symbol', 10, 2 ); /**
 * Add custom symbol for new currencies.
 *
 * @param string $currency_symbol
 * @param string $currency
 * @return string
 */ function wccp_currency_symbol( $currency_symbol, $currency ) {
	switch( $currency ) {
		case 'BTC': $currency_symbol = ''; break;
		case 'LTC': $currency_symbol = ''; break;
		case 'DOGE': $currency_symbol = ''; break;
		case 'DASH': $currency_symbol = ''; break;
	}
	return $currency_symbol;
}
