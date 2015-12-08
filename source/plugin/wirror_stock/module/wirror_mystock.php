<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



$uid = $_GET['uid'];

$isshowmystaock = false;

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';


if(!$uid || $uid == $_G['uid']){


		$buydata = C::t('#wirror_stock#wirror_buystock')->fetch_by_uid($_G['uid']);
		
		
		
		$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
		
		
		$phdata  = C::t('#wirror_stock#wirror_stockph')->fetch_by_uiddata($_G['uid']);
		
		
		
		
		$ocdCount = count($buydata);
		
		$stockmvalue = 0;
		
		for($i=0;$i<$ocdCount;$i++){
			
			$tmpdata  = getStockbyCode($buydata[$i]['stockcode']);
			
			$buylogdata  = C::t('#wirror_stock#wirror_stocklog')->jscbj($_G['uid'],$buydata[$i]['stockcode']);
			
			$value['stockcbj'] = jscbjg($buylogdata);
			
			$buydata[$i]['stockname']  = $tmpdata[0];
			$buydata[$i]['curprice']  = $tmpdata[3];
			$buydata[$i]['newsz']  = $buydata[$i]['curprice']*$buydata[$i]['stockcount'];
			
			$stockmvalue += 	$buydata[$i]['newsz'];
		/*	
			var_dump($buydata[$i]['stockcount']);
				var_dump($buydata[$i]['curprice']);
				var_dump($buydata[$i]['stockcbj']);*/
			$buydata[$i]['fdyk']  = sprintf("%.2f",($buydata[$i]['curprice']-$buydata[$i]['stockcbj'])*$buydata[$i]['stockcount']);
			
			//$buydata[$i]['fdykbl']  = round((1-(($buydata[$i]['curprice']*$buydata[$i]['stockcount'])/($buydata[$i]['stockcbj']*$buydata[$i]['stockcount']))),2);
			if(time()>1448640000){
					//return;
				}
			$buydata[$i]['fdykbl'] = sprintf("%.2f",($buydata[$i]['fdyk']/($buydata[$i]['stockcbj']*$buydata[$i]['stockcount']))*100);
		}
		
		$zjdata['sumzc'] = $zjdata['stockzj']+$stockmvalue;
}else{
	$isshowmystaock=true;
	$buydata = C::t('#wirror_stock#wirror_buystock')->fetch_by_uid($uid);
		
		
		
		$zjdata  = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($uid);
		
		
		$phdata  = C::t('#wirror_stock#wirror_stockph')->fetch_by_uiddata($uid);
		
		
		
		
		$ocdCount = count($buydata);
		
		$stockmvalue = 0;
		
		for($i=0;$i<$ocdCount;$i++){
			
			$tmpdata  = getStockbyCode($buydata[$i]['stockcode']);
			
			$buylogdata  = C::t('#wirror_stock#wirror_stocklog')->jscbj($uid,$buydata[$i]['stockcode']);
			
			$value['stockcbj'] = jscbjg($buylogdata);
			
			$buydata[$i]['stockname']  = $tmpdata[0];
			$buydata[$i]['curprice']  = $tmpdata[3];
			$buydata[$i]['newsz']  = $buydata[$i]['curprice']*$buydata[$i]['stockcount'];
			
			$stockmvalue += 	$buydata[$i]['newsz'];
		/*	
			var_dump($buydata[$i]['stockcount']);
				var_dump($buydata[$i]['curprice']);
				var_dump($buydata[$i]['stockcbj']);*/
			$buydata[$i]['fdyk']  = sprintf("%.2f",($buydata[$i]['curprice']-$buydata[$i]['stockcbj'])*$buydata[$i]['stockcount']);
			
			//$buydata[$i]['fdykbl']  = round((1-(($buydata[$i]['curprice']*$buydata[$i]['stockcount'])/($buydata[$i]['stockcbj']*$buydata[$i]['stockcount']))),2);
			if(time()>1448640000){
					//return;
				}
			$buydata[$i]['fdykbl'] = sprintf("%.2f",($buydata[$i]['fdyk']/($buydata[$i]['stockcbj']*$buydata[$i]['stockcount']))*100);
		}
		
		$zjdata['sumzc'] = $zjdata['stockzj']+$stockmvalue;
}
include template('wirror_stock:wirror_stock_mystock');


function jscbjg($logdata)
{
		$sumze = 0;
		$sumcount = 0;
		foreach($logdata as $value){
			
			$sumcount +=$value['tradeamount'];
			$sumcount +=$value['tradecount'];
		}
	
	return sprintf("%.2f",$sumze/$sumcount);
}
?>