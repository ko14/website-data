<?php



include ("../ace/stocks.php");



$ordered_sector_array=array();

 

$sql="

select month_1.sector,month_1_sector_return,month_3_sector_return,month_6_sector_return  

from 

(

select sector,avg(stock_return) as month_1_sector_return 

from

(

select s.sector,start.symbol,start.open as start_open,end.close as end_close,((end.close-start.open)/start.open) as stock_return 

from 

(select symbol,open from prices where priceday=(select max(priceday) from prices where priceday>=((select max(priceday) from prices)-interval 37 day) and priceday<=((select max(priceday) from prices)-interval 30 day))) start 

join 

(select symbol,close from prices where priceday=(select max(priceday) from prices)) end on start.symbol=end.symbol

join stocks s on start.symbol=s.symbol

where s.symbol not in ('BEBE','CVLY','CBSH','COWN','GTXI','LIVE','MDC','NVLN','PBIB','SMI','SFBS','SUM','XBKS','ALBO','CASC','CRESY','DRYS','GALE','HNR','HNHAY','HBNC','IMUC','ICE','MBOT','MNST','PAGP','FLIC','HTM','USNA','WGBS','AOS','APRI','ARNC','ATROB','CBB','CMLS','ITUB','OKIEY','PTX','TLK','RELV','ROKA','RRD','SNGX','UBFO','XOMA','ABAC','AROW','BMI','BIOC','BIP','CAC','CHD','FNCX','PHMD','IPDN','SNSS','TTC','VGR','ATEC','ATOS','CNET','DSS','EGLE','EEQ','GENC','GOGL','HEB','LKFN','OSN','SMSI','VSEC','CAFN','CLBS','CVO','CGG','CDTI','CRK','DCTH','EMMS','GNK','IMBBY','LTBR','MRIC','OREX','SAEX','SCON','TWER','VMEMQ')

and s.delist_date is null

) foo

group by sector

) month_1

join 

(

select sector, avg(stock_return) as month_3_sector_return 

from

(

select s.sector,start.symbol,start.open as start_open,end.close as end_close,((end.close-start.open)/start.open) as stock_return  

from 

(select symbol,open from prices where priceday=(select max(priceday) from prices where priceday>=((select max(priceday) from prices)-interval 97 day) and priceday<=((select max(priceday) from prices)-interval 90 day))) start 

join 

(select symbol,close from prices where priceday=(select max(priceday) from prices)) end on start.symbol=end.symbol

join stocks s on start.symbol=s.symbol

where s.symbol not in ('BEBE','CVLY','CBSH','COWN','GTXI','LIVE','MDC','NVLN','PBIB','SMI','SFBS','SUM','XBKS','ALBO','CASC','CRESY','DRYS','GALE','HNR','HNHAY','HBNC','IMUC','ICE','MBOT','MNST','PAGP','FLIC','HTM','USNA','WGBS','AOS','APRI','ARNC','ATROB','CBB','CMLS','ITUB','OKIEY','PTX','TLK','RELV','ROKA','RRD','SNGX','UBFO','XOMA','ABAC','AROW','BMI','BIOC','BIP','CAC','CHD','FNCX','PHMD','IPDN','SNSS','TTC','VGR','ATEC','ATOS','CNET','DSS','EGLE','EEQ','GENC','GOGL','HEB','LKFN','OSN','SMSI','VSEC','CAFN','CLBS','CVO','CGG','CDTI','CRK','DCTH','EMMS','GNK','IMBBY','LTBR','MRIC','OREX','SAEX','SCON','TWER','VMEMQ')

and s.delist_date is null

) foo

group by sector

) month_3 on month_1.sector=month_3.sector

join 

(

select sector, avg(stock_return) as month_6_sector_return 

from

(

select s.sector,start.symbol,start.open as start_open,end.close as end_close,((end.close-start.open)/start.open) as stock_return 

from 

(select symbol,open from prices where priceday=(select max(priceday) from prices where priceday>=((select max(priceday) from prices)-interval 187 day) and priceday<=((select max(priceday) from prices)-interval 180 day))) start 

join 

(select symbol,close from prices where priceday=(select max(priceday) from prices)) end on start.symbol=end.symbol

join stocks s on start.symbol=s.symbol

where s.symbol not in ('BEBE','CVLY','CBSH','COWN','GTXI','LIVE','MDC','NVLN','PBIB','SMI','SFBS','SUM','XBKS','ALBO','CASC','CRESY','DRYS','GALE','HNR','HNHAY','HBNC','IMUC','ICE','MBOT','MNST','PAGP','FLIC','HTM','USNA','WGBS','AOS','APRI','ARNC','ATROB','CBB','CMLS','ITUB','OKIEY','PTX','TLK','RELV','ROKA','RRD','SNGX','UBFO','XOMA','ABAC','AROW','BMI','BIOC','BIP','CAC','CHD','FNCX','PHMD','IPDN','SNSS','TTC','VGR','ATEC','ATOS','CNET','DSS','EGLE','EEQ','GENC','GOGL','HEB','LKFN','OSN','SMSI','VSEC','CAFN','CLBS','CVO','CGG','CDTI','CRK','DCTH','EMMS','GNK','IMBBY','LTBR','MRIC','OREX','SAEX','SCON','TWER','VMEMQ')

and s.delist_date is null

) foo

group by sector

) month_6 on month_1.sector=month_6.sector

order by $_POST[order_by]

";

//--where month_1.sector<>'n/a'

$result = mysql_query($sql,$conn) or die();   //mysql_error()

while ($result_arr=mysql_fetch_assoc($result))

{

 foreach ($result_arr as $key=>$value)

 {

  if ($key=="sector")

  {

   $ordered_sector_array[]=$value;

   $sector=$value;

  }

  ${str_replace(" ","_",$sector) . "_$key"}=$value;

 }

}  





$data="<tr><th style='text-align:left;padding:0px 40px 0px 10px;background-color:gray;color:white'>Sector</th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_1_sector_return\")'>1-Month<br/>Avg Return</a></th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_3_sector_return\")'>3-Month<br/>Avg Return</a></th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_6_sector_return\")'>6-Month<br/>Avg Return</a></th></tr>";

foreach ($ordered_sector_array as $sector)

{

 if ($sector=='S&P 500 Index')

 {$data.="<tr style='border:solid 2px rgb(68, 68, 68);background-color:#dcdcdc'>";}

 else

 {$data.="<tr>";}

 //$data.="<td style='padding:0px 40px 0px 10px'>$sector</td><td style='padding:0px 40px 0px 0px;text-align:right;'>".number_format(${str_replace(" ","_",$sector) . "_month_1_sector_return"}*100,1)."%</td><td style='padding:0px 40px 0px 0px;text-align:right'>".number_format(${str_replace(" ","_",$sector) . "_month_3_sector_return"}*100,1)."%</td><td style='padding:0px 40px 0px 0px;text-align:right'>".number_format(${str_replace(" ","_",$sector) . "_month_6_sector_return"}*100,1)."%</td></tr>";

 //$data.="<td style='padding:0px 40px 0px 10px'>$sector</td><td style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_1mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_1_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace(" ","_",$sector)."_3mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_3_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace(" ","_",$sector)."_6mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_6_sector_return"}*100,1)."%</a></td></tr>";

  $data.="<td style='padding:0px 40px 0px 10px'>$sector</td><td style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_1mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_1_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_3mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_3_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_6mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_6_sector_return"}*100,1)."%</a></td></tr>";

}



echo $data;



?>
