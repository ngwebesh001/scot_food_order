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
        array("name"=>$meal->getname(),
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
      $message = "Locations found";
      
      $name = $meal->getname();
      $price =$meal->getprice();
      $details =$meal->getdetails();
      $image =$meal->getimage();
  
      array_push($response,array("code"=>$code,"message"=>$message,"name"=>$name,"price"=>$price,"details"=>$details,"image"=>$image));
  
    }
    else{
      $code = "BAD";
      $message = "location info could not be retrived.";
      array_push($response,array("code"=>$code,"message"=>$message));
    }
  
    echo json_encode($response);
  }
 
?>