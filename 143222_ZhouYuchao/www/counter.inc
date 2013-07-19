<?php
function get_hitcount($counter_file)
{
/* 将计数器归零
这样如果计数器还未被使用，初始值将是1
你当然也可以把初始值设成20000来骗人咯
*/
$count=0;
// 如果存放计数器文件已经存在，读取其中的内容
if ( file_exists($counter_file) )
{
$fp=fopen($counter_file,"r");
// 我们只取了前20位，希望你的站点不要太受欢迎啊
$count=0+fgets($fp,20);
// 由于函数fgets()返回字符串，我们可以通过加0的方法将其自动转换为整数
fclose($fp);
// 对文件操作完毕
}
// 增加一次计数值
$count++;
// 将新的计数值写入文件
$fp=fopen($counter_file,"w");
fputs($fp,$count);
fclose($fp);
# 返回计数值
return ($count);
}
?>
