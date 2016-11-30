<?php

class AskareController extends BaseController{

	public static function index(){
		$user = self::get_user_logged_in();
		$askareet = Askare::haeKaikki($user->id);

		View::make('askare/index.html', array('askareet' => $askareet));
	}

	public static function uusi(){
		View::make('askare/new.html');
	}

	public static function talleta(){
		$user = self::get_user_logged_in();
		$params = $_POST;
		$askare = new Askare(array(
			'kayttaja_id' => $user->id,
			'nimi' => $params['nimi'],
			'paivamaara' => $params['paivamaara'],
			'kuvaus' => $params['kuvaus']
			));
		//Kint::dump($params);
		if($params['nimi'] != '' && strlen($params['nimi']) >=2){
		$askare->tallenna();
		Redirect::to('/askare/' . $askare->id, array('message' => 'Askare lisätty muistilistaan!'));
	}
	else{
		View::make('askare/new.html', array('virhe' => 'Liian lyhyt nimi!'));
	}
	}

	public static function show($id){
		$askare = Askare::haeYksi($id);

		View::make('askare/askare.html', array('askare' => $askare));
	}

	public static function muokkaa($id){
		$askare = Askare::haeYksi($id);
		View::make('askare/muokkaa.html', array('askare' => $askare));
	}

	public static function paivita($id){
		$params = $_POST;
		$tiedot = array(
			'id' => $id,

			'nimi' => $params['nimi'],
			'paivamaara' => $params['paivamaara'],
			'kuvaus' => $params['kuvaus']
			);
		//Kint::dump($params);
		if($params['nimi'] != '' && strlen($params['nimi']) >=2){
			$askare = new Askare($tiedot);
			$askare->paivita();
		Redirect::to('/askare/' . $askare->id, array('message' => 'Askare päivitetty!'));
	}
	else{
		View::make('askare/muokkaa.html', array('virhe' => 'Liian lyhyt nimi!'));
	}
	}

	public static function poista($id){
		$askare = new Askare(array('id' => $id));
		$askare->tuhoa($id);
		Redirect::to('/askare');
	}
	}
