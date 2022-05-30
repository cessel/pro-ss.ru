<?php
/**
 * Created by PhpStorm.
 * User: cesse
 * Date: 27.10.2017
 * Time: 13:38
 */

get_header(); ?>


    <div class="category">
        <div class="container">
            <div class="inner">

                <h1 class='category__title'>Результаты поиска</h1>

                <div class="category__wrapper">
					<?php  if( have_posts() ){while(have_posts()){the_post(); ?>

						<?
                            $cat = get_the_terms($post->ID,'goods_cat');
                            $moretext = (has_term('', 'goods_cat')) ? "Посмотреть цены" : "Подробнее...";
                            $cat_name = ($cat)? $cat[0]->name : get_the_category($post->ID)[0]->cat_name;

						if(has_excerpt())
                            {
                                $content = get_the_excerpt($post->ID);
                            }
						else
                            {
                                $content = wp_trim_words($post->post_content,55);
                            }

						?>

                        <div class="category__item">
                            <div class="category__itemImg"><img src="<? echo get_the_post_thumbnail_url($post->ID,'thumbnail'); ?>" alt=""></div>
                            <div class="category__itemContent">
                                <div class="category__itemTitle">
                                    <h2><a href="<? echo get_post_permalink($post->ID); ?>"><? the_title(); ?></a></h2>
                                </div>
                                <div class="category__itemExcerpt">
                                    <div class="category__itemCategory">
                                        <h3><? echo $cat_name; ?></h3>
                                    </div>
                                    <? echo $content; ?>
                                </div>
                                <div class="category__itemMoreBtn">
                                    <a class='site-btn' href="<? echo get_post_permalink($post->ID); ?>"><? echo $moretext; ?></a>
                                </div>
                            </div>
                        </div>



					<? }} else echo "<h2>Записей нет.</h2>";?>



                </div>
                <div class="goods__pagination">
		            <?php echo  paginate_links(); ?>
                </div>

            </div>
        </div>
    </div>






<? get_footer();?>