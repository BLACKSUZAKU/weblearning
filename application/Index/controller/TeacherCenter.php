<?php
namespace app\index\controller;

use app\admin\model\Type;
use app\index\model\Reply;
use app\index\model\Videos;
use app\index\model\Favorite;
use app\index\model\Lesson;
use app\index\model\Student;
use app\index\model\Teacher;
use think\Controller;
use think\Db;
use think\Session;

class TeacherCenter extends Controller
{
    public function _initialize(){
        if(!Session::get('teacherid')){
            $this->redirect('index/index');
        }
//        Session::set('teacherid',1);
//        Session::set('portrait','5aed84308410b.jpg');
//        Session::set('username','黑盒子');
    }

    public function index(){
        $userid=Session::get('teacherid');
//        dump($userid);
        $data=Db::table('lesson')
            ->alias('l')
            ->join('type t','l.tid = t.tid')
            ->where('teacherId',$userid)->field('lessonid,l.tid,teacherId,lessonname,pic')->select();
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['lessonid'];//字段赋值
            $data[$key]['videos'] = \Lesson_videos('videos',$pid);
        }
//        foreach($data as $key=>$value){   //循环读取
//            dump($value);
//        }

        $this->assign('schedule',$data);
        return $this->fetch('teacher/schedule');
    }

    public function favorite(){
        $userid=Session::get('teacherid');
        $subsql = Db::table('student')->field('sid,studentname')->group('sid')->buildSql();
        $subsql1 = Db::table('lesson')->field('lessonid,lessonname,pic')->group('lessonid')->buildSql();
        $subsql2 = Db::table('videos')->field('vid,vname')->group('vid')->buildSql();
        $question=Db::table('question')
            ->alias('a')
            ->join([$subsql1=>'b'],'a.lessonid = b.lessonid')
            ->join([$subsql=>'c'],'a.studentid = c.sid')
            ->join([$subsql2=>'d'],'a.vid = d.vid')
            ->paginate(5);
        $this->assign('question',$question);
//        dump($question);
//        die();
        return $this->fetch('teacher/favorite');
    }

    public function comment(){
        $userid=Session::get('teacherid');
//        $data=Favorite::where('studentid',$userid)->select();
        $data=Db::table('comment')
            ->alias('a')
            ->join('lesson l','a.lessonid = l.lessonid')
            ->join('student s','a.sid = s.sid')
            ->field('commentid,lessonname,content,a.createtime,s.studentname')->where('teacherId',$userid)->paginate(5);
//        dump($data);
        $this->assign('comment',$data);
        return $this->fetch('teacher/comment');
    }

    public function personinfo(){
        $userid=Session::get('teacherid');
        $data=Teacher::get($userid);
        $this->assign('userinfo',$data);
//        dump($data->toArray());
        return $this->fetch('teacher/personinfo');
    }

    public function changepass(){
        return $this->fetch('teacher/changepass');
    }

    public function doChangePass(){
        $oldpass=input('param.oldpass');
        $newpass=input('param.newpass');
        $userid=Session::get('teacherid');
        $re=Teacher::where('teacherId',$userid)->value('password');
//        $re=Teacher::where(['sid'=>$userid,'password'=>md5($oldpass)])->value('password');
        if(md5($oldpass)==$re){
            $result=Teacher::where('teacherId',$userid)->setField('password',md5($newpass));
            if($result){
                Session::flash('studentsuccess','修改成功');
                $this->redirect('index/tchangepass');
            }else{
                Session::flash('studenterror','修改失败');
                $this->redirect('index/tchangepass');
            }
        }else{
            Session::flash('studenterror','密码错误');
            $this->redirect('index/tchangepass');
        }
    }

    public function changeinfo(){
        $data=request()->post();
        $file = request()->file('pic');
        $stu=new Teacher();
        $uid=Session::get('teacherid');
        $users = Teacher::where('teacherId', '<>', $uid)->where('teachername',$data['teachername'])->count();

        if($file){
            // 先删除原头像
            $pic=Teacher::where('teacherId',$data['teacherId'])->value('pic');
            $filename=ROOT_PATH . 'public' . DS . 'static' . DS . 'img/'.$pic;
            if(file_exists($filename)){
                $delPic=unlink($filename);
                if(!$delPic){
                    Session::flash('studenterror','头像更新失败');
                    $this->redirect('index/tpersoninfo');
                }
            }
            //上传新头像
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'img');
            if ($info) {
                $pic = $info->getFilename();
                $data['pic'] = $pic;
//                dump($data);
//                exit();
            }
            else{
                Session::flash('studenterror','头像更新失败');
                $this->redirect('index/tpersoninfo');
            }

        }
        //没有跟新头像直接修改信息
        if($users){
            Session::flash('studenterror','用户名已存在');
            $this->redirect('index/tpersoninfo');
        }
        $result=$stu->validate(true)->save($data,['teacherId'=>$data['teacherId']]);
        if (false === $result) {
            // 验证失败 输出错误信息
            Session::flash('studenterror',$stu->getError());
            $this->redirect('index/tpersoninfo');
        } else {
            Session::flash('studentsuccess','更新成功');
            $this->redirect('index/tpersoninfo');
        }
    }
    public function addLesson(){
        $data=Type::all();
        $this->assign('type',$data);
        return $this->fetch('teacher/addlesson');
    }
    public function addVideo(){
        $uid=Session::get('teacherid');
        $data=Lesson::where('teacherId',$uid)->select();
        $this->assign('lesson',$data);
//        dump($data);
        return $this->fetch('teacher/addvideo');
    }
    public function reply(){
        return $this->fetch('teacher/reply');
    }
    public function doReply(){
        $data=input('param.');
        $commentid=$data['commentid'];
        $exist=Reply::where(['commentid'=>$commentid])->count();

        if($exist){
            $date=[
                'status'=>0,
                'msg'=>'已提交过回复'
            ];
            return json($date);
        }
//
        $reply=new Reply();
        $re=$reply->data($data)->save();
        if ($re){
            $date=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>'失败'
            ];
        }
        return json($date);
    }
    public function doAddLesson(){
        $data=request()->post();

        $file=request()->file('pic');
        if($file){
            //上传
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'poster');
            if ($info) {
                $pic = $info->getFilename();
                $data['pic'] = $pic;
            }
            else{
                $back=[
                    'status'=>1,
                    'msg'=>'失败'
                ];
                return json($back);
            }
        }
        $lesson=new Lesson();
        $re=$lesson->data($data)->save();

        if ($re){
            $date=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>'失败'
            ];
        }
        return json($date);
    }
    public function doAddVideo(){
        $data=request()->post();
        $file=request()->file('video');
        if($file){
            //上传 size表示自己数 1字节=1b 1024b=1kb 1024kb=1mb 1024mb=1g  1g/6=170956970
            $info = $file->rule('uniqid')->validate(['size'=>170956970,'ext'=>'mp4,avi'])->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'videos');
            if ($info) {
                $path = $info->getFilename();
                $data['path'] = "videos/".$path;
            }
            else{
                $back=[
                    'status'=>1,
                    'msg'=>$file->getError()
                ];
                return json($back);
            }
        }
        $video=new Videos();
        $re=$video->data($data)->save();

        if ($re){
            $date=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>'失败'
            ];
        }
        return json($date);
    }
}