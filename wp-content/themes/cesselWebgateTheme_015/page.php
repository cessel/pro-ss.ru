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
                    <div class="page__content">
	                    <?php the_content(); ?>
                    </div>

						
				<?php }} else echo "<h2>Записей нет.</h2>";?>
		</div>
	</div>
</section>

<?php get_footer(); ?>