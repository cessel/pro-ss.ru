$(document).ready(function()
{try{refresh_cart('.cart-data__inner');$('.js--order-form').submit(function(e){e.preventDefault();var form=$(this);if(form.data('token')!==undefined)
{order_form(form);}});$(".product_viewlist").on('click',function(e)
{$('.product_viewlist').removeClass('active');$(this).addClass('active');var view_type=$(this).data('view_type');var product__inner=$(".products__inner");if(view_type==='list'){product__inner.removeClass('large');product__inner.addClass('list');}
else if(view_type==='large'){product__inner.removeClass('list');product__inner.addClass('large');$('.product-card__attr').show();}});$(".attributes__title").click(function()
{$(this).closest('.product-card__inner').find('.product-card__attr').toggle();});$('.main-content').on('click','.product-buy__minus',function(e)
{var curr_qty_dom=$(this).closest('.product-buy__qty').find('.product-buy__number');var curr_qty=curr_qty_dom.find('input').val();if(curr_qty>1){curr_qty--;curr_qty_dom.find('input').val(curr_qty);$('.single .product-card__buy').data('incart',curr_qty);curr_qty_dom.find('input').change();}});$('.main-content').on('click','.product-buy__plus',function(e)
{var curr_qty_dom=$(this).closest('.product-buy__qty').find('.product-buy__number');var curr_qty=curr_qty_dom.find('input').val();curr_qty++;curr_qty_dom.find('input').val(curr_qty);$('.single .product-card__buy').data('incart',curr_qty);curr_qty_dom.find('input').change();});$('.main-content .cart').on('change','input[name="product-buy__number"]',function(e)
{var curr_qty=$(this).val();var curr_price_dom=$(this).closest('.js--product-item').find('.js--price .price');var curr_summ=$(this).closest('.js--product-item').find('.js--summ .price');if(typeof curr_price_dom.data('current_price')==='number')
{if(curr_qty<1){curr_qty=1;$(this).val(1)}
var curr_price=curr_price_dom.data('current_price');curr_summ.html(curr_qty*curr_price);}
update_total();var product_id=$(this).closest('.js--product-item').data('product_id');try{update_qty(product_id,curr_qty);}
catch(e){console.log(e);}});$('.js--refresh-cart').click(function(e)
{$('input[name="product-buy__number"]').change();refresh_cart('.cart-data__inner');});$('.js--clear-cart').click(function(e)
{clear_cart();});$('.product-card__buy').click(function(e)
{try{var body=$('body');if(!(body.hasClass('loading'))){var button=$(this);var incart=button.data('incart');console.log(incart);if((+incart)===0){button.html('В корзине');button.addClass('added');button.data('incart',(+incart+1));add_to_cart(button.data('product'));}
else if($(this).hasClass('added')){location.href='/cart/';}
else{update_qty(button.data('product'),incart);}}}
catch(e){console.log(e);}});$('.added').click(function(e)
{e.preventDefault();location.href='/cart/';});$('.main-content').on('click','.remove_from_cart',function(e)
{try{var body=$('body');if(!(body.hasClass('loading'))){var button=$(this);var product_id=button.data('product_id');button.closest('.js--product-item').remove();remove_from_cart(product_id);console.log(product_id);}}
catch(e){console.log(e);}});$('#one_click-single').on('shown.bs.modal',function(event)
{var button=$(event.relatedTarget);var product_card=button.closest('.inner');var product_url=location.href;var product_fullname=product_card.find('h1 span').html();var product_price=product_card.find('.product-buy__price').text();var send_form=$(this).find('form');var form_product_name=send_form.find('#product_name');var form_product_url=send_form.find('#product_url');var form_product_price=send_form.find('#product_price');form_product_name.val(product_fullname);form_product_url.val(product_url);form_product_price.val(product_price);console.log(product_fullname+' '+product_price+' '+product_url);});$('#order-single').on('shown.bs.modal',function(event)
{var button=$(event.relatedTarget);var product_url=location.href;var product_card=button.closest('.inner');var product_fullname=product_card.find('h1 span').html();var product_price=product_card.find('.product-buy__price').text();var product_qty=product_card.find('.product-buy__number').html();var send_form=$(this).find('form');var form_product_name=send_form.find('#product_name');var form_product_url=send_form.find('#product_url');var form_product_price=send_form.find('#product_price');var form_product_qty=send_form.find('#product_qty');form_product_name.val(product_fullname);form_product_url.val(product_url);form_product_price.val(product_price);form_product_qty.val(product_qty);$('.site-form__line--orderdata').html('<h3>'+product_fullname+' '+product_price+' - '+product_qty+'шт.</h3>');console.log('<h3>'+product_fullname+' '+product_price+' - '+product_qty+'шт.</h3>'+product_url);});$('.menu-item-has-children>a').on('click',function(e)
{if($('html').hasClass('mobile')||$('html').hasClass('tablet'))
{}
e.preventDefault();$(this).closest('li').find('.sub-menu').toggleClass('show');});$('.menu-item-has-children').on('mouseleave',function(e)
{e.preventDefault();if(!$('html').hasClass('mobile')&&!$('html').hasClass('tablet'))
{$(this).closest('li').find('.sub-menu').removeClass('show');}});$('.menu-item-has-children').on('mouseenter',function(e)
{e.preventDefault();if(!$('html').hasClass('mobile')&&!$('html').hasClass('tablet'))
{}});setTimeout(function()
{var preloader=$(".preloader");preloader.fadeOut();},500);$('.js--mobile-menu').click(function(e)
{$('.nav-mobile').toggleClass('show');});$('#main-banner').owlCarousel({autoplay:true,loop:true,margin:0,nav:false,dots:true,responsive:{0:{items:1},600:{items:1},1000:{items:1}}});}
catch(e){consle.log(e);}});'use strict';function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}
r(function(){if(!document.getElementsByClassName){var getElementsByClassName=function(node,classname){var a=[];var re=new RegExp('(^| )'+classname+'( |$)');var els=node.getElementsByTagName("*");for(var i=0,j=els.length;i<j;i++)
if(re.test(els[i].className))a.push(els[i]);return a;}
var videos=getElementsByClassName(document.body,"youtube");}else{var videos=document.getElementsByClassName("youtube");}
var nb_videos=videos.length;for(var i=0;i<nb_videos;i++){videos[i].style.backgroundImage='url(https://i.ytimg.com/vi/'+videos[i].id+'/sddefault.jpg)';var play=document.createElement("div");play.setAttribute("class","play");videos[i].appendChild(play);videos[i].onclick=function(){var iframe=document.createElement("iframe");var iframe_url="https://www.youtube.com/embed/"+this.id+"?autoplay=1&autohide=1";if(this.getAttribute("data-params"))iframe_url+='&'+this.getAttribute("data-params");iframe.setAttribute("src",iframe_url);iframe.setAttribute("frameborder",'0');iframe.style.width=this.style.width;iframe.style.height=this.style.height;this.parentNode.replaceChild(iframe,this);}}});$(window).scroll(function(){var header=$('header');var header_offset=header.height()-50;var current_offset=$(this).scrollTop();if(current_offset>header_offset){header.addClass('shrink');}
else{header.removeClass('shrink');}});$(window).resize(function(){var header=$('header');$(".main-content").css('margin-top',header.outerHeight());});var spinner=$('.ymap-container').children('.loader');var check_if_load=false;var myMapTemp,myPlacemarkTemp;function init(){var map_id='map-yandex';var lat=$("#"+map_id).data('lat');var long=$("#"+map_id).data('long');var siteName=$("#"+map_id).data('firm');var adress=$("#"+map_id).data('adress');var myMapTemp=new ymaps.Map(map_id,{center:[lat,long],zoom:15,controls:['zoomControl','fullscreenControl']},{fullscreenControlFloat:'left'});myMapTemp.behaviors.disable('scrollZoom');var myPlacemark=new ymaps.Placemark([lat,long],{hintContent:siteName,balloonContent:siteName+" - "+adress});myMapTemp.geoObjects.add(myPlacemark);var layer=myMapTemp.layers.get(0).get(0);waitForTilesLoad(layer).then(function(){var spinner=$('.ymap-container').children('.loader');spinner.removeClass('is-active');$('.ymap-container').removeClass('blur');});}
function waitForTilesLoad(layer){return new ymaps.vow.Promise(function(resolve,reject){var tc=getTileContainer(layer),readyAll=true;tc.tiles.each(function(tile,number){if(!tile.isReady()){readyAll=false;}});if(readyAll){resolve();}else{tc.events.once("ready",function(){resolve();});}});}
function getTileContainer(layer){for(var k in layer){if(layer.hasOwnProperty(k)){if(layer[k]instanceof ymaps.layer.tileContainer.CanvasContainer||layer[k]instanceof ymaps.layer.tileContainer.DomContainer){return layer[k];}}}
return null;}
function loadScript(url,callback){var script=document.createElement("script");if(script.readyState){script.onreadystatechange=function(){if(script.readyState=="loaded"||script.readyState=="complete"){script.onreadystatechange=null;callback();}};}else{script.onload=function(){callback();};}
script.src=url;document.getElementsByTagName("head")[0].appendChild(script);}
var ymap=function(){$(window).scroll(function(){var trigger_container=$('.sert').offset().top-500;var current_offset=$(this).scrollTop();if(($("div").is(".ymap-container"))&&$(this).scrollTop()>trigger_container){if(!check_if_load){console.log('MAP LOADING START!');check_if_load=true;var spinner=$('.ymap-container').children('.loader');spinner.addClass('is-active');loadScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;loadByRequire=1",function(){ymaps.load(init);});}}});};$(function(){ymap();});function remove_from_cart(product_id)
{try{var body=$('body');if(!(body.hasClass('loading'))){var incart_arr=get_cart();Cookies.remove('incart');var j=0;var new_incart_data_arr=[];incart_arr.forEach(function(id,i){console.log("id: "+id.product_id+" === "+product_id);if(+id.product_id!==+product_id&&id.product_id!==''&&id.product_id!=='null'&&id.product_id!==null){new_incart_data_arr[j++]=incart_arr[i];}});var new_incart_data=JSON.stringify(new_incart_data_arr);Cookies.set('incart',new_incart_data);incart_arr=get_cart();if(incart_arr.length===0){console.log('nothing');refresh_cart('.cart-data__inner');}
refresh_cart_icon();}}
catch(e){console.log(e);}}
function add_to_cart(product_id)
{try{var body=$('body');if(!(body.hasClass('loading'))){console.log('Product ID '+product_id+': Added to cart!');var flag=true;var incart_arr=get_cart();Cookies.remove('incart');var qty=0;incart_arr.forEach(function(id,i){if(+id.product_id===+product_id){flag=false;qty=+id.qty++;incart_arr[i].qty=qty;}});if(flag){qty=1;incart_arr.push({'product_id':product_id,'qty':qty});}
var new_product_data=JSON.stringify(incart_arr);Cookies.set('incart',new_product_data);}
refresh_cart_icon();}
catch(e){console.log(e);}}
function get_cart()
{var cookie_data=Cookies.get('incart');var cookie_data_arr=[];console.log(cookie_data);if((cookie_data!==undefined)&&cookie_data!=='')
{cookie_data_arr=JSON.parse(cookie_data);console.log(cookie_data_arr);}
return cookie_data_arr;}
function refresh_cart(selector)
{try{var body=$('body');if(!(body.hasClass('loading')))
{body.addClass('loading');var spinner="<i class='icon-spin icon-2x animate-spin'></i>";var result_block=$(selector);result_block.html(spinner);var data={action:'get_cart_data'};$.post('/wp-admin/admin-ajax.php',data,function(result)
{body.removeClass('loading');var result_json=JSON.parse(result);if(result_json.status==="0")
{result_block.html(result_json.html);if(result_json.summ!==0){$('.cart-footer__total').html('Сумма заказа: '+result_json.summ);}}
else if(result_json.status==='empty')
{result_block.html(result_json.html);$('.cart-header').html('');$('.cart-footer').html('');$('.js--order-form').html('');refresh_cart_icon();}
else
{result_block.html("Ошибка: "+result_json.error+" Сообщение об ошибке: "+result_json.message);}
console.log('Cart reloaded!');result_block.find('i.animate-spin').remove();});}}
catch(e){console.log(e);}}
function order_form(selector)
{try{var body=$('body');if(!(body.hasClass('loading')))
{body.addClass('loading');var spinner="<i class='icon-spin icon-2x animate-spin'></i>";var result_block=selector.find('.form-response');result_block.html(spinner);var data={};data.form=selector.serializeArray();var flag=0;data.form.forEach(function(item,i)
{if(item.name!=='form-message'&&item.value==''){$('#'+item.name).addClass('is-invalid');flag++;}
else{$('#'+item.name).removeClass('is-invalid').addClass('is-valid');}});if(flag!==0){result_block.html('<p class="text-danger">Заполните обязательные поля</p>');body.removeClass('loading');return false;}
var cart=get_cart();if(cart.length==0)
{refresh_cart('.cart-data__inner');body.removeClass('loading');return false;}
data.action='send_order';data.token=selector.data('token');console.log(data);$.post('/wp-admin/admin-ajax.php',data,function(result)
{body.removeClass('loading');var result_json=JSON.parse(result);if(result_json.status===0)
{result_block.html(result_json.html);clear_cart();}
else
{result_block.html("Ошибка: "+result_json.error+" Сообщение об ошибке: "+result_json.message);}
console.log(result);console.log('Order send!');result_block.find('i.animate-spin').remove();});}}
catch(e){console.log(e);}}
function clear_cart()
{Cookies.remove('incart');refresh_cart('.cart-data__inner');refresh_cart_icon();}
function refresh_cart_icon()
{try{var body=$('body');if(!(body.hasClass('loading')))
{body.addClass('loading');var spinner="<i class='icon-spin icon-2x animate-spin'></i>";var result_block=$('.js--cart-icon');result_block.html(spinner);var data={action:'cart_icon'};$.post('/wp-admin/admin-ajax.php',data,function(result)
{$('.product-buy__qty div').prop('disabled',false);body.removeClass('loading');var result_json=JSON.parse(result);if(result_json.status===0)
{result_block.html(result_json.html);}
console.log('Cart reloaded!');result_block.find('i.animate-spin').remove();});}}
catch(e){console.log(e);}}
function update_qty(product_id,qty)
{try{$('.product-buy__qty div').prop('disabled',true);var body=$('body');if(!(body.hasClass('loading'))){console.log('Product ID '+product_id+': Added to cart!');var flag=true;var incart_arr=get_cart();Cookies.remove('incart');incart_arr.forEach(function(id,i){if(+id.product_id===+product_id){flag=false;incart_arr[i].qty=qty;}});if(flag){incart_arr.push({'product_id':product_id,'qty':qty});}
var new_product_data=JSON.stringify(incart_arr);Cookies.set('incart',new_product_data);}
refresh_cart_icon();}
catch(e){console.log(e);}}
function update_total()
{var summas=$('.js--summ');var total=0;summas.each(function(i,summ)
{console.log(summ);total+=+$(summ).find('.price').html();});if(total!==0)
{total=total+' '+summas.eq(0).text().split(' ')[1];}
$('.cart-footer__total').html('Сумма заказа: '+total);};