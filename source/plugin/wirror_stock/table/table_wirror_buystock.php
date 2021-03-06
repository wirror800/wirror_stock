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

class table_wirror_buystock extends discuz_table
{
	public function __construct() {

		$this->_table = 'wirror_buystock';
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
		return DB::fetch_all('SELECT * FROM  %t  ORDER BY createtime desc ', array($this->_table));
		//test
		//	return DB::fetch_all('SELECT * FROM  %t   ORDER BY submitdate desc  limit 8', array($this->_table));
	}
	
	public function fetch_by_uid($uid)
	{
		return DB::fetch_all('SELECT * FROM  %t   where uid=%s and stockcount >0  ORDER BY createtime desc ', array($this->_table,$uid));
	}
	
	
	public function fetch_gpm($uid)
	{
		return DB::fetch_all('SELECT distinct stockname FROM  %t   where uid=%s and stockcount >0  ORDER BY createtime desc ', array($this->_table,$uid));
	}
	
	public function insert_data($data)
	{
		return 	DB::insert($this->_table,$data);
	}
	
	public function  fetch_by_uidstcok($uid,$stockcode)
   {
		return DB::fetch_first('SELECT  *  FROM  %t  WHERE  uid=%s and stockcode=%s and stockcount >0 ', array($this->_table, $uid,$stockcode));
	}
	
	public function update_by_uidstockcode($uid,$money,$count,$stockcode)
	{
		return DB::query("UPDATE  %t  SET  stockcbj=".$money.",updatetime=".time().",stockcount=".$count."  WHERE uid=%s and stockcode=%s", array($this->_table, $uid,$stockcode));
	}
	

}

?>