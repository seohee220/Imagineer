<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/inc_head.php";?>
<BR><BR>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
 <style type="text/css">
		a { text-decoration:none}
		a:link {color:black;}
		a:visited{ color:black;}
		a:hover{ color:gray }

		/*순서 마크업 css 시작*/
		p.num{padding-top:10px;text-align:center;}
		p.num img{vertical-align:middle;}
		p.num>a{padding:0 3px;}
		#wrap{width:1204px;height:615px; margin:0 auto;}
		/*#board_wrap{width:800px;height:600px; margin:0 auto;border:1px solid black;}*/
		#header{width:1204px; height:150px;}
		/*순서 마크업 css 끝*/
		
		.mb40{margin-bottom:40px; }
		.apply_btn { float:right; }
		.ft { font-size:15pt;} 
		#center{float:left; width:330px; height:400px;}
		#list {float:right; margin-top:10px; margin-right:100px;}
		#bot { margin-top:500px;}
		p.calendar_control{width:330px;height:36px;background-color:#00bc9c;font-size:18px;color:#ffffff;text-align:center;padding-top:5px;}
		table.calendar{border:1px solid #dddddd;width:330px;height:252px;text-align:center;color:#888888;margin-bottom:40px;}
		table.calendar td a{color:#888888;}
		table.calendar th.sunday{color:#d01919;}
		table.calendar th { width:34px;height:26px;padding-top:8px;position:relative;left:10px; }
		table.calendar th.saturday{color:#167aad;}
		table.calendar td a.today{display:block;background:url("/images/apply/today.jpg") 0 0 no-repeat;font-weight:bold;color:#ffffff;width:34px;height:26px;padding-top:8px;position:relative;left:5px;}
		
	</style>

 <?
	$page = $_REQUEST['page'];
	if(!$page) $page=1;
	$num_per_page=10;
	$page_per_block=10;
  
	//넘버링용
	$query="SELECT COUNT(idx) FROM APPLY_SECOND WHERE idx > '1583'";
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
	
	$k=$total_record-($num_per_page*($page-1));  //게시판번호구하기
	$i=1;
	
?>
 </head>
 <body>
<center>
	<form name="myform" action="tutor_schedule.php" method="post" id="person_list" class="form-inline"  role="form">
		<input type="hidden" name="inc" value="">
		<input type="hidden" name="idx" value="<?=$idx?>">
		<input type="hidden" name="page" value="<?=$page?>" />
		<table border=1 color=gray width=800px style="border-collapse:collapse;border-spacing:0" summary="Tutor Schedule_List">
			<thead>
				<tr>
					<th style="width:50px">번호</th>
					<th style="width:130px">Korean Day</th>
					<th style="width:100px">Korean Time</th>
					<th style="width:100px">Korean Name</th>
					<th style="width:100px">English Name</th>
					<th style="width:100px">Kakao ID</th>
					<th style="width:100px">Feedback</th>
					<!--th scope="col"><input type='checkbox' onclick="AllCk();" name='all_chkstock' value='' id='chkstock' class='check01' onfocus='this.blur();'></th-->
				</tr>
			</thead>

			<tbody>
				<?
				
				$query = "SELECT *
			        FROM APPLY_SECOND 
				   WHERE idx > '0' ORDER BY idx DESC limit $first, $last";
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
				<tr name="apply_time" id="<?=$ApplyTime?>" align="center">
				<script> colorful(); </script> <!-- 색채우기 -->
					<td><?=$cnt?></td>
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
				}//while문 종료


				
				?>
			</tbody>
		</table>



	<!-- 순서 마크업 html 시작 -->
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
		<img src="/bizadmin/images/next_btn.gif" alt="다음으로" /></a></p>
		<!-- 순서 마크업 html 끝 -->
                        
                      
	</form>
</center>
 </body>
</html>