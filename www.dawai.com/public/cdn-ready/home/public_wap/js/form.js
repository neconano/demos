$(function(){
	//发送验证码
	$('body').on('click','.send-yzm',function(){
		var wait=60;  
		timeOut();  
		function timeOut(){  
   		 if(wait === 0){  
      	    $('.send-yzm').removeAttr('disabled');
			$('.send-yzm').val("重发验证码");
   		 }else{                    
		 	$('.send-yzm').attr('disabled','disabled');
       		 setTimeout(function(){  
       		     wait--;  
        	    $('.send-yzm').val(wait+" S");  
        	    timeOut();  
       		 },1000);
   		 }  
		}  
	});
    //清除提示
    $(document).on('input','.form-input-wrap .input-area input',function(){
        $(this).parent().find('i').removeClass('active');
    });
});