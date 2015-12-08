<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';
	
$wirror_op = daddslashes($_GET['op']);

	
if($wirror_op == "submitbuystock"){
		
	$stockcode = daddslashes($_GET['code']);

	$cur_stock = getStockbyCode($stockcode);
	
	$userstock = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);

	$count  = intval($_GET['number']);
	
	if(!$count){
		showmessage('购买的股票数量不能小于0','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'error'));
	}
	

	$stockMoney = intval($count*$cur_stock[3]);

	if($stockMoney>$userstock['stockzj']){
		showmessage('您的股票资金不足，购买失败','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'error'));
	}
	
	$existdata = C::t('#wirror_stock#wirror_buystock')->fetch_by_uidstcok($_G['uid'],$stockcode);
	
	if(!$existdata){
		$buydata  = array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'stockcount'=>$count,
			'stockcode'=>$stockcode,
			'stockname'=>$cur_stock[0],
			'stockcbj'=>$cur_stock[3],
			'createtime'=>time(),
			'createtime'=>time(),
		);
		
		
		C::t('#wirror_stock#wirror_buystock')->insert($buydata);
		
		
	}else{
		$stockcount = $existdata['stockcount']+$count;
		C::t('#wirror_stock#wirror_buystock')->update_by_uidstockcode($_G['uid'],$cur_stock[3],$stockcount,$stockcode);
	}
	
	
	//扣除账号余额
	$kcmoney = $userstock['stockzj']-$stockMoney;
	C::t('#wirror_stock#wirror_stock')->update_by_uid($_G['uid'],$kcmoney);
	
	//增加股票的投入金额
	$sumexp = $userstock['sumexp']+$stockMoney;
	C::t('#wirror_stock#wirror_stock')->update_by_uid01($_G['uid'],$sumexp);

	
	
	$userstock = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
	
	$buylogdata  = array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'tradename'=>$cur_stock[0],
			'stockcode'=>$stockcode,
			'tradecount'=>$count,
			'tradeamount'=>sprintf("%.2f", $count*$cur_stock[3]),
			'tradeprice'=>$cur_stock[3],
			'amountze'=>$userstock['stockzj'],
		/*	'fsze'=>1,
			'jyj'=>1,
			'yhs'=>1,
			'ghf'=>1,
			'jygf'=>1,*/
			'tradetype'=>1,
			'createtime'=>time(),
	);
	
	C::t('#wirror_stock#wirror_stocklog')->insert($buylogdata);
	

	showmessage('购买成功','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'right'));
	
}else{
	
	$stockcode = daddslashes($_GET['code']);
	$cur_stock = getStockbyCode($stockcode);
	$userstock = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);
	$buycount = intval($userstock['stockzj']/$cur_stock[3]);


	include template('common/header_ajax');
	include template('wirror_stock:buystock');
	include template('common/footer_ajax');
}



?>