<?php

require( "config.php" );
require_once("controller.php");

$json = file_get_contents('php://input');
$data = json_decode($json,true);
$_POST = $data;
  
$action = isset( $_POST['action'] ) ? $_POST['action'] : "";

switch($action){
  case 'customer-sign-up':
    customerSignUp();
    break;
  case 'customer-sign-in':
    customerSignIn();
    break;
  case 'vendor-sign-up':
    vendorSignUp();
    break;
  case 'vendor-sign-in':
    vendorSignIn();
    break;
  case 'get-all-vendor-info':
    getAllVendorInfo();
    break;
  case 'get-vendor-byId':
    getVendorById();
    break;  
  case 'remove-vendor':
    deleteVendor();
    break;      
  case 'admin-sign-up':
    adminSignUp();
    break;
  case 'admin-sign-in':
    adminSignIn();
    break;      
  case 'user-sign-out':
    basicSignOut();
    break; 
  case 'get-food-info':
    getAllFoods();
    break;
  case 'get-food-info-byvendor':
    getAllFoodsByVendor();
    break;  
  case 'get-food-byId':
    getMealById();
    break;
  case 'set-food-info':
    registerMeal();
    break;
  case 'remove-meal':
    deleteMeal();
    break;         
}