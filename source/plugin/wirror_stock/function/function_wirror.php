<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function  getStockData($page,$showNum){
		
	//	$stockdataurl = "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22hq%22,%22hs_a%22,%22%22,0,1,40]]";
		
	$stockdataurl = "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22hq%22,%22hs_a%22,%22%22,0,".$page.",".$showNum."]]";
	
	$str = sendRequest($stockdataurl);
	
	//$str = file_get_contents($stockdataurl);
		
	$str = json_decode($str,true);
		
	return $str[0];
	//return $str[0]['items'];
		
}
function  getStockDatahz($page,$showNum,$type){
		
	//	$stockdataurl = "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22hq%22,%22hs_a%22,%22%22,0,1,40]]";
		
	//$stockdataurl = "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22hq%22,%22hs_a%22,%22%22,0,".$page.",".$showNum."]]";
	//http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,1,40,%22%22,0,%22zhishu_399001%22]]
	//http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,1,40,%22%22,0,%22zhishu_000001%22]]
	
	//http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,1,40,%22%22,0,%22zhishu_000001%22]]

		//$stockdataurl = "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,".$page.",".$showNum.",%22%22,0,%22zhishu_000001%22]]";
	
	//$stockdataurl =  "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,".$page.",".$showNum.",%22%22,0,%22zhishu_000001%22]]";
	if($type == "hz"){
		$stockdataurl =  "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,".$page.",".$showNum.",%22%22,0,%22zhishu_000001%22]]";
	}else if($type == "sz"){
		$stockdataurl =  "http://money.finance.sina.com.cn/d/api/openapi_proxy.php/?__s=[[%22jjhq%22,".$page.",".$showNum.",%22%22,0,%22zhishu_399001%22]]";
	}else{
		
		return false;
	}
	
	$str = sendRequest($stockdataurl);
	
	//$str = file_get_contents($stockdataurl);
		
	$str = json_decode($str,true);
		
	return $str[0];
	//return $str[0]['items'];
		
}


function getStockZS($type){
	if($type=='sh'){
		$stockdataurl = "http://hq.sinajs.cn/list=s_sh000001";
	}else if($type=='sz'){
		$stockdataurl = "http://hq.sinajs.cn/list=s_sz399001";
	}else{
		return ;
	}
	$str = sendRequest($stockdataurl);
	$str = explode("=", $str);
	$str[1]=str_replace("\"","",$str[1]);
	$str[1]=str_replace(";","",$str[1]);
	$str = explode(",", $str[1]);
	return $str;
}

function getStockbyCode($code){
	
	

	$url = "http://hq.sinajs.cn/list=".$code;

	$str = sendRequest($url);

	$str = explode("=", $str);
	$str[1]=str_replace("\"","",$str[1]);
	$str[1]=str_replace(";","",$str[1]);
	$str = explode(",", $str[1]);
	return $str;
}


function sendRequest($url){
	 	
	 		
	 		$ch = curl_init();
	 		curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT,1000);
            $returndata = curl_exec($ch);
            curl_close($ch);
           
            return $returndata;
	 }

//计算胜算率
function jsyycs($buydata){
	
	$yycount=0;
	$substockcount = 0;
	foreach($buydata as $value){
		
		$tmpdata  = getStockbyCode($value['stockcode']);
		
		$fdyk  = ($tmpdata[3]-$value['stockcbj'])*$value['stockcount'];
		if($fdyk>=0){
			$yycount  += 1;
		}
		$substockcount +=1;
		
	}
	
	return ($yycount/$substockcount)*100;
	
}

//计算仓位
function jscw($buydata,$uid){
	foreach($buydata as $value){
			$tmpdata  = getStockbyCode($value['stockcode']);
			$cursz = $tmpdata[3]*$value['stockcount'];
			$sumcursz += $cursz;
	}
		
	$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($uid);
	$sumzj = $zjdata['stockzj']+$sumcursz;
	
	return ($sumcursz/$sumzj)*100;
}

//计算总收益率 
//总收益率= （总资产- 资金转账转入的资金-默认的资金）/(资金转账转入的资金+默认的资金)
function jszsyl($buydata,$uid){
	
	foreach($buydata as $value){
			$tmpdata  = getStockbyCode($value['stockcode']);
			$cursz = $tmpdata[3]*$value['stockcount'];
			$sumcursz += $cursz;
	}
		
	$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($uid);
	

	
	//总资产
	$sumzj = $zjdata['stockzj']+$sumcursz;
	
		
	
	//资金转入总额
	$zrze = C::t('#wirror_stock#wirror_stocklog')->getTradeamount($uid);
	$zjzrze = $zrze['zrze'];
	
	return ($sumzj-$zjzrze-1)/$zjzrze+1;
	
}

?>