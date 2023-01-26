<?php
  
  function customerSignUp(){
    $response = array();
    $user_id = "0";
  
    // User has posted the data
    $user = new FoodCustomer;
    $isRegistered = $user->emailIsRegistered( $_POST['email'] );
  
    if($isRegistered){
      $code = "BAD";
      $message = "You could not be registered.\n
                  That email is already registered in the system.";
    }
    elseif(!$isRegistered){
  
      $user->storeFormValues( $_POST );
      $id = $user->insert();
  
      if(!is_null( $id )){
        $user_id = $user->getId();
        $code = "GOOD";
        $message = "You have been successfully registered in the system.\n
                  Welcome to Food Ordering System."; 
      }else{
        $code = "BAD";
        $message = "You could not be registered please try again.";
      }
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }
  
  function customerSignIn() {
    $response = array();
    $user_id = "";
  
    // User has posted the login form: attempt to log the user in
    $user = new FoodCustomer;
    $num  = $user->getLogin($_POST['email'],$_POST['password']);
  
    if ( $num >= 1 ) {
      $user_id = $user->getId();
      $code = "GOOD";
      $message = "You have been successfully logged in"; 
  
    } else {
      // Login failed: display an error message to the user
      $code = "BAD";
      $message = "Your login failed.";
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }

  function vendorSignUp(){
    $response = array();
    $user_id = "0";
  
    // User has posted the data
    $user = new FoodVendor;
    $isRegistered = $user->emailIsRegistered( $_POST['email'] );
  
    if($isRegistered){
      $code = "BAD";
      $message = "You could not be registered.\n
                  That email is already registered in the system.";
    }
    elseif(!$isRegistered){
  
      $user->storeFormValues( $_POST );
      $id = $user->insert();
  
      if(!is_null( $id )){
        $user_id = $user->getId();
        $code = "GOOD";
        $message = "You have been successfully registered in the system.\n
                  Welcome to Food Ordering System."; 
      }else{
        $code = "BAD";
        $message = "You could not be registered please try again.";
      }
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }
  
  function vendorSignIn() {
    $response = array();
    $user_id = "";
  
    // User has posted the login form: attempt to log the user in
    $user = new FoodVendor;
    $num  = $user->getLogin($_POST['email'],$_POST['password']);
  
    if ( $num >= 1 ) {
      $user_id = $user->getId();
      $code = "GOOD";
      $message = "You have been successfully logged in"; 
  
    } else {
      // Login failed: display an error message to the user
      $code = "BAD";
      $message = "Your login failed.";
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }

  function getAllVendorInfo(){
    $code = ""; $message = "";
    $response      = array();
    $vendors       = array();

    $user          = new FoodVendor;

    $vendorInfo    = $user->getList();
    $vendorList    = $vendorInfo['results'];
    $numberOfItems = $vendorInfo['totalRows'];
  
    if($numberOfItems >= 1){
      foreach($vendorList as $vendor){

        array_push($vendors,
        array("id"=> $vendor->getId(),
              "first_name"=>$vendor->getFirstName(),
              "last_name"=>$vendor->getLastName(),
              "email"=>$vendor->getEmail()));
      }

      $code = "GOOD";
      $message = "Vendor Info Available";
      array_push($response,array("code"=>$code,"message"=>$message,"vendorList"=>$vendors));
    }else {
      $code = "BAD";
      $message = "No Vendor Available";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
   
    echo json_encode($response);
  }

  function getVendorById() {
    $response = array();
    $vendor = FoodVendor::getById( $_POST['id']);
  
    if(!is_null($vendor)){
      $code = "GOOD";
      $message = "Vendor found";

      $id = $vendor->getId();
      $firstname = $vendor->getFirstName();
      $lastname = $vendor->getLastName();
      $email = $vendor->getEmail();
  
      array_push($response,array("code"=>$code,"message"=>$message,"id"=>$id,"firstname"=>$firstname,
      "lastname"=>$lastname,"email"=>$email));
  
    }
    else{
      $code = "BAD";
      $message = "vendor info could not be retrived.";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
  
    echo json_encode($response);
  }

  function deleteVendor(){
    $response = array();

    $vendor = new FoodVendor;
    $vendor->setId($_POST['vendor_id']);
    $vendor->delete();
    
    $code = "GOOD";
    $message = "Delete Request Made";
    
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
  }

  function adminSignUp(){
    $response = array();
    $user_id = "0";
  
    // User has posted the data
    $user = new Admin;
    $isRegistered = $user->emailIsRegistered( $_POST['email'] );
  
    if($isRegistered){
      $code = "BAD";
      $message = "You could not be registered.\n
                  That email is already registered in the system.";
    }
    elseif(!$isRegistered){
  
      $user->storeFormValues( $_POST );
      $id = $user->insert();
  
      if(!is_null( $id )){
        $user_id = $user->getId();
        $code = "GOOD";
        $message = "You have been successfully registered in the system.\n
                  Welcome to Food Ordering System."; 
      }else{
        $code = "BAD";
        $message = "You could not be registered please try again.";
      }
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }
  
  function adminSignIn() {
    $response = array();
    $user_id = "";
  
    // User has posted the login form: attempt to log the user in
    $user = new Admin;
    $num  = $user->getLogin($_POST['email'],$_POST['password']);
  
    if ( $num >= 1 ) {
      $user_id = $user->getId();
      $code = "GOOD";
      $message = "You have been successfully logged in"; 
  
    } else {
      // Login failed: display an error message to the user
      $code = "BAD";
      $message = "Your login failed.";
    }
  
    array_push($response,array("code"=>$code,"message"=>$message,"user_id"=>$user_id));
    echo json_encode($response);
  }
  
  function basicSignOut() {
    $response = array();
    
    $code = "GOOD";
    $message = "See you soon.";
  
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
  }

  function getAllFoods(){
    $code = ""; $message = "";
    $response      = array();
    $meals       = array();

    $user          = new Meal;

    $mealInfo    = $user->getList();
    $mealList    = $mealInfo['results'];
    $numberOfItems = $mealInfo['totalRows'];
  
    if($numberOfItems >= 1){
      foreach($mealList as $meal){

        array_push($meals,
        array("id"=> $meal->getid(),
              "name"=>$meal->getname(),
              "price"=>$meal->getprice(),
              "details"=>$meal->getdetails(),
              "image"=>$meal->getimage()));
      }

      $code = "GOOD";
      $message = "meal Info Available";
      array_push($response,array("code"=>$code,"message"=>$message,"foodList"=>$meals));
    }else {
      $code = "BAD";
      $message = "No meal Available";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
   
    echo json_encode($response);
  }

  function getAllFoodsByVendor(){
    $code = ""; $message = "";
    $response      = array();
    $meals       = array();

    $user          = new Meal;
    $user->storeFormValues( $_POST );

    $mealInfo    = $user->getListByVendorId();
    $mealList    = $mealInfo['results'];
    $numberOfItems = $mealInfo['totalRows'];
  
    if($numberOfItems >= 1){
      foreach($mealList as $meal){

        array_push($meals,
        array("id"=> $meal->getid(),
              "name"=>$meal->getname(),
              "price"=>$meal->getprice(),
              "details"=>$meal->getdetails(),
              "image"=>$meal->getimage()));
      }

      $code = "GOOD";
      $message = "meal Info Available";
      array_push($response,array("code"=>$code,"message"=>$message,"foodList"=>$meals));
    }else {
      $code = "BAD";
      $message = "No meal Available";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
   
    echo json_encode($response);
  }

  function getMealById() {
    $response = array();
    $meal = Meal::getById( $_POST['id']);
  
    if(!is_null($meal)){
      $code = "GOOD";
      $message = "Meal info found";

      $id = $meal->getid();
      $name = $meal->getname();
      $price =$meal->getprice();
      $details =$meal->getdetails();
      $image =$meal->getimage();
  
      array_push($response,array("code"=>$code,"message"=>$message,"id"=>$id,"name"=>$name,"price"=>$price,"details"=>$details,"image"=>$image));
  
    }
    else{
      $code = "BAD";
      $message = "meal info could not be retrived.";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
  
    echo json_encode($response);
  }

  function registerMeal(){
    $response = array();
    $meal = new Meal;
  
    $isRegistered = $meal->isMealRegistered($_POST['name']);
    
    if($isRegistered){
      $code = "BAD";
      $message = "You have already registered this meal.";
    }
    elseif(!$isRegistered){
  
      $meal->storeFormValues( $_POST );
      $name = 'meal-'.time();
      $meal->storeUploadedImage( $_POST['image'], $name );      
      $num_rows = $meal->insert();

      if($num_rows >= 1){
        $code = "GOOD";
        $message = "Your meal has been successfully registered in the system.";
      }
      else{
        $code = "BAD";
        $message = "Your meal could not be registered.";  
      }
    }
    
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
  }

  function deleteMeal(){
    $response = array();

    $meal = new Meal;
    $meal->setId($_POST['meal_id']);
    $meal->delete();
    
    $code = "GOOD";
    $message = "Delete Request Made";
    
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
  }
 
?>