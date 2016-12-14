<?php


class Kateaska extends BaseModel{
	
		public $id, $kategoria_id, $askare_id;

		public function __construct($attributes){
		parent::__construct($attributes);
	}


	public function haeYksi($id){
		$query = DB::connection()->prepare("SELECT * FROM Kateaska WHERE id = :id LIMIT 1");
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row){
				$kateaska = new Kateaska(array(
					'id' => $row['id'],
					'kategoria_id' => $row['kategoria_id'],
					'askare_id' => $row['askare_id'],
					));
			return $kateaska;
			}
			return null;
	}
	public function haeKaikki(){
		$query = DB::connection()->prepare("SELECT * FROM Kateaska");
			$query->execute(array('kategoria_id' => $id));
			
			$rows = $query->fetchAll();
			$kateaskareet = array();

			foreach($rows as $row){
				$kateaskareet[] = new Kateaska(array(
					'id' => $row['id'],
					'kategoria_id' => $row['kategoria_id'],
					'askare_id' => $row['askare_id']
					));
				
			}
			return $kateaskareet;
			
			
	}
	public function kaikkiByKategoria($id){
			$query = DB::connection()->prepare("SELECT * FROM Kateaska WHERE kategoria_id = :id");
			$query->execute(array('id' => $id));
			
			$rows = $query->fetchAll();
			$kateaskareet = array();

			foreach($rows as $row){
				$kateaskareet[] = new Kateaska(array(
					'id' => $row['id'],
					'kategoria_id' => $row['kategoria_id'],
					'askare_id' => $row['askare_id']
					));
				
			}
			return $kateaskareet;

	}
	public function askareetByKategoria($id){
			$query = DB::connection()->prepare("SELECT * FROM Kateaska WHERE kategoria_id = :id");
			$query->execute(array('id' => $id));
			
			$rows = $query->fetchAll();
			$kateaskareet = array();

			foreach($rows as $row){
				$kateaskareet[] = Askare::haeYksi($row['askare_id']);
				
			}
			return $kateaskareet;

	}

	public function kategoriatByAskare($id){

		$query = DB::connection()->prepare("SELECT * FROM Kateaska WHERE askare_id = :id");
			$query->execute(array('id' => $id));
			
			$rows = $query->fetchAll();
			$askategoriat = array();

			foreach($rows as $row){
				$askategoriat[] = Kategoria::haeYksi($row['kategoria_id']);
				
			}
			return $askategoriat;

	}

	public function luoUusi(){
		$query = DB::connection()->prepare('INSERT INTO Kateaska (kategoria_id, askare_id) VALUES (:kategoria_id, :askare_id) RETURNING id');
			$query->execute(array('kategoria_id' => $this->kategoria_id,'askare_id' => $this->askare_id));
			$row = $query->fetch();
	}

	public function paivita(){
		$query = DB::connection()->prepare('UPDATE Kateaska (kategoria_id, askare_id) VALUES (:kategoria_id, :askare_id) RETURNING id');
			$query->execute(array('kategoria_id' => $this->kategoria_id,'askare_id' => $this->askare_id));
			$row = $query->fetch();
	}

	public function poista(){
			$query = DB::connection()->prepare('DELETE FROM Kateaska WHERE id = :id');
		
			$query->execute(array('id' => $this->$id));

	}

	public function poistaAskareelta($id){
			$query = DB::connection()->prepare('DELETE FROM Kateaska WHERE askare_id = :id');
		
			$query->execute(array('id' => $id));
	}
}