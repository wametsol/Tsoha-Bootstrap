<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function(){
  	UserController::login();
  });

  $routes->post('/login', function(){
  	UserController::handle_login();
  });

  $routes->get('/askarelista/1', function(){
  	HelloWorldController::askare();
  });

  $routes->post('/askare/:id/muokkaa', function($id){
    AskareController::paivita($id);
  });

  $routes->get('/askare/:id/poista', function($id){
    AskareController::poista($id);
  });

  $routes->get('/askare/:id/muokkaa', function($id){
  	AskareController::muokkaa($id);
  });

  $routes->get('/askare', function(){
    AskareController::index();
  });

  $routes->post('/askare', function(){
    AskareController::talleta();
  });

  $routes->get('/askare/new', function(){
    AskareController::uusi();
  });


  $routes->get('/askare/:id', function($id){
    AskareController::show($id);
  });

  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/kayttaja', function(){
    UserController::show();
  });

  $routes->get('/register', function(){
    UserController::uusi();
  });

  $routes->post('/register', function(){
    UserController::luoKayttaja();
  });

  $routes->get('/kayttaja/:id/poista', function($id){
    UserController::poista($id);
  });

  $routes->get('/kayttaja/:id/muokkaa', function($id){
    UserController::muokkaa($id);
  });

  $routes->post('/kayttaja/:id/muokkaa', function($id){
    UserController::paivita($id);
  });