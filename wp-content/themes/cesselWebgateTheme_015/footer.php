<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.5
 */
?>
</div>
<footer>
    <div class="container">
        <div class="inner">
            <div class="footer__blockLine">
                <div class="footer__block">
                    <?
                    $has_socials = get_field('соцсети_в_подвале','options');
                    if ($has_socials) { ?>
                        <div class="footer__title">
                            Мы в соцсетях
                        </div>
                        <div class="footer__line footer__line--socials">
                        <?
                        $socials = get_field('соцсети','options');
                        foreach ( $socials as $social ) {
                            echo "<a href='".$social['ссылка']."' title='".$social['заголовок']."'>";
                            icon($social['код_иконки']);
                            echo "</a>";
                        }
                        ?>
                    </div>
                    <? } ?>
			        <? dynamic_sidebar( 'footer-left-sidebar' ); ?>
                </div>
                <div class="footer__block">
			        <? dynamic_sidebar( 'footer-center-sidebar' ); ?>
                </div>
                <div class="footer__block footer__block--contacts">
			        <? dynamic_sidebar( 'footer-right-sidebar' ); ?>
                </div>
            </div>
            <div class="footer__blockLine footer__blockLine--copyrights">
                <div class="footer__block w100">
			        <? dynamic_sidebar( 'footer-bottom-sidebar' ); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<?php get_template_part('modals'); ?>
<? echo get_field('дополнительный_скрипты_для_сайта','options'); ?>
<script>wpcf7.cached = 0;</script>
</body>
</html>