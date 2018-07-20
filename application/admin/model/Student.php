<?php
namespace app\admin\model;

use think\Model;

class Student extends Model
{
    protected $table='student';

    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}