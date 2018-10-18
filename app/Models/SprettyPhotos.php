<?php
/**
 * Created by PhpStorm.
 * User: Johnson
 * Date: 2018-10-18
 * Time: 17:44
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SprettyPhotos extends Model
{
    //表名
    protected $table = 'spretty_photos';
    //指定主键名 默认id
    protected $primaryKey = 'id';
    //自动维护时间戳
    public $timestamps  = true;
    //设置允许批量赋值的字段
    protected $fillable = ['project_id', 'path', 'desc', 'filetype','media_uniqid','file_name'];
    //设置不允许自动赋值的字段
    protected $guarded=[];
    //设置时间
 /*   public function getDateFormat()
    {
        return date('Y-m-d H:i:s');
    }*/
    //不格式化时间戳
    /*private function asDateTime($value){
        return $value;
    }*/
}