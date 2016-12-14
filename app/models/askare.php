<?php

	class Askare extends BaseModel{
	
		public $id, $kayttaja_id, $nimi, $paivamaara, $kuvaus, $tarkeys;

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
					'tarkeys' => $row['tarkeys']
					));
				
			}
			return $askareet;

		}
		public static function haeKategoriat(){
			$kategoriat = Kateaska::kategoriatByAskare($this->id);
			return $kategoriat;
		}

		public static function uusiKategoria(){
			
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
					'tarkeys' => $row['tarkeys']
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

		public function muutaTarkeytesi(){
			if($this->tarkeys == 0){
				$uusiTarkeys = 1;
			}
			elseif ($this->tarkeys == 1) {
				$uusiTarkeys = 0;
			}

			$query = DB::connection()->prepare('UPDATE Askare SET tarkeys = :tarkeys WHERE id = :id');
			
			$query->execute(array('id' => $this->id,'tarkeys' => $uusiTarkeys));
			

		}

		public function validate(){
			$errors = array();
			if($this->nimi == '' || $this->nimi == null){
				$errors[] = 'Nimi ei saa olla tyhjä!';
			}
			if(strlen($this->nimi) <= 2 || strlen($this->nimi) >=20){
				$errors[] = 'Nimen oltava 2-20 merkkiä pitkä';
			}
			if(strlen($this->paivamaara) >=18){
				$errors[] = 'Määräajan oltava alle 18 merkkiä';
			}
			if(strlen($this->kuvaus) >=350){
				$errors[] = 'Kuvauksen oltava alle 350 merkkiä';
			}


			return $errors;
		}


	}