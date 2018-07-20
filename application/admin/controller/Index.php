<?php
namespace app\admin\controller;

use app\admin\model\Login;
use app\admin\model\Type;
use think\Db;
use think\Paginator;
use think\Request;
use think\Session;

class Index extends BaseController
{
    public function index()
    {
        $type=Type::all();
//        $type=Db::name('type')->order('tid desc')->paginate(2);
        $this->assign('type',$type);
        return $this->fetch('index/empty');
    }
    public function edit(){
        # code...
        $tid=input("param.tid");
        $type=Type::get($tid);
        echo json_encode($type);
    }

    public function typedel(){
        $id=input('param.tid');
//        $re=Type::where('tid',$id)->delete();
        Db::startTrans();
        $re=Type::destroy($id);
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

    public function typeadd(Request $request){
        //对数据进行过滤，防止未知的用户输入风险（sql注入、恶意输入）
//        $request->filter(['strip_tags','htmlspecialchars']);
        $typename= $request->post('typename');

        //获取数据列数
        $model=new Type();
        $num=$model->where("typename='$typename'")->Count();

        if($num>0){
            Session::flash('typeerror',"该类型已存在");
            $this->redirect('admin/index');
        }else{
            $data=["typename"=>$typename];
            if($model->save($data)){
                Session::flash('typesuccess',"添加成功");
                $this->redirect('admin/index');
            }else{
                Session::flash('typeerror',"添加失败");
                $this->redirect('admin/index');
            }
        }
    }
    public function typeupdate(){
        # code...
        $data=[
            "tid"=>input("param.tid"),
            "typename"=>input("param.typename"),
        ];
        $exist=Type::where('typename',$data["typename"])->Count();
        if($exist>0){
            Session::flash('typeerror',"该类型已存在");
            $this->redirect('admin/index');
        }else{
            if(Type::update($data)){
                Session::flash('typesuccess',"修改成功");
                $this->redirect('admin/index');
            }else{
                Session::flash('typeerror',"修改失败");
                $this->redirect('admin/index');
            }
        }
    }

    public function getUrl(Request $req){
        //获取域名
        dump($req->domain());
        //获取目录
        dump($req->url(true));
        echo $req->path();
        echo $req->controller();
        //获取根目录
        dump($req->baseFile());

        dump($req->ip());
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
