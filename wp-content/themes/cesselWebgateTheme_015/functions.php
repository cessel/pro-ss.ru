<?php
require_once(get_template_directory().'/theme_settings/settings.php');
define('CES_IMG',get_template_directory_uri()."/img");
/* global $post */
// Удаляем лишнее с head части сайта при необходимости раскоментировать

remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links',       2 );
remove_action( 'wp_head', 'rsd_link'            ); 
remove_action( 'wp_head', 'wlwmanifest_link'    );
add_filter('the_generator', '__return_empty_string'); 
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'wp_resource_hints', 2); 
remove_action('wp_head','start_post_rel_link',10);
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'template_redirect', 'rest_output_link_header', 11 );


/* Админ бар */
add_filter('show_admin_bar', '__return_false'); // отключить
//add_filter('show_admin_bar', '__return_true'); // включить

if ( ! is_admin() ) {
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
}

if( wp_doing_ajax() ){
	add_action('wp_ajax_get_cart_data', 'ajax_get_cart_data');
	add_action('wp_ajax_nopriv_get_cart_data', 'ajax_get_cart_data');
	add_action('wp_ajax_send_order', 'ajax_send_order');
	add_action('wp_ajax_nopriv_send_order', 'ajax_send_order');
	add_action('wp_ajax_cart_icon', 'ajax_cart_icon');
	add_action('wp_ajax_nopriv_cart_icon', 'ajax_cart_icon');
	add_action('wp_ajax_get_order', 'ajax_get_order');
	add_action('wp_ajax_nopriv_get_order', 'ajax_get_order');
}


function icon($iconname,$echo = true)
    {
        $icon = "<i class='icon-".$iconname."'></i>";
        if($echo){
	        echo $icon;
        }
        else{
            return $icon;
        }

    }
function logo($footer=false,$with_link = true)
{
	$footer_logo_src = get_field('логотип_для_подвала','options')['sizes']['large'];
	$logo_src = ( $footer == 'footer' && $footer_logo_src )? $footer_logo_src : wp_get_attachment_image_url(get_theme_mod( 'custom_logo'),'full');
	$logo_html = ($with_link && !(is_home()||is_front_page())) ? "<a href='".get_home_url()."' title='".get_bloginfo('name')." - на главную'><img src='".$logo_src."' alt='".get_bloginfo('name')." - наш логотип'></a>" : "<img src='".$logo_src."' alt='".get_bloginfo('name')." - наш логотип'>";

	echo $logo_html;
}

/* АВТОМАТИЧЕСКОЕ ПОДКЛЮЧЕНИЕ JS И CSS ФАЙЛОВ ИЗ ПАПКИ /js/ и /css/ СООТВЕТСТВЕННО */
/*Для включения кеша закомментировать $v = time(); */

function CWG_scripts()
	{
		$v = 1;
        $v = time();
		$dir_js = get_template_directory().'/js/lib/';
		$dir_css = get_template_directory().'/css/libs/';
		$js_files=scandir($dir_js);
		$css_files=scandir($dir_css);
		$i=0;
		$uri_css = get_template_directory_uri() . '/css/';
		$uri_js = get_template_directory_uri() . '/js/';
		foreach ($js_files as $js)
			{
				$extension = explode('.',$js);
				if($extension[count($extension)-1]=='js')
					{
						wp_enqueue_script('script'.$i++,  $uri_js.'lib/'. $js);
					}
				
			}
			$i=0;
		foreach ($css_files as $css)
			{
				$extension = explode('.',$css);
				if($extension[count($extension)-1]=='css')
					{
						wp_enqueue_style('style'.$i++, $uri_css .'/libs/'. $css);
					}
			}
		wp_enqueue_style('style_main', $uri_css . '/styles.css?v='.$v);
		//wp_enqueue_style('style_main', $uri_css . '/style.min.css?v='.$v);
		if(get_field('включить_яндекс_карты','options'))
			{
				wp_enqueue_script('yandex_map', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU');
			}
		wp_enqueue_script('script_main', $uri_js . 'misc.js','jquery',$v);
	}
add_action( 'wp_enqueue_scripts', 'CWG_scripts' );


function modal_toggle_link($link_text,$id_modal,$link_class='site-btn')
	{
		echo '<a href="'.$id_modal.'" data-toggle="modal" data-target="'.$id_modal.'" class="'.$link_class.'">'.$link_text.'</a>';
	}
function get_sitedata($varname)
	{
		$page = get_page_by_title('Главная');
		return get_metadata('post',$page->ID, $varname, true);
		
	}
 function get_sitedata_dy_page_id($varname,$id)
	{
		$page = get_post( $id );
		return get_metadata('post',$page->ID, $varname, true);
		
	}
function remove_opensans_font()
	{
			
	}


register_nav_menus(array(
	'top'    => 'Верхнее меню',    //Название месторасположения меню в шаблоне
	'bottom' => 'Нижнее меню'      //Название другого месторасположения меню в шаблоне
));

function wp_kama_theme_setup(){
	// Поддержка миниатюр
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support('woocommerce');

}

add_action( 'after_setup_theme', 'wp_kama_theme_setup' );

add_action( 'widgets_init', 'register_my_widgets' );

function register_my_widgets() {
	register_sidebar( array(
		'name'          => 'Подвал - левый блок',
		'id'            => "footer-left-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты - правый блок',
		'id'            => "contacts-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="contactsWidgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - левый блок',
		'id'            => "footer-contacts-left-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - центральный блок',
		'id'            => "footer-contacts-center-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Контакты в подвале - правый блок',
		'id'            => "footer-contacts-right-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Блок слайдера на главной странице',
		'id'            => "frontpage-banner",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="banner__carouselWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '',
		'after_title'   => "",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - средний блок',
		'id'            => "footer-center-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - правый блок',
		'id'            => "footer-right-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
	register_sidebar( array(
		'name'          => 'Подвал - нижний блок',
		'id'            => "footer-bottom-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div class="widgetWrapper">',
		'after_widget'  => "</div>",
		'before_title'  => '<p class="widget__title">',
		'after_title'   => "</p>",
	) );
}
/**
 * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
 * param  $number Integer Число на основе которого нужно сформировать окончание
 * param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
 *         например array('яблоко', 'яблока', 'яблок')
 * return String
 */
function getNumEnding($number, $endingArray)
{
	$number = $number % 100;
	if ($number>=11 && $number<=19) {
		$ending=$endingArray[2];
	}
	else {
		$i = $number % 10;
		switch ($i)
		{
			case (1): $ending = $endingArray[0]; break;
			case (2):
			case (3):
			case (4): $ending = $endingArray[1]; break;
			default: $ending=$endingArray[2];
		}
	}
	return $ending;
}

function rus_date() {
// Перевод
 $translate = array(
 "am" => "дп",
 "pm" => "пп",
 "AM" => "ДП",
 "PM" => "ПП",
 "Monday" => "Понедельник",
 "Mon" => "Пн",
 "Tuesday" => "Вторник",
 "Tue" => "Вт",
 "Wednesday" => "Среда",
 "Wed" => "Ср",
 "Thursday" => "Четверг",
 "Thu" => "Чт",
 "Friday" => "Пятница",
 "Fri" => "Пт",
 "Saturday" => "Суббота",
 "Sat" => "Сб",
 "Sunday" => "Воскресенье",
 "Sun" => "Вс",
 "January" => "Января",
 "Jan" => "Янв",
 "February" => "Февраля",
 "Feb" => "Фев",
 "March" => "Марта",
 "Mar" => "Мар",
 "April" => "Апреля",
 "Apr" => "Апр",
 "May" => "Мая",
 "May" => "Мая",
 "June" => "Июня",
 "Jun" => "Июн",
 "July" => "Июля",
 "Jul" => "Июл",
 "August" => "Августа",
 "Aug" => "Авг",
 "September" => "Сентября",
 "Sep" => "Сен",
 "October" => "Октября",
 "Oct" => "Окт",
 "November" => "Ноября",
 "Nov" => "Ноя",
 "December" => "Декабря",
 "Dec" => "Дек",
 "st" => "ое",
 "nd" => "ое",
 "rd" => "е",
 "th" => "ое"
 );
 // если передали дату, то переводим ее
 if (func_num_args() > 1) {
 $timestamp = func_get_arg(1);
 return strtr(date(func_get_arg(0), $timestamp), $translate);
 } else {
// иначе текущую дату
 return strtr(date(func_get_arg(0)), $translate);
 }
 }
function phone_convert_to_link($tel,$class = '', $ancor = false)
{
	$ancor = $ancor ? $ancor : $tel;

	echo "<a href='tel:".preg_replace('/[ \-()]/','',$tel)."' class='".$class."'>".$ancor."</a>";
}
function email_convert_to_link($email,$class = '')
{
	echo "<a href='mailto:".$email."' class='".$class."'>".$email."</a>";
}
function skype_convert_to_link($skype)
	{
		echo "<a href='skype:".$skype."?chat'>$skype</a>";
	}
function generate_owl_from_post($cat_id,$numposts)
	{
		$args = array
			(
				'category' => $cat_id,
				'numberposts' => $numposts
			);
		$posts = get_posts($args);
		
		$return = "<div class='owl-carousel'>";
		
		foreach ($posts as $post)
			{
				
			}
			
		$return .= "</div>";
		return $return;
	}
function generate_owl_from_array($owl_array = array())
	{

		$id = $owl_array['id'];
		$return = "<div id='".$id."' class='banner owl-carousel owl-theme'>";
		foreach ($owl_array['data'] as $data)
			{
				$img_url = wp_get_attachment_image_url($data['картинка'],'full');
				$return .= "<div class='owl-item' style='background-image:url(".$img_url.")'>";
				$return .= "<h1>".$data['заголовок']."</h1>";
				$return .= "<h2>".$data['подзаголовок']."</h2>";
				$return .= "<a href='".$data['ссылка_с_кнопки']."' class='site-btn owl-btn'>".$data['надпись_на_кнопке']."</a>";
				$return .= '<div class="dotted-overlay"></div>';
				$return .= "</div>";
			}
		$return .= "</div>";
		return $return;
	}

	/* для bootstrap4 меню*/
/*add_filter( 'nav_menu_css_class', 'add_my_class_to_nav_menu', 10, 3 );
function add_my_class_to_nav_menu( $classes, $item  ){
	$classes[] = 'nav-item';
	return $classes;
}
add_filter( 'nav_menu_link_attributes', 'nav_link_filter', 10, 4 );
function nav_link_filter( $atts, $item, $args, $depth ){
	$atts['class'] = 'nav-link';
	return $atts;
}*/

add_shortcode( 'button', 'button_shortcode' );

function button_shortcode( $attr ){

	$link ='#link';
    if(isset($attr['link']))
        {
            $link = $attr['link'];
        }
	return "<a href='".$link."' class='btn ".$attr['class']."' >".$attr['text']."</a>";

}
add_shortcode( 'contacts', 'contacts_shortcode' );

function contacts_shortcode()
	{
		$contacts['tel'] = get_option('option_phone');
		return "<p class='contacts__line'>".phone_convert_to_link($contacts['tel'],false)."</p>";

}
add_shortcode( 'show_map', 'show_map_shortcode' );

function show_map_shortcode()
	{
		$contacts['adress'] = get_option('option_adress');
		$contacts['adress2'] = get_option('option_adress2');
		return "<div id='mapWidget' data-adress='".$contacts['adress']."' data-adress2='".$contacts['adress2']."' data-sitename='".get_bloginfo('name')."'></div>";

}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Настройки сайта',
		'menu_title'	=> 'Настройки сайта',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
if( function_exists('acf_add_local_field') ) {
	acf_add_local_field(array(
		'key' => 'field_enable_ymaps',
		'label' => 'Включить Яндекс карты',
		'name' => 'включить_яндекс_карты',
		'type' => 'true_false',
		'parent' => 'site-settings'
	));
}
if( function_exists('acf_add_local_field_group') ) {
	acf_add_local_field_group(array(
		'key' => 'site-settings',
		'title' => 'Настройки сайта',
		'fields' => array (),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
	));
}

function some_replaces($content)
    {
        $replaces[] = array('find' => '[FIRMNAME]','replace' => get_bloginfo('name'));
	    foreach ( $replaces as $replace ) {
		    $content = str_replace($replace['find'],$replace['replace'],$content);
        }
        return $content;
    }
add_filter('the_content','some_replaces');
function get_attributes($post_id)
    {
	    $dimension = ' см.';
	    $dimension2 = ' кг.';

	    $length = get_field('длина',$post_id);
	    $width = get_field('ширина',$post_id);
        $diametr = get_field('диаметр',$post_id);
        $height = get_field('высота',$post_id);
        $weight = get_field('масса',$post_id);
        $gost = get_field('гост',$post_id);
        $series = get_field('серия',$post_id);

	    $attrs[] = ($length && trim($length) != '') ? "<div class='attributes__item'><div class='attributes__label'>Длина:</div><div class='attributes__value'>".$length.$dimension."</div></div>" : '';
	    $attrs[] = ($width && trim($width) != '') ? "<div class='attributes__item'><div class='attributes__label'>Ширина:</div><div class='attributes__value'>".$width.$dimension."</div></div>" : '';
	    $attrs[] = ($diametr && trim($diametr) != '') ? "<div class='attributes__item'><div class='attributes__label'>Диаметр:</div><div class='attributes__value'>".$diametr.$dimension."</div></div>" : '';
	    $attrs[] = ($height && trim($height) != '') ? "<div class='attributes__item'><div class='attributes__label'>Высота:</div><div class='attributes__value'>".$height.$dimension."</div></div>" : '';
	    $attrs[] = ($weight && trim($weight) != '') ? "<div class='attributes__item'><div class='attributes__label'>Масса:</div><div class='attributes__value'>".$weight.$dimension2."</div></div>" : '';
	    $attrs[] = ($gost && trim($gost) != '') ? "<div class='attributes__item attributes__item--gost'><div class='attributes__label'>ГОСТ:</div><div class='attributes__value'>".$gost."</div></div>" : '';
	    $attrs[] = ($series && trim($series) != '') ? "<div class='attributes__item attributes__item--series'><div class='attributes__label'>Серия:</div><div class='attributes__value'>".$series."</div></div>" : '';


	    $html = '<div class="attributes">';
	    $html .= '<div class="attributes__inner">';
	    foreach (  $attrs as $attr ) {
		    $html .= $attr;
		}
	    $html .= '</div>';
	    $html .= '</div>';

	    return $html;
    }
function get_bestsellers($products,$number = 8)
    {
    	?>
	    <div class="products">
		    <div class="products__inner">
			    <?
			    foreach ( $products as $product ) {
				    get_product($product);
			    }
			    ?>
		    </div>
	    </div>
	    <?
    }
function get_product($product)
{
    $price = get_product_price($product->ID);
    ?>

    <div class="product-card">
        <div class="product-card__inner">
            <div class="product-card__title">
	            <? echo get_product_name($product->ID); ?>
            </div>
            <div class="product-card__img">
                <a href="<? the_permalink($product->ID); ?>"><img src="<? echo get_the_post_thumbnail_url($product->ID,'medium'); ?>" alt="<? echo get_the_title($product->ID); ?> - <? bloginfo('name'); ?>"></a>
            </div>
            <div class="product-card__price"><? echo get_product_price_html($price); ?></div>
            <? /*<div class="attributes__title">
                <span>Параметры...</span>
            </div> */ ?>
            <div class="product-card__attr">
				<? echo get_attributes($product->ID); ?>
            </div>
            <div class="product-card__btn">
                <? $in_cart = is_product_in_cart($product->ID); ?>
                <? $add_to_cart_class = ($in_cart)? ' added' : '';?>
                <? $add_to_cart_text = (!$in_cart)? 'В корзину' : 'В корзине'; ?>
                <button class="site-btn product-card__buy<? echo $add_to_cart_class; ?>" data-product="<? echo $product->ID; ?>" data-price="<? echo $price; ?>" data-incart="0"><? echo $add_to_cart_text; ?></button>
            </div>
        </div>
    </div>
<?
}

function get_product_price_html($price) {
	$currency_sim = ( empty( $price ) || ( $price == 0 ) ) ? '' : get_field( 'символ_для_валюты', 'options' );
	$price        = ( empty( $price ) || ( $price == 0 ) ) ? 'По запросу' : $price;

	return "<span class='price' data-current_price='" . $price . "'>" . $price . "</span> " . $currency_sim;
}
function get_product_price($product_id){
    if(!is_prices_active() || !get_field('включить_цену_товара',$product_id)){
        return '';
    }
	return get_field('цена',$product_id);
}
function show_youtube_video($video_id, $echo = true)
{
	$videoblock = '<div class="youtube" id="'.$video_id.'"></div>';
	if($echo)
		echo $videoblock;
	else
		return $videoblock;
}

add_filter('style_loader_tag', 'clean_style_tag');
function clean_style_tag($src) {
	$src = str_replace("type='text/javascript'", '', $src);
	$src =  str_replace('type="text/javascript"', '', $src);
	$src = str_replace("type='text/css'", '', $src);
	return str_replace('type="text/css"', '', $src);
}

add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src) {
	$src = str_replace("type='text/javascript'", '', $src);
	$src =  str_replace('type="text/javascript"', '', $src);
	$src = str_replace("type='text/css'", '', $src);
	return str_replace('type="text/css"', '', $src);

}
function get_goods_category($cat)
    {
        $category_image = wp_get_attachment_image_url(get_field('изображение_категории','goods_cat_'.$cat->term_id),'medium');

        $html = '<div class="category">';
	    $html .= "<div class='category__inner'>";

	    $html .= "<div class='category__img'>";
	    $html .= "<a href='".get_term_link( $cat )."'><img src='".$category_image."' alt='".$cat->name." - ".get_bloginfo('name')."'></a>";
	    $html .= "</div>";
	    $html .= "<div class='category__title'>";
	    $html .= "<h2><a href='".get_term_link( $cat )."'>".$cat->name."</a></h2>";
	    $html .= "</div>";
	    $html .= "<div class='category__btn'>";
	    $html .= "<a href='".get_term_link( $cat )."'>Посмотреть цены</a>";
	    $html .= "</div>";
	    $html .= "</div>";
	    $html .= "</div>";

	    return $html;
    }
function get_goods_categories($parent = 0)
    {
        $args = array
            (
                'taxonomy'      =>  'goods_cat',
                'hierarchical'  =>  false,
                'parent'        => $parent
            );
        $cats = get_terms($args);
        if(count($cats) == 0){ return false; }
        $html = "<div class='categories'>";
        $html .= "<div class='categories__inner'>";
	    foreach ( $cats as $cat ) {
	        $html .= get_goods_category($cat);
        }
	    $html .= "</div>";
	    $html .= "</div>";

        return $html;
    }

function get_single_product_buy($post_id)
    {

	    $product_price = get_product_price($post_id);
	    $html = "<div class='product-buy js--product-item'>";

	    if(!empty($product_price)){

		    $html .= "<div class='product-buy__line'>";
		    $html .= "<div class='product-buy__price js--summ' data-product_price='".$product_price."'>";
		    $html .= get_product_price_html($product_price);
		    $html .= "</div>";
		    $html .= "</div>";

		    $html .= "<div class='product-buy__line'>";
		    $html .= product_qty_block(1);
		    $in_cart = is_product_in_cart($post_id);
		    $add_to_cart_class = ($in_cart)? ' added' : '';
		    $add_to_cart_text = (!$in_cart)? 'В корзину' : 'В корзине';
		    $html .= "<button class='site-btn product-card__buy".$add_to_cart_class."' data-product='".$post_id."' data-price='".$product_price."' data-incart='0'>".$add_to_cart_text."</button>";
		    $html .= "</div>";
	    } else{
		    $html .= "<div class='product-buy__line'>";
		    $html .= "<button class='site-btn product-card__buy' data-product='".$post_id."' data-target='#send-price-query' data-toggle='modal' >Узнать цену и наличие</button>";
		    $html .= "</div>";
	    }

	    $html .= "<div class='product-buy__line'>";
	    $html .= "<a href='#get_price-single' data-target='#get_price-single' data-toggle='modal' class='get-price-single-buy'>Получить полный прайс-лист</a>";
        $html .= "</div>";

        $html .= "</div>";

        return $html;
    }

function the_cart_header()
    {
        $html = "<div class='cart-header'>";
	    $html .= "<div class='cart-header__inner'>";
	    $html .= "<div class='cart-header__coll cart-header__img'>";
	    $html .= "Изображение";
	    $html .= "</div>";
	    $html .= "<div class='cart-header__coll cart-header__name'>";
	    $html .= "Наименование";
	    $html .= "</div>";
	    $html .= "<div class='cart-header__coll cart-header__price'>";
	    $html .= "Цена";
	    $html .= "</div>";
	    $html .= "<div class='cart-header__coll cart-header__qty'>";
	    $html .= "Кол-во";
	    $html .= "</div>";
	    $html .= "<div class='cart-header__coll cart-header__summ'>";
	    $html .= "Сумма";
	    $html .= "</div>";
	    $html .= "<div class='cart-header__coll cart-header__remove'>";
	    $html .= "</div>";
	    $html .= "</div>";
	    $html .= "</div>";
	    echo $html;
    }

function the_cart_lines()
    {
	    $incart = str_replace('\\','',$_COOKIE['incart']);
        $cart = (!empty($incart)) ? json_decode($incart,true) : array() ;
	    $html = "<div class='cart-data'>";
	    $html .= "<div class='cart-data__inner'>";
	    foreach ( $cart as $item ) {

            $product = get_post($item['product_id']);
		    $html .= get_cart_line($product,$item['qty']);

	    }
	    if(count($cart)==0){
		    $html .= '<div class="cart__none"><p>Ваша корзина пуста.</p><p>Вы можете выбрать необходимые позиции у нас в <a href="/goods/">каталоге</a>, или воспользовать поиском в шапке сайта</p></div>';
	    }

	    $html .= "</div>";
	    $html .= "</div>";
	    echo $html;

    }
function get_cart_line($product,$qty)
    {

	    $price = get_product_price($product->ID);

	    $html = "<div class='cart-item js--product-item' data-product_id='".$product->ID."'>";
	    $html .= "<div class='cart-item__inner'>";

	    $html .= "<div class='cart-item__coll cart-item__img'>";
	    $html .= "<img src='".get_the_post_thumbnail_url($product->ID)."' alt='".get_the_title($product->ID)."'>";
	    $html .= "</div>";

	    $html .= "<div class='cart-item__coll cart-item__name'>";
	    $html .= get_product_name($product->ID);
	    $html .= "</div>";
	    $html .= "<div class='cart-item__coll cart-item__price js--price'>";
	    $html .= get_product_price_html($price);
	    $html .= "</div>";

	    $html .= "<div class='cart-item__coll cart-item__qty'>";
	    $html .= product_qty_block($qty);
        $html .= "</div>";

	    $html .= "<div class='cart-item__coll cart-item__summ js--summ'>";
	    $html .=  get_product_price_html((int)$price*$qty);
	    $html .= "</div>";
	    $html .= "<div class='cart-item__coll cart-item__remove'>";
	    $html .= "<div class='remove_from_cart' data-product_id='".$product->ID."'>".icon('close',false)."</div>";
	    $html .= "</div>";

	    $html .= "</div>";
	    $html .= "</div>";

        return $html;
    }
function ajax_get_cart_data(){
	$incart = str_replace('\\','',$_COOKIE['incart']);
	$cart = (!empty($incart)) ? json_decode($incart,true) : array() ;
	$html = '';
	$status = '0';
	foreach ( $cart as $item ) {

		$product = get_post($item['product_id']);
		$html .= get_cart_line($product,$item['qty']);

	}

	if(count($cart)==0){
		$html .= '<div class="cart__none"><p>Ваша корзина пуста.</p><p>Вы можете выбрать необходимые позиции у нас в <a href="/goods/">каталоге</a>, или воспользовать поиском в шапке сайта</p></div>';
		$status = 'empty';
	}
	$summ = get_cart_summ($cart);
	$summ = ($summ == 0 ) ? 0 : get_product_price_html($summ);
    $return['html']     = $html;
	$return['status']   = $status;
	$return['summ']     = $summ;

	//wp_send_json($return,$status);

    $return_ready = json_encode($return);
    echo $return_ready;
    wp_die();

}

function get_cart_count()
    {
        $incart = str_replace('\\','',$_COOKIE['incart']);
	    return (!empty($incart)) ? count(json_decode($incart,true)) : 0 ;
    }
function is_product_in_cart($product_id)
    {
	    $incart = str_replace('\\','',(isset($_COOKIE['incart'])) ? $_COOKIE['incart'] : '') ;

	    $incart_arr = (!empty($incart)) ? json_decode($incart,true) : array();

	    foreach ( $incart_arr as $item ) {
            if($item['product_id'] == $product_id)
                {
                    return true;
                }
	    }

        return false;

    }

function product_qty_block($qty)
    {
	    $html = "<div class='product-buy__qty'>";
	    $html .= "<div class='product-buy__minus'>-</div>";
	    $html .= "<div class='product-buy__number'><input name='product-buy__number' value='".$qty."' type='number' min='1'></div>";
	    $html .= "<div class='product-buy__plus'>+</div>";
	    $html .= "</div>";
        return $html;
    }

function the_cart_footer()
    {
	    $html = "<div class='cart-footer'>";
	    $html .= "<div class='cart-footer__inner'>";

	    $html .= "<div class='cart-footer__line'>";
	    $html .= "<div class='cart-footer__line cart-footer__btns'>";
	    $html .= "<button class='site-btn grey js--clear-cart'>Очистить корзину</button>";
	    $html .= "<div class='cart-footer__total'>";
	    $html .= "</div>";
	    $html .= "<button class='site-btn js--refresh-cart'>Обновить корзину</button>";
	    $html .= "</div>";
	    $html .= "</div>";

	    $html .= "</div>";
	    $html .= "</div>";
	    echo $html;

    }
function get_product_name($product_id)
    {
	    $cat = get_the_terms($product_id,'goods_cat')[0];
	    $html = "<h2><a href='".get_permalink($product_id)."'>".get_the_title($product_id)."</a></h2>";
	    //$html .= "<h4><a href='".get_term_link($cat->term_id)."'>".$cat->name."</a></h4>";
        return $html;
    }

function the_order_form()
    {

        $html = '<form class="js--order-form">
            <div class="site-form">
                <div class="site-form__line"><p class="site-form__title">Оформление заказа</p></div>
                <div class="site-form__line site-form__line--orderdata"></div>
                <div class="site-form__line">
                    <input id="form-name" name="form-name" type="name" class="site-form__input" placeholder="Введите имя*">
                </div>
                <div class="site-form__line">
                    <input id="form-tel" name="form-tel" type="tel" class="site-form__input" placeholder="Введите телефон*">
                </div>
                <div class="site-form__line">
                    <input id="form-email" name="form-email" type="email"  class="site-form__input" placeholder="Email*">
                </div>
                <div class="site-form__line">
                    <textarea id="form-message" name="form-message" class="site-form__textarea" placeholder="Сообщенине"></textarea>
                </div>
                <div class="site-form__line site-form__line--submit">
                    <input type="submit" class="site-btn site-form__input site-form__input--submit" disabled val="Заказать">
                    '.icon('spin icon-2x animate-spin',false).'
                </div>
                <div class="site-form__line"><p class="site-form__polytics">Отправляя форму, я соглашаюсь<br> с <a
                        href="/privacy-policy/">политикой обработки персональных данных</a></p></div>
                <div class="form-response"></div>
            </div>
        </form>';
	    $html .= ' <script src="https://www.google.com/recaptcha/api.js?render=6LdwpJMUAAAAALKBSjteXxaLWo0-dm-Xc4_PfjeP"></script>';
	    $html .= "<script>
          grecaptcha.ready(function() {
              setTimeout(function(e)
                {
                    grecaptcha.execute('6LdwpJMUAAAAALKBSjteXxaLWo0-dm-Xc4_PfjeP', {action: 'cart'}).then(function(token) {
                        var form = $('.js--order-form');
                        form.data('token',token);
                        var submit_btn = form.find('input[type=\"submit\"]');
                        submit_btn.prop('disabled',false);
                        form.find('i').remove(); 
              });
                },'500');
              
          });
          </script>";

	    echo $html;
    }

function ajax_send_order(){
    $recaptcha_secret = '6LdwpJMUAAAAADBxd_BpDaRxIxKt4o7k_3ueCzyj';

	if (isset($_POST['token'])) {
		$captcha_token = $_POST['token'];
		$captcha_action = 'cart';
	} else {
		$return['status']   = 1;
		$return['html']     = 'Order send status: Captcha check fail!';
		$return['error']    = 'Капча работает некорректно. Обратитесь к администратору!';
		echo json_encode($return);
		wp_die();
	}

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$params = [
		'secret' => $recaptcha_secret,
		'response' => $captcha_token
	];

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);
	$decoded_response = '';
	if(!empty($response)) $decoded_response = json_decode($response);


	if ($decoded_response && $decoded_response->success && $decoded_response->action == $captcha_action && $decoded_response->score > 0) {
		$success = $decoded_response->success;
		$client_data = $_POST['form'];

		$new_order_data = create_order($client_data);

		if($new_order_data){
            if(!send_message('admin',$new_order_data))
                {
	                $return['status']   = 4;
	                $return['html']     = 'Order send status: Admin mail fail!';
	                $return['error']    = $decoded_response;

                }
            if(!send_message('client',$new_order_data))
                {
	                $return['status']   = 4;
	                $return['html']     = 'Order send status: Client mail fail!';
	                $return['error']    = $decoded_response;
                }
			$return['status']   = 0;
			$return['html']     = 'Заказ успешно оформлен. Данные по заказу оптравлены на указанную почту';
			$return['error']    = 0;

		}
        else{
	        $return['status']   = 3;
	        $return['html']     = 'Order send status: Order create fail!';
	        $return['error']    = $decoded_response;
        }


	} else {

		$return['status']   = 2;
		$return['html']     = 'Order send status: Captcha check fail!';
		$return['error']    = $decoded_response;
	}




	$return['post'] = $_POST;




    echo json_encode($return);
	wp_die();

}

function get_cart_items()
    {
	    $incart = str_replace('\\','',(isset($_COOKIE['incart'])) ? $_COOKIE['incart'] : '') ;
	    $cart = (!empty($incart)) ? json_decode($incart,true) : array() ;
        return $cart;
    }
function create_order($client_data) {
	    $cart = get_cart_items();
        if(!empty($cart)){
	        $post_data = array(
		        'post_title'    => 'Заказ № ',
		        'post_content'  => '',
		        'post_status'   => 'publish',
		        'post_author'   => 1,
                'post_type'     => 'pss-order'
	        );

	        $order_id = wp_insert_post( wp_slash($post_data) );
	        if( is_wp_error($order_id) ){
		        return false;
	        }
	        else {
		        $order_return_data['client']['name'] = esc_html($client_data[0]['value']);
		        $order_return_data['client']['tel'] = esc_html($client_data[1]['value']);
		        $order_return_data['client']['email'] = esc_html($client_data[2]['value']);
		        $order_return_data['client']['message'] = esc_html($client_data[3]['value']);

		        $order_return_data['order']['ID'] = $order_id;
		        $order_return_data['order']['date'] = get_the_date('d.m.Y', $order_return_data['order']['ID']);
		        $order_return_data['order']['post_title'] = $order_return_data['order']['ID'].' от '.$order_return_data['order']['date'];
		        $order_return_data['order']['pin'] = wp_rand( 1000, 9999 );
		        $order_return_data['order']['link'] = get_the_permalink($order_return_data['order']['ID']);
		        wp_update_post( wp_slash($order_return_data['order']) );

		        update_field('номер_заказа',$order_return_data['order']['ID'], $order_return_data['order']['ID']);
		        update_field('дата_заказа',$order_return_data['order']['date'],$order_return_data['order']['ID']);
		        update_field('имя_клиента',$order_return_data['client']['name'],$order_return_data['order']['ID']);
		        update_field('телефон_клиента',$order_return_data['client']['tel'],$order_return_data['order']['ID']);
		        update_field('email_клиента',$order_return_data['client']['email'],$order_return_data['order']['ID']);
		        update_field('комментарий_клента',$order_return_data['client']['message'],$order_return_data['order']['ID']);
		        update_field('pin',$order_return_data['order']['pin'], $order_return_data['order']['ID']);

		        $field_key = "что_заказано";
		        $value = array();
		        $order_return_data['order']['total'] = 0;
		        foreach ( $cart as $item ) {

			        $price = get_product_price($item['product_id']);
			        $order_return_data['cart'][$item['product_id']]['price'] = $price;
			        $order_return_data['cart'][$item['product_id']]['url'] = get_post_permalink($item['product_id']);
			        $order_return_data['cart'][$item['product_id']]['qty'] = $item['qty'];
			        $order_return_data['cart'][$item['product_id']]['summ'] = $order_return_data['cart'][$item['product_id']]['qty']*$order_return_data['cart'][$item['product_id']]['price'];
			        $value[] =
				        array(
					        "изделие"	=> $item['product_id'],
					        "ссылка_на_изделие"	=>  array( "title" => "", "url" => $order_return_data['cart'][$item['product_id']]['url'], "target"=> "_blank"),
					        "количество"	=>  $order_return_data['cart'][$item['product_id']]['qty'],
					        "стоимость"	=>  $order_return_data['cart'][$item['product_id']]['summ'],
				        );
			        $order_return_data['order']['total'] += $order_return_data['cart'][$item['product_id']]['summ'];
		        }
		        update_field( $field_key, $value, $order_return_data['order']['ID'] );

		        return $order_return_data;
	        }
        }
        else{
            return false;
        }
    }

function get_cart_icon()
    {
        $cart = get_cart_items();
	    $cart_count = 0;
	    foreach ( $cart as $item ) {
		    $cart_count += $item['qty'];
	    }
	    $cart_count_class = ($cart_count == 0) ? ' hide' : '';
	    $link = ($cart_count == 0) ? '/goods/' : '/cart/';
	    $cart_goods = ($cart_count == 0) ? '<p>Корзина пока пуста</p>' : '<p>'.$cart_count.' '.getNumEnding($cart_count, array('товар','товара','товаров')).'</p>';
	    $summ = get_cart_summ($cart);
        $summ = ($summ != 0) ? '<p>На сумму: '.get_product_price_html($summ).'</p>' : '' ;
	    $html = '<div class="cart-icon__inner">';
	    $html .= '<a class="cart-icon__cartlink" href="'.$link.'"></a>';
	    $html .= '<div class="cart-icon__icon">';

	    $html .= icon('basket',false);
	    $html .= '<div class="cart-icon__count'.$cart_count_class.'">';
	    $html .= $cart_count;
	    $html .= '</div>';

	    $html .= '</div>';

	    $html .= '<div class="cart-icon__goods'.$cart_count_class.'">';
	    $html .= $cart_goods;
	    $html .= $summ;
	    $html .= '</div>';

	    $html .= '</div>';

        return $html;
    }
function ajax_cart_icon()
    {
        $return['html'] = get_cart_icon();
        $return['status'] = 0;
        echo json_encode($return);
        wp_die();
    }
function get_cart_summ($cart)
    {
        $summ = 0;
        if(!empty($cart)){

	        foreach ( $cart as $item ) {
		        $price = get_product_price($item['product_id']);
		        $price = ( empty($price) || $price == 0 ) ? 0 : $price;
		        $summ += ($price*$item['qty']);
	        }
        }

        return $summ;
    }
function send_message($type,$order)
    {
	    $admin_email = 'snab.gbi1@mail.ru';
        $title = ($type == 'client') ? 'Информация по вашему заказу на сайте pro-ss.ru' : 'На сайте pro-ss.ru сделали заказ' ;
	    $to = ($type == 'client') ? $order['client']['email'] : $admin_email ;
        $subject = ($type == 'client') ? '[ЗАКАЗ] Ваш заказ на сайте pro-ss.ru' : '[ЗАКАЗ] На сайте pro-ss.ru сделали заказ';



	    $html = '<table style="border:none;">
    <tr>
        <td><h1>'.$title.'</h1></td>
    </tr>
    <tr>
        <td><h2>Заказ № '.$order['order']['post_title'].'</h2></td>
    </tr>
    <tr>
        <td>
            <table style="border-collapse: collapse;">
                <tr>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Изображение</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Название и категория</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Цена</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Кол-во</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Сумма</td>
                </tr>';
	    foreach ( $order['cart'] as  $product_id => $item ) {
	        $img_url = get_the_post_thumbnail_url($product_id,'thumbnail');
		    $html .= '<tr style="border:1px solid #aaa;">
                    <td style="text-align: center; padding:5px 10px;"><img src="'.$img_url.'" style="width:100%; max-width:150px;" alt=""></td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_name($product_id).'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_price_html($item['price']).'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.$item['qty'].'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_price_html($item['summ']).'</td>
                </tr>';

	    }
        $html.= '</table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Итого:</td>
                    <td><p style="font-size:1.75em;">'.get_product_price_html($order['order']['total']).'</p></td>
                </tr>
                <tr>
                    <td>PIN-код заказа:</td>
                    <td>'.$order['order']['pin'].'</td>
                </tr>
                <tr>
                    <td>Cсылка на заказ:</td>
                    <td>'.$order['order']['link'].'</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><h3>Контактные данные</h3></td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Имя</td>
                    <td>'.$order['client']['name'].'</td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td>'.$order['client']['tel'].'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>'.$order['client']['email'].'</td>
                </tr>
                <tr>
                    <td>Сообщение: </td>
                    <td>'.$order['client']['message'].'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

	    return _mail('wordpress@pro-ss.ru', $to, $subject, $html);
    }
function _mail ($from, $to, $subj, $what)
    {
        return mail($to, $subj, $what,
            "Mime-Version: 1.0\n".
            "Date: ".date('r')."\n".
            "From: $from\n".
            "Reply-To: $from\n".
            "Content-type: text/html; charset=utf-8\n".
            "Content-Transfer-Encoding: 8bit"
        );
    }

function get_order($order_id,$pin)
    {
        $pin_check = get_field('pin',$order_id);
        if($pin_check !== $pin)
            {
                return 'pin_error';
            }
	    $order['order']['post_title'] = get_the_title($order_id);
	    $order['client']['name'] = get_field('имя_клиента',$order_id);
	    $order['client']['tel'] = get_field('телефон_клиента',$order_id);
	    $order['client']['email'] = get_field('email_клиента',$order_id);
	    $order['client']['message'] = get_field('комментарий_клента',$order_id);
	    $order['cart'] = get_field('что_заказано',$order_id);
	    $order['order']['total'] = 0;
	    $html = '<table style="border:none;">
    <tr>
        <td><h1>'.$title.'</h1></td>
    </tr>
    <tr>
        <td><h2>Заказ № '.$order['order']['post_title'].'</h2></td>
    </tr>
    <tr>
        <td>
            <table style="border-collapse: collapse;">
                <tr>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Изображение</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Название и категория</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Цена</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Кол-во</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">Сумма</td>
                </tr>';
	    foreach ( $order['cart'] as  $item ) {
		    $img_url = get_the_post_thumbnail_url($item['изделие'],'thumbnail');
		    $html .= '<tr style="border:1px solid #aaa;">
                    <td style="text-align: center; padding:5px 10px;"><img src="'.$img_url.'" style="width:100%; max-width:150px;" alt=""></td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_name($item['изделие']).'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_price_html(($item['стоимость']/$item['количество'])).'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.$item['количество'].'</td>
                    <td style="text-align: center; padding:5px 10px;border:1px solid #aaa;">'.get_product_price_html($item['стоимость']).'</td>
                </tr>';
		    $order['order']['total'] += $item['стоимость'];
	    }
	    $html.= '</table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Итого:</td>
                    <td><p style="font-size:1.75em;">'.get_product_price_html($order['order']['total']).'</p></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><h3>Контактные данные</h3></td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Имя</td>
                    <td>'.$order['client']['name'].'</td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td>'.$order['client']['tel'].'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>'.$order['client']['email'].'</td>
                </tr>
                <tr>
                    <td>Сообщение: </td>
                    <td>'.$order['client']['message'].'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

	    return $html;
    }

function ajax_get_order() {
	$order_id = $_POST['order_id'];
	$pin = $_POST['pin'];
	$return['html'] = get_order($order_id,$pin);
	$return['status'] = 0;

	if($return['html'] == 'pin_error')
        {
	        $return['status'] = 'error';
	        $return['html'] = 'Не верный пин-код заказа';
        }
	echo json_encode($return);
	wp_die();

}
function is_prices_active(){
	return get_field('включить_цены_для_всех_товаров','options');
}