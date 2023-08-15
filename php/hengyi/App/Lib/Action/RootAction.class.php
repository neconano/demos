<?php
// 本类由系统自动生成，仅供测试用途
class RootAction extends Action {

	public function _initialize(){
		B('Authenticate', $action);
	}
	
    public function index(){
		if($_POST['keyword']){
			$www['title'] = array('like','%'.$_POST['keyword'].'%');
			$this->assign('keyword',$_POST['keyword']);
		}
		$www['is_delete'] = 0;
		$list = D("news2")->where($www)->order('id desc')->select();
		$this->assign('list',$list);
		$this->display('index');
	}
		
    public function add(){
		if($_POST){
			$data = $_POST;
			// $i=0;
			// foreach($data as $k=> $v){
			// 	$data_t[$k] = addslashes($v);
			// 	$i ++;
			// }
			// $data = $data_t;
			$res = $this->uploadInfos('/news');
			$data['content'] = stripslashes($data['content']);
			if($data['id']){
				$www['id'] = $data['id'];
				if($res['url']){
						$data['face_img'] = $res['url'];
						$bak = D("news2")->where($www)->find();
						unlink($bak['face_img']);
				}
				D("news2")->where($www)->save($data);
				redirect(U('Root/add','id='.$data['id']));
			}
			$data['face_img'] = $res['url'];
			$data['date_line'] = time();
			$id = D("news2")->add($data);

			redirect(U('Root/add','id='.$id));
		}
		if($_GET['id']){
			$www['id'] = $_GET['id'];
			$data = D("news2")->where($www)->find($data);
		}else{
			$data['seo_keywords'] = "大连恒宜,恒宜,恒宜科技,大连恒宜科技有限公司";
			$data['seo_description'] = "大连恒宜科技有限公司主要从事面向行业的物联网应用软件产品开发，公司拥有一支不断进取的科研开发和服务团队，与大连理工大学、吉林大学合作建立了‘物联网应用及行业软件研发实验室’，开发了适合国内用户需求特点、具有自主知识产权的‘恒宜’系列产品。";
		}
		$this->assign('new',$data);
		$this->display('news_add');
	}

    public function remove(){
		if($_GET['id']){
				$www['id'] = $_GET['id'];
				$data['is_delete'] = 1;
				D("news2")->where($www)->save($data);
				redirect(U('Root/Index'));
		}
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
	
	
    // 上传文件
    public function uploadInfos($dir = null){
		$re['status'] = false;
		if(!$dir){
				$re['msg'] = '没有指定地址';
				return $re;
		}
		// import('Think.ORG.Net.UploadFile');
		import('ORG.Net.UploadFile');
		// import('Common.Lib.Net.UploadFile');
		$upload = new \UploadFile();
		$upload->maxSize = "3145728";//设置附件上传大小
		$upload->allowExts = array("jpg","gif","png","jpeg");//设置附件上传类型
		$upload->savePath = "./Uploads/".$dir.'/';//设置上传目录
		$upload->thumb = true; // 使用对上传图片进行缩略图处理
		$upload->thumbType = 0; // 缩略图生成方式 1 按设置大小截取 0 按原图等比例缩略
		$thumbPrefix = 'thumb_';
		$upload->thumbPrefix = $thumbPrefix; // 缩略图前缀
		$upload->thumbRemoveOrigin = true; // 是否移除原图
		$upload->thumbMaxWidth = '40,2000';
		$upload->thumbMaxHeight = '30,2000';
		if (!is_dir($upload->savePath))
				mkdir($upload->savePath, 0777, true);
		if ($upload->upload()) {
				$info = $upload->getUploadFileInfo();
				$dat['name'] = $info[0]['savename'];
		}
		if(!$dat['name']){
				$re['msg'] = $upload->getErrorMsg();
				return $re;
		}
		$re['status'] = true;
		$re['url'] = $upload->savePath.$thumbPrefix.$dat['name'];
		return $re;
	} 

}