<?php

class AskareController extends BaseController{

	public static function index(){
		self::check_logged_in();
		$user = self::get_user_logged_in();
		$askareet = Askare::haeKaikki($user->id);

		View::make('askare/index.html', array('askareet' => $askareet));
	}

	public static function liitäKategoria($askare_id){
		self::check_logged_in();
		$params = $_POST;
		$kategoriat = $params['kategoriat'];
		foreach($kategoriat as $kategoria){

		$kateaska = new Kateaska(array('kategoria_id' => $kategoria, 'askare_id' => $askare_id
			));
		$kateaska->luoUusi();


		}
		Redirect::to('/askare/' . $askare_id, array('message' => 'Kategoria lisätty'));
		}
	public static function kategorianLisays($id){
		self::check_logged_in();
		$askare = Askare::haeYksi($id);
		$kategoriat = Kategoria::haeKaikki();

		View::make('kategoria/liitos.html', array('askare' => $askare, 'kategoriat' => $kategoriat));
	}

	public static function kategoriatPois($id){
		$askare = Askare::haeYksi($id);
		Kateaska::poistaAskareelta($id);
		self::show($id);

	}


	public static function uusi(){
		self::check_logged_in();
		View::make('askare/new.html');
	}

	public static function talleta(){
		self::check_logged_in();
		$user = self::get_user_logged_in();
		$params = $_POST;
		$askare = new Askare(array(
			'kayttaja_id' => $user->id,
			'nimi' => $params['nimi'],
			'paivamaara' => $params['paivamaara'],
			'kuvaus' => $params['kuvaus']
			));
		//Kint::dump($params);
		$errors = $askare->validate();
		if(count($errors) > 0){
		View::make('askare/new.html', array('errors' => $errors));
	}
	else{
		

		$askare->tallenna();
		Redirect::to('/askare/' . $askare->id, array('message' => 'Askare lisätty muistilistaan!'));
	}
	}

	public static function show($id){
		self::check_logged_in();
		$askare = Askare::haeYksi($id);
		$kategoriat = Kateaska::kategoriatByAskare($id);
		View::make('askare/askare.html', array('askare' => $askare, 'kategoriat' => $kategoriat));
	}

	public static function muokkaa($id){
		self::check_logged_in();
		$askare = Askare::haeYksi($id);
		View::make('askare/muokkaa.html', array('askare' => $askare));
	}

	public static function muutaTarkeys($id){
		self::check_logged_in();
		$askare = Askare::haeYksi($id);
		$askare->muutaTarkeytesi();
		Redirect::to('/askare');
		
	}



	public static function paivita($id){
		self::check_logged_in();
		$params = $_POST;
		$tiedot = array(
			'id' => $id,

			'nimi' => $params['nimi'],
			'paivamaara' => $params['paivamaara'],
			'kuvaus' => $params['kuvaus']
			);
		//Kint::dump($params);
		$askare = new Askare($tiedot);
		$errors = $askare->validate();
		if(count($errors) > 0){
			View::make('askare/muokkaa.html', array('errors' => $errors, 'askare' => Askare::haeYksi($id)));
			}
			else{
			
			$askare->paivita();
		Redirect::to('/askare/' . $askare->id, array('message' => 'Askare päivitetty!'));
	}}

	public static function poista($id){
		self::check_logged_in();
		$askare = new Askare(array('id' => $id));
		$askare->tuhoa($id);
		Redirect::to('/askare');
	}
	}
