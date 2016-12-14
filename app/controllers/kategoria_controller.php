<?php
Class KategoriaController extends BaseController{
	

	public static function listaa(){
		self::check_logged_in();
		$kategoriat = Kategoria::haeKaikki();
		View::make('kategoria/kategoria.html', array('kategoriat' =>$kategoriat));

	}

	public static function luoKategoria(){
		self::check_logged_in();
		View::make('kategoria/new.html');
	}

	public static function talleta(){
		self::check_logged_in();
		$user = self::get_user_logged_in();
		$params = $_POST;
		$kategoria = new Kategoria(array(
			'nimi' => $params['nimi']
			));
		//Kint::dump($params);
		if(strlen($params['nimi']) >20 || strlen($params['nimi']) <5 ){
		View::make('kategoria/new.html', array('error' => 'Nimen oltava 5-20 merkkiä!'));
	}
	else{
		

		$kategoria->tallennaKategoria();
		self::listaa();
		
	}

	}

	public static function poistaKategoriat(){
		$params = $_POST;
		$kategoriat = $params['kategoriat'];
		foreach($kategoriat as $kategoria){
		$kateaskareet = Kateaska::kaikkiByKategoria($kategoria);
		if($kateaskareet){
		foreach($kateaskareet as $kateaska){
			if($kateaska){
				$kategoriat = Kategoria::haeKaikki();
			View::make('kategoria/kategoria.html', array('error' => 'Poista kategoriat ensin askareilta!', 'kategoriat' =>$kategoriat));
		}
	}	
		}
		else {}
		Kategoria::poista($kategoria);
		self::listaa();
	}	

		}
	}







	
