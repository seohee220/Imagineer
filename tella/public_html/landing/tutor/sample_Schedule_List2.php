<? include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<style type="text/css">
		/*순서 마크업 css 시작*/
		p.num{padding-top:10px;text-align:center;}
		p.num img{vertical-align:middle;}
		p.num>a{padding:0 3px;}
        #wrap{width:1204px;margin:0 auto;}
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
		#board_rap {float:left; margin-top: 100px; width: 1200px; height: 800px;}
		
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
            myform2.idx.value = idx
            myform2.action = "sample_apply_tutor_view.php"
            myform2.submit();
        }
        function GotoListPage(page) {
            document.getElementById("loadingspinner").style.display = "block"
            if (!(page == 0)) myform2.page.value = page
            myform2.inc.value = "list"
            myform2.action = "sample_Schedule_List.php"
            myform2.submit();
        }

		function GotoList() {
            if ((myform1.ApplyWeek.value == '토') || (myform1.ApplyWeek.value == '일')) { alert("날짜를 다시 선택하여 주세요!"); myform1.ApplyWeek.focus(); return false; }
			if (myform1.ApplyDay.value == '') { alert("날짜를 선택하세요"); myform1.ApplyDay.focus(); return false; }
			myform1.page.value=1;
		
			myform1.target = "";
			myform1.action = "sample_Schedule_List.php";
			myform1.submit();
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
	

	$ban = array("08:00~10:00", "10:00~12:00", "12:00~14:00", "14:00~16:00", "16:00~18:00", "18:00~20:00", "20:00~22:00");


	$query_count1 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[0]}'";
	$result_count1=mysql_query($query_count1);
	$row_count1 = mysql_num_rows($result_count1);

	$query_count2 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[1]}'";
	$result_count2=mysql_query($query_count2);
	$row_count2 = mysql_num_rows($result_count2);

	$query_count3 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[2]}'";
	$result_count3=mysql_query($query_count3);
	$row_count3 = mysql_num_rows($result_count3);

	$query_count4 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[3]}'";
	$result_count4=mysql_query($query_count4);
	$row_count4 = mysql_num_rows($result_count4);

	$query_count5 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[4]}'";
	$result_count5=mysql_query($query_count5);
	$row_count5 = mysql_num_rows($result_count5);

	$query_count6 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[5]}'";
	$result_count6=mysql_query($query_count6);
	$row_count6 = mysql_num_rows($result_count6);

	$query_count7 = "SELECT Ban FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' AND Ban = '{$ban[6]}'";
	$result_count7=mysql_query($query_count7);
	$row_count7 = mysql_num_rows($result_count7);


	
  
	//넘버링용
	$query="SELECT COUNT(idx) FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' ";
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
					<div id="center_bottom">
						<h3>Choice Day : <font class="ft"><span id="choice_date"></span>&nbsp;&nbsp;<span id="choice_time"></span>&nbsp;&nbsp;<span id="weekday"></span></font></h3>
						<form name="myform1" action="sample_Schedule_List.php" method="post" id="person_list" class="form-inline"  role="form">
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
                    <div style="border:1px solid black; width:610px; padding:10px; margin-bottom:10px;">
                        필리핀은 코리안 타임에서 한시간 뺀 시간이야. 우간다 시간은 코리안 타임에서 6시간 뺀 시간이야. 꼭 참고하도록 해.
                        
                        </div>
					<?echo($ApplyDay);?>

					<table border=1 color=gray width=630px summary="Tutor Schedule_List">
						<thead>
							<tr>
								<th style="width:160px">Time</th>
								<th style="width:250px">English Name ( KaKao Talk ID )</th>
								<th style="width:100px">Tutoring</th>
								<th style="width:140px">Check Time</th>
								<!--th scope="col"><input type='checkbox' onclick="AllCk();" name='all_chkstock' value='' id='chkstock' class='check01' onfocus='this.blur();'></th-->
							</tr>
						</thead>

						<tbody>
							<?
							
							$query = "SELECT * FROM APPLY_FREE WHERE ApplyDay = '{$ApplyDay}' ORDER BY Ban ASC limit $first, $last";
							//echo $query; exit;
							$result=mysql_query($query);

							

							while($row = mysql_fetch_array($result)) {
							$idx = $row[idx];
							$KaKaoId = $row[KaKaoId];
							$ApplyDay = $row[ApplyDay];
							$ApplyTime = $row[ApplyTime];
							$Ban = $row[Ban];
							$Eng_Name = $row[Eng_Name];
							$Memo = $row[Memo];
							$checktime = $row[checktime];
							$RegDate = substr($row[RegDate],0,10);
							$cnt = ($notice_num>0) ? "<font color='red' style='font-weight:bold;'>[공지]</font>" : $k;
							$index=1;
							?>
							<tr>
								<td><?=$Ban?></td>
								<td><a href="sample_apply_tutor_view.php?inc=view&idx=<?=$idx?>&page=<?=$page?>&index=<?=$index?>">
								&nbsp;&nbsp;<?=$Eng_Name?> ( <?=$KaKaoId?> )</a></td>
								<td><a href=./check_Tutor.php?idx=<?=$idx?>>
								<center>Tutoring Finish</center></a></td>
								<td><?=$checktime?></td>
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

	<div id = "board_rap"> 여기는 공지사항 구역입니다. </div>
    </div><!-- #wrap 끝 -->

	</body>
</html>
