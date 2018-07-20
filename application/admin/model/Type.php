<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Type extends Model
{
//    use SoftDelete;
    protected $table='type';
    protected $pk='tid';
//    protected static $deleteTime = 'delete_time';

    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}
