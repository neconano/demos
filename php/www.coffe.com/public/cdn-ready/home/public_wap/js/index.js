$(function(){
	var mySwiper = new Swiper ('.swiper-container-banner', {
		loop: false,
		nextButton: '.swiper-button-next-banner',
		prevButton: '.swiper-button-prev-banner',
		pagination: '.swiper-pagination-banner',
		paginationClickable: true
    });
	var mySwiper = new Swiper ('.swiper-container-index', {
		loop: false,
		nextButton: '.swiper-button-next-index',
		prevButton: '.swiper-button-prev-index',
		slidesPerView: 2,
		slidesPerColumn: 2,
		slidesPerGroup : 4,
        spaceBetween: 12
    });
	var mySwiper = new Swiper ('.swiper-container-index2', {
		loop: false,
		nextButton: '.swiper-button-next-index2',
		prevButton: '.swiper-button-prev-index2',
		slidesPerView: 2,
		slidesPerColumn: 2,
		slidesPerGroup : 4,
        paginationClickable: true,
        spaceBetween: 12
    });
	var mySwiper = new Swiper ('.swiper-container-index3', {
		loop: false,
		nextButton: '.swiper-button-next-index3',
		prevButton: '.swiper-button-prev-index3',
        paginationClickable: true,
		pagination: '.swiper-pagination',
    });
});