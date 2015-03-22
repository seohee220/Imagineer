<? include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>

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

		
		.mytable { border-collapse:collapse; }  
		.mytable th, .mytable td { border:1px solid black; }

	</style>

<?
	$page = $_REQUEST['page'];
	if(!$page) $page=1;
	$num_per_page=10;
	$page_per_block=10;

	$query="SELECT COUNT(idx) FROM Board_Tutor";
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
<table class="mytable" color=gray width=630px summary="Tutor Schedule_List">
			<thead>
				<tr>
					<th style="width:80px">순서</th>
					<th style="width:80px">알림</th>
					<th style="width:300px">Title</th>
					<th style="width:100px">ID</th>
					<th style="width:100px">Date</th>
					<!--th scope="col"><input type='checkbox' onclick="AllCk();" name='all_chkstock' value='' id='chkstock' class='check01' onfocus='this.blur();'></th-->
				</tr>
			</thead>

			<tbody align="center">
<?

			$query = "SELECT *
			        FROM Board_Tutor 
				   WHERE idx > '0' ORDER BY idx DESC limit $first, $last";
			$result=mysql_query($query);



			while($row = mysql_fetch_array($result)) {
			$idx = $row[idx];
			$Title = $row[Title];
			$ID = $row[ID];
			$Date = $row[RegDate];
			$Content = $row[Content];
			$Notice = $row[Notice];
			$cnt = ($notice_num>0) ? "<font color='red' style='font-weight:bold;'>[공지]</font>" : $k;
?>
				<tr>
					<td><?=$cnt?></td>
					<td><?=$Notice?></td>
					<td><a href="read.php?idx=<?=$idx?>"><?=$Title?></a></td>
					<td><?=$ID?></td>
					<td><?=$Date?></td>
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
		<img src="/bizadmin/images/next_btn.gif" alt="다음으로" /></a>
	</p>

	<a href="write.php"><input type="button" name="Write" value="글쓰기"></a>
	</center>
</body>
</html>