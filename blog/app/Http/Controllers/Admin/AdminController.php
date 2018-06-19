<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends CommonController
{
    //get.admin/admin  全部管理员列表
    public function index()
    {
        $admins = User::paginate(5);
        return view('admin.admin.index')->with('data',$admins);
    }

    //get.admin/admin/create   添加管理员
    public function create()
    {
        return view('admin/admin/add');
    }

    //post.admin/admin 添加管理员提交方法
    public function store()
    {
        $input = Input::except('_token');

        $rules = [
            'user_name'=>'required',
            'user_pass'=>'required|min:6',

        ];

        $message = [
            'user_name.required'=>'管理员名称不能为空！',
            'user_pass.required'=>'管理员密码不能为空！',
            'user_pass.min'=>'管理员密码不能少于6位',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['user_pass'] = Crypt::encrypt($input['user_pass']);
            $re = User::create($input);
            if($re){
                return redirect('admin/admin');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/admin/{admin}/edit  编辑管理员
    public function edit($user_id)
    {
        $data = User::find($user_id);
        return view('admin/admin/edit',compact('data'));
    }

    //put.admin/admin/{admin}    更新管理员
    public function update($user_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'user_name'=>'required',
            'user_pass'=>'required|min:6',

        ];

        $message = [
            'user_name.required'=>'管理员名称不能为空！',
            'user_pass.required'=>'管理员密码不能为空！',
            'user_pass.min'=>'管理员密码不能少于6位',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['user_pass'] = Crypt::encrypt($input['user_pass']);
            $re = User::where('user_id',$user_id)->update($input);
            if($re){
                return redirect('admin/admin');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/admin/{admin}  显示单个管理员信息
    public function show()
    {

    }

    //delete.admin/admin/{admin}   删除单个管理员
    public function destroy($user_id)
    {
        $re = User::where('user_id',$user_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '管理员删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '管理员删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
