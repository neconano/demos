<?php
// 鏈被鐢辩郴缁熻嚜鍔ㄧ敓鎴愶紝浠呬緵娴嬭瘯鐢ㄩ€?
class IndexAction extends Action {
    public function index(){
		A('Index2')->index();
		// redirect(U('Index2/index'));
		// redirect('index.html');
		// $this->display();
    }
	
    public function chanpin(){
		$news = D("news");
		$id = $_REQUEST['id'];
		$n =$news->where("`id` = '$id'")->find();
		$this->assign('new',$n);
		$this->display();
    }
	
    public function job(){
		$news = D("news");
		$n =$news->where("`id` = '8'")->find();
		$id = $_REQUEST['id'];
		$n =$news->where("`id` = '$id'")->find();
		$this->assign('new',$n);
		$this->display();
    }
	
    public function about(){
		$news = D("news");
		$n =$news->where("`id` = '9'")->find();
		$id = $_REQUEST['id'];
		$n =$news->where("`id` = '$id'")->find();
		$this->assign('new',$n);
		$this->display();
    }
	
    public function law(){
		$news = D("news");
		$n =$news->where("`id` = '10'")->find();
		$id = $_REQUEST['id'];
		$n =$news->where("`id` = '$id'")->find();
		$this->assign('new',$n);
		$this->display();
    }
	
    public function contact(){
		$news = D("news");
		$n =$news->where("`id` = '11'")->find();
		$id = $_REQUEST['id'];
		$n =$news->where("`id` = '$id'")->find();
		$this->assign('new',$n);
		$this->display();
    }
	
}