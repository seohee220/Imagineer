<?  include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 튜터 관리자 페이지 </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" id="browser_mode" content="IE=edge" />
   
    <!-- IE6~8에서 HTML5 태그를 지원하기위한 HTML5 shim -->
    <!--[if lt IE 9]>
      <script src="/bootstrap/js/html5shiv.js"></script>
    <![endif]-->

	<?
		session_start();
		if($_SESSION['username'] == "") {
			msg("로그인 후 이용해 주시길 바랍니다.");
			go_url("/landing/tutor/");
		}

	?>
  </head>
  <body width="800px"><center>
  <a href="tutor_schedule.php">Home</a>&nbsp;&nbsp;
  <?
		if($_SESSION['author']=="ADMIN")
		{
			echo("<a href='show_list.php'>");
?>
			list</a>&nbsp;&nbsp;
<?
		}

		echo($_SESSION['username']);
		echo("님");
		echo("&nbsp;&nbsp;<a href='logout.php'>");
  ?>Log Out </a>
  </center>
  </body>
 </html>