<?php
	ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="content-Type" content="Text/html" charset="euc-kr"><!-- "utf-8" --> <!-- euc-kr -->
</head>
<body>
	<?php
		if(isset($_FILES['file_kakao']['name'])){
			$filename = $_FILES['file_kakao']['name'];
			//$filename = iconv("utf-8","CP949",$filename);
			$tmp_file = $_FILES['file_kakao']['tmp_name'];
			//$destination = $_SERVER['DOCUMENT_ROOT'].'/Imagineer/files/'.$filename;
			$destination = './files/'.$filename;
			echo $filename; echo"<br>";
			echo $destination; echo"<br>";
			echo $tmp_file; echo"<br>";
			echo "==>".var_dump(iconv_get_encoding('all'))."<br>"; 
			move_uploaded_file($tmp_file, $destination) or die("error");
			$loc='txt_to_db_update_by_date.php';
			header("Location:$loc"."?file_kakao=$filename");
		}else{
	?>
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="form">
		<input type="file" name="file_kakao"> <!-- multiple --> <br>
		<input type="submit" name="submit" value="파일저장">
	</form>
	<?}?>
</body>
</html>
