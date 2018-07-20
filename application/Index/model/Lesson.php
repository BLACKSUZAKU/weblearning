<?php
namespace app\index\model;

use think\Model;

class Lesson extends Model
{
    protected $table='lesson';
    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}