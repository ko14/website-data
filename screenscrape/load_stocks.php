<?php

function run_load_stocks($conn)
{
 $exchange_list=""; //this will populate to become a comma-delimited list of stocks that are currently present in the downloaded files
 $exchange_list=&stock_load($conn,"NASDAQ",$exchange_list);
 $exchange_list=&stock_load($conn,"NYSE",$exchange_list); 
 
 //de-list any in database that are not in $exchange_list and not already marked as de-listed (MSG listed in both files, so using this method to compensate)
 $exchange_list=trim($exchange_list,",");  
 $sql_update_delist="update stocks set delist_date=current_date where delist_date is null and symbol<>'.inx' and symbol not in ($exchange_list)";
 $result_update_delist=mysql_query($sql_update_delist) or die(mysql_error().$sql_update_delist);   
}

function &stock_load($conn,$exchange,$exchange_list)
{
  $file = @fopen("location?exchange=$exchange&render=download", "r");
  fgets($file); //skip the first row with column headings
  while ($line = fgets($file)) 
  {
   $line_array=explode("\",\"",$line);
   $symbol=trim(substr($line_array[0],1,strlen($line_array[0])));
   if ($line_array[2]=="n/a") //Last Sale
   {$line_array[2]=0;}   
   if ($line_array[5]=="n/a") //IPO Year
   {$line_array[5]=0;}
   $sql_check="select symbol from stocks where symbol='$symbol'";
   $result_check=mysql_query($sql_check) or die(mysql_error());
   if (mysql_num_rows($result_check)==0)
   {
     $sql_add="insert into stocks values ('$symbol','$line_array[1]',$line_array[2],$line_array[3],'$line_array[4]',$line_array[5],'$line_array[6]','$line_array[7]',null,'$exchange',current_date,null)";
     $result_add=mysql_query($sql_add) or die(mysql_error().$sql_add);    
   }
   else
   {
     $sql_update="update stocks set name='$line_array[1]',market_cap=$line_array[3],sector='$line_array[6]',industry='$line_array[7]',exchange='$exchange',delist_date=null where symbol='$symbol'";
     $result_update=mysql_query($sql_update) or die(mysql_error().$sql_update); 
   }
   $exchange_list.="'$symbol',";
  } //end while
  fclose($file);
  return $exchange_list;
}
?>
