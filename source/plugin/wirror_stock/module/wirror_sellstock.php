<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';
	
$wirror_op = daddslashes($_GET['op']);

if($wirror_op == "submitsellstock"){
	
	$stockcode = daddslashes($_GET['code']);

	$cur_stock = getStockbyCode($stockcode);
	
	$userstock = C::t('#wirror_stock#wirror_stock')->fetch_by_uid($_G['uid']);

	$count  = intval($_GET['sellnumber']);
	
	
	if(!$count){
		showmessage('卖出的股票数量不能小于0','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'error'));
	}
	$existdata = C::t('#wirror_stock#wirror_buystock')->fetch_by_uidstcok($_G['uid'],$stockcode);
	
	if($count>$existdata['stockcount']){
		showmessage('卖出的股票数量不能大于已有数量','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'error'));
	}
	
	
	$stockcount = $existdata['stockcount']-$count;
	
	$sycount = $stockcount > 0 ? $stockcount:0;
	
	C::t('#wirror_stock#wirror_buystock')->update_by_uidstockcode($_G['uid'],$cur_stock[3],$sycount,$stockcode);
	
	//增加账号余额
	$stockMoney = intval($count*$cur_stock[3]);
	$kcmoney = $userstock['stockzj']+$stockMoney;
	C::t('#wirror_stock#wirror_stock')->update_by_uid($_G['uid'],$kcmoney);
	
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
			'tradetype'=>2,
			'createtime'=>time(),
	);
	
	C::t('#wirror_stock#wirror_stocklog')->insert($buylogdata);
	
	showmessage('卖出成功','plugin.php?id=wirror_stock&ac=market', "",array('alert'=>'right'));
	
}else{
	
	$stockcode = daddslashes($_GET['code']);
	$cur_stock = getStockbyCode($stockcode);
	$userstock = C::t('#wirror_stock#wirror_buystock')->fetch_by_uidstcok($_G['uid'],$stockcode);
	include template('common/header_ajax');
	include template('wirror_stock:sellstock');
	include template('common/footer_ajax');
}



?>