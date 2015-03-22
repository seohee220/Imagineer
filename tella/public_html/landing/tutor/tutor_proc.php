<?  include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?
    $ConvertFileExt = array("exe","com","bat","asp","php","aspx","spf","inc","js","css","reg","vbs","vb","htm","html");
    $img_ext = array("bmp","gif","jpg","jpeg","png");
    $inc = $_POST['inc'];
	$page = $_REQUEST['page'];	
    if(!$page) $page=1;	
    if(!is_numeric($page)) $page=1;
    $page = (int)$page;	
    $idx = $_POST['idx'];
    if(!$idx) $idx=0;	
    if(!is_numeric($idx)) $idx=0;
    $Kor_Name = $_POST['Kor_Name'];
	$Tel = $_POST['Tel'];
    $Eng_Name = $_POST['Eng_Name'];
    $KaKaoId = $_POST['KaKaoId'];
	$EMail = $_POST['EMail_1']."@".$_POST['EMail_2'];
	if(trim($EMail) == "@") $EMail = "";
    $ApplyDay = $_POST['ApplyDay'];
    $ApplyTime = $_POST['ApplyTime'];
	$RegDate = date("Y-m-d H:i:s");
    $RegIP = $_SERVER[REMOTE_ADDR];
	$Memo = $_POST['Memo'];
	$Job = $_POST['Job'];
	$Age = $_POST['Age'];
	$PurposeOfStudy = $_POST['PurposeOfStudy'];
	$ExpressionOfStudy = $_POST['ExperienceOfStudy'];
	$Expression = $_POST['Expression'];
	$Grammar = $_POST['Grammar'];
	$ReplyingSpeed = $_POST['ReplyingSpeed'];

/*
	if($inc =="Mod" || $inc =="Del" || $inc =="Del_File" ){
        if ($idx == "") {
	        msg_back("잘못된 접근입니다.1");
	        exit;
        }
        if ($_SESSION['SESSION_MemberGroup'] != "ROOT" || $_SESSION['SESSION_MemberAuthority'] != "관리자") {
	        msg_back($_SESSION['SESSION_MemberAuthority']."관리자로 로그인 후 작성하십시오");
	        exit;
        }
    }
*/
 
    if($inc == "Mod") { // '수정
		$Tel = $_POST['Tel'];
        $query= " SELECT * FROM APPLY_SECOND WHERE idx IN ($idx)  ";
        $result=mysql_query($query,$dbconn) or die($query.mysql_error());
        if(!mysql_num_rows($result)){
	        msg_back("등록되지 않은 의뢰건 입니다.");
	        exit;
        }
        $row = mysql_fetch_array($result);

	    $query="UPDATE APPLY_SECOND
			    SET
				Job = '$Job'
				,Age = '$Age'
				,PurposeOfStudy = '$PurposeOfStudy'
				,ExperienceOfStudy = '$ExperienceOfStudy'
				,Expression = '$Expression'
				,Grammar = '$Grammar'
				,ReplyingSpeed = '$ReplyingSpeed'
				,Memo = '$Memo'
                WHERE idx IN ($idx)  ";                                    
        $result=mysql_query($query,$dbconn) or die(mysql_error());	 
		
        if($rtnURL == "")  $rtnURL = "tutor_schedule.php"; 
        msg_replace("정상적으로 수정 되었습니다.",$rtnURL) ;
    }

	if($inc == "Del") { // '삭제
        $query= " SELECT * FROM APPLY_SECOND WHERE idx IN ($idx)  ";
        $result=mysql_query($query,$dbconn) or die($query.mysql_error());
        if(!mysql_num_rows($result)){
	        msg_back("등록되지 않은 문의건 입니다.");
	        exit;
        }

        $query= " DELETE FROM APPLY_SECOND WHERE idx IN ($idx)  ";
        $result=mysql_query($query,$dbconn) or die($query.mysql_error());
        			
         if($rtnURL == "")  $rtnURL = "tutor_schedule";         
        msg_replace("문의건이 정상적으로 삭제 되었습니다.",$rtnURL) ;
	}
?>
