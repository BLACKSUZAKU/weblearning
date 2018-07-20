<?php
namespace app\index\controller;

use app\index\model\Comment;
use app\index\model\Favorite;
use app\index\model\Schedule;
use app\index\model\Student;
use think\Controller;
use think\Db;
use think\Session;

class StudentCenter extends Controller
{
    public function _empty(){
        $this->redirect('index/index');
    }

    public function _initialize(){
        if(!Session::get('studentid')){
            $this->redirect('index/index');
        }
//        Session::set('userid',1);
//        Session::set('portrait','5aed84308410b.jpg');
//        Session::set('username','黑盒子');
    }

    public function index(){
        $userid=Session::get('studentid');
//        dump($userid);
        $data=Db::table('schedule')
            ->alias('a')
            ->join('lesson l','a.lessonid = l.lessonid')
            ->join('type t','l.tid = t.tid')
            ->field('lessonname,typename,a.createtime,scid,l.lessonid,l.tid')->where('studentid',$userid)->paginate(5);

        $this->assign('schedule',$data);
        return $this->fetch('student/schedule');
    }

    public function favorite(){
        $userid=Session::get('studentid');
//        $data=Favorite::where('studentid',$userid)->select();
        $data=Db::table('favorite')
            ->alias('a')
            ->join('lesson l','a.lessonid = l.lessonid')
            ->join('type t','l.tid = t.tid')
            ->field('lessonname,typename')->where('studentid',$userid)->paginate(5);
//        dump($data);
        $this->assign('favor',$data);
        return $this->fetch('student/favorite');
    }

    public function comment(){
        $userid=Session::get('studentid');
//        $data=Favorite::where('studentid',$userid)->select();
        $data=Db::table('comment')
            ->alias('a')
            ->join('lesson l','a.lessonid = l.lessonid')
            ->join('type t','l.tid = t.tid')
            ->field('lessonname,typename,content,a.createtime,commentid')->where('sid',$userid)->paginate(5);
//        dump($data);
        $this->assign('comment',$data);
        return $this->fetch('student/comment');
    }

    public function personinfo(){
        $userid=Session::get('studentid');
        $data=Student::get($userid);
        $this->assign('userinfo',$data);
//        dump($data->toArray());
        return $this->fetch('student/personinfo');
    }

    public function changepass(){
        return $this->fetch('student/changepass');
    }

    public function doChangePass(){
        $oldpass=input('param.oldpass');
        $newpass=input('param.newpass');
        $userid=Session::get('studentid');
        $re=Student::where('sid',$userid)->value('password');
//        $re=Student::where(['sid'=>$userid,'password'=>md5($oldpass)])->value('password');
        if(md5($oldpass)==$re){
            $result=Student::where('sid',$userid)->setField('password',md5($newpass));
            if($result){
                Session::flash('studentsuccess','修改成功');
                $this->redirect('index/schangepass');
            }else{
                Session::flash('studenterror','修改失败');
                $this->redirect('index/schangepass');
            }
        }else{
            Session::flash('studenterror','密码错误');
            $this->redirect('index/schangepass');
        }
    }

    public function changeinfo(){
        $data=request()->post();
        $file = request()->file('pic');
        $stu=new Student();
        $uid=Session::get('studentid');
        $users = Student::where('sid', '<>', $uid)->where('studentname',$data['studentname'])->count();
//        echo $users;
//        dump($data);
        if($file){
            // 先删除原头像
            $pic=Student::where('sid',$data['sid'])->value('pic');
            $filename=ROOT_PATH . 'public' . DS . 'static' . DS . 'img/'.$pic;
            if(file_exists($filename)){
                $delPic=unlink($filename);
                if(!$delPic){
                    Session::flash('studenterror','头像更新失败');
                    $this->redirect('index/spersoninfo');
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
                $this->redirect('index/spersoninfo');
            }
        }
        //没有跟新头像直接修改信息
        if($users){
            Session::flash('studenterror','用户名已存在');
            $this->redirect('index/spersoninfo');
        }
        $result=$stu->validate(true)->save($data,['sid'=>$data['sid']]);
        if (false === $result) {
            // 验证失败 输出错误信息
            Session::flash('studenterror',$stu->getError());
            $this->redirect('index/spersoninfo');
        } else {
            Session::flash('studentsuccess','更新成功');
            $this->redirect('index/spersoninfo');
        }
    }
    //加入我的课程
    public function collect(){
        $data=input('param.');
        $lessonid=$data['lessonid'];
        $sid=$data['studentid'];
        $exist=Schedule::where(['lessonid'=>$lessonid,'studentid'=>$sid])->count();

        if($exist){
            $date=[
                'status'=>0,
                'msg'=>'该课程已加入您的课程'
            ];
            return json($date);
        }

        $schedule=new Schedule();
        $re=$schedule->data($data)->save();
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
//    删除课程
    public function scheduleDel(){
        $id=input('param.scid');
        Db::startTrans();
        $re=Schedule::destroy($id);
        if($re){
            Db::commit();
        }else{
            Db::rollback();
        }
        if ($re){
            $date=[
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>'删除失败'
            ];
        }
        return $date;
    }
    //删除评论
    public function commentDel(){
        $id=input('param.commentid');
        Db::startTrans();
        $re=Comment::destroy($id);
        if($re){
            Db::commit();
        }else{
            Db::rollback();
        }
        if ($re){
            $date=[
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $date=[
                'status'=>1,
                'msg'=>'删除失败'
            ];
        }
        return $date;
    }

    //加入我的课程
    public function commentAdd(){
        $data=input('param.');
        $sid=$data['sid'];
        $lessonid=$data['lessonid'];
        $exist=Comment::where(['sid'=>$sid,'lessonid'=>$lessonid])->count();

        if($exist){
            $date=[
                'status'=>0,
                'msg'=>'您已提交过评论'
            ];
            return json($date);
        }

        $comment=new Comment();
        $re=$comment->data($data)->save();
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