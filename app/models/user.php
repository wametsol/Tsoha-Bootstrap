<?php

class User extends BaseModel{
	
		public $id, $nimi, $salasana;

		public function __construct($attributes){
		parent::__construct($attributes);
		
		}
		public static function authenticate($nimi, $salasana){
			$query = DB::connection()->prepare("SELECT * FROM Kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1");
			$query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
			$row = $query->fetch();

			if($row){
				$kayttaja = new User(array(
					'id' => $row['id'],
					'nimi' => $row['nimi'],
					'salasana' => $row['salasana']
					));
			return $kayttaja;
			}
			return null;

		}

		public static function haeKayttaja($id){
			$query = DB::connection()->prepare("SELECT * FROM Kayttaja WHERE id = :id LIMIT 1");
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row){
				$kayttaja = new User(array(
					'id' => $row['id'],
					'nimi' => $row['nimi'],
					'salasana' => $row['salasana']
					));
			return $kayttaja;
			}
			return null;

		}

		public function tuhoa($id){

			$query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
		
			$query->execute(array('id' => $id));
			

		}

		


			
			
		}
		