<?php
/**
 * Template name: Корзина
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 23.02.2019
 * Time: 21:38
 */
get_header(); ?>

	<section class='page cart'>
		<div class='container'>
			<div class='inner'>
				<?php if( have_posts() ){while(have_posts()){the_post(); ?>

					<h1><?php the_title(); ?></h1>
					<div class="cart__text">
						<? the_content(); ?>
					</div>
					<div class="cart__content">

						<? if(get_cart_count()>0){the_cart_header();} ?>
						<div class='cart-data'>
							<div class='cart-data__inner'>
							</div>
						</div>
								<? //the_cart_lines(); ?>
						<? the_cart_footer(); ?>
						<? the_order_form(); ?>
					</div>

				<?php }} else echo "<h2>Записей нет.</h2>";?>
			</div>
		</div>
	</section>

<?php get_footer(); ?>