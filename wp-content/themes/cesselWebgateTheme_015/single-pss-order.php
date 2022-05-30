<?php
/**
 * The page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1
 */

get_header(); ?>

<section class='page'>
	<div class='container'>
		<div class='inner'>
				<?php if( have_posts() ){while(have_posts()){the_post(); ?>
						
					<h1><?php the_title(); ?></h1>
                    <div class="page__img">
                        <? the_post_thumbnail('full'); ?>
                    </div>
                    <div class="page__content js--order-pin">
                        <h3>Для просмотра параметров заказа введите пин-код из вашего письма о подтверждении заказа</h3>
                        <form id="pin-form" class="site-form" data-order_id="<? echo $post->ID; ?>">
                            <div class="site-form__line">
                                <input class="site-form__input" type="number" name="pin" value="">
                            </div>
                            <div class="site-form__line">
                                <input type="submit" class="site-btn site-form__input site-form__input--submit"  value="Посмотреть данные о заказе">
                            </div>
                        </form>
                        <div class="order-pin__error"></div>
                    </div>

				<?php }} else echo "<h2>Записей нет.</h2>";?>
		</div>
	</div>
</section>

<?php get_footer(); ?>