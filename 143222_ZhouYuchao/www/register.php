<html>
<head>
<title>PhotoFun - Register</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
body {
	background-color: #0FF;
}
</style>
</head>
<body>
<h1><center>PhotoFun - Share your photoes</center></h1>
<hr>
<I>You can create a new account in this page.</I>
<?php
$title="首页";
?>
<!-- Redister form -->
<form action="register.php" method="post">
<p>
<label for="username">Username: </label>
<input type="text" name="username"> 
   <br>
<label for="password">Password: </label>
<input type="password" name="password"><br>
<label for="checkpassword">Password check:  </label>
<input type="password" name="checkpassword">
<br>
<label for="email">Email address:</label>
<input type="text" name="email"><br>
<label for="age">Age:</label>
<input type="text" name="age"> 
   <br>
Please choose your denger: 
<input type="radio" name="sex" value="Male"> Male
<input type="radio" name="sex" value="Female"> Female<br>
How many years do you take photoes:
<input type="checkbox" name="time" value="One"> One Year
<input type="checkbox" name="time" value="Two"> Two Year
<input type="checkbox" name="time" value="Three"> Three Year<br>

<td>How do you get to know PhotoFun: </td>
<tr>
<td><select name="ways" size=4 multiple>
<option value="1" selected>TV advertising</option>
<option value="2">Friends' recommend</option>
<option value="3">Phone directory</option>
<option value="4">Leaflet</option>
</select>
</td>
</tr>
<br>
<br>
<input type="submit" value="Submit me" name="submit"><input type="reset">
</p>
</form>


<?php
// write into the txt
if(isset($_POST["submit"]))
{
	echo "Congraturation. You created a new account.<br>";
	function fileWrite( $fileName, $str )
	{
		$handle = fopen( $fileName, "a" );
		fwrite( $handle, $str );
		fclose( $handle );
	}
	fileWrite( "data/users.txt", $_POST["username"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["password"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["email"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["age"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["sex"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["time"]);
	fileWrite( "data/users.txt", "|");
	fileWrite( "data/users.txt", $_POST["ways"]);
	fileWrite( "data/users.txt", "\r\n");	
}
?>


<?php
include("footer.inc");
?>
</body>
</html>