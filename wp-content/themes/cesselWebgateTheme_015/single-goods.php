<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 06.12.2018
 * Time: 20:48
 */
get_header(); ?>
<?

global $post;
$thumbs = get_field('Фото товара',$post->ID);
$thumbs = (is_array($thumbs)) ? $thumbs: array();
$cat = get_the_terms($post->ID,'goods_cat')[0]->name;

?>
	<div class='singlegoods'>
		<div class='container'>
			<div class='inner'>
				<?php if( have_posts() ){while(have_posts()){the_post(); ?>
					<div class="singlegoods__title"><h1><? /* Купить <span><? echo $cat; ?> */?><? the_title(); ?></span></h1></div>
					<div class="singlegoods__content">
						<div class="singlegoods__images">
							<div class="singlegoods__mainimage">
								<a href="<? echo get_the_post_thumbnail_url($post->ID,'full'); ?>">
									<img src="<? echo get_the_post_thumbnail_url($post->ID,'large'); ?>" alt="Купить <? the_title(); ?>">
								</a>
							</div>
							<div class="singlegoods__thumbs">
								<a class="selected js--change-foto" href="<? echo get_the_post_thumbnail_url($post->ID,'full'); ?>">
									<img src="<? echo get_the_post_thumbnail_url($post->ID,'large'); ?>" alt="Купить <? the_title(); ?>">
								</a>
								<? foreach ( $thumbs as $thumb ) {
									if($thumb['фото']) {
										?>
                                        <a class="js--change-foto" href="<? echo wp_get_attachment_image_url( $thumb['фото'], 'full' ); ?>">
                                            <img src="<? echo wp_get_attachment_image_url( $thumb['фото'], 'thumbnail' ); ?>"
                                                 alt="Купить <? the_title(); ?>">
                                        </a>
										<?
									}
								} ?>
							</div>
						</div>
						<div class="singlegoods__data">
							<div class="singlegoods__shortdesc">
								<? the_content(); ?>
							</div>
							<div class="singlegoods__attr">
								<? echo get_attributes($post->ID); ?>
							</div>
							<div class="singlegoods__buy">
								<? echo get_single_product_buy($post->ID); ?>
							</div>
						</div>
					</div>
					<div class="singlegoods__fulldesc">
						<?php //the_content(); ?>
					</div>




				<?php }} else echo "<h2>Записей нет.</h2>";?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>