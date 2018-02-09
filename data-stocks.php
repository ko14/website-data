<?php
if (isset($_COOKIE['display_message'])) 
{
  if (isset($_GET[gotit]))
  {setcookie("display_message","no",time() + (10 * 365 * 24 * 60 * 60));header("Location:data-stocks.php");}
}
else
{setcookie("display_message","yes",time() + (10 * 365 * 24 * 60 * 60));header("Location:data-stocks.php");}

include ("../ace/stocks.php");
?>

<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->


<head>

   <!--- Basic Page Needs
   ================================================== -->
  <meta charset="utf-8">
	<title>Kristopher Orr | Data</title>
	<meta name="description" content="">
	<meta name="author" content="">

   <!-- Mobile Specific Metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
    ================================================== -->
   <link rel="stylesheet" href="css/default-data.css">
   <link rel="stylesheet" href="css/layout-data.css">
   <link rel="stylesheet" href="css/media-queries.css">
 

   <!-- Script
   ================================================== -->
	<script src="js/modernizr.js"></script>
  <script src="js/jquery-1.10.2.min.js"></script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87768403-1', 'auto');
  ga('send', 'pageview');

  </script>  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
   function reload_sector_return(order_by)
   {
    $('#sector_return').html("<center><img src='images/loader.gif' /></center>");
    $.ajax({
     type: "POST",
     url: "reload_sector_return.php",
     data: {order_by:order_by},
     success: callbackhere
    });
    function callbackhere(data,status)
    {
    $('#sector_return').html(data);
    }  
   }
   
   function topetf(selection)
   {
    $("#etf_ytd").css("display","none");
    $("#etf_1m").css("display","none");
    $("#etf_3m").css("display","none");
    $("#etf_1y").css("display","none");  
    
    $("#etf_ytd_link").css("border-bottom","none");   
    $("#etf_1m_link").css("border-bottom","none");   
    $("#etf_3m_link").css("border-bottom","none");  
    $("#etf_1y_link").css("border-bottom","none");          
         
    if (selection=='ytd')
    {$("#etf_ytd").css("display","block");$("#etf_ytd_link").css("border-bottom","solid 1px black");}
    else if (selection=='1m')
    {$("#etf_1m").css("display","block");$("#etf_1m_link").css("border-bottom","solid 1px black");}
    else if (selection=='3m')
    {$("#etf_3m").css("display","block");$("#etf_3m_link").css("border-bottom","solid 1px black");}
    else if (selection=='1y')
    {$("#etf_1y").css("display","block");$("#etf_1y_link").css("border-bottom","solid 1px black");}                  
   }
   
   //Google Charts
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   google.charts.setOnLoadCallback(drawChart_gold);   

   function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', '10-Year Yield'],
          ['2014',  3.00],
          ['2015',  2.12],
          ['2016',  2.24],
          ['Last',  1.58]
   ]);

   var options = {
          legend: "none",
          vAxis: {textPosition: "none"},
          width: 230,
          height: 75
          };

   var chart = new google.visualization.LineChart(document.getElementById('treasury_chart'));

   chart.draw(data, options);
   }
   function drawChart_gold() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Gold Price'],
          ['2014',  1205.40],
          ['2015',  1186.80],
          ['2016',  1075.10],
          ['Last',  1341.55]
   ]);

   var options = {
          legend: "none",
          vAxis: {textPosition: "none"},          
          width: 230,
          height: 75
          };

   var chart = new google.visualization.LineChart(document.getElementById('gold_chart'));

   chart.draw(data, options);
   }   
  
  
  </script>

   <!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="favicon.ico" > 

</head>

<body>

   <!-- Header
   ================================================== -->
   <header>

      <div class="row">

         <div class="twelve columns">

            <div class="logo">
              <a href="/"><span style="font:15px raleway-bold,sans-serif !important;line-height:30px !important">Kris Orr</span></a> 
            </div>

            <nav id="nav-wrap">

               <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
	            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

               <ul id="nav" class="nav">

	          <li><a href="professional.html">Professional</a></li>
	          <li class="current"><a>Data</a></li>            
            <li><a href="/portfolio/index.html">Work Samples</a></li>                   
		        <li><a href="contact.html">Contact</a></li>
		        
                  <li style="margin-left:22px">|</li>

		  <li style="font-size:larger"><a href="http://www.linkedin.com/in/krisorr" target="_blank"><i class="fa fa-linkedin-square" title="LinkedIn"></i></a></li>
		  <li style="font-size:larger"><a href="https://twitter.com/krisorr24" target="_blank"><i class="fa fa-twitter-square" title="Twitter"></i></a></li>
		  <li style="font-size:larger"><a href="https://github.com/ko14" target="_blank"><i class="fa fa-github-square" title="GitHub"></i></a></li>
               </ul> <!-- end #nav -->

            </nav> <!-- end #nav-wrap -->

         </div>

      </div>

   </header> <!-- Header End -->

   <!-- Info Section
   ================================================== -->
   <section id="info">

      <div class="row">

         <div class="bgrid-seventyfive s-bgrid-seventyfive">

           <div class="leftcolumns">
           <?php 
            if ($_COOKIE['display_message']=="yes")
            {echo "Data Automatically Refreshed Daily - <a href='data-stocks.php?gotit'><span style='padding:0px 3px;background-color:rgb(70, 184, 218);color:white;border-radius:5px;'>Got it</span></a>";}
           ?>
              <h2 class="label">Sector Performance</h2>

<?php

//******************** Sector Return *******************//

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
order by month_1_sector_return
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



echo "<table class='left-table' id='sector_return' width='100%'>";
echo "<tr><th style='text-align:left;padding:0px 40px 0px 10px;background-color:gray;color:white'>Sector</th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_1_sector_return\")'>1-Month<br/>Avg Return</a></th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_3_sector_return\")'>3-Month<br/>Avg Return</a></th><th style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:white;' href='javascript:reload_sector_return(\"month_6_sector_return\")'>6-Month<br/>Avg Return</a></th></tr>";
foreach ($ordered_sector_array as $sector)
{
 if ($sector=='S&P 500 Index')
 {echo "<tr style='border:solid 2px rgb(68, 68, 68);background-color:#dcdcdc'>";}
 else
 {echo "<tr>";}
 echo "<td style='padding:0px 40px 0px 10px'>$sector</td><td style='padding:0px 40px 0px 0px;text-align:right;'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_1mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_1_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_3mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_3_sector_return"}*100,1)."%</a></td><td style='padding:0px 40px 0px 0px;text-align:right'><a style='text-decoration:none;color:rgb(51, 51, 51)' target='_blank' href='https://raw.githubusercontent.com/ko14/website-data/master/".str_replace("/","_",str_replace(" ","_",$sector))."_6mo.txt'>".number_format(${str_replace(" ","_",$sector) . "_month_6_sector_return"}*100,1)."%</a></td></tr>";
}
echo "</table>";
echo "<span style='font-size:10px'>*Note: Data source of stock listing does not consistently specify sector accurately</span>";
                                          
//******************** 5 Day Trading Volume *******************//

$sql_volume="                  
select d1.priceday,d1.symbol,s.name,s.exchange,d1.volume as v1,d1.day_return as r1,d2.volume as v2,d2.day_return as r2,d3.volume as v3,d3.day_return as r3,d4.volume as v4,d4.day_return as r4,d5.volume as v5,d5.day_return as r5,d6.volume as v6,d6.day_return as r6  
from
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=1
) d1
join
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=2
) d2 on d1.symbol=d2.symbol
join
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=3
) d3 on d1.symbol=d3.symbol
join
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=4
) d4 on d1.symbol=d4.symbol
join
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=5
) d5 on d1.symbol=d5.symbol
join
(
  select p.priceday,symbol,volume,day_return 
  from prices p 
  join priceday_sorted ps on p.priceday=ps.priceday and ps.sort_number=6
) d6 on d1.symbol=d6.symbol
join stocks s on d1.symbol=s.symbol
where s.delist_date is null and s.market_cap<>0 and d1.symbol<>'.inx' and d1.volume>d2.volume and d2.volume>d3.volume and d3.volume>d4.volume and d4.volume>d5.volume and d5.volume>d6.volume 
order by d1.volume desc
";
$result_volume = mysql_query($sql_volume,$conn) or die();   //mysql_error()

echo "<h2 class='label' style='margin-top:30px'>5 Day Increasing Trade Volume</h2>";

if (mysql_num_rows($result_volume)==0)
{echo "None";}
else
{
 echo "<table class='left-table' id='five_day_volume' style='margin-bottom:20px'>";
 echo "<tr><th style='text-align:left;padding-left:10px;background-color:gray;color:white;width:175px;'>Symbol<br/>*Vol in 000's</th><th style='padding-right:10px;text-align:center;color:white;width:120px;' colspan='2'>Day 5<br/>Vol &nbsp; Return</th><th style='padding-right:10px;text-align:center;color:white;width:120px;' colspan='2'>Day 4<br/>Vol &nbsp; Return</th><th style='padding-right:10px;text-align:center;color:white;width:120px;' colspan='2'>Day 3<br/>Vol &nbsp; Return</th><th style='padding-right:10px;text-align:center;color:white;width:120px;' colspan='2'>Day 2<br/>Vol &nbsp; Return</th><th style='padding-right:10px;text-align:center;color:white;width:120px;' colspan='2'>Day 1<br/>Vol &nbsp; Return</th></tr>";
 while ($result_volume_arr=mysql_fetch_array($result_volume))
 {
   echo "<tr><td style='padding-left:10px' title='$result_volume_arr[name]'><a style='color:rgb(53, 106, 160)' target='_blank' href=\"https://www.google.com/finance/historical?q=$result_volume_arr[exchange]%3A$result_volume_arr[symbol]\">$result_volume_arr[symbol]</a></td><td style='padding:0px 10px;text-align:right;border-left:solid 1px black'>".number_format($result_volume_arr['v5']/1000,0)."</td><td style='padding-right:10px;text-align:right;border-left:solid 1px blac'>$result_volume_arr[r5]%</td><td style='padding:0px 10px;text-align:right;border-left:solid 1px black'>".number_format($result_volume_arr['v4']/1000,0)."</td><td style='padding-right:10px;text-align:right'>$result_volume_arr[r4]%</td><td style='padding:0px 10px;text-align:right;border-left:solid 1px black'>".number_format($result_volume_arr['v3']/1000,0)."</td><td style='padding-right:10px;text-align:right'>$result_volume_arr[r3]%</td><td style='padding:0px 10px;text-align:right;border-left:solid 1px black'>".number_format($result_volume_arr['v2']/1000,0)."</td><td style='padding-right:10px;text-align:right'>$result_volume_arr[r2]%</td><td style='padding:0px 10px;text-align:right;border-left:solid 1px black'>".number_format($result_volume_arr['v1']/1000,0)."</td><td style='padding-right:10px;text-align:right'>$result_volume_arr[r1]%</td></tr>";
 }
 echo "</table>";
}
?>

<!--******************** ETF Performance *******************-->



            

           </div> <!--end: left-columns-->  
        </div> <!--end: bgrid-seventyfive-->  


<!-- ******************  Right-Side ******************************-->
        <div class="bgrid-quarters s-bgrid-quarters">
            <!--<div class="columns">
           <h2 class="label">Market Pulse</h2>
             
             
              <div style="font-size:13px;width:100%;padding:0px 3px;background-color:#4f4f4f;color:white">10-Yr Treasury Yield<br/></div>
              <div>
               <table class='sidetable'><tr><td>Last</td><td>1d</td><td>5d</td><td>1m</td><td>6m</td><td>1y</td></tr>
               <tr><td>1.58</td><td>1.53</td><td>1.51</td><td>1.53</td><td>1.74</td><td>2.14</td></tr></table>
              </div>
              <div id="treasury_chart" ></div>
              
              <div style="margin-top:10px;font-size:13px;width:100%;padding:0px 3px;background-color:#4f4f4f;color:white">Gold<br/></div>
              <div>
               <table class='sidetable'><tr><td>Last</td><td>1d</td><td>1m</td><td>6m</td><td>1y</td></tr>
               <tr><td>1,341</td><td>1,340</td><td>1,340</td><td>1,239</td><td>1,123</td></table>
              </div>   
              <div id="gold_chart" ></div>  
              
              <div style="margin-top:10px;font-size:13px;width:100%;padding:0px 3px;background-color:#444444;color:white">Currencies to 1 USD<br/></div>
              <div>
               <table class='sidetable'><tr><td></td><td>Now</td><td>1d</td><td>5d</td><td>1m</td><td>3m</td></tr>
               <tr><td>CNY</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr>
               <tr><td>EUR</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr>  
               <tr><td>GBP</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr>                 
               <tr><td>CAN</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr>  
               <tr><td>JPY</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr>
               <tr><td>KRW</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td><td>1.51</td></tr></table>                                                          
              </div>
              
           
          </div> -->
          
          <div class='columns' style='float:right;'>
          
          <?php
          echo "<h2 class='label'>New Listings NYSE/Nasdaq</h2>";
          $sql_new_stocks="select symbol,name,market_cap,exchange from stocks where add_date>=(current_date-interval 7 day) and symbol not like '%.%' and symbol not like '%^%' and symbol not like '%$%' order by symbol";
          $result_new_stocks = mysql_query($sql_new_stocks,$conn) or die();   //mysql_error()
          if (mysql_num_rows($result_new_stocks)>0)
          {           
           echo "<table class='sidetable'><tr style='background-color:#4f4f4f;color:white'><td style='padding-left:5px'>Sym</td><td>Name</td><td>Exchg</td></tr>";
           while ($result_new_stocks_arr=mysql_fetch_array($result_new_stocks))
           {
             echo "<tr><td><a target='_blank' href='http://www.nasdaq.com/symbol/$result_new_stocks_arr[symbol]'>$result_new_stocks_arr[symbol]</a></td><td>".substr(str_replace("\n","",$result_new_stocks_arr['name']),0,14)."</td><td>$result_new_stocks_arr[exchange]</td></tr>";
            
             //$exchange_url=substr($result_new_stocks_arr['exchange'],0,3);  http://www.nasdaq.com/symbol/bl
             //echo "<tr><td><a target='_blank' href='http://www.morningstar.com/stocks/x$exchange_url/$result_new_stocks_arr[symbol]/quote.html'>$result_new_stocks_arr[symbol]</a></td><td>".substr(str_replace("\n","",$result_new_stocks_arr['name']),0,14)."</td><td>$result_new_stocks_arr[exchange]</td></tr>";
           }
           echo"</table>"; 
          }
          else
          {echo "No listings in past 7 days";} 
          ?>     
          
           <hr class='hr-dark' />  
           <h2 class="label">Earnings Announcements</h2>
             
           <table class='sidetable'><tr style="background-color:#4f4f4f;color:white"><td style='padding-left:5px'>Sym</td><td>Name</td><td>Est.</td></tr>
           <?php
            $sql_annoucements="select annday,a.symbol,s.name,eps from announcements a join stocks s on a.symbol=s.symbol where annday=(select min(annday) from announcements a join stocks s on a.symbol=s.symbol where annday>=current_date) order by a.symbol";
            $result_announcements = mysql_query($sql_annoucements,$conn) or die();   //mysql_error()
            while ($result_announcements_arr=mysql_fetch_array($result_announcements))
            {
              echo "<tr><td><a href='https://finance.yahoo.com/quote/$result_announcements_arr[symbol]/analysts' target='_blank'>	$result_announcements_arr[symbol]	</a></td><td>	$result_announcements_arr[name]	</td><td style='text-align:right'>	$result_announcements_arr[eps]	</td></tr>";
            }
           ?>

          </table>              
          </div>
         
                    
                        
                      
                                
                    

        </div>   <!-- Right-Side End-->

        
      </div>   <!-- Row End-->

    
   </section> <!-- Info Section End-->
   
   <section id="info" style='padding-bottom:10px'>

      <div class="row">
      <div style='margin-left:20px;font-size:12px'>Information is solely for informational purposes, not for trading or advice</div>
      </div>
   </section>

   <!-- footer
   ================================================== -->
   <footer>

      <div class="row">


         <div class="twelve columns">



            <ul class="copyright">
               <li>&copy; 2016 Kristopher Orr</li> 
            </ul>

         </div>

         <!--<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>-->

      </div>

   </footer> <!-- Footer End-->

   <!-- Java Script
   ================================================== -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
   <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

   <script src="js/jquery.flexslider.js"></script>
   <script src="js/doubletaptogo.js"></script>
   <script src="js/init.js"></script>

</body>

</html>
