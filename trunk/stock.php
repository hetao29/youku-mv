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
var stock_price2=40;
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
var duties_config= new Array();
duties_config[0]={"min":0,"max":500,"p":0.05,"t":0};
duties_config[1]={"min":500.01,		"max":2000,		"p":"0.10","t":25};
duties_config[2]={"min":2000.01,	"max":5000,		"p":"0.15","t":125};
duties_config[3]={"min":5000.01,	"max":20000,	"p":"0.20","t":375};
duties_config[4]={"min":20000.01,	"max":40000,	"p":"0.25","t":1375};
duties_config[5]={"min":40000.01,	"max":60000,	"p":"0.30","t":3375};
duties_config[6]={"min":60000.01,	"max":80000,	"p":"0.35","t":6375};
duties_config[7]={"min":80000.01,	"max":100000,	"p":"0.40","t":10375};
duties_config[8]={"min":100000.01,	"max":999999999,"p":"0.45","t":15375};
function _getDuties(total){
		for(var i in duties_config){
				var item = duties_config[i];
				if(total/12>=item.min && total/12<=item.max){
						$("rate").value=item.p;
						var min=Math.ceil(item.min*12/exchange_rate/stock_price2);
						var max=Math.floor(item.max*12/exchange_rate/stock_price2);
						$("info").innerHTML="此税范围的股票数:("+min+"-<span style='color:red'>"+max+"</span>)ADS";
						return (total/12*item.p-item.t)*12;
				}
		}
}
 
</script> 
</head> 
<body> 
<table> 
		<th><td>现金/非现金行权工具</td></th> 
		<tr><td>实时汇率:</td><td><input type="text" id="exchange_rate" value="<?php echo $v;?>"/></td></tr> 
		<tr><td>授予价(美元):</td><td><input type="text" id="stock_price1" value="0.00"/></td></tr> 
		<tr><td>成交价(美元):</td><td><input type="text" id="stock_price2" value="40"/></td></tr> 
		<tr><td>行使数(ADS):</td><td><input type="text" id="stock_num" value="100"/></td></tr> 
		<tr><td>税率:</td><td><input readonly type="text" id="rate" value=""/><span id="info"></span></td></tr> 
		<tr><td>非现金行权收入(RMB):</td><td><input readonly type="text" id="total" value=""/><span id="total_tips"/></td></tr> 
		<tr><td>现金行权成本(RMB):</td><td><input readonly type="text" id="total2" value=""/><span id="total2_tips"/></td></tr> 
		<tr><td>&nbsp;</td><td><input onclick="_getTotal()" value="计算" type="submit"></td></tr> 
</table> 
<form> 
</form> 
</body> 
</html> 