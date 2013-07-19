<html>
<!-- 
student name: Zhou Yuchao
student id: 143222
-->
<head>
<title>PhotoFun - Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
body {
	background-color: #0FF;
}
</style>
</head>
<body>
<h1> Wellcome to PhotoFun</h1>
<div align="center">
  <?php
$title="图片库";
?>
  <?php
session_start();
$fp=fopen("data/list.txt","r");
		while ($v1=fgetcsv($fp,1024, "|")) 
		{
			$idbuffer=$v1[1];
		}
fclose($fp);	
$postid=$idbuffer+1;  //sotre the id of the next picture
$id=0;  //store the the id of the current picture
$tempid=0; //store the tempt of the id
$tempname="";  //store the name of the picture

// user has login
if (isset($_SESSION["authority"]))
{
	echo '欢迎回来:  '.$_SESSION["authority"].'<br />';

	if(!isset($_GET["id"]))  //not set id in the url
	{
		//output the nearest uploaded picture
		$fp=fopen("data/list.txt","r");
		while ($v1=fgetcsv($fp,1024, "|")) 
		{
			$tempid=$v1[1];
			$tempname=$v1[0];
		}
		$picid=$tempid;
		$picname=$tempname;
		$current=$tempid;
		if(is_file("submissions/$picname"))
			echo '<br>'."<IMG SRC=\"submissions/$picname\">";
	fclose($fp);
	?>
	<br>
  	<br>
  <?php
  
//previous page and next page
$a=$current-1;
$b=$current+1;
$fp=fopen("data/list.txt","r");
	while ($v1=fgetcsv($fp,1024, "|")) 
	{
		$maxid=$v1[1];
		$maxname=$v1[0];
	}
fclose($fp);
if ($b <= $maxid)
{
?>
  <a href="index.php?id=<?php echo $b; ?>">Previous page</a>
  <?php
}
else
{
	echo "END";
}
if ($a >= 1)
{
?>
  <a href="index.php?id=<?php echo $a; ?>">Next page</a>
  <?php
}
else
{
	echo "END";
}
?>
  </div>
  
  <!-- Comments and logout -->
  <hr>
  <I><font size="2">Comments and logout:</font></I>
  <br>
   <?php
   $fp=fopen("data/$current.txt","r");
  while ($v=fgetcsv($fp,1024, "|")) 
	{
  		echo $v[0].':<br>';
		echo $v[1].'<br><br>';
	}
fclose($fp);
  ?>
  <hr>
  <I><font size="2">You can uplaod your picture here:</font></I>
  
  <!-- upload picture  -->
<form action="index.php" method="post" enctype="multipart/form-data">
  <div>
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	<label for="usefile">
      <div align="left">Upload a file: </div>
    </label>
	<input type="file" name="userfile" id="userfile"/>
	<input type="submit" value="Submit" name="submit"/>
	<input type="submit" value="Logout" name="logout"/>
	</div>
	</form>
	<I><FONT SIZE="2">(If you want to logout, Please click logout button twice!)</FONT></I>


	<hr>
    <I><FONT SIZE="2">You can make your comments here:</FONT></I>
	<TABLE WIDTH="460" ALIGN="CENTER" VALIGN="TOP">
		<TH COLSPAN="2">
		
		</TH>
		<FORM NAME="guestbook" ACTION="index.php?id=<?php echo $current; ?>" METHOD="POST">
		<TR>
			<TD ALIGN="RIGHT" VALIGN="TOP">Username:</TD>
			<TD><INPUT TYPE=text NAME=name></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN="TOP">Comments:</TD>
			<TD><TEXTAREA NAME=comments COLS=40 ROWS=6></TEXTAREA>
			<P><INPUT TYPE=submit VALUE=Submit name="submitcomment"> <INPUT TYPE=Reset VALUE=Reset>
		</TD>
		</TR>
		</FORM>
	</TABLE>


	<?php
	// logout
	if(isset($_POST["logout"]))	
	{
		unset($_SESSION["authority"]);
		session_destroy();
	}
	
	if(isset($_POST["submitcomment"]))	
	{
		$current;
		function fileWrite( $fileName, $str )
		{
			$handle = fopen( $fileName, "a" );
			fwrite( $handle, $str );
			fclose( $handle );
		}
		fileWrite( "data/$current.txt", $_POST["name"]);
		fileWrite( "data/$current.txt", "|");
		fileWrite( "data/$current.txt", $_POST["comments"]);
		fileWrite( "data/$current.txt", "\r\n");
	}
		
		
	// submit
	if(isset($_POST["submit"]))
	{	
		$fp1=fopen("data/list.txt","r");
		while ($v=fgetcsv($fp1,1024, "|")) 
		{
			$a=$v[1];
		}
		$id=$a;
		$id++;

		fclose($fp1);
		if ($_FILES['userfile']['error'] > 0)
		{
			echo 'Problem: ';
			switch ( $_FILES['userfile']['error'])
			{
				case 1: echo'File exceeded upload_max_filesize';
				break;
				case 2: echo'File exceeded max_file_filesize';
				break;
				case 3: echo'File only partially uploaded';
				break;
				case 4: echo'No file uploaded';
				break;
				case 6: echo'Connot upload file: No temp directory specified';
				break;
				case 7: echo'Uplaod failed: Cannot write to disk';
				break;
			}
			exit;
		}

		//Does the file have the right MIME type?
		if ($_FILES['userfile']['type'] != 'image/jpeg')
		{
			echo'Problem: file is not image..';
			exit;
		}
	
		//put the file where we's like it
		$upfile = '/www/submissions/'.$_FILES['userfile']['name'];

		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			if(!move_uploaded_file($_FILES['userfile']['tmp_name'],$upfile))
			{
				echo'Problem: Could not move file to destination directory';
				exit;
			}
		}
		else
		{
			echo'Probelm: Possible file upload attack. Filename: ';
			echo $_FILES['userfile']['name'];
			exit;
		}
	
		echo'<br><br>File uploaded successful<br><br>';
		
		//remove possible HTML and PHP tags from the file's contents
		$contents= file_get_contents($upfile);
		$contents= strip_tags($contents);
		file_put_contents($_FILES['userfile']['name'], $contents);
		
		function fileWrite( $fileName, $str )
		{
			$handle = fopen( $fileName, "a" );
			fwrite( $handle, $str );
			fclose( $handle );
		}
		fileWrite( "data/list.txt", $_FILES['userfile']['name']);
		fileWrite( "data/list.txt", "|");
		fileWrite( "data/list.txt", $id);
		fileWrite( "data/list.txt", "\r\n");
		fileWrite( "data/$id.txt", "");	
	}
	}
	else  // set id in the url
	{
		$fp=fopen("data/list.txt","r");
		while ($v1=fgetcsv($fp,1024, "|")) 
		{
			if ($_GET['id'] == $v1[1])
			{
				$tempid=$v1[1];
				$tempname=$v1[0];
				break;
			}
		}
		fclose($fp);
		echo '<br>'."<IMG SRC=\"submissions/$tempname\">";
	//}
 ?>
  <br>
  <br>
  <?php
  
//previous page and next page
$a=$_GET['id']-1;
$current=$_GET['id'];
$b=$_GET['id']+1;
$fp=fopen("data/list.txt","r");
	while ($v1=fgetcsv($fp,1024, "|")) 
	{
		$maxid=$v1[1];
		$maxname=$v1[0];
	}
fclose($fp);
if ($b <= $maxid)
{
?>
  <a href="index.php?id=<?php echo $b; ?>">Previous page</a>
  <?php
}
else
{
	echo "END";
}
if ($a >= 1)
{
?>
  <a href="index.php?id=<?php echo $a; ?>">Next page</a>
  <?php
}
else
{
	echo "END";
}
?>
  </div>
  <hr>
  <I><FONT SIZE="2">Comments:</FONT></I>
  <br>
   <?php
   $fp=fopen("data/$current.txt","r");
  while ($v=fgetcsv($fp,1024, "|")) 
	{
  		echo $v[0].':<br>';
		echo $v[1].'<br><br>';
	}
fclose($fp);
  ?>
  <hr>
  <I><FONT SIZE="2">You can uplaod your picture here:</FONT></I>
  
  <!-- upload picture  -->

<form action="index.php" method="post" enctype="multipart/form-data">
  <div>
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	<label for="usefile">
      <div align="left">Upload a file: </div>
    </label>
	<input type="file" name="userfile" id="userfile"/>
	<input type="submit" value="Submit" name="submit"/>
	<input type="submit" value="Logout" name="logout"/>
	</div>
	</form>
	<I><FONT SIZE="2">(You may notice a slight delay while we upload your file.)</FONT></I>


	<hr>
    <I><FONT SIZE="2">You can make your comments here:</FONT></I>
	<TABLE WIDTH="460" ALIGN="CENTER" VALIGN="TOP">
		<TH COLSPAN="2">
		
		</TH>
		<FORM NAME="guestbook" ACTION="index1.php?id=<?php echo $current; ?>" METHOD="POST">
		<TR>
			<TD ALIGN="RIGHT" VALIGN="TOP">Username:</TD>
			<TD><INPUT TYPE=text NAME=name></TD>
		</TR>
		<TR>
			<TD ALIGN="RIGHT" VALIGN="TOP">Comments:</TD>
			<TD><TEXTAREA NAME=comments COLS=40 ROWS=6></TEXTAREA>
			<P><INPUT TYPE=submit VALUE=Submit name="submitcomment"> <INPUT TYPE=Reset VALUE=Reset>
		</TD>
		</TR>
		</FORM>
	</TABLE>


	<?php
	// logout
	if(isset($_POST["logout"]))	
	{
		unset($_SESSION["authority"]);
		session_destroy();
	}
	
	if(isset($_POST["submitcomment"]))	
	{
		$current;
		function fileWrite( $fileName, $str )
		{
			$handle = fopen( $fileName, "a" );
			fwrite( $handle, $str );
			fclose( $handle );
		}
		fileWrite( "data/$current.txt", $_POST["name"]);
		fileWrite( "data/$current.txt", "|");
		fileWrite( "data/$current.txt", $_POST["comments"]);
		fileWrite( "data/$current.txt", "\r\n");
	}
		
		
	
	if(isset($_POST["submit"]))
	{	
		$fp1=fopen("data/list.txt","r");
		while ($v=fgetcsv($fp1,1024, "|")) 
		{
			$a=$v[1];
		}
		$id=$a;
		$id++;
		echo '...<br><br>'.$id.'<br>';
		fclose($fp1);
		if ($_FILES['userfile']['error'] > 0)
		{
			echo 'Problem: ';
			switch ( $_FILES['userfile']['error'])
			{
				case 1: echo'File exceeded upload_max_filesize';
				break;
				case 2: echo'File exceeded max_file_filesize';
				break;
				case 3: echo'File only partially uploaded';
				break;
				case 4: echo'No file uploaded';
				break;
				case 6: echo'Connot upload file: No temp directory specified';
				break;
				case 7: echo'Uplaod failed: Cannot write to disk';
				break;
			}
			exit;
		}

		//Does the file have the right MIME type?
		if ($_FILES['userfile']['type'] != 'image/jpeg')
		{
			echo'Problem: file is not image..';
			exit;
		}
	
		//put the file where we's like it
		$upfile = '/www/submissions/'.$_FILES['userfile']['name'];

		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			if(!move_uploaded_file($_FILES['userfile']['tmp_name'],$upfile))
			{
				echo'Problem: Could not move file to destination directory';
				exit;
			}
		}
		else
		{
			echo'Probelm: Possible file upload attack. Filename: ';
			echo $_FILES['userfile']['name'];
			exit;
		}
	
		echo'<br><br>File uploaded successful<br><br>';
		
		//remove possible HTML and PHP tags from the file's contents
		$contents= file_get_contents($upfile);
		$contents= strip_tags($contents);
		file_put_contents($_FILES['userfile']['name'], $contents);
		
		function fileWrite( $fileName, $str )
		{
			$handle = fopen( $fileName, "a" );
			fwrite( $handle, $str );
			fclose( $handle );
		}
		fileWrite( "data/list.txt", $_FILES['userfile']['name']);
		fileWrite( "data/list.txt", "|");
		fileWrite( "data/list.txt", $id);
		fileWrite( "data/list.txt", "\r\n");
		fileWrite( "data/$id.txt", "");	
	}
}
}
else  //user is not login
{
	if(isset($_GET["id"]))
	{
		$fp=fopen("data/list.txt","r");
		while ($v1=fgetcsv($fp,1024, "|")) 
		{
			if ($_GET['id'] == $v1[1])
			{
				$tempid=$v1[1];
				$tempname=$v1[0];
				break;
			}
		}
		fclose($fp);
		echo '<br>'."<IMG SRC=\"submissions/$tempname\">";
		
		
	$a=$_GET['id']-1;
	$b=$_GET['id']+1;
	$current=$_GET['id'];
	$fp=fopen("data/list.txt","r");
	while ($v1=fgetcsv($fp,1024, "|")) 
	{
		$maxid=$v1[1];
		$maxname=$v1[0];
	}
	fclose($fp);
	if ($b <= $maxid)
	{	
	?>
    <br>
	<a href="index.php?id=<?php echo $b; ?>">Privious page</a>
	<?php
	}
	else
	{
		echo "END";
	}
	if ($a >= 1)
	{
	?>
    
	<a href="index.php?id=<?php echo $a; ?>">Next page</a>
	<?php
	}
	else
	{
		echo "END";
	}

	
	?>
	</div>
<hr>
  <I><FONT SIZE="2">Comments:</FONT></I>
  <br>
   <?php
   $fp=fopen("data/$current.txt","r");
  while ($v=fgetcsv($fp,1024, "|")) 
	{
  		echo $v[0].':<br>';
		echo $v[1].'<br><br>';
	}
fclose($fp);
	
	
	
	

		
	}
	else  //not set id in the url
	{
		$fp=fopen("data/list.txt","r");
		while ($v1=fgetcsv($fp,1024, "|")) 
		{
			$tempid=$v1[1];
			$tempname=$v1[0];
		}
		$picid=$tempid;
		$picname=$tempname;
		if(is_file("submissions/$picname"))
			echo '<br>'."<IMG SRC=\"submissions/$picname\">";
	fclose($fp);
	
	?>
	<br>
<?php
	$a=$tempid-1;
	$b=$tempid+1;
	$current=$tempid;
	$fp=fopen("data/list.txt","r");
	while ($v1=fgetcsv($fp,1024, "|")) 
	{
		$maxid=$v1[1];
		$maxname=$v1[0];
	}
	fclose($fp);
	if ($b <= $maxid)
	{	
	?>
		<a href="index.php?id=<?php echo $b; ?>">Privious page</a>
	<?php
	}
	else
	{
		echo "END";
	}
	if ($a >= 1)
	{
	?>
		<a href="index.php?id=<?php echo $a; ?>">Next page</a>
	<?php
	}
	else
	{
		echo "END";
	}
	?>
	</div>
	<hr>
  <I><FONT SIZE="2">Comments:</FONT></I>
  <br>
   <?php
   $fp=fopen("data/$current.txt","r");
  	while ($v=fgetcsv($fp,1024, "|")) 
	{
  		echo $v[0].':<br>';
		echo $v[1].'<br><br>';
	}
	fclose($fp);
}
}
?>

<?php
include("footer.inc");
?>
</body>
</html>