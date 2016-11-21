<?php

class Kayttaja extends BaseModel{
	
		public $id, $nimi, $salasana;

		public function __construct($attributes){
		parent::__construct($attributes);
		
		}

		public static function luoKukka(){
			
			
		}
		}