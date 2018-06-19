<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/config  全部网站配置列表
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }

        }
        return view('admin.config.index',compact('data'));
    }
    /*
     * 对配置项的内容进行填充（添加）
     * **/
    public function changeContent(){
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','网站配置更新成功！');

    }
    /**
     * 对配置项进行写入配置文件中
    */
    public function putFile(){
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
    /*
     * 修改排序
     * */
    public function changeOrder()
    {
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '网站配置更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '网站配置更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/config/create   添加网站配置
    public function create()
    {
        return view('admin.config.add');
    }

    //post.admin/config  添加网站配置
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];

        $message = [
            'conf_name.required'=>'网站配置名称不能为空！',
            'conf_title.required'=>'网站配置标题不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','网站配置添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get.admin/config/{config}/edit  编辑网站配置
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //put.admin/config/{config}    更新网站配置
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];

        $message = [
            'conf_name.required'=>'网站配置名称不能为空！',
            'conf_title.required'=>'网站配置标题不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Config::where('conf_id',$conf_id)->update($input);
            if($re){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with('errors','网站配置更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //delete.admin/config/{config}   删除单个网站配置
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '网站配置删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '网站配置删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //get.admin/config/{config}  显示单个导航信息
    public function show()
    {

    }
}
