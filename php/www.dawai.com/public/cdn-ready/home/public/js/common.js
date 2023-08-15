$(function(){
	$(document).on('click','.dawai-right-tools ul li span',function(){
		var tval = $(this).attr('data-href');
		var tos = $(tval).offset().top;
		$('body').animate({scrollTop:tos},1000);
	});
	$(document).on('click','.btn-backtop',function(){
		$('body').animate({scrollTop:0},1000);
	});
});