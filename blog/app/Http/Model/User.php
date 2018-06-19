<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='user';
    protected $primaryKey='user_id';
    public $timestamps=false;
    protected $guarded = [];//通过create提交数据时的验证，除此以外的可以提交
}
