<? include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";?>
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
  </style>
    <script type="text/javascript">
		function Kakao_search()
		{
			search_form.target="_blank";
			document.search_form.action="kakao_list.php";
			document.search_form.submit();
		}

    </script>

 </head>

 <body>
		<form name="search_form" method="post" action="kakao_list.php" target="_blank" id="kakaoId_sch" role="form">
			<input type="text" placeholder="Kakao ID" value="" name="kakaoId">
			<a href="#" onclick="javascript:Kakao_search();return false;">검색</a>
		</form>
		
 </body>
</html>
