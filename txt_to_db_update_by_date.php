<meta http-equiv="content-Type" content="Text/html" charset="euc-kr">
<?php
	if(isset($_GET['file_kakao'])){
		$file_kakao = $_GET['file_kakao'];
		echo '---------------------------'.$file_kakao;
	}
?>
<html>
<head>
<meta http-equiv="content-Type" content="Text/html" charset="euc-kr">
</head>
<body>
<?php
	function get_reply_speed($who,$who_before,$time,$time_before){
		if($who != $who_before){
			return "MINUTE(TIMEDIFF('$time', '$time_before')";
		}
	}

	function get_month_eng($md){
		switch ($md){
			case 'January' :
				$month=1;
				break;
			case 'Feburary' :
				$month=2;
				break;
			case 'March' :
				$month=3;
				break;
			case 'April' :
				$month=4;
				break;
			case 'May' :
				$month=5;
				break;
			case 'June' :
				$month=6;
				break;
			case 'July' :
				$month=7;
				break;
			case 'August' :
				$month=8;
				break; 
			case 'September' :
				$month=9;
				break;
			case 'October' :
				$month=10;
				break;
			case 'November' :
				$month=11;
				break;
			case 'December' :
				$month=12;
				break;
		}
		return $month;
	}
	/*
	function get_qurter($h,$m,$h_final){
		if($m>=0 && $m<=15 && $h==$h_final){
			return 1;
		}
		else if($m>15 && $m<=30 && $h==$h_final){
			return 2;	
		}
		else if($m>30 && $m<=45 && $h==$h_final){
			return 3;	
		}
		else{
			return 4;
		}
	}
	*/
?>
<?php
// DB connection & table 정보
include "./db_connection.inc";

// 한글깨짐 : db->utf8로 저장
mysqli_query ( $dbc, "SET NAMES 'utf8'" );

// file name
//$filename_a = 'KakaoTalk_20150102_1003_23_564_신땡땡.txt';
$filename = $file_kakao;
//$filename = iconv ( "UTF-8", "EUC-KR", $filename_a );
echo '22==='.$filename."<br>";
$arr_filename = explode ( '_', $filename );
$arr_filename2 = explode ( '.', $arr_filename [5] );
  //user(고객) 이름
$user = $arr_filename2 [0];
echo "33==".$user;
//$temp = file ( './files/'.$filename ) ; // 파일을 받아서
	$destination = './files/'.$filename;
	$temp = file ( $destination ) ;
$cnt = count ( $temp ); // 몇줄이냐
//quarter 처음 무조건 1
$quarter=1;
/* 
// get number of saved line
$q_numOfSavedLine = "SELECT MAX($text_line) FROM $tablename"; // 추가해야됨 : where user="누구"
$res_numOfSavedLine = mysqli_query ( $dbc, $q_numOfSavedLine ) or die ( "ERROR: QUERY - GET NUM OF SAVED LINE" );
$tmp_line = mysqli_fetch_array ( $res_numOfSavedLine );
$numOfSavedLine = $tmp_line [0];

if ($numOfSavedLine == null) {
	$numOfSavedLine = 0;
}
 */

//마지막으로 넣은 날짜, 시간 SELECT //get date and time of last row 
$query = "SELECT DATE FROM TEXT ORDER BY `id` DESC LIMIT 1";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
$last_date = $row[$text_date];
//$last_time = $row[$text_time];
echo $last_date/*.' '.$last_time*/;
/*
 * $file = 'log.txt'; // 불러올 파일명 $f = fopen( $filename, "r" ); // 파일을 열어 '읽기만' 한다. (포인터는 파일의 맨 처음) while ( ( $line = fgets( $f, 4096 ) ) !== false ) { // 파일이 끝날 때까지 loop echo $line,'<br />'; // 한 줄을 출력한다. } fclose($f) // 파일을 닫는다.
 */

for($i = 0; $i < $cnt; $i ++) {
	//$first=지금 대화하는 사람 이름
	$tmp = explode ( "] [", $temp[$i] );
	//echo "==>".var_dump(iconv_get_encoding('all'))."<br>"; */
	$first = ltrim ( $tmp [0], "[" ); // '['문자 제거!
	//$first = iconv ( "utf-8", "euc-kr", $first ); //utf-8 -> euc-kr
	//echo $first."<br>";
	///////////////////////////////////
	
	
	//영어면 //Friday, January 2, 2015
	if(strpos($first, "Sunday, ") || strpos($first, "Monday, ") || strpos($first, "Tuesday, ") || strpos($first, "Wednesday, ") || strpos($first, "Thursday, ") || strpos($first, "Friday, ") || strpos($first, "Saturday, ") ) {
		if(strpos($first, "January") || strpos($first, "Feburary") || strpos($first, "March") || strpos($first, "April") || strpos($first, "May") || strpos($first, "June") || strpos($first, "July") || strpos($first, "August") || strpos($first, "September") || strpos($first, "October") || strpos($first, "November") || strpos($first, "December")  )  {
			$tmpp=explode(", ", $temp[$i]);
			$month_day=explode(" ", $tmpp[1]);
			//$day=$tmpp[0]; //요일:day of the week
			$day=$month_day[1];
			$year=$tmpp[2];
			$month = get_month_eng($month_day[0]);
			
			//date
			$date=date("Y-m-d", mktime(null,null,null,$month,$day,$year));
			echo 'dddd'.$date;
		}
		
	} 
	//한국어면 //2015년 3월 16일 월요일
	else if(strpos($first, "년 ") && strpos($first, "월 ") && strpos($first, "일 ") && strpos($first, "요일") ){ //first에 january가 있다면
		$rep1=str_replace("년 ", "-", $first);
		$rep2=str_replace("월 ", "-", $rep1);
		$exp1=explode("일", $rep2);
		//date
		$date = $exp1[0];
	}

	//날짜 부분 아니면!!!!!! (=) 일반 대화부분
	else{
		$first = iconv ( "utf-8", "euc-kr", $first );
		if (strcmp ( $first, $user ) != 0) { //	 $first != $user
			if ($tutor == null) {
				$tutor = $first;
			}
			$who = 'T';
		} else {
			$who = 'U';
		}
		
		// 추가된 대화면  //else{skip}
		if($date>$last_date){
			$time='';
			$arr = explode ( "] ", $tmp[1] );
			
			
			//AM - PM 
			if(eregi(" AM", $arr[0])){
				$time = str_replace(" AM", "", $arr[0]);
			}
			else if(eregi("오전 ", $arr[0])){
				$time = str_replace("오전 ", "", $arr[0]);
			}
			// PM -> +12hours
			else if(eregi(" PM", $arr[0])){
				$time = str_replace(" PM", "", $arr[0]);
				$tm2 = explode(":", $tm1);
				$tm_hour = $tm2[0]+12;
				$time = $tm_hour.':'.$tm2[1];
			}
			else if(eregi("오후 ", $arr[0])){
				$tm1 = str_replace("오후 ", "", $arr[0]);
				$tm2 = explode(":", $tm1);
				$tm_hour = $tm2[0]+12;
				$time = $tm_hour.':'.$tm2[1];
			}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
//////////////////////////////0317///////////////////////0317///////////////////////0317/////////////////0317///////////0317//////////////0317/////////0317////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$reply_speed = get_reply_speed($who,$who_before,$time,$time_before);
			
			//이전 대화가 Tutor인지 User인지
			if(!empty($who)){$who_before = $who;}
			if(!empty($time)){$time_before = $time;}
			
			$contents = addslashes( $arr[1] ); // (' 앞에 \추가)
			$size_of_contents=strlen($contents);
			if (strpos ( $contents, "*" ) === false) { //
				$correct = 1;
			} else {
				$correct = 0;
			}

			//UPDATE DIALOGUE : 줄바꿈->한대화로 묶기
			if ($first != $tutor && $first != $user) {
				$query2 = "SELECT CONTENTS FROM TEXT ORDER BY  `TIME` DESC LIMIT 1"; // WHERE DATE='$date'
				$result = mysqli_query ( $dbc, $query2 ) or die ( "error: query 33." );
				$tmp_contents = mysqli_fetch_array ( $result );
				
				$contents = addslashes ( $first ); // delete?
				
				$tmp_contents_addslashes = addslashes ( $tmp_contents [0] );
				//contents2 : update dialogue
				$contents2 = addslashes ( $tmp_contents[0] ).addslashes ( $contents );
				$size_of_contents2 = strlen($contents2);
				$query2 = "UPDATE $tablename ".
						  "SET $text_contents='$contents2', ".
						  "SIZE=$size_of_contents2 ".
						  "WHERE $text_contents='$tmp_contents_addslashes'";
				mysqli_query($dbc, $query2);
			}
			
			//get qurter : 15분 단위로 끊기
			$tm_m = explode(":", $time);
			if(!isset($tm_h)){ $tm_h=$tm_m[0]; }
			//$qurter = get_qurter($tm_m[0], $tm_m[1], $tm_h);
			if($tm_m[1]>=0 && $tm_m[1]<=15 && $tm_m[0]==$tm_h){
				$quarter=1;
			}
			else if($tm_m[1]>15 && $tm_m[1]<=30 && $tm_m[0]==$tm_h){
				$quarter=2;	
			}
			else if($tm_m[1]>30 && $tm_m[1]<=45 && $tm_m[0]==$tm_h){
				$quarter=3;	
			}
			else{
				$quarter=4;
			}
			//user 인코딩
			$user_iconv = iconv("euc-kr", "utf-8", $user);
			//SAVE DIALOGUE //대화 내용 저장 (일반)
			$query = "INSERT INTO TEXT " .
					 "SET $text_user='$user_iconv'".
					 ",$text_tutor='$tutor'".
					 ",$text_date='$date'".
					 ",$text_time='$time'".
					 ",$text_contents='$contents'".
					 ",$text_correct='$correct'".
					 ",$text_who='$who'".
					 ",QUARTER=$quarter".
					 ",SIZE=$size_of_contents"
					 ;

			if(!empty($reply_speed)){
				$query.=",REPLY_SPEED=$reply_speed)";
			}
			if ($first != null && $time != null && $contents != null) { // $contents!="" //strpos($contents,null)===false
				mysqli_query ( $dbc, $query ) or die ( "error: query dialogue." );
			}


			// 맨 마지막에 txt파일 line 수 저장.(line field에) //이제 필요없음..
			if ($i == $cnt - 1) {
				$q_countline = "UPDATE TEXT SET LINE=$cnt ORDER BY `TIME` DESC LIMIT 1";
				mysqli_query ( $dbc, $q_countline ) or die ( "error: query - countline" );
			}
		}

	}
} //for(한줄씩 받기) 끝



//TUTOR 답장 속도
$query = "SELECT MIN(REPLY_SPEED) AS min, MAX(REPLY_SPEED) AS max, AVG(REPLY_SPEED) AS avg FROM TEXT WHERE WHO='T'";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result)){
	$min_t = $row['min'];
	$max_t = $row['max'];
	$avg_t =  $row['avg'];

}
//USER 답장 속도
$query = "SELECT MIN(REPLY_SPEED) AS min, MAX(REPLY_SPEED) AS max, AVG(REPLY_SPEED) AS avg FROM TEXT WHERE WHO='U'";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result)){
	$min_u = $row['min'];
	$max_u = $row['max'];
	$avg_u =  $row['avg'];

}
//15분 단위 TUTOR 답장 평균 속도
for($i=1; $i<=4; $i++){
	$query = "SELECT AVG(REPLY_SPEED) AS avg FROM TEXT WHERE WHO='T' AND QUARTER=$i";
	$result = mysqli_query($dbc,$query);
	while($row = mysqli_fetch_array($result)){
		$qut_t[$i-1] = $row['avg'];
	}
}
for($i=1; $i<=4; $i++){
	echo 'aaa'.$qut_t[$i-1]."<br>";
}
echo "<br>";
//15분 단위 USER 답장 평균 속도
for($i=1; $i<=4; $i++){
	$query = "SELECT AVG(REPLY_SPEED) AS avg FROM TEXT WHERE WHO='U' AND QUARTER=$i";
	$result = mysqli_query($dbc,$query);
	while($row = mysqli_fetch_array($result)){
		$qut_u[$i-1] = $row['avg'];
	}
}
for($i=1; $i<=4; $i++){
	echo 'aaa'.$qut_u[$i-1]."<br>";
}

//대화 길이 최소, 최대, 평균
$query = "SELECT MIN(SIZE) AS min, MAX(SIZE) AS max, AVG(SIZE) AS avg FROM TEXT";
$result = mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result)){
	$min_size = $row['min'];
	$max_size = $row['max'];
	$avg_size =  $row['avg'];
}
//echo $min_size.'/'.$max_size.'/'.$avg_size;

//INDICATOR DB에 저장
$query = "INSERT INTO INDICATOR ".
		 "SET ".
		 "IND_DATE='$date'".
		 ",IND_TUTOR_MAX=$max_t".
		 ",IND_TUTOR_MIN=$min_t".
		 ",IND_TUTOR_AVG=$avg_t".
		 ",IND_MEMBER_MAX=$max_u".
		 ",IND_MEMBER_MIN=$min_u".
		 ",IND_MEMBER_AVG=$avg_u".
		 ",IND_TUTOR_15MIN_1=$qut_t[0]".
		 ",IND_TUTOR_15MIN_2=$qut_t[1]".
		 ",IND_TUTOR_15MIN_3=$qut_t[2]".
		 ",IND_TUTOR_15MIN_4=$qut_t[3]".
		 ",IND_MEMBER_15MIN_1=$qut_u[0]".
		 ",IND_MEMBER_15MIN_2=$qut_u[1]".
		 ",IND_MEMBER_15MIN_3=$qut_u[2]".
		 ",IND_MEMBER_15MIN_4=$qut_u[3]".
		 ",IND_LETTER_MAX=$max_size".
		 ",IND_LETTER_MIN=$min_size".
		 ",IND_LETTER_AVG=$avg_size"
		 ;
mysqli_query($dbc,$query) or die("indicator error");

mysqli_close ( $dbc );

?>

</body>
</html>