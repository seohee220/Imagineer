<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/inc_head.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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

  <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="../js/calendar.js"></script>
  <script type="text/javascript" src="../js/time.js"></script>
  <script type="text/javascript">
        function EnterKeyCheck() {
            if (event.keyCode == 13) { myform1.submit(); }
            else { return false; }
        }
        function GotoViewPage(idx) {
            document.getElementById("loadingspinner").style.display = "block"
            myform.idx.value = idx
            myform.action = "tutor_view.php"
            myform.submit();
        }

		function GotoList() {
            if ((myform.ApplyWeek.value == '토') || (myform.ApplyWeek.value == '일')) { alert("날짜를 다시 선택하여 주세요!"); myform.ApplyWeek.focus(); return false; }
			if (myform.ApplyDay.value == '') { alert("날짜를 선택하세요"); myform.ApplyDay.focus(); return false; }
			myform.page.value=1;
		
			myform.target = "";
			myform.action = "tutor_schedule.php";
			myform.submit();
        }
        
		function colorful(x)
		{
			if(x=="AM 07:00")
				document.getElementById("AM 07:00").style.backgroundColor = "#ffedf3";
			else if(x=="AM 08:00")
				document.getElementById("AM 08:00").style.backgroundColor = "#faf7ff";
			
			else if(x=="AM 09:00")
				document.getElementById("AM 09:00").style.backgroundColor = "#D4F2FA";
			else if(x=="AM 10:00")
				document.getElementById("AM 10:00").style.backgroundColor = "#FAC3FA";
			else if(x=="AM 11:00")
				document.getElementById("AM 11:00").style.backgroundColor = "#B0FBCA";
			else if(x=="PM 06:00")
				document.getElementById("PM 06:00").style.backgroundColor = "#FEEDCD";
			else if(x=="PM 07:00")
				document.getElementById("PM 07:00").style.backgroundColor = "#FCC4E6";
			else if(x=="PM 08:00")
				document.getElementById("PM 08:00").style.backgroundColor = "#EDF2FE";
			else if(x=="PM 09:00")
				document.getElementById("PM 09:00").style.backgroundColor = "#E7D6FE";
			else
				document.getElementById("PM 10:00").style.backgroundColor = "#9EFED6";
			
		}

    </script>

 <?
    $ApplyDay = $_REQUEST['ApplyDay'];
    $inc	=	$_REQUEST['inc'];
    if(!$inc) $inc="write";


	$page = $_REQUEST['page'];
	if(!$page) $page=1;
	$num_per_page=10;
	$page_per_block=10;
  
	//넘버링용
	$query="SELECT COUNT(idx) FROM APPLY_SECOND WHERE ApplyDay = '{$ApplyDay}' ";
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
            <div id="wrap">
				<div id="center">
					<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/tutor_search_kakaoid.php";?>

					<div id="center_bottom">
						<h3>Choice Day : <font class="ft"><span id="choice_date"></span>&nbsp;&nbsp;<span id="choice_time"></span>&nbsp;&nbsp;<span id="weekday"></span></font></h3>
						<form name="myform" action="tutor_schedule.php" method="post" id="person_list" class="form-inline"  role="form">
						<input type="hidden" name="inc" value="">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="page" value="<?=$page?>" />

						<div class="cal_wrap">
							<input id="input_Day" name="ApplyDay" value=""  type="hidden"/>
							<input id="input_Time" name="ApplyTime" value="" type="hidden"/>
							<input id="input_Week" name="ApplyWeek" value="" type="hidden"/>
							<input id="input_Day2" name="ApplyDay2" value="" type="hidden"/>

							<p class="calendar_control">
							<a href="#" title="이전달"><img src="/images/apply/calendar_prev.jpg" alt="이전달" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span class="yymm">8 2013</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#" title="다음달"><img src="/images/apply/calendar_next.jpg" alt="다음달" /></a>
							</p>
							<div id="calendar">
								<table summary="달력" class="calendar">
								<caption class="hid">Calendar</caption>
									<colgroup>
										<col width="15%"/>
										<col width="14%" />
										<col width="14%" />
										<col width="14%" />
										<col width="14%" />
										<col width="14%" />
										<col width="15%" />
									</colgroup>
									<thead>
										<tr>
											<th class="sunday">Sun</th>
											<th>Mon</th>
											<th>Tue</th>
											<th>Wed</th>
											<th>Thu</th>
											<th>Fri</th>
											<th class="saturday">Sat</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1<span>스케쥴내용</span></td>
											<td>2</td>
											<td>3</td>
											<td>4</td>
											<td>5</td>
											<td>6</td>
											<td>7</td>
										</tr>
									</tbody>
								</table>
							</div><!-- #calendar 끝 -->
						</div><!-- .cal_wrap 끝 -->
					</div><!-- #center_bottom 끝 -->
					<p class="apply_btn" style="text-align:legt;">
						<a href="#" onclick="javascript:GotoList();return false;"><img src="/images/button/confirm3.jpg" alt="확인" /></a>
					</p>
				</div><!-- #center 끝-->
        
				<div id="list">
                    <div style="border:1px solid black; width:610px; height:270px; padding:10px; margin-bottom:10px;">
                        <!-- 필리핀은 코리안 타임에서 한시간 뺀 시간이야. 우간다 시간은 코리안 타임에서 6시간 뺀 시간이야. 꼭 참고하도록 해. -->
						<table border="0" cellspacing="0" cellpadding="0" style="float:left">
							<tr>
								<td align="center">
									<script type="text/javascript" src="http://www.worldtimeserver.com/clocks/embed.js">
									</script>
									<script type="text/javascript" language="JavaScript">objKR=new Object;objKR.wtsclock="wtsclock001.swf";objKR.color="FF9900";objKR.wtsid="KR";objKR.width=180;objKR.height=200;objKR.wmode="transparent";showClock(objKR);
									</script>
								</td>
							</tr>
							<tr>
								<td align="center"><h2>Seoul</h2>
								</td>
							</tr>
						</table>
						
						<table border="0" cellspacing="0" cellpadding="0" style="float:left">
							<tr>
								<td align="center">
									<script type="text/javascript" src="http://www.worldtimeserver.com/clocks/embed.js">
									</script>
									<script type="text/javascript" language="JavaScript">objPH=new Object;objPH.wtsclock="wtsclock001.swf";objPH.color="FF9900";objPH.wtsid="PH";objPH.width=180;objPH.height=200;objPH.wmode="transparent";showClock(objPH);
									</script>
								</td>
							</tr>
							<tr>
								<td align="center"><h2>Manila</h2>
								</td>
							</tr>
						</table>
						
						<table border="0" cellspacing="0" cellpadding="0" style="float:left">
							<tr>
								<td align="center">
									<script type="text/javascript" src="http://www.worldtimeserver.com/clocks/embed.js">
									</script>
									<script type="text/javascript" language="JavaScript">objUG=new Object;objUG.wtsclock="wtsclock001.swf";objUG.color="FF9900";objUG.wtsid="UG";objUG.width=180;objUG.height=200;objUG.wmode="transparent";showClock(objUG);
									</script>
								</td>
							</tr>
							<tr>
								<td align="center"><h2>Kampala</h2>
								</td>
							</tr>
							</table>
                        
                        </div>
					<?echo($ApplyDay);?>

					<table border=1 color=gray width=630px style="border-collapse:collapse;border-spacing:0" summary="Tutor Schedule_List">
						<thead>
							<tr>
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
							
							$query = "SELECT * FROM APPLY_SECOND WHERE ApplyDay = '{$ApplyDay}' ORDER BY ApplyTime ASC limit $first, $last";
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
							<script> colorful('<?=$ApplyTime?>'); </script> <!-- 색채우기 -->
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
					echo("<a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$my_page&ApplyDay=$ApplyDay&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\" class='ctn'>");
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
							echo(" <a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$direct_page&ApplyDay=$ApplyDay&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='jump to page $direct_page';return true;\" onMouseOut=\"status=''\">$direct_page</a> ");
						}
					}
				?> 
						
				<?
					if($page<$total_page)
					{
						$my_page=$page+1;
						echo(" <a href=\"http://{$_SERVER[HTTP_HOST]}$_SERVER[PHP_SELF]?page=$my_page&ApplyDay=$ApplyDay&BoardID=$BoardID&idx=$idx&inc=list\" onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\">");
					}
				?>						
						<img src="/bizadmin/images/next_btn.gif" alt="다음으로" /></a></p>
						<!-- 순서 마크업 html 끝 -->
                        
                        
                        
				</div>
	</form>


	
	</div><!-- #left 끝 -->
	</div><!-- #container 끝 -->
    
    
    </div><!-- #warp 끝 -->


    <div id = "board_wrap">
	<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/board.php";?>    

    
    </div>

	</body>
</html>
