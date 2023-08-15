<?php

class Index2Action extends Action {

		public function header(){
				$this->display();
    }

    public function index(){

				$www['is_delete'] = 0;
				$list = M('news2')->where($www)->order('news_date desc')->limit('0,4')->select();
				$this->assign('news',$list);
				$this->display('Index2/index');
		}

    public function news(){

				if($_POST['keyword']){
					$www['title'] = array('like','%'.$_POST['keyword'].'%');
					$this->assign('keyword',$_POST['keyword']);
				}
				$www['is_delete'] = 0;
				$list = M('news2')->where($www)->order('news_date desc')->select();
				$this->assign('list',$list);
				$this->display();
		}
		
    public function news_detail(){

				$www['id'] = $_GET['id'];
				$www['is_delete'] = 0;
				$info = M('news2')->where($www)->find();
				$this->assign('info',$info);
				$this->display();
		}
	
    public function about_us(){
				$this->display();
		}

    public function products(){
				$this->display();
		}

    public function partners(){
				$this->display();
		}

    public function honors(){
				$this->display();
		}

    public function jobs(){
				$this->display();
		}

    public function jobs_2(){
				$this->display('jobs-2');
		}


	
}