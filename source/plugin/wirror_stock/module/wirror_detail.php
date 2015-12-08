<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';

$stockcode = daddslashes($_GET['code']);


	$cur_stock = getStockbyCode($stockcode);

//var_dump($cur_stock);


include template('wirror_stock:wirror_stock_detail');


?>