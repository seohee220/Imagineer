<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/inc_head.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title> 텔라 </title>
    <style type="text/css">
	  /*순서 마크업 css 시작*/
	  p.num{padding-top:10px;text-align:center;}
	  p.num img{vertical-align:middle;}
	  p.num>a{padding:0 3px;color:#999;}
	  /*순서 마크업 css 끝*/

	.mytable { border-collapse:collapse; }  
	.mytable th, .mytable td { border:1px solid black; }
  </style>

<?

    $inc	=	$_REQUEST['inc'];
    if(!$inc) $inc="write";
	$sch_key = $_REQUEST['kakaoId'];

	$page = $_REQUEST['page'];	
	if(!$page) $page=1;
	$num_per_page=10;
	$page_per_block=10;

	//검색 쿼리

	$encoded_key=urlencode($key);
  
	//넘버링용
	
	
	$query="SELECT COUNT(idx) FROM APPLY_SECOND WHERE KaKaoId = '{$sch_key}' ";
	
	
	//echo $query;
	$result=mysql_query($query,$dbconn) or die(mysql_error());
	$total_record=mysql_result($result,0,0);

	if(!$total_record){
		$first=1;
		$last=0;
	}else{
		$first=$num_per_page*($page-1);
		$last=$num_per_page;
	}

	$total_page=ceil($total_record/$num_per_page);
	$total_block=ceil($total_page/$page_per_block);
	$block=ceil($page/$page_per_block);
	$first_page=($block-1)*$page_per_block;
	$last_page=$block*$page_per_block;
?>
 </head>

 <body>
<?
		$query = "SELECT * FROM APPLY_SECOND 
				   WHERE KaKaoId='$sch_key' ORDER BY ApplyDay ASC limit $first, $last";
				   $result=mysql_query($query);
	$k=$total_record-($num_per_page*($page-1));  //게시판번호구하기
	$i=1;

	?>

	<form name="myform" method="post" action="<?=$PHP_SELF?>" id="apply_free" role="form">
	<br><br>
	<center>
	<table class="mytable" summary="회원 리스트">
			<thead>
				<tr>
					<th style="width:130px">Korean Day</th>
					<th style="width:100px">Korean Time</th>
					<th style="width:100px">Korean Name</th>
					<th style="width:100px">English Name</th>
					<th style="width:100px">Kakao ID</th>
					<th style="width:100px">Feedback</th>
				</tr>
			</thead>
			<tbody>

<?
	
	$query = "SELECT * FROM APPLY_SECOND WHERE KaKaoId = '{$sch_key}' ORDER BY ApplyDay DESC limit $first, $last";
	//echo $query; exit;
	$result=mysql_query($query);

	while($row = mysql_fetch_array($result)) {
	$idx = $row[idx];
	$Kor_Name=$row[Kor_Name];
	$KaKaoId = $row[KaKaoId];
	$ApplyDay = $row[ApplyDay];
	$ApplyTime = $row[ApplyTime];
	$Eng_Name = $row[Eng_Name];
	$Memo = $row[Memo];
	$Job=$row[Job];
	$Age=$row[Age];
	$PurposeOfStudy=$row[PurposeOfStudy];
	$ExperienceOfStudy=$row[ExperienceOfStudy];
	$Expression=$row[Expression];
	$Grammar=$row[Grammar];
	$ReplyingSpeed=$row[ReplyingSpeed];

	$checktime = $row[checktime];
	$RegDate = substr($row[RegDate],0,10);
	$cnt = ($notice_num>0) ? "<font color='red' style='font-weight:bold;'>[공지]</font>" : $k;
	?>
				<tr align="center">
					<td><?=$ApplyDay?></td>
					<td><a target="_blank" href="tutor_view.php?inc=view&idx=<?=$idx?>&page=<?=$page?>"><?=$ApplyTime?></td>
					<td><a target="_blank" href="tutor_view.php?inc=view&idx=<?=$idx?>&page=<?=$page?>"><?=$Kor_Name?></td>
					<td><a target="_blank" href="tutor_view.php?inc=view&idx=<?=$idx?>&page=<?=$page?>"><?=$Eng_Name?></td>
					<td><a target="_blank" href="tutor_view.php?inc=view&idx=<?=$idx?>&page=<?=$page?>">
					<?=$KaKaoId?></a></td>
					<td>
					<?if($Job==""||$Age==""||$PurposeOfStudy=""||$ExperienceOfStudy=""||$Expression=""||$Grammar=""||$ReplyingSpeed="")
					echo("Not Yet");

					else
					echo("Done");
					?></td>
				</tr>

<?    
		$k-=1;
		$i++;
		}
?>

			</tbody>
		</table>


<?
	if($block>=$total_block)
	{
		$last_page=$total_page;
	}
	?>
	<p class="num">
		<?
		if($page>1)
		{
		$my_page=$page-1;
		echo("<a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$my_page&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\" class='ctn'>");
		}
		?>
		<img src="/bizadmin/images/prev_btn.gif" alt="이전으로" /></a> 

		<?
		for($direct_page=$first_page+1;$direct_page<=$last_page;$direct_page++)
		{
		if($page == $direct_page)
		{	
		echo("&nbsp;<strong>$direct_page</strong>&nbsp;");
		}
		else
		{
		echo(" <a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$direct_page&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='jump to page $direct_page';return true;\" onMouseOut=\"status=''\">$direct_page</a> ");
		}
		}
		?> 

		<?
		if($page<$total_page)
		{
		$my_page=$page+1;
		echo(" <a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$my_page&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\">");
		}
		?>						
		<img src="/bizadmin/images/next_btn.gif" alt="다음으로" /></a>
	</p>

	</form>

</center>
 </body>
</html>