<? include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>

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
        function GotoDataSaveProc() {
			if (myform.Job.value == '') { alert("직업을 입력해주세요."); myform.Job.focus(); return false; }
			if (myform.Age.value=='') { alert("나이를 입력해주세요."); return false;}
			if (myform.PurposeOfStudy.value == '') { alert("Purpose Of Study를 입력해주세요."); myform.PurposeOfStudy.focus(); return false; }
			if (myform.ExperienceOfStudy.value == '') { alert("Expreience Of Study을 입력하세요"); myform.ExperienceOfStudy.focus(); return false; }
			
			
			if (confirm('정확하게 작성하셨습니까?')){
				document.myform.inc.value = "Mod";
				document.myform.target = "";
				document.myform.action = "tutor_proc.php";
				document.myform.submit();
			}
			else{
				return;
			}
		
        }
        function GotoListPage() {
            myform.target = "";
            myform.action = "tutor_view.php"
            myform.submit();
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

        function NumObj(obj) {
            if (event.keyCode >= 48 && event.keyCode <= 57) {
                return true;
            } else {
                event.returnValue = false;
            }
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
	$ExpressionOfStudy = $row[ExpressionOfStudy];
	$Expression = $row[Expression];
	$Grammar = $row[Grammar];
	$ReplyingSpeed = $row[ReplyingSpeed];

	$rtnURL = "tutor_view.php?page=$page&idx=$idx";
?>
</head>

<body>

            <div class="col-xs-12 col-sm-9">
                <div>
                    <h3>무료체험신청 내용 관리</h3>
                <form name="myform" method="post" action="tutor_proc.php" class="form-horizontal"  role="form">
                    <input type="hidden" name="inc" value="<?=$inc?>" />
                    <input type="hidden" name="page" value="<?=$page?>" />
                    <input type="hidden" name="sch_key" value="<?=$sch_key?>" />
                    <input type="hidden" name="key" value="<?=$key?>" />
                    <input type="hidden" name="rtnURL" value="<?=$rtnURL?>" />
					<input type="hidden" name="idx" value="<?=$idx?>"/>
					<input type="hidden" name="ApplyDay" value="<?=$ApplyDay?>"/>

                           <table  class="mytable">
									<tbody>
									<tr>
										<th style='width:10%' class='active'>접수순번</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$idx?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>한글이름</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Kor_Name?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>전화번호</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Tel?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>영어이름</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Eng_Name?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>카카오톡ID</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$KaKaoId?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>이메일</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$Email?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>체험날짜</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$ApplyDay?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>체험반</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$ApplyTime?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>등록일자</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$RegDate?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>등록IP</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;"><?=$RegIP?></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>직업</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="text" size=20  name="Job" maxlength="100" value="<?=$Job?>"  placeholder="직업" /></td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>나이</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="text" size=10  name="Age" maxlength="5" value="<?=$Age?>"  placeholder="나이" /></td>
										</td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>Purpose Of Study</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="text" size=100  name="PurposeOfStudy" maxlength="100" value="<?=$PurposeOfStudy?>"  placeholder="Purpose Of Study" />
										</td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>Experience Of Study</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="text" size=100  name="ExperienceOfStudy" maxlength="100" value="<?=$ExperienceOfStudy?>"  placeholder="Expression Of Study" />
										</td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>Expression</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="radio" name="Expression" value="1">1
											<input type="radio" name="Expression" value="2" checked="checked">2
											<input type="radio" name="Expression" value="3">3
									</tr>
									<tr>
										<th style='width:10%' class='active'>Grammar</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="radio" name="Grammar" value="1">1
											<input type="radio" name="Grammar" value="2" checked="checked">2
											<input type="radio" name="Grammar" value="3">3
										</td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>Replying Speed</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
											<input type="radio" name="ReplyingSpeed" value="1">1
											<input type="radio" name="ReplyingSpeed" value="2" checked="checked">2
											<input type="radio" name="ReplyingSpeed" value="3">3
									</td>
									</tr>
									<tr>
										<th style='width:10%' class='active'>비고</th>
										<td style="padding:10px 10px 10px 10px; line-height:150%; width:90%;">
										<input type="text" size=100  name="Memo" maxlength="100" value="<?=$Memo?>"  placeholder="비고" />
										</td>
									</tr>
									</tbody>
                           </table>
                 
                            <p >

                                <a href="#" onclick="javascript:GotoDataSaveProc();return false;"> 등록</a>
								&nbsp;
                                <a href="#" onclick="javascript:GotoListPage();return false;"> 취소</a>
                            </p>
                     


                    </form>
                </div>
                <!-- #center_bottom 끝 -->
            </div>
            <!-- #center 끝-->
            
                

        </div>
    </div>

</body>
</html>







