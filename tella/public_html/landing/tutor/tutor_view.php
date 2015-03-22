<?include "{$_SERVER[DOCUMENT_ROOT]}/landing/tutor/inc_head.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<style type="text/css">
	 
	.mytable { border-collapse:collapse; }  
	.mytable th, .mytable td { border:1px solid black; }
	</style>

    <script type="text/javascript">
		
        function GotoUpdatePage() {
			document.myform.target="";
            document.myform.action = "tutor_input.php"
            document.myform.submit();
        }
		function GotoDelete() {
			document.myform.inc.value = "Del";
            document.myform.target = "";
            document.myform.action = "tutor_proc.php";
            document.myform.submit();
        }


        function CheckStr(strOriginal, strFind, strChange) {
            var position, strOri_Length;

            position = strOriginal.indexOf(strFind);

            while (position != -1) {
                strOriginal = strOriginal.replace(strFind, strChange);
                position = strOriginal.indexOf(strFind);
            } 
            return strOriginal;
        }
    </script>
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

    $query= "SELECT * FROM APPLY_SECOND WHERE idx IN ('$idx') ";
    $result=mysql_query($query,$dbconn) or die($query.mysql_error());
    if(!mysql_num_rows($result)){
	    msg_back("조회대상 정보가 불확실 합니다.");
	    exit;
    }
    $row = mysql_fetch_array($result);
	$idx = $row[idx];
	$Kor_Name = $row[Kor_Name];
	$Tel = $row[Tel];
	$Eng_Name = $row[Eng_Name];
	$KaKaoId = $row[KaKaoId];
	$Email = $row[Email];
	$ApplyDay = $row[ApplyDay];
	$ApplyTime = $row[ApplyTime];
	$RegDate = substr($row[RegDate],0,10);
    $RegDate = $row[RegDate];
    $RegIP = $row[RegIP];
	$Memo = $row[Memo];
	$Job = $row[Job];
	$Age = $row[Age];
	$PurposeOfStudy = $row[PurposeOfStudy];
	$ExperienceOfStudy = $row[ExperienceOfStudy];
	$Expression = $row[Expression];
	$Grammar = $row[Grammar];
	$ReplyingSpeed = $row[ReplyingSpeed];


    $rtnURL = "tutor_schedule.php";
?>
</head>

<body align="center">
			<div class="col-xs-12 col-sm-9">
                <div >
                    <h3> 무료체험신청 상세내용</h3>
							<form name="myform" method="post" action="sample_Schedule_List.php" class="form-inline"  role="form">
								<input type="hidden" name="inc" value="<?=$inc?>" />
								<input type="hidden" name="idx" value="<?=$idx?>" />
								<input type="hidden" name="page" value="<?=$page?>" />
								<input type="hidden" name="keyfeild" value="<?=$keyfeild?>" />
								<input type="hidden" name="key" value="<?=$key?>" />
								<input type="hidden" name="rtnURL" value="<?=$rtnURL?>" />
								<center>
								<table class="mytable">
									<tbody>
									<tr>
										<th style='width:100px' class='active'>접수순번</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$idx?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>한글이름</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Kor_Name?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>전화번호</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Tel?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>영어이름</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Eng_Name?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>카카오톡ID</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$KaKaoId?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>이메일</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Email?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>체험날짜</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$ApplyDay?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>체험반</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$ApplyTime?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>등록일자</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$RegDate?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>등록IP</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$RegIP?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>직업</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Job?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>나이</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Age?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>Purpose Of Study</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$PurposeOfStudy?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>Experience Of Study</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$ExperienceOfStudy?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>Expression</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Expression?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>Grammar</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Grammar?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>ReplyingSpeed</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$ReplyingSpeed?></td>
									</tr>
									<tr>
										<th style='width:100px' class='active'>비고</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:300px;"><?=$Memo?></td>
									</tr>
									</tbody>
								</table>
							  </center>

					<p >
						
						
									 <a href="#" onclick="javascript:GotoUpdatePage();return false;"> 수정</a>
									 &nbsp;
									 <? if($_SESSION['username'] == "tellakor") { ?>
									  <a href="#" onclick="javascript:GotoDelete();return false;"> 삭제</a>
									  <? } ?>
					</p>
</form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>







