<?php

	class Database{
		private $data;
		private $MySQLi;
		private $center;
		private static $instance;
		private $selfa;
		
		function __construct( $t0,$t1='',$t2='',$t3=''){
			if(is_array($t0)){
			
				if(array_key_exists('host',$t0) && array_key_exists('user',$t0) && array_key_exists('pass',$t0) && array_key_exists('name',$t0)){
					
					$this->data = $t0;
					
				}else{
					
					$this->data = array(
						'host'  =>  $t0['0'],
						'user'  =>  $t0['1'],
						'pass'  =>  $t0['2'],
						'name'  =>  $t0['3']
					);
				}
				
			}else{
				
				$this->data	=	array(
					'host'	=>	$t0,
					'user'	=>	$t1,
					'pass'	=>	$t2,
					'name'	=>	$t3,
				);
				
			}
			
			if(!empty($this->data)){
				$this->MySQLi	=	@ new mysqli(
							$this->data['host'],
							$this->data['user'],
							$this->data['pass'],
							$this->data['name']
						);
						
			if (mysqli_connect_errno()) {
				
				throw new Exception('Database error.');
			
			}
			
			$this->MySQLi->set_charset("utf8");
			}
			$in0 = $t0;
			$in1 = $t1;
			$in2 = $t2;
			$in3 = $t3;
		}
		
		public static function init($in0,$in1,$in2,$in3){
			if(self::$instance instanceof self){
				return false;
			}
		
		self::$instance = new self($in0,$in1,$in2,$in3);
	}
		
		public static function query($q){
			
			return self::$instance->MySQLi->query($q);
			
		}
		
		public static function select_feild($table){
			$center = self::$instance->query("SELECT * FROM ".$table);
			$ifi = 0;
			while($bot0 = $center->fetch_field()){
				$tab[$ifi] = $bot0->name;
				$ifi++;
			}
			return $tab;
		}
		
		public static function select_all($table,$name_array=''){
		
			$center = self::$instance->query("SELECT * FROM ".$table);
				
					$i = 0;
					 
					while($bot = $center->fetch_assoc()){
						
						if(empty($name_array) ){
							
							$tab[$i] = $bot;
							$i++;
							
						}else{
							
						if(in_array($name_array,self::$instance->select_feild($table))){
							
						$tab[$bot[$name_array]] = $bot;
						
						
						}else{
							
						$tab[$name_array.$i] = $bot;
						
						$i++;
						
						}
					}
					}
			return $tab;
	}
			
}
