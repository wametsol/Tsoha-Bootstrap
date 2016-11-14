<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function askarelista(){
      View::make('suunnitelmat/askarelista.html');
    }

    public static function askare(){
      View::make('suunnitelmat/askare.html');
    }

    public static function muokkaa(){
      View::make('suunnitelmat/muokkaa.html');
    }

  }
