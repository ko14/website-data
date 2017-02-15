<?php

function run_load_prices($conn)
{
$date=date("m/d/Y",strtotime("-1 day"));
$date_ref=str_replace("/","%2F",$date);

//get S&P return for this day
$sp_array=get_data($date_ref,"spx");
if ($sp_array[2]<>"NoData")
{
 //add S&P500 prices entry
 $sql_check_exists="select id from prices where symbol='.inx' and priceday='".date("Y-m-d",strtotime($date))."'";
 $result_check_exists=mysql_query($sql_check_exists) or die($sql_check_exists.mysql_error());  
 if (mysql_num_rows($result_check_exists)==0)
 {
  $sqlprices="insert into prices values (default,1,'".date("Y-m-d",strtotime($date))."',$sp_array[0],$sp_array[1],$sp_array[2],$sp_array[3],'.inx')"; 
  $resultprices=mysql_query($sqlprices) or die($sqlprices.mysql_error());
 }
 
 //run for all stocks
 $sql="select s.symbol from stocks s left join (select symbol,priceday from prices where priceday='".date("Y-m-d",strtotime($date))."') p on s.symbol=p.symbol where p.symbol is null and s.market_cap>0"; 
 $result=mysql_query($sql) or die(mysql_error());

 while ($resultarr=mysql_fetch_array($result))
 {
  $data_array=get_data($date_ref,$resultarr['symbol']);
  if ($data_array[2]<>"NoData")
  {

     $sqlprices="insert into prices values (default,null,'".date("Y-m-d",strtotime($date))."',$data_array[0],$data_array[1],$data_array[2],$data_array[3],'$resultarr[symbol]')"; 
     $resultprices=mysql_query($sqlprices) or die($sqlprices.mysql_error());  
     echo "inserted $resultarr[symbol] \n";     
  }
  
 } //end while - for each stock
 
 //update priceday_sorted table
 $sql_sorted_delete="delete from priceday_sorted";
 $result_sorted_delete=mysql_query($sql_sorted_delete) or die($sql_sorted_delete.mysql_error());  
 
 $sql_sorted_add="insert into priceday_sorted select (@cnt := @cnt+1) as rownumber,p.priceday from prices p cross join (select @cnt :=0) dummy group by p.priceday order by p.priceday desc";
 $result_sorted_add=mysql_query($sql_sorted_add) or die($sql_sorted_add.mysql_error());   
 
} //end if - S&P had data for given day

} // end load_prices function 


function get_data($date_ref,$symbol)
{
  $page = file_get_contents("http://redacted/historical/default.asp?symb=$symbol&closeDate=$date_ref");
  if ($price_exists=strpos($page,"<th>Closing Price:</th>"))
  {
    $close_start=strpos($page,"<td>",$price_exists)+4;
    $close_end=strpos($page,"<",$close_start);
    $diff=$close_end-$close_start;
    $close_price=str_replace(",","",substr($page,$close_start,$diff)); 
    
    $open_find=strpos($page,"<th>Open:</th>");
    $open_start=strpos($page,"<td>",$open_find)+4;
    $open_end=strpos($page,"<",$open_start);   
    $diff=$open_end-$open_start;   
    $open_price=str_replace(",","",substr($page,$open_start,$diff)); 
    
    $return=number_format((($close_price-$open_price)/$open_price)*100,2);
    $return=str_replace(",","",$return);
  
    $volume_find=strpos($page,"<th>Volume:</th>");
    $volume_start=strpos($page,"<td>",$volume_find)+4;
    $volume_end=strpos($page,"<",$volume_start);   
    $diff=$volume_end-$volume_start;   
    $volume=str_replace(",","",substr($page,$volume_start,$diff)); 
    if ($volume=="n/a"){$volume="null";} 
    
    $return_array=array($open_price,$close_price,$return,$volume);
   }
   else
   {
    $return_array=array(0,0,"NoData",0);   
   } 
   return $return_array;
}
?>
