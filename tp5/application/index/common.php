<?php
function arr_unique($arr2d){
	// 把二维数组拆开
	foreach ($arr2d as $k => $v) {
		# code...
		$v = join(',',$v);//以逗号拆分成字符串
		$temp[] = $v;
	}
	if($temp){
		$temp = array_unique($temp);
	// 将去重后的一维数组还原为二维数组，索引已经改变成为数字
		foreach ($temp as $k => $va) {
			$temp[$k] = explode(',', $v);
		}
		return $temp;
	}
	
	
}
?>