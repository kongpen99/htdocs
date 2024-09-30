<?php
define("_SERVER", "localhost");
define("_DATABASE", "PCB_NG_DATA");
define("_USER", "");
define("_PASSWORD", "");

class CSQL {

	private $connection; // ประกาศตัวแปรสำหรับไว้เก็บค่าการ Connection
	private $Result; // ประกาศตัวแปรสำหรับไว้เก็บค่า Query result
	private $DataArray = array(); // ประกาศตัวแปรสำหรับไว้เก็บค่าข้อมูลที่ได้จากการ Query โดยเก็บข้อมูลเป็น Array

	// ประกาศ Function การทำงานในส่วนของ Class Constructure
	// จะทำการสร้าง Connection ไปยัง Database หลังจากมีการประกาศ Object
	public function connect($ip , $db) {
        $connectioninfo = array("Database" => $db, "UID" => _USER, "PWD" => _PASSWORD, "CharacterSet" => "UTF-8");
		$this->connection = sqlsrv_connect($ip, $connectioninfo) or die(sqlsrv_errors());


		return($this);
		// $connectioninfo = array("Database" => _DATABASE, "UID" => _USER, "PWD" => _PASSWORD, "CharacterSet" => "UTF-8");
		// $this->connection = sqlsrv_connect(_SERVER, $connectioninfo) or die(sqlsrv_errors());
	}

	// ทำหน้าที่ Query ข้อมูลและคืนค่า Result เป็นในตัวแปร $Result
	public function Query($SQLCommand) {
		$this->Result = sqlsrv_query($this->connection, $SQLCommand) or die(sqlsrv_errors());
	}

	// ทำหน้าที่ Fetch ข้อมูลที่ได้จากการ Query ($Result) เก็บในตัวแปร $DataArray
	public function FetchData() {
		unset($this->DataArray);	// Cleard Array

		if( $this->Result === false)  
			{  
     			echo "Error in query preparation/execution.\n";  
     			die( print_r( sqlsrv_errors(), true));  
		} else { 
			while ($Data = sqlsrv_fetch_Array($this->Result)) {
				$this->DataArray[] = $Data;
			}
		}

		// Return ข้อมูลที่ได้จากการ fetch data
		return (isset($this->DataArray)?$this->DataArray:NULL);
	}

	// ทำหน้าที่ Return จำนวนแถวทั้งหมดที่ได้จากการ Fetch ข้อมูลแล้ว
	public function RowCount() {
		return count($this->DataArray);
	}

	//* fn ที่สั่งทำ transaction sql
	public function transaction(){
		if ( sqlsrv_begin_transaction( $this->connection ) === false )  
		{  
		    echo "Could not begin transaction.\n";  
		    die( print_r( sqlsrv_errors(), true ));  
		}  
	}

	//* fn : ยืนยันคำสั่งของ sql หลังจากที่ทำ transaction
	public function commit(){
		sqlsrv_commit( $this->connection );  
		return "Transaction was committed.";  
	}

	//* fn : ยกเลิกคำสั่งของ sql เมื่อ transaction เกิด error
	public function rollback(){
		sqlsrv_rollback( $this->connection );  
		return "Transaction was rolled back.";  
	}
}
?>