<?php
Class UserController extends BaseController{

	public static function etusivu(){
      
   	  View::make('etusivut/etusivu.html');
    }

	public static function login(){
		View::make('kayttaja/login.html');
	}

	public static function handle_login(){
		$params = $_POST;

		$user = User::authenticate($params['nimi'], $params['salasana']);

		if(!$user){
			View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
		}else{
			$_SESSION['user'] = $user->id;

			Redirect::to('/askare', array('message' => 'Tervetuloa '. $user->nimi .'!'));
		}
	}

	public static function logout(){
		$_SESSION['user'] = null;
		Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
	}

	public static function show(){
		self::check_logged_in();
		$user = self::get_user_logged_in();
		
		$maara = sizeof(Askare::haeKaikki($user->id));

		View::make('kayttaja/kayttaja.html', array('kayttaja' => $user, 'maara' => $maara));
	}

	public static function uusi(){
		
		View::make('kayttaja/register.html');
	}

	public static function luoKayttaja(){

		$params = $_POST;
		$user = new User(array(
			'nimi' => $params['nimi'],
			'salasana' => $params['salasana']
			));
		$errors = $user->validate();
		if(count($errors) > 0){
		View::make('kayttaja/register.html', array('errors' => $errors));
	}
		else{
			$user->tallennaKayttaja();
			Redirect::to('/login', array('message' => 'Tunnus luotu, voit nyt kirjautua!'));
		}
	}

	public static function poista($id){
		self::check_logged_in();
		$user = new User(array('id' => $id));
		$user->tuhoa($id);
		Redirect::to('/login', array('message' => 'Tunnus poistettu!'));
	}

	public static function muokkaa($id){
		self::check_logged_in();
		$user = new User(array('id' => $id));

		View::make('kayttaja/muokkaa.html', array('kayttaja' => $user));
	}

	public static function paivita($id){
		self::check_logged_in();
		$params = $_POST;
		$tiedot = new User(array(
			'id' => $id,
			'salasana' => $params['salasana']
			));

		if(strlen($params['salasana']) >25 || strlen($params['salasana']) <5 ){
				$errors[] = 'Salasanan oltava 5-25 merkkiä';
				View::make('kayttaja/muokkaa.html', array('error' => 'Salasanan oltava 5-25 merkkiä', 'kayttaja' => $tiedot));
			}
		else{

		
			$tiedot->paivitys();
			Redirect::to('/kayttaja', array('message' => 'Salasana vaihdettu'));
		}
        }


}
