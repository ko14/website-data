<?php

function run_load_announcements($conn)
{ 

$counter=0;
$date=date("Y-m-d",strtotime("+$counter day"));

while ($counter<2)
{
  $sql_check="select annday from announcements where annday='$date'";
  $result_check=mysql_query($sql_check) or die($sql_check.mysql_error());
  if (mysql_num_rows($result_check)==0)
  {
    $date_web_format=date("Ymd",strtotime($date));
    $file_contents=file_get_contents("https://redacted/research/earncal/$date_web_format.html");
    $offset=0;
    $pos=strpos($file_contents,"q?s",$offset);
    while ($pos<>false)
    {
     $symbol_pos_start=strpos($file_contents,">",$pos)+1;
     $symbol_pos_end=strpos($file_contents,"<",$pos);
     $symbol_length=$symbol_pos_end-$symbol_pos_start;
     $symbol=substr($file_contents,$symbol_pos_start,$symbol_length);
     
     $eps_pos_start=strpos($file_contents,"align=center>",$pos)+13;
     $eps_pos_end=strpos($file_contents,"<",$eps_pos_start);
     $eps_length=$eps_pos_end-$eps_pos_start;
     $eps=substr($file_contents,$eps_pos_start,$eps_length);     
      
     $sql_add="insert into announcements (annday,symbol,eps) values ('$date','$symbol','$eps')";
     $result_add=mysql_query($sql_add) or die($sql_add.mysql_error());      
     //echo "\n \n \n $symbol:$eps \n \n ";
     
     $offset=$pos+10; 
     $pos=strpos($file_contents,"q?s",$offset);     
    }
  }
  $counter++;
  $date=date("Y-m-d",strtotime("+$counter day"));
} 

}

?>