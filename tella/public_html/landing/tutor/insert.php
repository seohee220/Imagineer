<?  include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?
	session_start();
	if($_SESSION['username'] == "") {
		msg("로그인 후 이용해 주시길 바랍니다.");
		go_url("/landing/tutor/");
	}
	$inc = $_POST['inc'];
	$page = $_REQUEST['page'];	
	if(!$page) $page=1;	
	if(!is_numeric($page)) $page=1;
	$page = (int)$page;	
	$idx = $_POST['idx'];
	if(!$idx) $idx=0;	
	if(!is_numeric($idx)) $idx=0;

	if($inc =="Mod" || $inc =="Del" || $inc =="Del_File" ){
		if ($idx == "") {
			msg_back("잘못된 접근입니다.1");
			exit;
		}
	}
	$RegDate = $_POST['RegDate'];
	$ID = $_SESSION['username'];
	$Content = $_POST['Content'];
	$Title = $_POST['Title'];
	$Notice = $_POST['Notice'];

	$query=" SELECT IFNULL(MAX(idx),0)+1  AS idx FROM Board_Tutor ";
	$result=mysql_query($query,$dbconn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$idx = $row[idx];
	mysql_free_result($result);

	$query = "SELECT max(thread) FROM Board_Tutor";
	$max_thread_result = mysql_query($query, $dbconn);
	$max_thread_fetch = mysql_fetch_row($max_thread_result);

	$max_thread = ceil($max_thread_fetch[0]/1000)*1000+1000;
	 $query="INSERT INTO Board_Tutor
				 SET
					 ID = '$ID'
					,Notice='$Notice'
					,Content = '$Content'
					,Title = '$Title'
					,RegDate = '$RegDate'
					,thread = '$max_thread'
					,depth = '0'
		  ";
	$result=mysql_query($query, $dbconn);
	


	// 새 글 쓰기인 경우 리스트로..
	echo ("<meta http-equiv='Refresh' content='1; URL=tutor_schedule.php'>");

?>
