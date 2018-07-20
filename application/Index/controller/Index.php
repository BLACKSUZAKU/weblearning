<?php
namespace app\index\controller;

use app\admin\model\Type;
use app\index\model\Lesson;
use app\index\model\Student;
use app\index\model\Teacher;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Controller{

    public function _empty(){
        $this->redirect('index/index');
    }

    public function index(){
        $lesson=new Lesson();
//        $data=$lesson->field(['createtime','updatetime'],true)->select();
        $data=Db::table('lesson')
            ->alias('a')
            ->join('type t','a.tid=t.tid')
            ->paginate(8,true);
        $type=Type::all();
        $this->assign('type',$type);
        $this->assign('lesson',$data);

//        Session::set('studentid',1);
//        return json_encode($data);
        return $this->fetch('index/index');
    }

    public function tLesson(){
        $tid=input('param.tid');
        $data=Db::table('lesson')->alias('a')->join('type t','a.tid=t.tid')->where('a.tid',$tid)->paginate(8,true);
//        $data=Lesson::where('tid',$tid)->select();
        $type=Type::all();
        $this->assign('type',$type);
        $this->assign('lesson',$data);
        return $this->fetch('index/index');
    }

    public function login(){
        $user=input('param.');
        $user['password']=md5($user['password']);
        $re=Student::where($user)->find();
        if($re){
            Session::set('studentid',$re['sid']);
            Session::set('username',$re['studentname']);
            Session::set('portrait',$re['pic']);
            $this->redirect('index/index');
        }else{
            Session::flash('loginError','登录失败');
            $this->redirect('index/index');
        }
//        dump($user);
//        dump($re);
    }

    public function tlogin(){
        $user=input('param.');
        $user['password']=md5($user['password']);
        $re=Teacher::where($user)->find();
        if($re){
            Session::set('teacherid',$re['teacherId']);
            Session::set('username',$re['teachername']);
            Session::set('portrait',$re['pic']);
//            $this->success('登录成功','index/index',1);
            $this->redirect('index/index');
        }else{
            Session::flash('loginError','登录失败');
//            $this->redirect('index/index');
            $this->success('登录失败','index/index',1);
        }
//        dump($user);
//        dump($re);
    }

    public function logout(){
        Session::delete('studentid');
        Session::delete('studentname');
        Session::delete('teacherid');
        $this->redirect('index/index');
//        dump($user);
    }

    public function search(){
        $search_str=input('key');
//        $search_str='基础';
        $data['lessonname']=array('like', "%$search_str%");
        $lesson=Db::table('lesson')->alias('a')->join('type t','a.tid=t.tid')->where($data)->paginate(10,true);
        $this->assign('lesson',$lesson);
        $type=Type::all();
        $this->assign('type',$type);
//        Session::set('studentid',1);
//        return json_encode($data);
        return $this->fetch('index/index');
//        dump($lesson);
    }

    public function sReg(){
        $data=request()->post();
        $file = request()->file('pic');
        $stu=new Student();
        $users = Student::where('studentname',$data['studentname'])->count();
        //查询是否存在该用户名
        if($users){
            $date=[
                'status'=>1,
                'msg'=>'用户名已存在'
            ];
            return json($date);
        }
        if($file){
            //上传头像
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'img');
            if ($info) {
                $pic = $info->getFilename();
                $data['pic'] = $pic;
            }
            else{
                $date=[
                    'status'=>1,
                    'msg'=>'头像上传失败'
                ];
                return json($date);
            }
        }else{
            $data['pic'] = 'default.jpg';
        }
        $data['password']=md5($data['password']);
        $result=$stu->validate(true)->data($data)->save();
        if ($result){
            $date=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>$stu->getError()
            ];
        }
        return json($date);

    }
    public function tReg(){
        $data=request()->post();
        $file = request()->file('pic');
        $tea=new Teacher();
        $users = Teacher::where('teachername',$data['teachername'])->count();
        //查询是否存在该用户名
        if($users){
            $date=[
                'status'=>1,
                'msg'=>'用户名已存在'
            ];
            return json($date);
        }
        if($file){
            //上传头像
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'img');
            if ($info) {
                $pic = $info->getFilename();
                $data['pic'] = $pic;
            }
            else{
                $date=[
                    'status'=>1,
                    'msg'=>'头像上传失败'
                ];
                return json($date);
            }
        }else{
            $data['pic'] = 'default.jpg';
        }
        $data['password']=md5($data['password']);
        $result=$tea->validate(true)->data($data)->save();
        if ($result){
            $date=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>$tea->getError()
            ];
        }
        return json($date);

    }
}
