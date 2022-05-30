<?php
/**
 * Created by PhpStorm.
 * User: cesse
 * Date: 11.10.2017
 * Time: 19:03
 */

// ------------------------------------------------------------------
// Вешаем все блоки, поля и опции на хук admin_init
// ------------------------------------------------------------------
//
add_action( 'admin_init', 'eg_settings_api_init' );
function eg_settings_api_init() {
	// Добавляем блок опций на базовую страницу "Чтение"
	add_settings_section(
		'eg_setting_section', // секция
		'Настройки темы Cessel\'s WEBGate Theme',
		'eg_setting_section_callback_function',
		'general' // страница
	);

	// Добавляем поля опций. Указываем название, описание,
	// функцию выводящую html код поля опции.
	add_settings_field(
		'option_phone',
		'Контактный телефон сайта',
		'eg_setting_callback_function', // можно указать ''
		'general', // страница
		'eg_setting_section' // секция
	);
	add_settings_field(
		'option_adress',
		'Адрес компании',
		'eg_setting_callback_function2',
		'general', // страница
		'eg_setting_section' // секция
	);

	// Регистрируем опции, чтобы они сохранялись при отправке
	// $_POST параметров и чтобы callback функции опций выводили их значение.
	register_setting( 'general', 'option_phone' );
	register_setting( 'general', 'option_adress' );
}

// ------------------------------------------------------------------
// Сallback функция для секции
// ------------------------------------------------------------------
//
// Функция срабатывает в начале секции, если не нужно выводить
// никакой текст или делать что-то еще до того как выводить опции,
// то функцию можно не использовать для этого укажите '' в третьем
// параметре add_settings_section
//
function eg_setting_section_callback_function() {
	echo '<p>Необязательные но нужные настройки отображения темы</p>';
}

// ------------------------------------------------------------------
// Callback функции выводящие HTML код опций
// ------------------------------------------------------------------
//
// Создаем input теги
//
function eg_setting_callback_function() {
	echo '<input 
		name="option_phone"  
		type="text" 
		value="' . get_option( 'option_phone' ) . '" 
		class="code2"
	 />';
}
function eg_setting_callback_function2() {
	echo '<input 
		name="option_adress"  
		type="text" 
		value="' . get_option( 'option_adress' ) . '" 
		class="code2"
	 />';
}