<?php
// Add custom Theme Functions here

/**
 * Remove Updates
 */
/*function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');*/


/**
 * Simple product setting.
 */
function ace_add_stock_inventory_multiplier_setting() {

	?><div class='options_group'><?php

		woocommerce_wp_text_input( array(
			'id'				=> '_stock_multiplier',
			'label'				=> __( 'Inventory reduction per quantity sold', 'woocommerce' ),
			'desc_tip'			=> 'true',
			'description'		=> __( 'Enter the quantity multiplier used for reducing stock levels when purchased.', 'woocommerce' ),
			'type' 				=> 'number',
			'custom_attributes'	=> array(
				'min'	=> '1',
				'step'	=> '1',
			),
		) );

	?></div><?php

}
add_action( 'woocommerce_product_options_inventory_product_data', 'ace_add_stock_inventory_multiplier_setting' );

/**
 * Add variable setting.
 *
 * @param $loop
 * @param $variation_data
 * @param $variation
 */
function ace_add_variation_stock_inventory_multiplier_setting( $loop, $variation_data, $variation ) {

	$variation = wc_get_product( $variation );
	woocommerce_wp_text_input( array(
		'id'				=> "stock_multiplier{$loop}",
		'name'				=> "stock_multiplier[{$loop}]",
		'value'				=> $variation->get_meta( '_stock_multiplier' ),
		'label'				=> __( 'Inventory reduction per quantity sold', 'woocommerce' ),
		'desc_tip'			=> 'true',
		'description'		=> __( 'Enter the quantity multiplier used for reducing stock levels when purchased.', 'woocommerce' ),
		'type' 				=> 'number',
		'custom_attributes'	=> array(
			'min'	=> '1',
			'step'	=> '1',
		),
	) );

}
add_action( 'woocommerce_variation_options_pricing', 'ace_add_variation_stock_inventory_multiplier_setting', 50, 3 );

/**
 * Save the custom fields.
 *
 * @param WC_Product $product
 */
function ace_save_custom_stock_reduction_setting( $product ) {

	if ( ! empty( $_POST['_stock_multiplier'] ) ) {
		$product->update_meta_data( '_stock_multiplier', absint( $_POST['_stock_multiplier'] ) );
	}
}
add_action( 'woocommerce_admin_process_product_object', 'ace_save_custom_stock_reduction_setting'  );

/**
 * Save custom variable fields.
 *
 * @param int $variation_id
 * @param $i
 */
function ace_save_variable_custom_stock_reduction_setting( $variation_id, $i ) {
    $variation = wc_get_product( $variation_id );
	if ( ! empty( $_POST['stock_multiplier'] ) && ! empty( $_POST['stock_multiplier'][ $i ] ) ) {
		$variation->update_meta_data( '_stock_multiplier', absint( $_POST['stock_multiplier'][ $i ] ) );
		$variation->save();
	}
}
add_action( 'woocommerce_save_product_variation', 'ace_save_variable_custom_stock_reduction_setting', 10, 2 );

/**
 * Reduce with custom stock quantity based on the settings.
 *
 * @param $quantity
 * @param $order
 * @param $item
 * @return mixed
 */
function ace_custom_stock_reduction( $quantity, $order, $item ) {

	/** @var WC_Order_Item_Product $product */
	$multiplier = $item->get_product()->get_meta( '_stock_multiplier' );

	if ( empty( $multiplier ) && $item->get_product()->is_type( 'variation' ) ) {
		$product = wc_get_product( $item->get_product()->get_parent_id() );
		$multiplier = $product->get_meta( '_stock_multiplier' );
	}

	if ( ! empty( $multiplier ) ) {
		$quantity = $multiplier * $quantity;
	}

	return $quantity;
}
add_filter( 'woocommerce_order_item_quantity', 'ace_custom_stock_reduction', 10, 3 );


/**
 * @snippet       Variable Product Price Range: "From: $$$min_price"
 
 
add_filter( 'woocommerce_variable_price_html', 'bbloomer_variation_price_format_min', 9999, 2 );
  
function bbloomer_variation_price_format_min( $price, $product ) {
   $prices = $product->get_variation_prices( true );
   $min_price = current( $prices['price'] );
   $price = sprintf( __( 'إبت من: %1$s', 'woocommerce' ), wc_price( $min_price ) );
   return $price;
}*/


add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);
function custom_variation_price( $price, $product ) {
    $available_variations = $product->get_available_variations();
    $selectedPrice = '';
    $dump = '';
    foreach ( $available_variations as $variation )
    {
        // $dump = $dump . '<pre>' . var_export($variation['attributes'], true) . '</pre>';

        $isDefVariation=false;
        foreach($product->get_default_attributes() as $key=>$val){
            // $dump = $dump . '<pre>' . var_export($key, true) . '</pre>';
            // $dump = $dump . '<pre>' . var_export($val, true) . '</pre>';
            if($variation['attributes']['attribute_'.$key]==$val){
                $isDefVariation=true;
            }   
        }
        if($isDefVariation){
            $price = $variation['display_price'];         
        }
    }
    $selectedPrice = wc_price($price);

//  $dump = $dump . '<pre>' . var_export($available_variations, true) . '</pre>';

    return $selectedPrice . $dump;
}


/*add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

    function custom_variation_price( $price, $product ) {

        foreach($product->get_available_variations() as $pav){
            $def=true;
            foreach($product->get_variation_default_attributes() as $defkey=>$defval){
                if($pav['attributes']['attribute_'.$defkey]!=$defval){
                    $def=false;             
                }   
            }
            if($def){
                $price = $pav['display_price'];         
            }
        }   

        return woocommerce_price($price);

    }*/



// Utility function to get the default variation (if it exist)
function get_default_variation( $product ){
    $attributes_count = count($product->get_variation_attributes());
    $default_attributes = $product->get_default_attributes();
    // If no default variation exist we exit
    if( $attributes_count != count($default_attributes) )
        return false;

    // Loop through available variations
    foreach( $product->get_available_variations() as $variation ){
        $found = true;
        // Loop through variation attributes
        foreach( $variation['attributes'] as $key => $value ){
            $taxonomy = str_replace( 'attribute_', '', $key );
            // Searching for a matching variation as default
            if( isset($default_attributes[$taxonomy]) && $default_attributes[$taxonomy] != $value ){
                $found = false;
                break;
            }
        }
        // If we get the default variation
        if( $found ) {
            $default_variaton = $variation;
            break;
        }
        // If not we continue
        else {
            continue;
        }
    }
    return isset($default_variaton) ? $default_variaton : false;
}

add_action( 'woocommerce_before_single_product', 'move_variations_single_price', 1 );
function move_variations_single_price(){
    global $product, $post;

    if ( $product->is_type( 'variable' ) ) {
        // removing the variations price for variable products
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

        // Change location and inserting back the variations price
        add_action( 'woocommerce_single_product_summary', 'replace_variation_single_price', 10 );
    }
}

function replace_variation_single_price(){
    global $product;

    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $active_price = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $regular_price = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    if ( $active_price !== $regular_price && $product->is_on_sale() ) {
        $price = '<del>' . $regular_price . $product->get_price_suffix() . '</del> <ins>' . $active_price . $product->get_price_suffix() . '</ins>';
    } else {
        $price = $regular_price;
    }

    // When a default variation is set for the variable product
    if( get_default_variation( $product ) ) {
        $default_variaton = get_default_variation( $product );
        if( ! empty($default_variaton['price_html']) ){
            $price_html = $default_variaton['price_html'];
        } else {
            if ( ! $product->is_on_sale() )
                $price_html = $price = wc_price($default_variaton['display_price']);
            else
                $price_html = $price;
        }
        $availiability = $default_variaton['availability_html'];
    } else {
        $price_html = $price;
        $availiability = '';
    }
    // Styles ?>
    <style>
        div.woocommerce-variation-price,
        div.woocommerce-variation-availability,
        div.hidden-variable-price {
            height: 0px !important;
            overflow:hidden;
            position:relative;
            line-height: 0px !important;
            font-size: 0% !important;
        }
    </style>
    <?php // Jquery ?>
    <script>
    jQuery(document).ready(function($) {
        var a = 'div.wc-availability', p = 'p.price';

        $('input.variation_id').change( function(){
            if( '' != $('input.variation_id').val() ){
                if($(a).html() != '' ) $(a).html('');
                $(p).html($('div.woocommerce-variation-price > span.price').html());
                $(a).html($('div.woocommerce-variation-availability').html());
            } else {
                if($(a).html() != '' ) $(a).html('');
                $(p).html($('div.hidden-variable-price').html());
            }
        });
    });
    </script>
    <?php

    echo '<p class="price">'.$price_html.'</p>
    <div class="wc-availability">'.$availiability.'</div>
    <div class="hidden-variable-price" >'.$price.'</div>';
}


//disply sale price
if (!function_exists('my_commonPriceHtml')) {

    function my_commonPriceHtml($price_amt, $regular_price, $sale_price) {
        $html_price = '<p class="price">';
        //if product is in sale
        if (($price_amt == $sale_price) && ($sale_price != 0)) {
            $html_price .= '<ins>' . wc_price($sale_price) . '</ins>';
            $html_price .= '<del>' . wc_price($regular_price) . '</del>';
        }
        //in sale but free
        else if (($price_amt == $sale_price) && ($sale_price == 0)) {
            $html_price .= '<ins>Free!</ins>';
            $html_price .= '<del>' . wc_price($regular_price) . '</del>';
        }
        //not is sale
        else if (($price_amt == $regular_price) && ($regular_price != 0)) {
            $html_price .= '<ins>' . wc_price($regular_price) . '</ins>';
        }
        //for free product
        else if (($price_amt == $regular_price) && ($regular_price == 0)) {
            $html_price .= '<ins>' . wc_price($regular_price) . '</ins>';
        }
        $html_price .= '</p>';
        return $html_price;
    }

}

add_filter('woocommerce_get_price_html', 'my_simple_product_price_html', 100, 2);

function my_simple_product_price_html($price, $product) {
    if ($product->is_type('simple')) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $price_amt = $product->get_price();
        return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
    } else {
        return $price;
    }
}

add_filter('woocommerce_variation_sale_price_html', 'my_variable_product_price_html', 10, 2);
add_filter('woocommerce_variation_price_html', 'my_variable_product_price_html', 10, 2);

function my_variable_product_price_html($price, $variation) {
    $variation_id = $variation->variation_id;
    //creating the product object
    $variable_product = new WC_Product($variation_id);

    $regular_price = $variable_product->get_regular_price();
    $sale_price = $variable_product->get_sale_price();
    $price_amt = $variable_product->get_price();

    return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
}

/*add_filter('woocommerce_variable_sale_price_html', 'my_variable_product_minmax_price_html', 10, 2);
add_filter('woocommerce_variable_price_html', 'my_variable_product_minmax_price_html', 10, 2);

function my_variable_product_minmax_price_html($price, $product) {
    $variation_min_price = $product->get_variation_price('min', true);
    $variation_max_price = $product->get_variation_price('max', true);
    $variation_min_regular_price = $product->get_variation_regular_price('min', true);
    $variation_max_regular_price = $product->get_variation_regular_price('max', true);

    if (($variation_min_price == $variation_min_regular_price) && ($variation_max_price == $variation_max_regular_price)) {
        $html_min_max_price = $price;
    } else {
        $html_price = '<p class="price">';
       // $html_price .= '<ins>' . wc_price($variation_min_price) . '-' . wc_price($variation_max_price) . '</ins>';
       // $html_price .= '<del>' . wc_price($variation_min_regular_price) . '-' . wc_price($variation_max_regular_price) . '</del>';
        $html_price .= '<del>' . wc_price($variation_min_regular_price) . ' ' .'</del>';
        $html_price .= '<ins>' . wc_price($variation_min_price) . ' ' .'</ins>';
        $html_min_max_price = $html_price;
    }

    return $html_min_max_price;
}*/
// Custome Price in Shop Page
add_filter('woocommerce_variable_sale_price_html', 'my_variable_product_custom_variation_price_html', 10, 2);
add_filter('woocommerce_variable_price_html', 'my_variable_product_custom_variation_price_html', 10, 2);

function my_variable_product_custom_variation_price_html($price, $product) {
    $variation_custom_variation_price = $product->get_variation_price($selectedPrice, true);
    $variation_custom_variation_regular_price = $product->get_variation_regular_price($selectedPrice, true);

    if (($variation_custom_variation_price == $variation_custom_variation_regular_price)) {
        $html_custom_price = $price;
    } else {
        $html_price = '<p class="price">';
       // $html_price .= '<ins>' . wc_price($variation_min_price) . '-' . wc_price($variation_max_price) . '</ins>';
       // $html_price .= '<del>' . wc_price($variation_min_regular_price) . '-' . wc_price($variation_max_regular_price) . '</del>';
        $html_price .= '<del>' . wc_price($variation_custom_variation_regular_price) . ' ' .'</del>';
        $html_price .= '<ins>' . wc_price($variation_custom_variation_price) . ' ' .'</ins>';
        $html_custom_price = $html_price;
    }

    return $html_custom_price;
}



/**
 * apply footer or header of elementor
 */
class Elementor_Theme_Advanced_Support {
	public function __construct() {
		// only run if Elementor Pro is installed and active
		add_action( 'elementor_pro/init', [ $this, 'on_elementor_pro_init' ] );
	}

	public function on_elementor_pro_init() {
		// hook in before elementor hook runs
		add_action( 'get_header', [ $this, 'handle_theme_support' ], 8 );
	}

	private function get_theme_builder_module() {
		return \ElementorPro\Modules\ThemeBuilder\Module::instance();
	}

	private function get_theme_support_instance() {
		$module = $this->get_theme_builder_module();
		return $module->get_component( 'theme_support' );
	}

	public function handle_theme_support() {
		/**
		 * @var \ElementorPro\Modules\ThemeBuilder\Module $module
		 */
		$module = $this->get_theme_builder_module();
		$conditions_manager = $module->get_conditions_manager();
		$headers = $conditions_manager->get_documents_for_location( 'header' );
		$footers = $conditions_manager->get_documents_for_location( 'footer' );

		if ( empty( $headers ) && empty( $footers ) ) {
			// if no headers and no footers then bail!
			return;
		} elseif ( empty( $headers ) ) {
			// only $headers is empty so remove the theme support header
			$this->remove_theme_support_action( 'header' );
		} else {
			// only footer is empty so remove the theme support footer
			$this->remove_theme_support_action( 'footer' );
		}
	}

	public function remove_theme_support_action( $action ) {
		$handler = 'get_' . $action;
		$instance = $this->get_theme_support_instance();
		remove_action( $handler, [ $instance, $handler ] );
	}
}
new Elementor_Theme_Advanced_Support();


/**
 * Font Awesome
 */
/*function wpb_load_fa() {
wp_enqueue_style( 'wpb-fa', get_stylesheet_directory_uri() . '/fonts/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );*/

/**
 * hide coupon field on checkout page
 */
function hide_coupon_field_on_checkout( $enabled ) {

	if ( is_checkout() ) {
		$enabled = false;
	}

	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

/**
 * Remove Checkout Fields
 */
function wc_remove_checkout_fields( $fields ) {
    // Billing fields
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_postcode'] );
    // Shipping fields
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_postcode'] );
    // Order fields
    //unset( $fields['order']['order_comments'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );

/**
 * edit placeholder
 */
 add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
 {
 unset($fields['billing']['billing_state']);
 unset($fields['shipping']['shipping_state']);
 unset($fields['billing']['billing_address_2']);
 $fields['billing']['billing_first_name']['placeholder'] = 'الاسم الثلاثي'; 
	
 $fields['billing']['billing_email']['placeholder'] = 'البريد الإلكتروني';
	
 $fields['shipping']['shipping_first_name']['placeholder'] = 'الاسم الثلاثي';
 //$fields['billing']['billing_first_name']['minlength'] = 11; 
// $fields['shipping']['shipping_first_name']['minlength'] = 11;
 $fields['billing']['billing_first_name']['custom_attributes'] = array( "minlength" => "12" );
 //$fields['billing']['billing_first_name']['custom_attributes'] = array( "pattern" => ".{12,}" ); //min 12 characters
 //$fields['billing']['billing_first_name']['custom_attributes'] = array( "pattern" => ".{10,10}" ); 

 return $fields;
 }

add_action( 'woocommerce_checkout_process', 'bbloomer_checkout_fields_custom_validation' );
   
function bbloomer_checkout_fields_custom_validation() { 
   if ( isset( $_POST['billing_first_name'] ) && ! empty( $_POST['billing_first_name'] ) ) {
      if ( strlen( $_POST['billing_first_name'] ) < 12 ) {
         wc_add_notice( 'عذرًا, الاسم الثلاثي لابد أن يكون أكثر من 12 حرف.', 'error' );
      }
   }   
}

/**
 * Make full name wider
 */
function custom_checkout_css_styles() {
    ?>
        <style>.form-row.form-row-first.validate-required {width: 100% !important;}</style>
    <?php
};
add_action( 'woocommerce_checkout_before_customer_details', 'custom_checkout_css_styles' );


// Change "city" checkout billing and shipping fields to a dropdown
function override_checkout_city_fields( $fields ) {
$city_args = wp_parse_args( array(
		'type' => 'select',
		'options' => array(
    // Define here in the array your desired cities (Here an example of cities)
         '' => __( 'اختر المدينة' ),
	    'الرياض' =>	'الرياض',
		'جدة' =>	'جدة',
		'مكة المكرمة' =>	'مكة المكرمة',
		'المدينة المنورة' =>	'المدينة المنورة',
		'الاحساء' =>	'الاحساء',
		'الدمام' =>	'الدمام',
		'الطائف' =>	'الطائف',
		'بريدة' =>	'بريدة',
		'تبوك' =>	'تبوك',
		'القطيف' =>	'القطيف',
		'خميس مشيط' =>	'خميس مشيط',
		'الخبر' =>	'الخبر',
		'حفر الباطن' =>	'حفر الباطن',
		'الجبيل' =>	'الجبيل',
		'الخرج' =>	'الخرج',
		'أبها' =>	'أبها',
		'حائل' =>	'حائل',
		'نجران' =>	'نجران',
		'ينبع' =>	'ينبع',
		'صبيا' =>	'صبيا',
		'الدوادمي' =>	'الدوادمي',
		'بيشة' =>	'بيشة',
		'أبو عريش' =>	'أبو عريش',
		'القنفذة' =>	'القنفذة',
		'محايل' =>	'محايل',
		'سكاكا' =>	'سكاكا',
		'عرعر' =>	'عرعر',
		'عنيزة' =>	'عنيزة',
		'القريات' =>	'القريات',
		'صامطة' =>	'صامطة',
		'جازان' =>	'جازان',
		'المجمعة' =>	'المجمعة',
		'القويعية' =>	'القويعية',
		'احد المسارحه' =>	'احد المسارحه',
		'وادي الدواسر' =>	'وادي الدواسر',
		'بحرة' =>	'بحرة',
		'الباحة' =>	'الباحة',
		'الجموم' =>	'الجموم',
		'رابغ' =>	'رابغ',
		'أحد رفيدة' =>	'أحد رفيدة',
		'شرورة' =>	'شرورة',
		'الليث' =>	'الليث',
		'رفحاء' =>	'رفحاء',
		'عفيف' =>	'عفيف',
		'العرضيات' =>	'العرضيات',
		'العرضة' =>	'العرضة',
		'الخفجي' =>	'الخفجي',
		'بلقرن' =>	'بلقرن',
		'الدرعية' =>	'الدرعية',
		'طبرجل' =>	'طبرجل',
		'بيشة' =>	'بيشة',
		'الزلفي' =>	'الزلفي',
		'الدرب' =>	'الدرب',
		'الافلاج' =>	'الافلاج',
		'سراة عبيدة' =>	'سراة عبيدة',
		'رجال المع' =>	'رجال المع',
		'بلجرشي' =>	'بلجرشي',
		'الحائط' =>	'الحائط',
		'بدر' =>	'بدر',
		'املج' =>	'املج',
		'رأس تنوره' =>	'رأس تنوره',
		'مهد الذهب' =>	'مهد الذهب',
		'الدائر' =>	'الدائر',
		'البكيرية' =>	'البكيرية',
		'البدائع' =>	'البدائع',
		'خليص' =>	'خليص',
		'العلا' =>	'العلا',
		'الطوال' =>	'الطوال',
		'النماص' =>	'النماص',
		'المجاردة' =>	'المجاردة',
		'بقيق' =>	'بقيق',
		'تثليث' =>	'تثليث',
		'المخواة' =>	'المخواة',
		'النعيرية' =>	'النعيرية',
		'الوجه' =>	'الوجه',
		'ضباء' =>	'ضباء',
		'بارق' =>	'بارق',
		'طريف' =>	'طريف',
		'خيبر' =>	'خيبر',
		'أضم' =>	'أضم',
		'النبهانية' =>	'النبهانية',
		'رنيه' =>	'رنيه',
		'دومة الجندل' =>	'دومة الجندل',
		'المذنب' =>	'المذنب',
		'تربه' =>	'تربه',
		'ظهران الجنوب' =>	'ظهران الجنوب',
		'حوطة بني تميم' =>	'حوطة بني تميم',
		'الخرمة' =>	'الخرمة',
		'قلوه' =>	'قلوه',
		'شقراء' =>	'شقراء',
		'الموية القديم' =>	'الموية القديم',
		'المزاحمية' =>	'المزاحمية',
		'الأسياح' =>	'الأسياح',
		'بقعاء' =>	'بقعاء',
		'السليل' =>	'السليل',
		'تيماء' =>	'تيماء',
		'الرس' =>	'الرس',
		'حريملاء' =>	'حريملاء',
		'مرات' =>	'مرات',
		'عيون الجواء' =>	'عيون الجواء',
		'رياض الخبراء' =>	'رياض الخبراء',
		'الخبراء' =>	'الخبراء',
		'الغاط' =>	'الغاط',
			
    ),
		'input_class' => array(
			'wc-enhanced-select',
		)
	), $fields['shipping']['shipping_city'] );

	$fields['shipping']['shipping_city'] = $city_args;
	$fields['billing']['billing_city'] = $city_args; // Also change for billing field

	wc_enqueue_js( "
	jQuery( ':input.wc-enhanced-select' ).filter( ':not(.enhanced)' ).each( function() {
		var select2_args = { minimumResultsForSearch: 5 };
		jQuery( this ).select2( select2_args ).addClass( 'enhanced' );
	});" );
	return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'override_checkout_city_fields' );

/**
 * Make postcode 12345
 */
add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
function default_values_checkout_fields( $fields ) {
 $fields['billing']['billing_postcode']['default'] = '12345';
 $fields['billing']['billing_postcode']['type'] = 'hidden'; 
 $fields['shipping']['shipping_postcode']['default'] = '12345';
 $fields['shipping']['shipping_postcode']['type '] = 'hidden'; 
 //$fields['billing']['billing_first_name']['priority'] = 10; 
 //$fields['billing']['billing_country']['priority'] = 20; 
 //$fields['billing']['billing_city']['priority'] = 30; 
 //$fields['billing']['billing_address_1']['priority'] = 40; 
 //$fields['billing']['billing_phone']['priority'] = 500; 
 //$fields['billing']['billing_email']['priority'] = 600;
 //$fields['billing']['billing_postcode']['priority'] = 700; 


		 return $fields;
}

/*add_filter( 'woocommerce_default_address_fields', 'mymentech_reorder_checkout_fields' );
 
function mymentech_reorder_checkout_fields( $fields ) {
  // just assign priority less than 10
  $fields['billing']['billing_city']['priority'] = 40;
 return $fields;
}*/

// 1. Hide default notes
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
 
// 2. Create new billing field
add_filter( 'woocommerce_checkout_fields' , 'bbloomer_custom_order_notes' );
 
function bbloomer_custom_order_notes( $fields ) {
   $fields['billing']['new_order_notes'] = array(
      'type' => 'textarea',
      'label' => 'ملاحظات',
      'class' => array('form-row-wide'),
      'clear' => true,
      'priority' => 999,
   );
   return $fields;
}
 
// 3. Save to existing order notes
add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_custom_field_value_to_order_notes', 10, 2 );
 
function bbloomer_custom_field_value_to_order_notes( $order_id, $data ) {
   if ( ! is_object( $order_id ) ) {
      $order = wc_get_order( $order_id );
   }
   $order->set_customer_note( isset( $data['new_order_notes'] ) ? $data['new_order_notes'] : '' );
   wc_create_order_note( $order_id, $data['new_order_notes'], true, true );
   $order->save();
}

/**
 * delete proudct info tabs
 */
add_filter('woocommerce_product_tabs', 'quadlayers_remove_product_tabs');

function quadlayers_remove_product_tabs($tabs) {

unset($tabs['additional_information']);

return $tabs;

}

/** Reset Invoice No. Daily*/
add_action( 'wpo_wcpdf_before_sequential_number_increment', 'wpo_wcpdf_reset_invoice_number_daily', 10, 3 );
function wpo_wcpdf_reset_invoice_number_daily( $number_store, $order_id, $date ) {
	if ( $number_store->store_name == 'invoice_number' ) {
		$current_day = date('z');
		$last_number_day = $number_store->get_last_date('z');
		// check if we need to reset
		if ( $current_day != $last_number_day ) {
			$number_store->set_next( 1 );
		}
	}
}

// Change Cart Totals
// =============================================================================
function change_no_product_text($translated) { 
  $translated = str_ireplace('No products in the cart.', 'لا يوجد منتجات بالسلة', $translated);
  return $translated; 
}
add_filter('gettext', 'change_no_product_text' );
// ===

/**sorting*/
add_filter( 'woocommerce_catalog_orderby', 'misha_remove_default_sorting_options' );
 
function misha_remove_default_sorting_options( $options ){
 
	unset( $options[ 'popularity' ] );
	//unset( $options[ 'menu_order' ] );
	//unset( $options[ 'rating' ] );
	unset( $options[ 'date' ] );
	//unset( $options[ 'price' ] );
	//unset( $options[ 'price-desc' ] );
 
	return $options;
 
}
/*
// Change "city" checkout billing and shipping fields to a dropdown
add_filter( 'woocommerce_checkout_fields' , 'override_checkout_city_fields' );
function override_checkout_city_fields( $fields ) {

    // Define here in the array your desired cities (Here an example of cities)
    $option_cities = array(
         '' => __( 'اختر المدينة' ),
	     'الرياض' =>	'الرياض',
		'جدة' =>	'جدة',
		'مكة المكرمة' =>	'مكة المكرمة',
		'المدينة المنورة' =>	'المدينة المنورة',
		'الاحساء' =>	'الاحساء',
		'الدمام' =>	'الدمام',
		'الطائف' =>	'الطائف',
		'بريدة' =>	'بريدة',
		'تبوك' =>	'تبوك',
		'القطيف' =>	'القطيف',
		'خميس مشيط' =>	'خميس مشيط',
		'الخبر' =>	'الخبر',
		'حفر الباطن' =>	'حفر الباطن',
		'الجبيل' =>	'الجبيل',
		'الخرج' =>	'الخرج',
		'أبها' =>	'أبها',
		'حائل' =>	'حائل',
		'نجران' =>	'نجران',
		'ينبع' =>	'ينبع',
		'صبيا' =>	'صبيا',
		'الدوادمي' =>	'الدوادمي',
		'بيشة' =>	'بيشة',
		'أبو عريش' =>	'أبو عريش',
		'القنفذة' =>	'القنفذة',
		'محايل' =>	'محايل',
		'سكاكا' =>	'سكاكا',
		'عرعر' =>	'عرعر',
		'عنيزة' =>	'عنيزة',
		'القريات' =>	'القريات',
		'صامطة' =>	'صامطة',
		'جازان' =>	'جازان',
		'المجمعة' =>	'المجمعة',
		'القويعية' =>	'القويعية',
		'احد المسارحه' =>	'احد المسارحه',
		'وادي الدواسر' =>	'وادي الدواسر',
		'بحرة' =>	'بحرة',
		'الباحة' =>	'الباحة',
		'الجموم' =>	'الجموم',
		'رابغ' =>	'رابغ',
		'أحد رفيدة' =>	'أحد رفيدة',
		'شرورة' =>	'شرورة',
		'الليث' =>	'الليث',
		'رفحاء' =>	'رفحاء',
		'عفيف' =>	'عفيف',
		'العرضيات' =>	'العرضيات',
		'العرضة' =>	'العرضة',
		'الخفجي' =>	'الخفجي',
		'بلقرن' =>	'بلقرن',
		'الدرعية' =>	'الدرعية',
		'طبرجل' =>	'طبرجل',
		'بيشة' =>	'بيشة',
		'الزلفي' =>	'الزلفي',
		'الدرب' =>	'الدرب',
		'الافلاج' =>	'الافلاج',
		'سراة عبيدة' =>	'سراة عبيدة',
		'رجال المع' =>	'رجال المع',
		'بلجرشي' =>	'بلجرشي',
		'الحائط' =>	'الحائط',
		'بدر' =>	'بدر',
		'املج' =>	'املج',
		'رأس تنوره' =>	'رأس تنوره',
		'مهد الذهب' =>	'مهد الذهب',
		'الدائر' =>	'الدائر',
		'البكيرية' =>	'البكيرية',
		'البدائع' =>	'البدائع',
		'خليص' =>	'خليص',
		'العلا' =>	'العلا',
		'الطوال' =>	'الطوال',
		'النماص' =>	'النماص',
		'المجاردة' =>	'المجاردة',
		'بقيق' =>	'بقيق',
		'تثليث' =>	'تثليث',
		'المخواة' =>	'المخواة',
		'النعيرية' =>	'النعيرية',
		'الوجه' =>	'الوجه',
		'ضباء' =>	'ضباء',
		'بارق' =>	'بارق',
		'طريف' =>	'طريف',
		'خيبر' =>	'خيبر',
		'أضم' =>	'أضم',
		'النبهانية' =>	'النبهانية',
		'رنيه' =>	'رنيه',
		'دومة الجندل' =>	'دومة الجندل',
		'المذنب' =>	'المذنب',
		'تربه' =>	'تربه',
		'ظهران الجنوب' =>	'ظهران الجنوب',
		'حوطة بني تميم' =>	'حوطة بني تميم',
		'الخرمة' =>	'الخرمة',
		'قلوه' =>	'قلوه',
		'شقراء' =>	'شقراء',
		'الموية القديم' =>	'الموية القديم',
		'المزاحمية' =>	'المزاحمية',
		'الأسياح' =>	'الأسياح',
		'بقعاء' =>	'بقعاء',
		'السليل' =>	'السليل',
		'تيماء' =>	'تيماء',
		'الرس' =>	'الرس',
		'حريملاء' =>	'حريملاء',
		'مرات' =>	'مرات',
		'عيون الجواء' =>	'عيون الجواء',
		'رياض الخبراء' =>	'رياض الخبراء',
		'الخبراء' =>	'الخبراء',
		'الغاط' =>	'الغاط',
    );

    $fields['billing']['billing_city']['type'] = 'select';
    $fields['billing']['billing_city']['options'] = $option_cities;
    $fields['shipping']['shipping_city']['type'] = 'select';
    $fields['shipping']['shipping_city']['options'] = $option_cities;

    return $fields;
}*/
/** Add shipping Price even it equal Zero*/
add_filter( 'woocommerce_cart_shipping_method_full_label', 'joseph_add_0_to_shipping_label', 10, 2 );
function joseph_add_0_to_shipping_label( $label, $method ) {
// if shipping rate is 0, concatenate ": 0.00" to the label
if ( ! ( $method->cost > 0 ) ) {
$label .= ' : ' . wc_price(0);
} 
return $label;
}


/**Creation of Minimum & Maximum Quantity fields*/
function wc_qty_add_product_field() {

	echo '<div class="options_group">';
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_wc_min_qty_product', 
			'label'       => __( 'Minimum Quantity', 'woocommerce-max-quantity' ), 
			'placeholder' => '',
			'desc_tip'    => 'true',
			'description' => __( 'Optional. Set a minimum quantity limit allowed per order. Enter a number, 1 or greater.', 'woocommerce-max-quantity' ) 
		)
	);
	echo '</div>';

	echo '<div class="options_group">';
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_wc_max_qty_product', 
			'label'       => __( 'Maximum Quantity', 'woocommerce-max-quantity' ), 
			'placeholder' => '',
			'desc_tip'    => 'true',
			'description' => __( 'Optional. Set a maximum quantity limit allowed per order. Enter a number, 1 or greater.', 'woocommerce-max-quantity' ) 
		)
	);
	echo '</div>';	
}
add_action( 'woocommerce_product_options_inventory_product_data', 'wc_qty_add_product_field' );

/*
* This function will save the value set to Minimum Quantity and Maximum Quantity options
* into _wc_min_qty_product and _wc_max_qty_product meta keys respectively
*/

function wc_qty_save_product_field( $post_id ) {
	$val_min = trim( get_post_meta( $post_id, '_wc_min_qty_product', true ) );
	$new_min = sanitize_text_field( $_POST['_wc_min_qty_product'] );

	$val_max = trim( get_post_meta( $post_id, '_wc_max_qty_product', true ) );
	$new_max = sanitize_text_field( $_POST['_wc_max_qty_product'] );
	
	if ( $val_min != $new_min ) {
		update_post_meta( $post_id, '_wc_min_qty_product', $new_min );
	}

	if ( $val_max != $new_max ) {
		update_post_meta( $post_id, '_wc_max_qty_product', $new_max );
	}
}
add_action( 'woocommerce_process_product_meta', 'wc_qty_save_product_field' );

/*
* Setting minimum and maximum for quantity input args. 
*/

function wc_qty_input_args( $args, $product ) {
	
	$product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
	
	$product_min = wc_get_product_min_limit( $product_id );
	$product_max = wc_get_product_max_limit( $product_id );	

	if ( ! empty( $product_min ) ) {
		// min is empty
		if ( false !== $product_min ) {
			$args['min_value'] = $product_min;
		}
	}

	if ( ! empty( $product_max ) ) {
		// max is empty
		if ( false !== $product_max ) {
			$args['max_value'] = $product_max;
		}
	}

	if ( $product->managing_stock() && ! $product->backorders_allowed() ) {
		$stock = $product->get_stock_quantity();

		$args['max_value'] = min( $stock, $args['max_value'] );	
	}

	return $args;
}
add_filter( 'woocommerce_quantity_input_args', 'wc_qty_input_args', 10, 2 );

function wc_get_product_max_limit( $product_id ) {
	$qty = get_post_meta( $product_id, '_wc_max_qty_product', true );
	if ( empty( $qty ) ) {
		$limit = false;
	} else {
		$limit = (int) $qty;
	}
	return $limit;
}

function wc_get_product_min_limit( $product_id ) {
	$qty = get_post_meta( $product_id, '_wc_min_qty_product', true );
	if ( empty( $qty ) ) {
		$limit = false;
	} else {
		$limit = (int) $qty;
	}
	return $limit;
}


/*
* Validating the quantity on add to cart action with the quantity of the same product available in the cart. 
*/
function wc_qty_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = '', $variations = '' ) {

	$product_min = wc_get_product_min_limit( $product_id );
	$product_max = wc_get_product_max_limit( $product_id );

	if ( ! empty( $product_min ) ) {
		// min is empty
		if ( false !== $product_min ) {
			$new_min = $product_min;
		} else {
			// neither max is set, so get out
			return $passed;
		}
	}

	if ( ! empty( $product_max ) ) {
		// min is empty
		if ( false !== $product_max ) {
			$new_max = $product_max;
		} else {
			// neither max is set, so get out
			return $passed;
		}
	}

	$already_in_cart 	= wc_qty_get_cart_qty( $product_id );
	$product 			= wc_get_product( $product_id );
	$product_title 		= $product->get_title();
	
	if ( !is_null( $new_max ) && !empty( $already_in_cart ) ) {
		
		if ( ( $already_in_cart + $quantity ) > $new_max ) {
			// oops. too much.
			$passed = false;			

			wc_add_notice( apply_filters( 'isa_wc_max_qty_error_message_already_had', sprintf( __( 'لقد تخطيت الكمية المسموح بها للشراء من هذا المنتج', 'woocommerce-max-quantity' ), 
						$new_max,
						$product_title,
                        '<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>',
						$already_in_cart ),
					$new_max,
					$already_in_cart ),
			'error' );

		}
	}

	return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'wc_qty_add_to_cart_validation', 1, 5 );

/*
* Get the total quantity of the product available in the cart.
*/ 
function wc_qty_get_cart_qty( $product_id , $cart_item_key = '' ) {
	global $woocommerce;
	$running_qty = 0; // iniializing quantity to 0

	// search the cart for the product in and calculate quantity.
	foreach($woocommerce->cart->get_cart() as $other_cart_item_keys => $values ) {
		if ( $product_id == $values['product_id'] ) {

			if ( $cart_item_key == $other_cart_item_keys ) {
				continue;
			}

			$running_qty += (int) $values['quantity'];
		}
	}

	return $running_qty;
}

/*
* Validate product quantity when cart is UPDATED
*/

function wc_qty_update_cart_validation( $passed, $cart_item_key, $values, $quantity ) {
	$product_min = wc_get_product_min_limit( $values['product_id'] );
	$product_max = wc_get_product_max_limit( $values['product_id'] );

	if ( ! empty( $product_min ) ) {
		// min is empty
		if ( false !== $product_min ) {
			$new_min = $product_min;
		} else {
			// neither max is set, so get out
			return $passed;
		}
	}

	if ( ! empty( $product_max ) ) {
		// min is empty
		if ( false !== $product_max ) {
			$new_max = $product_max;
		} else {
			// neither max is set, so get out
			return $passed;
		}
	}

	$product = wc_get_product( $values['product_id'] );
	$already_in_cart = wc_qty_get_cart_qty( $values['product_id'], $cart_item_key );

	if ( isset( $new_max) && ( $already_in_cart + $quantity ) > $new_max ) {
		wc_add_notice( apply_filters( 'wc_qty_error_message', sprintf( __( 'لقد تخطيت الكمية المسموح بها للشراء من هذا المنتج', 'woocommerce-max-quantity' ),
					$new_max,
					$product->get_name(),
					'<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>'),
				$new_max ),
		'error' );
		$passed = false;
	}

	if ( isset( $new_min) && ( $already_in_cart + $quantity )  < $new_min ) {
		wc_add_notice( apply_filters( 'wc_qty_error_message', sprintf( __( 'You should have minimum of %1$s %2$s\'s to %3$s.', 'woocommerce-max-quantity' ),
					$new_min,
					$product->get_name(),
					'<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>'),
				$new_min ),
		'error' );
		$passed = false;
	}

	return $passed;
}
add_filter( 'woocommerce_update_cart_validation', 'wc_qty_update_cart_validation', 1, 4 );

/**Removing attribute values from Product variation title*/
add_filter( 'woocommerce_product_variation_title_include_attributes', 'variation_title_not_include_attributes' );
function variation_title_not_include_attributes( $boolean ){
    if ( ! is_cart() )
        $boolean = false;
    return $boolean;
}
add_filter( 'woocommerce_product_variation_title_include_attributes', 'custom_product_variation_title', 10, 2 );
function custom_product_variation_title($should_include_attributes, $product){
    $should_include_attributes = false;
    return $should_include_attributes;
}
/**Display Product variation attributes label and values in separate rows*/
add_filter( 'woocommerce_is_attribute_in_product_name', 'remove_attribute_in_product_name' );
function remove_attribute_in_product_name( $boolean){
    if ( ! is_cart() )
        $boolean = false;
    return $boolean;
}
/**Remove the quantity from the product title*/
add_filter( 'woocommerce_checkout_cart_item_quantity', 'remove_product_variation_qty_from_title', 10, 3 );
function remove_product_variation_qty_from_title( $quantity_html, $cart_item, $cart_item_key ){
    if ( $cart_item['data']->is_type('variation') && is_checkout() )
        $quantity_html = '';

    return $quantity_html;
}
/**Remove the quantity from the product title*/
add_filter( 'woocommerce_get_item_data', 'filter_get_item_data', 10, 2 );
function filter_get_item_data( $item_data, $cart_item ) {

    if ( $cart_item['data']->is_type('variation') && is_checkout() )
        $item_data[] = array(
            'key'      => __('الكمية'),
            'display'  => $cart_item['quantity']
        );

    return $item_data;
}

/**
 * Exclude orders by status in My Account
 * 
 * @param $args
 * @return mixed
 */
add_filter( 'woocommerce_my_account_my_orders_query', 'custom_my_orders' );
function custom_my_orders($args ) {
    $args['status'] = array(
        'wc-pending',
        'wc-processing',
        'wc-on-hold',
        'wc-completed',
//      'wc-cancelled',
        'wc-refunded',
        'wc-failed',
		'wc-pickup',
		'wc-smsa',
    );

    return $args;
}
add_filter( 'woocommerce_shipping_chosen_method', '__return_false', 99);

//Remove Sales Flash
add_filter('woocommerce_sale_flash', 'woo_custom_hide_sales_flash');
function woo_custom_hide_sales_flash()
{
    return false;
}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );

function keep_me_logged_in_for_1_year( $expirein ) {
    return 31556926; // 1 year in seconds
}

/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
function wc_empty_cart_redirect_url() {
	return get_site_url();
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


/**
 * Changes the redirect URL for the Continue Shopping button in the cart.
 *
 * @return string
 */
 
add_filter( 'woocommerce_continue_shopping_redirect', 'bbloomer_change_continue_shopping' );
 
function bbloomer_change_continue_shopping() {
   return get_site_url();
}

/**
 * Fail all unpaid orders after held duration to prevent stock lock for those products.
 */
 
 function custom_wc_cancel_unpaid_orders() {
        $held_duration = get_option( 'woocommerce_hold_stock_minutes' );
        $data_store    = WC_Data_Store::load( 'order' );
        $unpaid_orders = $data_store->get_unpaid_orders( strtotime( '-' . absint( $held_duration ) . ' MINUTES', current_time( 'timestamp' ) ) );
        if ( $unpaid_orders ) {
            foreach ( $unpaid_orders as $unpaid_order ) {
                $order = wc_get_order( $unpaid_order );
                if ( apply_filters( 'woocommerce_cancel_unpaid_order', 'checkout' === $order->get_created_via(), $order ) ) {
                    $order->update_status( 'failed', __( 'Unpaid order marked failed - time limit reached.', 'flatsome' ) );
                }
            }
        }
        wp_clear_scheduled_hook( 'woocommerce_cancel_unpaid_orders' );
        wp_schedule_single_event( time() + ( absint( $held_duration ) * 60 ), 'woocommerce_cancel_unpaid_orders' );
    }
    add_action( 'woocommerce_cancel_unpaid_orders', 'custom_wc_cancel_unpaid_orders' );
	
/**
 * Fix guessing admin usernames
 */
 
 function disable_rest_endpoints ( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'disable_rest_endpoints');

function redirect_to_home_if_author_parameter() {

	$is_author_set = get_query_var( 'author', '' );
	if ( $is_author_set != '' && !is_admin()) {
		wp_redirect( home_url(), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'redirect_to_home_if_author_parameter' );

/**
 * Disable Login Hints
 **/
 
 function no_wordpress_errors(){
  return 'هناك شئ غير صحيح !';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

add_filter( 'xmlrpc_enabled', '__return_false' );

function shapeSpace_disable_xmlrpc_multicall($methods) {
	unset($methods['system.multicall']);
	return $methods;
}
add_filter('xmlrpc_methods', 'shapeSpace_disable_xmlrpc_multicall');

add_action( 'woocommerce_admin_process_product_object', 'custom_out_of_stock'  );

function custom_out_of_stock( $product ) {

	$stock = wc_stock_amount( $_POST['_stock'] );

	if( $stock == 0 ) {
		$product->set_props( array( 
			'stock_status' => 'outofstock',
		 ) );
	}
}