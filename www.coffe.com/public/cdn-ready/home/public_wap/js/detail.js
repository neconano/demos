$(function(){
	var mySwiper = new Swiper ('.swiper-container-detail1', {
		loop: false,
        paginationClickable: true,
		pagination: '.swiper-pagination-detail1',
		paginationBulletRender: function (swiper, index, className) {
			var content = ['课程介绍','课程安排','常见问题'];
            return '<span class="' + className + '">' + content[index] + '</span>';
        }
    });
	var mySwiper = new Swiper ('.swiper-container-detail2', {
		loop: false,
        paginationClickable: true,
		pagination: '.swiper-pagination-detail2',
		paginationBulletRender: function (swiper, index, className) {
			var content = ['在线课程','线下课程'];
            return '<span class="' + className + '">' + content[index] + '</span>';
        }
    });
	$(document).on('click','.dawai-detail-tab .detail2-content .content-header',function(){
		$(this).toggleClass('active');
		$(this).parent().find('.content-list').slideToggle();
	});
	$(document).on('scroll',function(){
		var pt = $('.dawai-detail-tab').offset().top;
		var bt = $('body').scrollTop();
		if(pt < bt){
			$('.swiper-pagination-detail1').addClass('active');
		}else{
			$('.swiper-pagination-detail1').removeClass('active');
		}
	});
	$(document).on('click','.swiper-pagination-bullet',function(){
		var pt = $('.dawai-detail-tab').offset().top;
		$('body').animate({scrollTop:pt},1000);
	});
});