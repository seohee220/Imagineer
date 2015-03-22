<? include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

 
<?
    $inc = $_REQUEST['inc'];
    if(!$inc) $inc = "I";
    $page = $_REQUEST['page'];	
    if(!$page) $page=1;	
    if(!is_numeric($page)) $page=1;
    $page = (int)$page;            	 
    $idx = $_REQUEST['idx'];
    If ($idx == "") {
	    msg_back("잘못된 접근입니다.");
	    exit;
    }		

    $query= "SELECT * FROM Board_Tutor WHERE idx IN ('$idx') ";
    $result=mysql_query($query,$dbconn) or die($query.mysql_error());
    if(!mysql_num_rows($result)){
	    msg_back("조회대상 정보가 불확실 합니다.");
	    exit;
    }
    $row = mysql_fetch_array($result);
	$Notice = $row[Notice];
	$Title = $row[Title];
	$Content = $row[Content];
	$ID = $row[ID];
	$RegDate = $row[RegDate];


    $rtnURL = "sample_apply_tutor_view.php?page=$page";
?>
</head>

<body>
	<div class="col-xs-12 col-sm-9">
		<div>
			<table  border=1>
				<tbody>
						<tr>
						<th style='width:10%' class='active'>Title</th>
						<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Title?></td>
					</tr>
					<tr>
						<th style='width:10%' class='active'>ID</th>
						<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$ID?></td>
					</tr>
					<tr>
						<th style='width:10%' class='active'>Notice</th>
						<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Notice?></td>
					</tr>
					<tr>
						<th style='width:10%' class='active'>작성일자</th>
						<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$RegDate?></td>
					</tr>
					<tr>
						<th style='width:10%' class='active'>Content</th>
						<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Content?></td>
					</tr>
				</tbody>
			</table>


			<p >


			<a href="tutor_schedule.php"> 목록으로</a>

		</div>
	</div>
      


</body>
</html>







