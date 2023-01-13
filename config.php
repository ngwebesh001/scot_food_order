<?php
    ini_set( "display_errors", true ); //show errors - used in development environment
    //error_reporting(E_ALL & ~E_NOTICE); //hide errors - used in production environment
    date_default_timezone_set( "Africa/Mbabane" );   //Africa/Mbabane

    defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'opt'.DS.'lampp'.DS.'htdocs'.DS.'umhlaba-admin2');
    //defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'var'.DS.'www'.DS.'html');
    defined('UPLOAD_IMAGE_PATH') ? null : define('UPLOAD_IMAGE_PATH',SITE_ROOT.DS.'uploads'.DS.'images');
    defined('UPLOAD_AD_MEDIA_PATH') ? null : define('UPLOAD_AD_MEDIA_PATH',SITE_ROOT.DS.'uploads'.DS.'ad_media');
    
    define( "DB_DSN", "mysql:host=localhost;dbname=scot_food_order");
    define( "DB_USERNAME", "root" );
    define( "DB_PASSWORD", "" );
    define( "CLASS_PATH", "classes" );
    define( "TEMPLATE_PATH", "pages" );

    //required class files
    require( CLASS_PATH .DS.'Admin.php' );
    require( CLASS_PATH .DS.'FoodCustomer.php' );
    require( CLASS_PATH .DS.'FoodVendor.php' );
    require( CLASS_PATH .DS.'Meal.php' );

    function handleException( $exception ) {
      echo "Sorry, a problem occurred. Please try later.";
      echo $exception->getMessage();
      error_log( $exception->getMessage() );
    }

    set_exception_handler( 'handleException' );
?>