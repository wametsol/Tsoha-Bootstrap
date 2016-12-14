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
		public function paivitys(){
			
			$query = DB::connection()->prepare('UPDATE Kayttaja SET salasana = :salasana WHERE id = :id');
			
			$query->execute(array('id' => $this->id,'salasana' => $this->salasana));
			$row = $query->fetch();
		}

		public function tallennaKayttaja(){

			$query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, salasana) VALUES (:nimi, :salasana) RETURNING id');
			$query->execute(array('nimi' => $this->nimi,'salasana' => $this->salasana));
			$row = $query->fetch();

		}

		public function validate(){
			$errors = array();
			if($this->nimi == '' || $this->nimi == null){
				$errors[] = 'Nimi ei saa olla tyhjä!';
			}
			if(strlen($this->nimi) <= 3 || strlen($this->nimi) >=15){
				$errors[] = 'Nimen oltava 3-15 merkkiä pitkä';
			}
			if(strlen($this->salasana) >=25 || strlen($this->salasana) <=5 ){
				$errors[] = 'Salasanan oltava 5-25 merkkiä';
			}
			


			return $errors;
		}

		


			
			
		}

		