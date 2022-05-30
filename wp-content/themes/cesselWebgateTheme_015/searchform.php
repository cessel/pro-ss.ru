<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 30.11.2018
 * Time: 16:29
 */

$s = (isset($_GET['s']) && !empty($_GET['s'])) ? $_GET['s'] : '';

?>

<div class="searchform">
    <div class="searchform__line">
        <form action="/" class="searchform__form" method="get">
            <div class="searchform__input">
                <input type="text" id="s" name="s" value="<? echo $s; ?>" placeholder="Введите ваш запрос">
            </div>
            <div class="searchform__button">
                <button type="submit"><? icon('search');?> </button>
            </div>
        </form>
    </div>
</div>