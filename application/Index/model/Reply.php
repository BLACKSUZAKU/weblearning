<?php
namespace app\index\model;

use think\Model;

class Reply extends Model
{
    protected $table='reply';
    protected $pk='rid';
    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime=false;
}