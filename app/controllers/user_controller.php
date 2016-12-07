<?php
Class UserController extends BaseController{

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

			Redirect::to('/askare', array('message' => 'Tervetuloa takaisin  '. $user->nimi .'!'));
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

		if($params['nimi'] != '' && strlen($params['nimi']) >=3 && $params['salasana'] != ''){
			$query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, salasana) VALUES (:nimi, :salasana) RETURNING id');
			$query->execute(array('nimi' => $params['nimi'],'salasana' => $params['salasana']));
			$row = $query->fetch();

		
		Redirect::to('/login', array('message' => 'Tunnus luotu, voit nyt kirjautua!'));
	}
		else{
		View::make('kayttaja/register.html', array('virhe' => 'Käyttäjänimen oltava vähintään 3 merkkiä ja salasana ei saa olla tyhjä'));
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
		$tiedot = array(
			'id' => $id,

			'salasana' => $params['salasana']
			);
		//Kint::dump($params);
		if($params['salasana'] != ''){
			$query = DB::connection()->prepare('UPDATE Kayttaja SET salasana = :salasana WHERE id = :id');
			
			$query->execute(array('id' => $id,'salasana' => $params['salasana']));

			
		Redirect::to('/kayttaja', array('message' => 'Salasana vaihdettu!'));
	}
	else{
		View::make('kayttaja/muokkaa.html', array('virhe' => 'Liian lyhyt salasana!'));
	}
        }


}
