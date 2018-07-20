<?php
namespace app\index\model;

use think\Model;

class Comment extends Model
{
    protected $table='comment';
    protected $autoWriteTimestamp='datetime';
    protected $createTime='createtime';
    protected $updateTime='updatetime';
}