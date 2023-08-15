$(function(){
	var mySwiper = new Swiper ('.swiper-container-banner', {
		loop: false,
		nextButton: '.swiper-button-next-banner',
		prevButton: '.swiper-button-prev-banner',
		pagination: '.swiper-pagination',
		paginationClickable: true,
		autoplay : 4000
    });
	var mySwiper = new Swiper ('.swiper-container-index', {
		loop: false,
		nextButton: '.swiper-button-next-index',
		prevButton: '.swiper-button-prev-index',
		slidesPerView: 4,
		slidesPerGroup : 4,
        paginationClickable: true,
        spaceBetween: 30
    });
	var mySwiper = new Swiper ('.swiper-container-index2', {
		loop: false,
		nextButton: '.swiper-button-next-index2',
		prevButton: '.swiper-button-prev-index2',
		slidesPerView: 4,
		slidesPerGroup : 4,
        paginationClickable: true,
        spaceBetween: 30
    });
	$(".index-lb").PicCarousel("init");
});