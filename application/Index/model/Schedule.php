<?php
namespace app\index\model;

use think\Model;

class Schedule extends Model
{
    protected $table='schedule';

    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime=false;
}