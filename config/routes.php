<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function(){
  	HelloWorldController::login();
  });

  $routes->get('/askarelista', function(){
  	HelloWorldController::askarelista();
  });

  $routes->get('/askarelista/1', function(){
  	HelloWorldController::askare();
  });

  $routes->get('/askarelista/1/muokkaa', function(){
  	HelloWorldController::muokkaa();
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
