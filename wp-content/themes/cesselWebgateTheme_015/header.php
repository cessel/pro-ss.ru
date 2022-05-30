<?php
/**
 * The Header template for our theme
 *
 *
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.5
 */
?><!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_015/css/icons/css/fontello.css">
    <link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_015/css/icons/css/animation.css">
    <style>.preloader{top:0;bottom:0;left:0;right:0;position:fixed;display:flex; z-index:99999; align-items:center;align-content:center;justify-content:center;background-color:#fff;font-size:5em;}.preloader i{color:#537791;}body{overflow:hidden;}</style>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php wp_title(); ?></title>
	<?php wp_site_icon(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="preloader"><i class="icon-spin icon-2x animate-spin"></i></div>
<header>
    <div class="container">
        <div class="inner">
            <div class="logo"><? logo(); ?></div>
            <div class="menu">
                <div class="menu__toggle js--mobile-menu"><? icon('menu'); ?></div>
            </div>
            <div class="phones">
                <div class="phones__line">
                    <?
                    $phones = get_field('телефоны','options');
                    foreach ( $phones as $phone ) {
	                     icon('phone'); ?>
                        <? phone_convert_to_link($phone['номер_телефона']);
                        echo "<br>";
                    }
                    ?>
                </div>
                <div class="phones__line phones__line--adress">
			       <? icon('map'); ?> <? the_field('адрес','options'); ?>
                </div>
                <div class="workhours">
                    <? $workhours = get_field('часы_работы','options');?>
                    <? if(!empty($workhours)) { ?>
                    <? } ?>
                </div>
            </div>

            <div class="buttons">
                <a href="#modal-callback" class="callback-btn site-btn" data-toggle="modal" data-target="#modal-callback">Заказать звонок</a>
	            <? get_search_form(); ?>
		        <? phone_convert_to_link(get_field('телефон','options'),'site-btn call-btn','позвонить'); ?>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <div class="inner">
	            <? //wp_nav_menu(array('menu'=>'main-menu','menu_class'=>'nav nav-pills main-menu')); ?>
	            <? wp_nav_menu(array('theme_location'=>'top','menu'=>'','menu_class'=>'nav nav-pills main-menu')); ?>
                <div class="cart-icon js--cart-icon">
                    <? echo get_cart_icon(); ?>
                </div>
            </div>
        </div>
    </nav>

</header>
<div class="nav-mobile d-flex d-xl-none">
    <div class="logo">
        <? logo('footer'); ?>
    </div>
    <nav>
		<? wp_nav_menu(array('menu'=>'main_menu','menu_class'=>'nav nav-pills mobile-menu')); ?>
    </nav>
    <div class="bars js--mobile-menu">
		<? icon('close'); ?>
    </div>
    <div class="phones">
        <div class="phones__line">
			<?                     foreach ( $phones as $phone ) {
				?>
				<? phone_convert_to_link($phone['номер_телефона']);
				echo "<br>";
			}
			?>
        </div>
    </div>
    <div class="buttons">
		<? phone_convert_to_link(get_field('телефон','options'),'site-btn','позвонить'); ?>
    </div>

</div>
<div class="main-content">
    <? if ( function_exists('yoast_breadcrumb') && (!is_home() && ! is_front_page()) ) { ?>
    <div class="container">
        <div class="inner">
            <div class="breadcrumbs">
		        <?php yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); ?>
            </div>
        </div>
    </div>
    <? } ?>