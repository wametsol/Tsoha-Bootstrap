<?php
Class UserController extends BaseController{

	public static function login(){
		View::make('kayttaja/login.html');
	}

	public static function handle_login(){
		$params = $_POST;

		$user = User::authenticate($params['nimi'], $params['salasana']);

		if(!$user){
			View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
		}else{
			$_SESSION['user'] = $user->id;

			Redirect::to('/askare', array('message' => 'Tervetuloa takaisin  '. $user->nimi .'!'));
		}
	}


}
