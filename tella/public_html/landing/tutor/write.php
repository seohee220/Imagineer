<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <?
		session_start();
		if($_SESSION['username'] == "") {
			msg("로그인 후 이용해 주시길 바랍니다.");
			go_url("/landing/tutor/");
		}

?>
 <script type="text/javascript">

	function Save() {

		if (myform.Title.value == '') { alert("제목 입력 하세요"); myform.Title.focus(); return false; }
		if (myform.Content.value == '') { alert("내용을 입력하세요"); myform.Content.focus(); return false; }
		if (myform.Notice.value == '') { alert("Notice를 선택하세요"); myform.Notice.focus(); return false; }
		

		if (confirm('정확하게 작성하셨습니까?')){
			var day = getDay();
			myform.RegDate.value=day;
			myform.target = "";
			myform.action = "insert.php";
			myform.submit();
		}else{
			return;
		}
	}
		
	var xmlHttp;

	function srvTime(){

		if(window.XMLHttpRequest){                          

		req = new XMLHttpRequest();

		}else if(window.ActiveXObject){                    

		req = new ActiveXObject("Microsoft.XMLHTTP");

		}

		xmlHttp = req;

		xmlHttp.open('HEAD',window.location.href.toString(),false);

		xmlHttp.setRequestHeader("Content-Type", "text/html");

		xmlHttp.send('');

		return xmlHttp.getResponseHeader("Date");

	}

	function getDay() {
		var st = srvTime();
		var theDay = new Date(st);
		var Year = theDay.getFullYear();
		var t = theDay.getMonth()+1; 
		var t2 = theDay.getDate(); 
		var x = Year+ "/" + t + "/" + t2;

		return x;
	}

	</script>

  </script>
<!--
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script  type="text/javascript">
	$(document).ready(function() {
        $("#inputTextBox").keyup(function(){
			var numChar = $(this).val().length;
			var maxChar = 500;
			var remainChar = maxChar-numChar;
			$("#counter").html(remainChar);			
			if(maxChar<numChar){
				$("button").attr("disabled","disabled");
				$("#counter").addClass("warning");
			}
			else if(maxChar>=numChar){
				$("button").removeAttr("disabled");
				$("#counter").removeClass("warning");
			}			
		});
    });
</script>
-->
 </head>
 <body>
   <center>
    <table border="0">
    <tr>
      <td>
        <form name="myform" action="insert.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="RegDate" value="">
			<input type="hidden" name="inc" value="Write">
			<div>
			 <input type="text" name="Title" id="Title" value="" onfocus="this.value=''" placeholder="제목" />
			 <select name="Notice" style="width:50px;">
			  <option value="">-</option>
			  <option value='공지'>공지</option>
			  <option value='요청'>요청</option>
			</select>
			 </div>
          <textarea id="inputTextBox" rows="20" cols="50" name="Content" style="resize:none;"></textarea><br>
		  <!--<span id="counter">500</span>/500-->
          <br><br>
	<center>
        <a href="#" onclick="javascript:Save();return false;"><input type="button" value="저장"></a>
      </center>
        </form>
      </td>
    </tr>
    </table>
 </body>
</html>
