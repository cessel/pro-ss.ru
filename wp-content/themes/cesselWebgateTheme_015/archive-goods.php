<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 06.12.2018
 * Time: 19:38
 */

get_header(); ?>
<?php
/**
 * @var $post WP_Post
 * @var $cat WP_Term
 */



$goods_title = "Каталог продукции";
//$page_html = ($wp_query->max_num_pages > 1)? ' - страница '.$page : '';
$page_html = (get_query_var('paged')) ? ' - страница '.get_query_var('paged') : '';
$page_cats_hide = (get_query_var('paged')) ? ' hide' : '';
$category_html = get_goods_categories();
?>


    <div class="goods">
    <div class="container">
        <div class="inner">
            <div class="goods__title">
                <h1><?php echo apply_filters('the_title','Категория '.$cat->name).$page_html; ?></h1>
            </div>
            <div class="goods__description">
				<?php echo apply_filters('the_content',$cat->description); ?>
            </div>
            <div class="goods__categories<?php echo $page_cats_hide; ?>">
				<?php echo $category_html; ?>
            </div>
			<?php if(!$category_html){ ?>
                <div class="products">
                    <div class="products__viewtype">
                        <div class="product_viewlist " data-view_type="large"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                        <div class="product_viewlist active" data-view_type="list"><i class="fa fa-th-list" aria-hidden="true"></i></div>
                    </div>
                    <div class="products__inner list">
						<?php if( have_posts() ){while(have_posts()){the_post();

							get_product($post);

						}} else echo "<h2>Записей нет.</h2>";?>
                    </div>
                </div>
                <div class="goods__pagination">
					<?php echo  paginate_links(); ?>
                </div>
			<?php } ?>
        </div>
    </div>
    </div><?php get_footer(); ?>