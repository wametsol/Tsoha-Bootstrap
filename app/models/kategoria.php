<?php

class Kategoria extends BaseModel{
	
		public $id, $nimi;

		public function __construct($attributes){
		parent::__construct($attributes);
	}

		public function tallennaKategoria(){
			$query = DB::connection()->prepare('INSERT INTO Kategoria (nimi) VALUES (:nimi) RETURNING id');
			$query->execute(array('nimi' => $this->nimi));
			$row = $query->fetch();
		}
		public function haeKaikki(){
			$query = DB::connection()->prepare("SELECT * FROM Kategoria");

			$query->execute();

			$rows = $query->fetchAll();
			$kategoriat = array();
			
			foreach($rows as $row){
				$kategoriat[] = new Kategoria(array(
					'id' => $row['id'],
					'nimi' => $row['nimi']
					));
				
			}
			return $kategoriat;

		}
		public function haeYksi($id){
			$query = DB::connection()->prepare("SELECT * FROM Kategoria WHERE id = :id LIMIT 1");
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row){
				$kategoria = new User(array(
					'id' => $row['id'],
					'nimi' => $row['nimi']
					));
			return $kategoria;
			}
			return null;
		}

		public function poista($id){
			$query = DB::connection()->prepare('DELETE FROM Kategoria WHERE id = :id');
		
			$query->execute(array('id' => $id));
		}
		
		}