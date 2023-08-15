<?php
namespace app\common\model;

/**
 * 课程
 * 
 */
class DwCourseLesson extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'dw_course_lesson';


    /**
     * 自动验证规则
     * 
     */
     protected $_validate = array(
        array('title','require','标题必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,1024', '标题长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('description','require','课程描叙必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('feature','require','课程特色必须选择', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('category','require','课程分类必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('lesson_type','require','授课方式必须选择', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
     );
    

    public function do_add($data)
    {
        $res['status'] = false;
        $data['feature']=implode(',',$data['feature']);
        $data['category']=$data['category'].','.$data['erjiradio'];
        $data['lesson_type']=implode(',',$data['lesson_type']);
        $data['teacher']=implode(',',$data['teacher']);
        
        $create = $this->create($data);
        if(!$create){
            $res['msg'] = $this->getError();
            return $res;
        }       
        if($data['id']){
            $info=$this->save($data);
        }else{
            $data['create_time']=time();
            $info=$this->add();
        }
        if ($info){
            $res['status'] = true;
            $res['msg'] = '新增成功';
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
        
    }

    // 获得数据
    public function do_get($id=''){
        $feature = \think\Db::table('dw_course_feature')->field('id,title')->where('status','=',1)->select();
        $feature = make_k_v_array($feature,'id','title');
        $teacher = \think\Db::table('dw_teacher')->field('id,title')->where('status','=',1)->select();
        $teacher = make_k_v_array($teacher,'id','title');

        if($id){
            $w['id'] = $id;
            $info = D2('DwCourseLesson')->where($w)->find();
            $info['feature'] = explode(',',$info['feature']);
            $category = explode(',',$info['category']);
            $info['category'] = $category;
            $info['lesson_type'] =explode(',',$info['lesson_type']);
            $info['teacher'] =explode(',',$info['teacher']);
        }
        $res['feature'] = $feature;
        $res['teacher'] = $teacher;
        $res['info'] = $info;
        return $res;
    }
    





}
