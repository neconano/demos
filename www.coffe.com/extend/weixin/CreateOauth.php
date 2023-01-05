<?php
namespace weixin;

class CreateOauth {

	protected $appid;		//公众平台AppID
	protected $appsecret;	//公众平台AppSecret;
	protected $curl_timeout;	//CRUL超时时间 默认30S
	protected $code;			//Oauth认证 回调Code
	protected $flag;			//Oauth认证的模式
								//false-->不弹出授权页面，直接跳转，只能获取用户openid
								//true-->弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息
	protected $access_token;

	public function __construct ($appid = '', $appsecret = '', $curl_timeout = 30, $flag = false) {
		if ($appid == '' || $appsecret == '') {
			return false;
		}
		$this->appid = $appid;
		$this->appsecret = $appsecret;
		$this->curl_timeout = $curl_timeout;
		$this->flag = $flag;
	}

	/**
	 * 作用：生成可以获得code的url
	 */
	public function createOauthUrlForCode ($redirectUrl = '') {
		if ($redirectUrl == '') return false;
		$urlObj['appid'] = $this->appid;
		$urlObj['redirect_uri'] = urlencode($redirectUrl);
		$urlObj['response_type'] = 'code';

		if ($this->flag) {
			$urlObj["scope"] = "snsapi_userinfo"; //弹出授权页面
		} else {
			$urlObj["scope"] = "snsapi_base";	//不弹出授权页面
		}

		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->formatPara($urlObj);
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?'.$bizString;
		return $url;
	}

	/**
	 * 作用：生成可以获得openid的url
	 */
	public function createOauthUrlForOpenid () {
		$urlObj["appid"] = $this->appid;
		$urlObj["secret"] = $this->appsecret;
		$urlObj["code"] = $this->code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->formatPara($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}

	/**
	 * 作用：生成可以获得用户详细信息的URL
	 */
	public function createUrlForUserInfo () {
		$urlObj["access_token"] = $this->access_token;
		$urlObj["openid"] = $this->openid;
		$urlObj["lang"] = 'zh_CN ';
		$bizString = $this->formatPara($urlObj);
		return "https://api.weixin.qq.com/sns/userinfo?".$bizString;
	}

	/**
	 * 作用：设置code
	 */
	public function setCode ($code_) {
		$this->code = $code_;
	}

	/**
	 * 作用：设置code
	 */
	public function getFlag () {
		return $this->flag;
	}

	/**
	 * 作用：通过curl向微信提交code，以获取openid  类型为snsapi_base 到此结束
	 */
	public function getOpenid () {
		$url = $this->createOauthUrlForOpenid();
		//初始化curl
       	$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//运行curl，结果以jason形式返回
        $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->openid = $data['openid'];
		$this->access_token = $data['access_token'];
		return $this->openid;
	}

	/**
	 * 作用：通过curl获取用户信息 类型为snsapi_userinfo调用
	 */
	public function getUserInfo () {
		$this->getOpenid();
		$url = $this->createUrlForUserInfo();
		//初始化curl
       	$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//运行curl，结果以jason形式返回
        $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		return $data;
	}


	/**
	 * 作用：生成参数
	 */
	protected function formatPara ($paraMap) {
		$buff = '';
		foreach ($paraMap as $k => $v) {
			$buff .= $k . '=' . $v . '&';
		}
		$reqPar = '';
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
}

