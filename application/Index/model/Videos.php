<?php
namespace app\index\model;

use think\Model;

class Videos extends Model
{
    protected $table='videos';
    protected $pk='vid';
    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}