<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_myrepeats.php 31512 2012-09-04 07:11:08Z monkey $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_wirror_stocklog extends discuz_table
{
	public function __construct() {

		$this->_table = 'wirror_stocklog';
		$this->_pk    = '';

		parent::__construct();
	}
	
	public function fetch_orderCondition($order_status=null,$username=null,$submitdatebegin=null,$submitdateend=null,$confirmbegin=null,$confirmend=null)
	{
		$condition = '';
		$condition .= $order_status ? ' AND order_status='. $order_status:'';
		$condition .= $username ? " AND username=". "'".$username."'":'';

		if($submitdatebegin and $submitdateend){
			$condition .=' AND (submitdate>='.strtotime($submitdatebegin.' 00:00:00').' AND submitdate<='.strtotime($submitdateend.' 23:59:59').')';
		}
		if($submitdatebegin and !$submitdateend){
				$condition .=$submitdatebegin? ' AND submitdate>='.strtotime($submitdatebegin.' 00:00:00'):'';
		}
		if($confirmbegin and $confirmend){
			$condition .=' AND (submitdate>='.strtotime($confirmbegin.' 00:00:00').' AND submitdate<='.strtotime($confirmend.' 23:59:59').')';
		}
		
		if($confirmbegin and !$confirmend){
			$condition .=$confirmbegin? ' AND submitdate>='.strtotime($confirmbegin.' 00:00:00'):'';
		}
		if($condition ==''){
			return  DB::fetch_all('SELECT * FROM  %t  ORDER BY submitdate desc', array($this->_table));
		}
				echo $condition;
		$condition = substr($condition,4);
		return  DB::fetch_all('SELECT * FROM  %t   where ' .$condition .' ORDER BY submitdate desc', array($this->_table));
		
	}
	public function fetch_ordercompleted_data($showNumber)
	{
		return DB::fetch_all('SELECT * FROM  %t   where order_status=2 and trade_no is not null  ORDER BY confirmdate desc  limit 8', array($this->_table));
		//test
	//	return DB::fetch_all('SELECT * FROM  %t   ORDER BY submitdate desc  limit 8', array($this->_table));
	}
	
	public function fetch_all_data()
	{
		return DB::fetch_all('SELECT * FROM  %t     ORDER BY gcreatetime desc ', array($this->_table));
		//test
		//	return DB::fetch_all('SELECT * FROM  %t   ORDER BY submitdate desc  limit 8', array($this->_table));
	}
	
	public function insert_data($data)
	{
		return 	DB::insert($this->_table,$data);
	}
	
	public function  fetch_by_uid($uid)
   {
		return DB::fetch_all('SELECT  *  FROM  %t  WHERE  uid=%s ORDER BY createtime desc', array($this->_table, $uid));
	}
	
	public function update_by_uid($uid,$money)
	{
		return DB::query("UPDATE  %t  SET  stockzj=".$money.",updatetime=".time()."  WHERE uid=%s", array($this->_table, $uid));
	}
	
	public function jscbj($uid,$stockcode){
		
		return DB::fetch_all('SELECT  *  FROM  %t  WHERE  uid=%s and tradetype=1 and stockcode=%s  ORDER BY createtime', array($this->_table, $uid,$stockcode));
		
	}
	
	//获取所有id
	public function getUIDs(){
		
				return DB::fetch_all('SELECT  distinct uid,username FROM  %t ', array($this->_table));
	
	}
	//获取各个股票购买总数
	public function getStockSUM($uid){
		return DB::fetch_all('SELECT uid,stockcode, SUM(tradecount) AS tradecount FROM %t WHERE uid = %S and tradetype=1 GROUP BY stockcode', array($this->_table, $uid));
	}
	
	public function getTradeamount($uid){
		
		return DB::fetch_first('SELECT sum(tradeamount) as zrze  FROM %t WHERE tradetype =3 and uid=%s', array($this->_table, $uid));
	
	}
	
	
		public function  fetch_byls_uid($uid)
   {
		return DB::fetch_all('SELECT  *  FROM  %t  WHERE  uid=%s and (tradetype=1 or tradetype=2) ORDER BY createtime desc', array($this->_table, $uid));
	}
	
}

?>