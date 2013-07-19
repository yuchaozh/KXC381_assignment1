<?php
$title="login";
?>
<style type="text/css">
body {
	background-color: #0FF;
}
</style>

<!-- Login form -->
<form action="login.php" method="post">
<p>
<label for="username">Username: </label>
<input type="text" name="username"><br>
<label for="password">Password: </label>
<input type="text" name="password"><br>
<input type="submit" value="Submit me" name="submit"><input type="reset">
</p>
</form>

<?php
session_start();
$fp=fopen("data/users.txt","r");
$login=0;

// check the user
if(isset($_POST["submit"]))
{
	while ($v=fgetcsv($fp,1024, "|")) 
	{
		if (( $_POST['username'] == $v[0])&& ( $_POST['password'] ==$v[1] ))
	 		{
				echo "You login!";
				$login=1; 
				$_SESSION["authority"]=$_POST['username'];
				echo $_SESSION["authority"];
				echo 'Login In Successfully.<br><a //href="index.php" target="_blank">Click here to go back to the home page.</a>  <br>';
				break;
			}
		else $login=-1;
	}
		if ( $login==-1 )
		echo "Login Error!<br> Please create a new account first!<br>";
}
fclose($fp);   
?>
<?php
include("footer.inc");
?>
