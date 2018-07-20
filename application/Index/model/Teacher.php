<?php
namespace app\index\model;

use think\Model;

class Teacher extends Model
{
    protected $table='teacher';
    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}