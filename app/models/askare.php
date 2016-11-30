<?php

	class Askare extends BaseModel{
	
		public $id, $kayttaja_id, $nimi, $paivamaara, $kuvaus;

		public function __construct($attributes){
		parent::__construct($attributes);

		
		}

		public static function luoKukka(){
			$kukat = new Askare(array('id' => 1, 'kayttaja_id' => 1, 'nimi' => 'Kastele Kukat', 'paivamaara' => '15.12', 'kuvaus' => 'Kukat kasteltava määräaikaan mennessä tai ne kuolevat' ));

			echo $kukat->nimi;
			
		}

		public static function haeKaikki($id){

			$query = DB::connection()->prepare("SELECT * FROM Askare WHERE kayttaja_id = :id");

			$query->execute(array('id' => $id));

			$rows = $query->fetchAll();
			$askareet = array();

			foreach($rows as $row){
				$askareet[] = new Askare(array(
					'id' => $row['id'],
					'kayttaja_id' => $row['kayttaja_id'],
					'nimi' => $row['nimi'],
					'paivamaara' => $row['paivamaara'],
					'kuvaus' => $row['kuvaus'],
					));
				
			}
			return $askareet;

		}

		public static function haeYksi($id){
			$query = DB::connection()->prepare("SELECT * FROM Askare WHERE id = :id LIMIT 1");
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row){
				$askare = new Askare(array(
					'id' => $row['id'],
					'kayttaja_id' => $row['kayttaja_id'],
					'nimi' => $row['nimi'],
					'paivamaara' => $row['paivamaara'],
					'kuvaus' => $row['kuvaus'],
					));
			return $askare;
			}
			return null;

		}
		public function tallenna(){
			$query = DB::connection()->prepare('INSERT INTO Askare (kayttaja_id, nimi, paivamaara, kuvaus) VALUES (:kayttaja_id, :nimi, :paivamaara, :kuvaus) RETURNING id');
			$query->execute(array('kayttaja_id' => $this->kayttaja_id,'nimi' => $this->nimi, 'paivamaara' => $this->paivamaara, 'kuvaus' => $this->kuvaus));
			$row = $query->fetch();
			//Kint::trace();
			//Kint::dump($row);
			$this->id = $row['id'];

		}

		public function paivita(){
			
			$query = DB::connection()->prepare('UPDATE Askare SET nimi = :nimi, paivamaara = :paivamaara, kuvaus = :kuvaus WHERE id = :id');
			
			$query->execute(array('id' => $this->id,'nimi' => $this->nimi, 'paivamaara' => $this->paivamaara, 'kuvaus' => $this->kuvaus));
			
			//Kint::trace();
			//Kint::dump($row);
			//$this->id = $row['id'];
		}

		public function tuhoa($id){

			$query = DB::connection()->prepare('DELETE FROM Askare WHERE id = :id');
		
			$query->execute(array('id' => $id));
			

		}


	}