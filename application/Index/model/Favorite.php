<?php
namespace app\index\model;

use think\Model;

class Favorite extends Model
{
    protected $table='favorite';

    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime=false;
}