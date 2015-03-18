<?php 
  //DB connection
  $host='www.tella.co.kr';
  $username='tella';
  $pwd='tella0303^&';
  $dbname='test';
  
  $dbc = mysqli_connect ( $host, $username, $pwd, $dbname ) or die ( "Error: DB Connect." );


  //table - TEXT
  $tablename='TEXT';

  $text_user='USER';
  $text_tutor='TUTOR';
  $text_date='DATE';
  $text_time='TIME';
  $text_contents='CONTENTS';
  $text_correct='CORRECT';
  $text_who = 'WHO';
  $text_line = 'LINE';


?>