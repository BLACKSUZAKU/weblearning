<?php
namespace app\index\controller;

use app\admin\model\Type;
use app\index\model\Lesson;
use think\Controller;
use think\Db;

class Details extends Controller
{
    public function _empty(){
        $this->redirect('index/index');
    }

    public function index()
    {
//        dump( session('userid'));
        $lid=input('lessonid');
        $showid=input('showid','0');
        $tid=input('tid');
        //访问量+1
        Lesson::where('lessonid',$lid)->setInc('hits');
        //课程信息多表联查
        $lessoninfo=Db::table('lesson')
            ->alias('l')
            ->join('teacher t','t.teacherId = l.teacherId')
            ->join('type ty','l.tid = ty.tid')
            ->field('lesson.lessonid,lessonname,lesson.tid,lesson.teacherId,intro,t.pic as tpic,
                        lesson.pic,teachername,email,typename,lesson.createtime,hits')
            ->where('lessonid',$lid)->find();

        //课程下视频列表
        $lessonvideo=Db::table('videos')->where('lessonid',$lid)->select();
        //课程评论
        $comment=Db::table('comment')
            ->alias('c')
            ->join('student s','c.sid = s.sid')
            ->join('reply r','c.commentid = r.commentid')
            ->where('lessonid',$lid)
            ->select();
        //课程简介
        $recommend = Db::table('lesson')->where('tid',$tid)->field('lessonid,lessonname,tid,pic,createtime')->limit(2)->order('hits')->select();
//        dump($recommend);
        $type=Type::all();
        $this->assign('type',$type);
        $this->assign('lesson',$lessoninfo);
        $this->assign('videolist',$lessonvideo);
        $this->assign('comment',$comment);
        $this->assign('recommend',$recommend);
        $this->assign('showid',$showid);

//        dump($lessoninfo);
        return $this->fetch('index/details');
    }
}
