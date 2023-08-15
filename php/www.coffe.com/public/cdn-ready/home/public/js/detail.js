$(function(){
	var mySwiper = new Swiper ('.swiper-container-teacher', {
    loop: false,
    nextButton: '.swiper-button-next-teacher',
    prevButton: '.swiper-button-prev-teacher',
	slidesPerView: 3
    });
	$(document).on('click','span[data-tab]',function(){
		var tval = $(this).attr('data-tab');
		var at = $('.dawai-detail-wrap').offset().top;
		$('span[data-tab='+tval+']').addClass('active').siblings().removeClass('active');
		$('div[data-tabarea='+tval+']').addClass('active').siblings().removeClass('active');
		$('body').animate({scrollTop:at},1000);
	});
	$(document).on('scroll',function(){
		var bt = $('body').scrollTop();
		var tt = $('.dawai-detail-wrap .tab-btnarea').offset().top;
		if((bt-tt) > 50){
			$('.info-fixed-nav').addClass('active');
		}else{
			$('.info-fixed-nav').removeClass('active');
		}
		if(bt > 450){
			$('.detail-right-tools .btn-backtop').addClass('active');
		}else{
			$('.detail-right-tools .btn-backtop').removeClass('active');
		}
	});
	$(document).on('click','.dawai-detail-wrap .left .content-area .second-content .content-wrap .content-header',function(){
		$(this).toggleClass('active');
		$(this).parent().find('.content-list').slideToggle();
	});
	$(document).on('click','span[data-stab]',function(){
		var tval = $(this).attr('data-stab');
		$('span[data-stab='+tval+']').addClass('active').siblings().removeClass('active');
		$('div[data-stabarea='+tval+']').addClass('active').siblings().removeClass('active');
	});
});