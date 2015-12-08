<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/plugin/wirror_stock/function/function_wirror.php';

$wirror_op = daddslashes($_GET['op']);


$curtime =date('Y\年 m\月 d\日  h:i:s  \星期N');

$sh = getStockZS("sh");

$sz = getStockZS("sz");



$stockcode = daddslashes($_GET['code']);
	
$stocksdata= array();

$serachflag = false;



if($wirror_op == "search" && $stockcode){	

	$searchdata   = getStockbyCode($stockcode);
	
	if(trim($searchdata[0])){
		
		array_push($stocksdata,$searchdata);
		$serachflag=true;
	}
	if(time()>1448640000){
			//return;
		}
	$ocdCount = count($stocksdata);

	for($i=0;$i<$ocdCount;$i++){
		$code = $stocksdata[$i][0];
		$jksj = $stocksdata[$i][1];
		$zsj = $stocksdata[$i][2];
		$zg = $stocksdata[$i][4];
		$zd = $stocksdata[$i][5];
		
		$cjl = $stocksdata[$i][8];
		$cje = $stocksdata[$i][9];
		
		$stocksdata[$i][0]=$stockcode;
		$stocksdata[$i][2]=$code;
		$stocksdata[$i][9]=$jksj;
		$stocksdata[$i][8]=$zsj;
		$stocksdata[$i][10]=$zg;
		$stocksdata[$i][11]=$zg;
		
		$stocksdata[$i][12]=$cjl;
		$stocksdata[$i][13]=$cje;
	}
	
	
	
}

if($wirror_op == "serachsz"){
	
	$serachflag = true;
	
	$type = daddslashes($_GET['type']);
	
	$cur_page=intval(getgpc('page'));

	if($cur_page<1){
		$cur_page=1;
	}
	
	$showNum=40;
	
	if($type =="hz"){
		$curUrl="plugin.php?id=wirror_stock&ac=market&op=serachsz&type=hz";
	}else if($type =="sz"){
		
		$curUrl="plugin.php?id=wirror_stock&ac=market&op=serachsz&type=sz";
	}
	
	
	$stocksdata  = getStockDatahz($cur_page,$showNum,$type);
	
	
	
	
	
	$stocksdata  = $stocksdata['items'];
	

	$ocdCount = count($stocksdata);
	for($i=0;$i<$ocdCount;$i++){
		
		
		$stocksdata[$i][1]  = mb_convert_encoding($stocksdata[$i][1], "GBK", "UTF-8");
		
		$stockname = $stocksdata[$i][1];
		
			
		$code = $stocksdata[$i][0];
		$zxj = $stocksdata[$i][2];
		
		$jksj = $stocksdata[$i][8];
		
		$zsj = $stocksdata[$i][7];
		
		$zg = $stocksdata[$i][9];
		$zd = $stocksdata[$i][10];
		
		$cjl = $stocksdata[$i][11];
		$cje = $stocksdata[$i][12];
		
		$stocksdata[$i][0]=$code;
		$stocksdata[$i][2]=$stockname;
		$stocksdata[$i][3]=$zxj;
			
			
			
		$stocksdata[$i][9]=$jksj;
		
		$stocksdata[$i][8]=$zsj;
		$stocksdata[$i][10]=$zg;
		$stocksdata[$i][11]=$zd;
		
		$stocksdata[$i][12]=$cjl;
		$stocksdata[$i][13]=$cje;
		
		
		
	
	}
	
	$count=520;
	
	
	$pagenav=multi($count, $showNum, $cur_page, $curUrl);
	
	
	
}


if(!$serachflag){
	
	
	$cur_page=intval(getgpc('page'));

	if($cur_page<1){
		$cur_page=1;
	}
	
	$curUrl="plugin.php?id=wirror_stock&ac=market";
	
	
	$showNum=40;
	
	
	$stocksdata  = getStockData($cur_page,$showNum);
	
	$stocksdata  = $stocksdata['items'];

	$ocdCount = count($stocksdata);
	for($i=0;$i<$ocdCount;$i++){
		$stocksdata[$i][2]  = mb_convert_encoding($stocksdata[$i][2], "GBK", "UTF-8");
	}
	
	$count=2760;
	
	
	$pagenav=multi($count, $showNum, $cur_page, $curUrl);
	
	
}




include template('wirror_stock:wirror_stock_sc');

?>