<?php 

class AuthenticateBehavior extends Behavior {
	protected $options = array();
	
	public function run(&$params) {
		if(intval(cookie('user_id')) != 0 && trim(cookie('name')) != ''){
			$user = M('user')->where(array('user_id' => intval(cookie('user_id'))))->find();
			session('name', $user['name']);
			session('user_id', $user['user_id']);
		} else {
			myalert('请先登录...', U('User/login'));
		}
	}
}