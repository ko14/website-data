<?php

function run_load_streak($conn)
{
$date=date("m/d/Y",strtotime("-1 day"));

 $sql_sp="select day_return from prices where streak_id=1 and priceday='".date("Y-m-d",strtotime($date))."'"; 
 $result_sp=mysql_query($sql_sp) or die(mysql_error());

 if (mysql_num_rows($result_sp)>0)
 {
  //******** no active streak for stock - usually brand new stock *************// 
  $sql_stocks="
  insert into streak (symbol,active,type,start_date,end_date,length,avg_daily_return,avg_daily_sp500_return,return_diff)
  select p.symbol,1,case when (day_return-sp_return)>=0 then 'win' else 'lose' end as outcome,'".date("Y-m-d",strtotime($date))."' as start,'".date("Y-m-d",strtotime($date))."' as end,1,day_return,sp_return,null 
  from prices p 
  left join (select symbol,id,type,start_date from streak where active=1) k on p.symbol=k.symbol 
  left join (select day_return as sp_return, priceday from prices where streak_id=1) sp on p.priceday=sp.priceday
  where p.priceday='".date("Y-m-d",strtotime($date))."' and p.streak_id is null and k.id is null order by p.symbol";
  $result_stocks=mysql_query($sql_stocks) or die(mysql_error());
 
  $sql_prices_update="update prices p join streak k on p.symbol=k.symbol and p.priceday=k.end_date set p.streak_id=k.id where p.streak_id is null and p.priceday='".date("Y-m-d",strtotime($date))."'"; 
  $result_prices_update=mysql_query($sql_prices_update) or die($sql_prices_update.mysql_error());  
 
  echo "$date: done with new stocks \n";
  
  //******** streak broken *************//  
  //mark last streak record as inactive
  $sql_stocks="
  update streak k 
  join 
  (
  select p.symbol,day_return,k.id,k.type,k.start_date,sp_return,(day_return-sp_return) as return_diff,case when (day_return-sp_return)>=0 then 'win' else 'lose' end as outcome 
  from prices p 
  join (select symbol,id,type,start_date from streak where active=1) k on p.symbol=k.symbol 
  join (select day_return as sp_return, priceday from prices where streak_id=1) sp on p.priceday=sp.priceday  
  where p.priceday='".date("Y-m-d",strtotime($date))."' and p.streak_id is null and k.type<>case when day_return-sp_return>=0 then 'win' else 'lose' end
  ) foo on k.id=foo.id
  set k.active=0";
  $result_stocks=mysql_query($sql_stocks) or die(mysql_error());
  
  //create new streak record for this day
  $sql_stocks="
  insert into streak (symbol,active,type,start_date,end_date,length,avg_daily_return,avg_daily_sp500_return,return_diff)
  select p.symbol,1,case when (day_return-sp_return)>=0 then 'win' else 'lose' end as outcome,'".date("Y-m-d",strtotime($date))."' as start,'".date("Y-m-d",strtotime($date))."' as end,1,day_return,sp_return,null 
  from prices p 
  left join (select symbol,id,type,start_date from streak where active=1) k on p.symbol=k.symbol 
  left join (select day_return as sp_return, priceday from prices where streak_id=1) sp on p.priceday=sp.priceday
  where p.priceday='".date("Y-m-d",strtotime($date))."' and p.streak_id is null and k.id is null order by p.symbol";
  $result_stocks=mysql_query($sql_stocks) or die(mysql_error());
 
  $sql_prices_update="update prices p join streak k on p.symbol=k.symbol and p.priceday=k.end_date set p.streak_id=k.id where p.streak_id is null and p.priceday='".date("Y-m-d",strtotime($date))."'"; 
  $result_prices_update=mysql_query($sql_prices_update) or die($sql_prices_update.mysql_error());   
  
  echo "$date: done with streak broken \n";
 
  //******** streak continues *************//  
  $sql_stocks="   
  update streak k 
  join 
  (  
  select p.symbol,day_return,k.id,k.type,k.start_date,sum(total_f.sp_return2)/count(total_f.eachday) as sp_avg_return,sum(total_f.stock_return)/count(total_f.eachday) as stock_avg_return
  from prices p 
  join (select symbol,id,type,start_date from streak where active=1) k on p.symbol=k.symbol 
  join (select day_return as sp_return, priceday from prices where streak_id=1) sp on p.priceday=sp.priceday 
  join (select sp_return2,stock_return,eachday,symbol from (select day_return as sp_return2, priceday as eachday from prices where streak_id=1) f join (select day_return as stock_return,priceday,symbol from prices) f2 on f.eachday=f2.priceday) total_f on total_f.symbol=k.symbol   
  where p.priceday='".date("Y-m-d",strtotime($date))."' and p.streak_id is null and k.type=case when day_return-sp_return>=0 then 'win' else 'lose' end
  and eachday>=k.start_date and eachday<='".date("Y-m-d",strtotime($date))."' 
  group by p.symbol,day_return,k.id,k.type,k.start_date
  ) foo on k.id=foo.id
  set length=length+1,end_date='".date("Y-m-d",strtotime($date))."',avg_daily_return=foo.stock_avg_return,avg_daily_sp500_return=foo.sp_avg_return,return_diff=null
  ";
  $result_stocks=mysql_query($sql_stocks) or die(mysql_error());
  
  $sql_prices_update="update prices p join streak k on p.symbol=k.symbol and p.priceday=k.end_date set p.streak_id=k.id where p.streak_id is null and p.priceday='".date("Y-m-d",strtotime($date))."'"; 
  $result_prices_update=mysql_query($sql_prices_update) or die($sql_prices_update.mysql_error());   
 
  echo "$date: done with streak continues \n";
   
  //******** update streak return_diff *************//          
  $sql_update_streak_return_diff="update streak set return_diff=(avg_daily_return-avg_daily_sp500_return) where return_diff is null";
  $result_update_streak_return_diff=mysql_query($sql_update_streak_return_diff) or die($sql_update_streak_return_diff.mysql_error());  
  
 } //end if - S&P 500 data exists
  

exec ("echo Done with load_streak 1>&2");
} //end function
?>
