<? /* TOPMENU */ ?>

<section class="topmenu">

	<? /* FOR DESKTOP */ ?>

	<div class="container d-none d-xl-block">
		<div class="inner">
			<? if(is_super_admin()){ ?>
				<div class="topmenu__loginBlock">
					<a href="/wp-admin/"><? icon('login'); ?></a>
				</div>
			<? } ?>
			<div class="topmenu__adressBlock">
				<? icon('location'); ?>
				<div class="topmenu__adress">
					<? echo get_option('option_adress'); ?>
				</div>
			</div>
			<div class="topmenu__phonesBlock">
				<div class="topmenu__phoneBlock active">
					<? icon('phone'); ?>
					<div class="topmenu__phone">
						<? echo get_option('option_phone'); ?>
					</div>
				</div>
				<div class="topmenu__phoneBlock active">
					<? icon('phone'); ?>
					<div class="topmenu__phone">
						<? echo get_option('option_phone2'); ?>
					</div>
				</div>
			</div>
		</div>

    </div>
    <div class="lg-chat-block d-none d-xl-flex">
        <div class="topmenu__chatBlock">
		    <? icon('skype'); ?>
            <div class="topmenu__chat">
			    <? skype_convert_to_link(get_option('option_phone3')); ?>
            </div>

        </div>
        <div class="topmenu__loginBlock">
            <div class="topmenu__loginBlockInner">
			    <? wp_loginout(); ?>
            </div>
        </div>
    </div>

	<? /* FOR TABLET */ ?>

	<div class="container d-none d-sm-none d-md-block d-lg-block d-xl-none">
		<div class="inner mobile">
			<div class="topmenu__menubars">
				<div class="hamburger" id="hamburger-1">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</div>
			</div>
		</div>
	</div>

	<? /* FOR SMARTPHONES */ ?>

	<div class="container d-block d-md-none">
		<div class="inner mobile">
			<div class="topmenu__mobileLogo">
				<a href="<? echo home_url(); ?>"><? logo(); ?></a>
			</div>
			<div class="topmenu__chatBlock">
				<? icon('skype'); ?>
				<div class="topmenu__chat">
					<? skype_convert_to_link(get_option('option_phone3')); ?>
				</div>
			</div>
			<div class="topmenu__menubars">
				<div class="hamburger" id="hamburger-1">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</div>
			</div>
		</div>
	</div>

</section>


<? /* MOBILE MENU */ ?>

<section class="mobile__menu">
	<div class="mobile__logo">
		<? logo(); ?>
	</div>
	<? wp_nav_menu(array('menu'=>'main-menu','menu_class'=>'mobile-menu')); ?>
	<div class="mobile__productSearch">
		<? get_product_search_form(); ?>
	</div>
	<div class="mobile__line">
		<? phone_convert_to_link(get_option('option_phone'),'site-btn mobile','Позвонить в магазин'); ?>
	</div>
	<div class="mobile__line">
		Наш адрес: <? echo get_option('option_adress'); ?>
	</div>
	<div class="close">
		<div class="hamburger" id="hamburger-1">
			<span class="line"></span>
			<span class="line"></span>
			<span class="line"></span>
		</div>
	</div>
</section>

<? /* END TOPMENU */ ?>