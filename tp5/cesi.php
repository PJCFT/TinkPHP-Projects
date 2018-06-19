<?php

/**
 * 公共空间及空间引入类
 */
namespace meizhou\jiaoling\yanmian;
header("content-type:text/html;charset=utf-8");
class Animals{
    public $obj = "dog";
    static $name = "小狗";
}
function getmes(){
    echo "旺旺";
}

namespace maoming\gaozhou\lizhi;

use meizhou\jiaoling\yanmian\Animals;//引入类

//直接可以使用
$animals = new Animals();
echo $animals->obj;
echo $animals::$name."<hr>";

