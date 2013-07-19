<HR><!水平线>
<div align='center'>
<tr>
<td align='center'>| <a href='index.php'>Home</a> | <a href='login.php'>Login</a> | <a href='register.php'>Register</a> | </td>
</tr>
<?php
include("counter.inc");
?>
<br></br><!//换行>
<!//我把计数值放在文件counter.txt中，读出并输出>
<?php
printf("<br><center><b>已有 %06d 人访问</b></center><br>",
//取得站点计数器
get_hitcount("counter.txt"));
?>
<P ALIGN="CENTER">
<SMALL><I>
KXC381 ASSIGNMENT1      Copyright @ by Zhou Yuchao, 2012
</I></SMALL>
</P>
</BODY>
</HTML>