<?php
// 本类由系统自动生成，仅供测试用途
class Root2Action extends Action {

	public function _initialize(){
		B('Authenticate', $action);
	}
	
    public function index(){
		$this->display();
    }
	
    public function edit(){
		$news = D("news");
		if($_POST){
			$d['id'] = $_POST['id'];
			$d['title'] = $_POST['title'];
			$d['content'] = $_POST['content'];
			$n =$news->mycreate($d);
			if($n)
				myalert('修改成功');
			else
				myalert('修改失败');
		}else{
			$id = $_REQUEST['id'];
			$n =$news->where("`id` = '$id'")->find();
			$this->assign('new',$n);
			$this->display();
		}
    }
	
    public function daohang(){
		$this->display();
    }
	
    public function editpassword(){
		if($_POST['password']){
			if($_POST['password'] != $_POST['re_password'] ){
				myalert('两次密码不同');
			}
			$m_user = M('user');
			$d['password'] = md5(md5($_POST['password']));
			$m_user->where("`user_id` = 1")->save($d);
			myalert('修改成功');
		}
		
		$this->display();
    }
	
	
	
	
}