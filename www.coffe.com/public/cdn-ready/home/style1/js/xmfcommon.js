var domain = window.location.host;
var basePath = "";
function GetRequest() {   
   var url = location.search; //获取url中"?"符后的字串   
   var theRequest = new Object();   
   if (url.indexOf("?") != -1) {   
      var str = url.substr(1);   
      strs = str.split("&");   
      for(var i = 0; i < strs.length; i ++) {   
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);   
      }   
   }   
   return theRequest;   
}

function setXmfCookie(){
 	var exp = new Date(); 
	var value = "xmf"+exp.getTime();
	setCookie("xmfCommonCookie", value, 864000);
}

getXmfCookie();
function getXmfCookie(){
	var Cookieval = getCookie("xmfCommonCookie");
	if(isEmpty(Cookieval)){//为空则创建cookie
		setXmfCookie();
	}
 	return Cookieval;
}

/**
 * 判断非空
 * 
 * @param val
 * @returns {Boolean}
 */
function isEmpty(val) {
	val = $.trim(val);
	if (val == null)
		return true;
	if (val == undefined || val == 'undefined')
		return true;
	if (val == "")
		return true;
	if (val.length == 0)
		return true;
	if (!/[^(^\s*)|(\s*$)]/.test(val))
		return true;
	return false;
}

/*手机*/
function is_cellphoneNum(str)
{
    var regExp = /^(\+86)?(13|18|15)\d{9}(?!\d)$/;
    return regExp.test(str);
}

 

//判断用户是否已登录
function loginCheck(){
	var token = getJwtToken();
	if(isEmpty(token)){
		var loc = window.location;
		//设置重新登录之前的url
 		setLoGoOutURL(loc);
		window.location.href = "xmf_login.html";
		return false;
	}
	return true;
} 


//验证码倒计时
var fs = parseInt(getComputedStyle(window.document.documentElement)["font-size"]);
var countdown=60;
function settime(obj) {
    if (countdown == 0) {   
        obj.removeAttribute("disabled");      
        obj.value="获取验证码";   
        countdown = 60;
        obj.style.cursor="pointer"
        return;  
    } else {   
        obj.setAttribute("disabled", true);   
        obj.value="重新发送(" + countdown + ")";   
        countdown--;   
        obj.style.cursor="auto"
    }   
setTimeout(function() {   
    settime(obj) }  
    ,1000)
}

$(function(){
	//计算切换的宽度
	var w1 = 0
	var $lis = $(".c-slideTop ul").children("li");
	console.log($lis.length)
	$lis.each(function(){
		w1 += $(this).width();
	});
	$(".c-slideTop ul").css("width",w1);
	//切换
	$(".c-slide li").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
	});
	//多选
	$(".c-slide2 li").click(function(){
		if($(this).hasClass("active")){
			$(this).removeClass("active");
		}else{
			$(this).addClass("active");
		}
	});
	//关闭所有弹窗
	$(".c-close").click(function(){
		layer.closeAll();
	})
    //子菜单
	$(".c-09personCenter .mc li").click(function(){
		if($(this).hasClass("active")){
			$(this).removeClass("active");
			$(this).children("dl").slideUp();
		}else{
			$(this).addClass("active");
			$(this).children("dl").slideDown();
		}
	});
	
	$(".c-new_3_1 .mt .c-search").bind('input propertychange', function() {
		if($(".c-new_3_1 .mt .c-search input").val().length>0){
			$(".c-new_3_1 .mt .c-search .c-cha").show();
		}else{
			$(".c-new_3_1 .mt .c-search .c-cha").hide();
		}
	});
	$(".c-new_3_1 .mt .c-search .c-cha").click(function(){
		$(this).siblings("input").val("");
	});
	$(".c-new_3_1 .mc .c-slide li").click(function(){
		$(".c-new_3_1 .mb").hide();
		$(".c-new_3_1 .mb").eq($(this).index()).show();
		
	});
})



/*密码格式*/
function is_password(str){ 
    var regExp = /^(?=.*[a-zA-Z])(?=.*[\d]).{6,16}$/;
    return regExp.test(str);
}


function is_vliUsername(str){
    var regExp = /^[\u4e00-\u9fa5_a-zA-Z0-9]+$/;
    return regExp.test(str);
}


function isNotEmpty(val) {
	return !isEmpty(val);
}

var TOKEN_KEY = "jwtToken";
var LOGOOUT_KEY = "logooutKey";

//取值
function getJwtToken() {
    return localStorage.getItem(TOKEN_KEY);
}

//保存
function setJwtToken(token) {
    localStorage.setItem(TOKEN_KEY, token);
}

//删除
function removeJwtToken() {
    localStorage.removeItem(TOKEN_KEY);
}

//登录之前的页面取值
function getLoGoOutURL() {
    return localStorage.getItem(LOGOOUT_KEY);
}

//登录之前的页面保存
function setLoGoOutURL(token) {
    localStorage.setItem(LOGOOUT_KEY, token);
}

//登录之前的页面删除
function removeLoGoOutURL() {
    localStorage.removeItem(LOGOOUT_KEY);
}
 
//验证码
function invokeSettime(obj) {
	var countdown = 60;
	settime(obj);
	function settime(obj) {
		if (countdown == 0) {
			$(obj).attr("disabled", false);
			$(obj).text("获取验证码");
			countdown = 60;
			$(obj).css({"cursor":"pointer"});
			return;
		} else {
			$(obj).attr("disabled", true);
			$(obj).text("(" + countdown + ") s后重新发送");
			countdown--;
			$(obj).css({"cursor":"auto"});
		}
		setTimeout(function() {
			settime(obj)
		}, 1000)
	}
}

//验证码[注册使用]
function invokeSettime(obj) {
	var countdown = 60;
	settime(obj);
	function settime(obj) {
		if (countdown == 0) {
			$(obj).attr("disabled", false);
			$(obj).text("获取验证码");
			countdown = 60;
			$(obj).css({"cursor":"pointer"});
			return;
		} else {
			$(obj).attr("disabled", true);
			$(obj).text("(" + countdown + ") s后重新发送");
			countdown--;
			$(obj).css({"cursor":"auto"});
		}
		setTimeout(function() {
			settime(obj)
		}, 1000)
	}
}

function GetRequest() {   
   var url = location.search; //获取url中"?"符后的字串   
   var theRequest = new Object();   
   if (url.indexOf("?") != -1) {   
      var str = url.substr(1);   
      strs = str.split("&");   
      for(var i = 0; i < strs.length; i ++) {   
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);   
      }   
   }   
   return theRequest;   
}

//统一ajax拦截
var ajaxTimeout = null;
$.wdbAjax = {
    request: function (options, dataJson) {
        var opts = $.extend({}, {
            limit: true, before: function () {
            }, error: function () {

            }, callback: function (data) {

            }, ajaxmethod:"post"
        }, options);
        var _url = opts.url;
        if (isEmpty(_url)) {
            _url = basePath + "/" + opts.model + "/" + opts.method;
        }
        if (isNotEmpty(opts.params)) {
            _url += "&" + opts.params;
        }

        if (opts.limit) {
            clearTimeout(ajaxTimeout);
            ajaxTimeout = setTimeout(function () {
                $.wdbAjax.ajaxMain(opts, _url, dataJson);
            }, 200);
        } else {
            $.wdbAjax.ajaxMain(opts, _url, dataJson);
        }
    },
    ajaxMain: function (opts, _url, dataJson) {
        $.ajax({
            type: opts.ajaxmethod,
            data: dataJson,
            url: _url,
            beforeSend: function () {
                opts.before();
            },
            error: function () {
                opts.error();
                clearTimeout(ajaxTimeout);
            },
            success: function (data) {
            	if(data.code == "99"){
      				//重新登录删除token
      				removeJwtToken();
      				window.location.href = "10login.html";
       			} else {
                    if (opts.callback) opts.callback(data);
                }
                clearTimeout(ajaxTimeout);
            }
        });
    }
};
 
function setCookie(name, value, liveMinutes) {  
	if (liveMinutes == undefined || liveMinutes == null) {
		liveMinutes = 60 * 2;
	}
	if (typeof (liveMinutes) != 'number') {
		liveMinutes = 60 * 2;//默认120分钟
	}
	var minutes = liveMinutes * 60 * 1000;
	var exp = new Date();
	exp.setTime(exp.getTime() + minutes + 8 * 3600 * 1000);
	//path=/表示全站有效，而不是当前页
	document.cookie = name + "=" + value + ";path=/;expires=" + exp.toUTCString();
}

//读取cookies 
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
} 

function myCenter(){
	localStorage.setItem("xmfyuming", window.location.host); //把当前资源主的域名存进session中
	var token = getJwtToken();
 	if(!isEmpty(token)){//用户已登录
   		var userInfoAnction = basePath+"/xmfUser/userInfo";
   		var callback = function(data){
      			if(data.code == "88"){
   					// $(".foot_nav #myCenter").attr("href","xmf_personCenter1.html");
   					window.location.href="xmf_personCenter.html";
     			} else if(data.code == "99"){
     				//重新登录删除token
     				removeJwtToken();
      			}
   			}
		$.post(userInfoAnction,{"token":token},callback);
   	}else{
   		removeLoGoOutURL();
     	setLoGoOutURL("xmf_personCenter.html");
   		// $(".foot_nav #myCenter").attr("href","xmf_login.html");
   		window.location.href="xmf_login.html";
   	}
}

