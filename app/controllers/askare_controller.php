<?php

class AskareController extends BaseController{
	public static function index(){
		$askareet = Askare::haeKaikki();

		View::make('askare/index.html', array('askareet' => $askareet));
	}

	public static function uusi(){
		View::make('askare/new.html');
	}

	public static function talleta(){
		$params = $_POST;
		$askare = new Askare(array(
			'nimi' => $params['nimi'],
			'paivamaara' => $params['paivamaara'],
			'kuvaus' => $params['kuvaus']
			));
		//Kint::dump($params);
		$askare->tallenna();
		Redirect::to('/askare/' . $askare->id, array('message' => 'Askare lisätty muistilistaan!'));
	}

	public static function show($id){
		$askare = Askare::haeYksi($id);

		View::make('askare/askare.html', array('askare' => $askare));
	}
}