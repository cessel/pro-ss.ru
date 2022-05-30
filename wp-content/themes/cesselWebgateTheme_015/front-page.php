<?php
/**
 * Template name: Главная страница
 * Created by PhpStorm.
 * User: cesse
 * Date: 27.10.2017
 * Time: 13:38
 */

get_header(); ?>

<?
if(get_field('показывать_баннер',$post->ID))
    {
        $banner['data'] = get_field('баннер',$post->ID);
        $banner['id'] = 'main-banner';
        ?>
        <!-- BANNER SECTION -->

        <div class="banner">
            <div class="inner">
                <? echo generate_owl_from_array($banner); ?>
            </div>
        </div>
        <!-- END BANNER SECTION -->
<? } ?>

<?
if(get_field('показывать_блок_хиты_продаж',$post->ID))
{
     /* НАСТРОЙКИ ДЛЯ БЛОКА "ХИТЫ ПРОДАЖ" */?>
    <? $bestsellers_title = get_field('заголовок_блока_хиты_продаж',$post->ID); ?>
    <?
    $bestsellers_array = get_field('товары_для_блока_хиты_продаж');
    /*echo "<!--";
    var_dump($bestsellers_array);
    echo "-->";*/
    $ids = array();
    if(!$bestsellers_array)
    {
        $bestsellers_array = array();
        $ids = array();
    }
    foreach ($bestsellers_array as $bestsellers_obj)
    {
        $ids[] = $bestsellers_obj->ID;
    }
    $bestsellers_ids = implode(',',$ids);
    ?>
    <? $bestsellers_allbuton_text = get_field('надпись_на_кнопке_после_блока_хиты_продаж',$post->ID); ?>
    <? $bestsellers_allbuton_url = get_field('cсылка_с_кнопки_в_блоке_хиты_продаж',$post->ID); ?>

        <!-- BESTSELLES SECTION -->
        <section class='bestsellers' id="bestsellers">
            <div class="container">
                <div class="inner">
                    <div class="bestsellers__title">
                        <p class='products-title'><? echo $bestsellers_title; ?></p>
                    </div>
                    <div class="bestsellers__products">
                        <? get_bestsellers($bestsellers_array); ?>
                    </div>
                    <div class="bestsellers__allbutton">
                        <a href="<? echo $bestsellers_allbuton_url; ?>" class="site-btn">
                            <? echo $bestsellers_allbuton_text ; ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- END BESTSELLES SECTION -->
<? } ?>


<?
if(get_field('показывать_блок_мы_в_цифрах',$post->ID))
{
 /* НАСТРОЙКИ ДЛЯ БЛОКА "МЫ В ЦИФРАХ" */?>
<?
$whymes = get_field('мы_в_цифрах',$post->ID);
$whyme_title = array();
$whyme_text = array();
foreach($whymes as $whyme)
{
	$whyme_title[] = $whyme['цифра'];
	$whyme_text[] = $whyme['описание'];
}
?>

    <!-- WHY ME SECTION -->
    <div class="whyme">
        <div class="container">
            <div class="inner">
	            <?
	            for($t=0;$t<count($whyme_title);$t++)
	            {
		            ?>
                    <div class="whyme__item">
                        <p class="whyme__title"><? echo $whyme_title[$t]; ?></p>
                        <div class="whyme__text"><? echo apply_filters('the_content',$whyme_text[$t]); ?></div>
                    </div>
		            <?
	            }
	            ?>
            </div>
        </div>
    </div>
    <!-- END WHY ME SECTION -->
<? } ?>

<?
if(get_field('показывать_блок_производство',$post->ID))
{

$making_title = get_field('заголовок_блока_производство',$post->ID);

$making_text = get_field('текст_для_бока_поизводство',$post->ID);

//$making_video_url = get_field('ссылка_на_видео_youtube_производство',$post->ID);
//$making_video_id = explode('/',$making_video_url);
$making_image_url = wp_get_attachment_image_url(get_field('ссылка_на_фото_производство',$post->ID),'large');

?>
    <!-- MAKING SECTION -->
    <div class="making">
        <div class="container">
            <div class="inner">
                <div class="making__title">
                    <p class="products-title"><? echo $making_title; ?></p>
                </div>
                <div class="making__video">
					<? //show_youtube_video($making_video_id[count($making_video_id)-1]); ?>
                    <img src="<? echo $making_image_url; ?>" alt="<? bloginfo('name') ?> - Наше производство">
                </div>
                <div class="making__text">
                    <? echo apply_filters('the_content',$making_text); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAKING SECTION -->
<? } ?>


<?
if(get_field('показывать_блок_продукция',$post->ID))
{

    /* НАСТРОЙКИ ДЛЯ БЛОКА КАТЕГОРИЙ */?>
<? $products_title = get_field('заголовок_блока_продукция',$post->ID); ?>

    <!-- PRODUCTS SECTION -->
    <div id="product" class="products">
        <div class="container">
            <div class="inner">
                <div class="products__title">
                    <p class="products-title"><? echo $products_title; ?></p>
                </div>
                <div class="products__goods">
					<? echo get_goods_categories(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PRODUCTS SECTION -->
<? } ?>

<?
if(get_field('показывать_блок_сертификаты',$post->ID))
{

 /* НАСТРОЙКИ ДЛЯ БЛОКА СЕРТИФИКАТЫ */?>
<? $sertificats_title = get_field('заголовок_блока_сертификаты',$post->ID); ?>
<? $sertificats_subtitle = get_field('подзаголовок_блока_сертификаты',$post->ID); ?>
<?

$sertificats = get_field('cертификаты',$post->ID);
$sertificats = (!empty($sertificats)) ? $sertificats : array();
$sert_img = array();
$sert_img_min = array();
foreach($sertificats as $sertificat)
{
	$sert_img[] = wp_get_attachment_image_url($sertificat['фото_сертификата'],'large');
	$sert_img_min[] = wp_get_attachment_image_url($sertificat['фото_сертификата'],'medium');
}
?>

    <!-- SERTIFICATE SECTION -->
    <div class="sert">
        <div class="container">
            <div class="inner">
                <p class="sert-title products-title"><? echo $sertificats_title; ?></p>
                <div class="sert_items">
					<? for($i=0;$i<count($sert_img);$i++)
					{   ?>
                        <div class="sert_item">
                            <a href="<? echo $sert_img[$i]; ?>" class="strip" data-strip-group="serts">
                                <img src="<? echo $sert_img_min[$i]; ?>" class="lazyload" alt="<? bloginfo('name')?> - <? echo $sertificats_title; ?>">
                            </a>
                        </div>
					<?  } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END SERTIFICATE SECTION -->
<? } ?>


<? /* НАСТРОЙКИ ДЛЯ КАРТЫ */?>
<? $lattitude = get_field('широта','options'); ?>
<? $longtitude = get_field('долгота','options'); ?>
<? $adress = get_field('адрес','options'); ?>
<? $firm = get_field('название_фирмы','options'); ?>

    <!-- MAP SECTION -->
    <div class="ymap-container blur">
        <div class="loader loader-default"></div>
        <div id="map-yandex" data-firm="<? echo $firm; ?>" data-adress="<? echo $adress; ?>" data-lat="<? echo $lattitude; ?>" data-long="<? echo $longtitude; ?>"></div>
    </div><!-- .ymap-container -->
    <!-- END MAP SECTION -->


<? get_footer(); ?>