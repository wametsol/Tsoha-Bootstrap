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
