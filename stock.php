<?php
$v = @file_get_contents("http://api.liqwei.com/currency/?exchange=USD|CNY&count=1");
if(empty($v)){$v="6.3";}
?>
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<script> 
//行权数量
var stock_num =1000;
//
var exchange_rate=6.4827;
//行权价
var stock_price1=0.45;
//股票价
var stock_price2=20;
//非现金行权计算,总收益
function $(id){
	return document.getElementById(id);
}
function _getTotal(){
	stock_num=$("stock_num").value;
	stock_price2=$("stock_price2").value;
	stock_price1=$("stock_price1").value;
	exchange_rate=$("exchange_rate").value;
	var total = stock_num*stock_price2*exchange_rate-
		//股权成本
		stock_num*stock_price1*exchange_rate-
		//税
		_getDuties((stock_price2-stock_price1)*stock_num*exchange_rate)-
		//费用
		(stock_num*0.03>24.95?(stock_num*0.03):24.95+5.35+0.0192*(stock_num*stock_price2/1000))*exchange_rate;
	$("total").value=parseInt(total*100)/100;
	$("total_tips").innerHTML= "收入估算:总收入("+parseInt(stock_num*stock_price2*exchange_rate*100)/100+
			")-股权成本("+parseInt(stock_num*stock_price1*exchange_rate*100)/100+
			")-个税("+parseInt(_getDuties((stock_price2-stock_price1)*stock_num*exchange_rate)*100)/100+
			")-手续费("+parseInt((stock_num*0.03>24.95?(stock_num*0.03):24.95+5.35+0.0192*(stock_num*stock_price2/1000))*exchange_rate*100)/100+")";
 
	console.log((stock_price2-stock_price1)*stock_num*exchange_rate);
	console.log(_getDuties((stock_price2-stock_price1)*stock_num*exchange_rate));
 
 
 
	//股权成本+税+手续费
	var total2 = stock_num*stock_price1*exchange_rate+
			_getDuties((stock_price2-stock_price1)*stock_num*exchange_rate)+
			5.35*exchange_rate;
 
	$("total2").value=parseInt(total2*100)/100;
	$("total2_tips").innerHTML= "成本估算:股权成本("+parseInt(stock_num*stock_price1*exchange_rate*100)/100 +")"+
			"+个税("+parseInt(_getDuties((stock_price2-stock_price1)*stock_num*exchange_rate)*100)/100+")"+
			"+手续费("+parseInt(5.35*exchange_rate*100)/100+")";
}
//个人所得税
//http://lvshi.sz.bendibao.com/z/geshui/
var duties_config= new Array();
duties_config[0]={"min":0,			"max":1500,		"p":"0.03","t":0};
duties_config[1]={"min":1500.01,	"max":4500,		"p":"0.10","t":105};
duties_config[2]={"min":4500.01,	"max":9000,		"p":"0.20","t":555};
duties_config[3]={"min":9000.01,	"max":35000,	"p":"0.25","t":1005};
duties_config[4]={"min":35000.01,	"max":55000,	"p":"0.30","t":2755};
duties_config[5]={"min":55000.01,	"max":80000,	"p":"0.35","t":5505};
duties_config[6]={"min":80000.01,	"max":999999999999999,"p":"0.45","t":13505};
function _getDuties(total){
	var flag=document.getElementsByName("time")[0].checked;
	if(flag){
		for(var i in duties_config){
				var item = duties_config[i];
				if(total>=item.min && total<=item.max){
					console.log(item);
						$("rate").value=item.p;
						var min=Math.ceil(item.min/exchange_rate/stock_price2);
						var max=Math.floor(item.max/exchange_rate/stock_price2);
						$("info").innerHTML="此税率范围的股票数:("+min+"-<span style='color:red'>"+max+"</span>)ADS";
						return ((total-3500)*item.p-item.t);
				}
		}
	}else{
		for(var i in duties_config){
				var item = duties_config[i];
				if(total/12>=item.min && total/12<=item.max){
						$("rate").value=item.p;
						var min=Math.ceil(item.min*12/exchange_rate/stock_price2);
						var max=Math.floor(item.max*12/exchange_rate/stock_price2);
						$("info").innerHTML="此税率范围的股票数:("+min+"-<span style='color:red'>"+max+"</span>)ADS";
						return ((total-3500)/12*item.p-item.t)*12;
				}
		}
	}
}
 
</script> 
</head> 
<body> 
<table style=""> 
		<tr><td></td><th style="text-align:left"><h1>优酷现金/非现金行权工具</h1></th></tr> 
		<tr><td>期权获得时间:</td><td><input type="radio" name="time" value="1" checked>上市前<input value="2" type="radio" name="time"/>上市后（2010年12月8日之后）获得的期权</td></tr> 
		<tr><td>实时汇率:</td><td><input type="text" id="exchange_rate" value="<?php echo $v;?>"/></td></tr> 
		<tr><td>授予价(美元):</td><td><input type="text" id="stock_price1" value="0.648"/></td></tr> 
		<tr><td>成交价(美元):</td><td><input type="text" id="stock_price2" value="20"/></td></tr> 
		<tr><td>行使数(ADS):</td><td><input type="text" id="stock_num" value="1000"/></td></tr> 
		<tr><td>税率:</td><td><input readonly type="text" id="rate" value=""/><span id="info">此税率范围的股票数:(0-0)ADS</span></td></tr> 
		<tr><td>非现金行权收入(RMB):</td><td><input readonly type="text" id="total" value=""/><span id="total_tips">收入估算:总收入(0)-股权成本(0)-个税(0)-手续费(0)</span></td></tr> 
		<tr><td>现金行权成本(RMB):</td><td><input readonly type="text" id="total2" value=""/><span id="total2_tips">成本估算:股权成本(0)+个税(0)+手续费(0)</span></td></tr> 
		<tr><td>&nbsp;</td><td><input onclick="_getTotal()" value="计算" type="submit"></td></tr> 
</table> 
<style>
p a:link { color: #999; text-decoration: none;} 
p a:visited { color: #999; text-decoration: none;} 
p a:hover { color: #999; text-decoration: none}
</style>
<p style="margin:0 auto;height: 16px; line-height: 16px; padding: 5px 0; font-size:12px; color: #999; ">
个税参考：<a href="http://lvshi.sz.bendibao.com/z/geshui/" target="_blank">http://lvshi.sz.bendibao.com/z/geshui/</a><br/>
个税计算：<a href="http://finance.21cn.com/bank/computer/tax.html" target="_blank">http://finance.21cn.com/bank/computer/tax.html</a><br/>
问题联系：<a href="mailto:hetao@youku.com" target="_blank">hetao@youku.com</a><br/>
</p>
</body> 
</html> 
