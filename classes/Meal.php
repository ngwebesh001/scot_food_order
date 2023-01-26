<?php

/**
*** Class to handle Users
**/

class Meal
{
    // Properties

    /**
    *** @var int The faq ID from the database
    **/
    private $id = null;
    private $vendor_id = null;

    private $name = null;

    private $price = null;

    private $details = null;

    private $image = null;

    /**
    * @var string created
    */
    private $created = null;

    /**
    * @var string modified
    */
    private $modified = null;

    /**
    * Sets the object's properties using the values in the supplied array
    *
    * @param assoc The property values
    */

    public function __construct( $data=array() ) {
      if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
      if ( isset( $data['vendor_id'] ) ) $this->vendor_id = (int) $data['vendor_id'];
      if ( isset( $data['details'] ) ) $this->details = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['details'] );
      if ( isset( $data['name'] ) ) $this->name = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['name'] );
      if ( isset( $data['price'] ) ) $this->price = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['price'] );
      if ( isset( $data['image'] ) ) $this->image = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['image'] );
      if ( isset( $data['created'] ) ) $this->created = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['created'] );
      if ( isset( $data['modified'] ) ) $this->modified = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['modified'] );
      
    }

    public function setId($id){
      $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }

    public function setVendorId($vendor_id){
      $this->vendor_id = $vendor_id;
    }

    public function getVendorId(){
      return $this->vendor_id;
    }

    public function setdetails($details){
      $this->details = $details;
    }

    public function getdetails(){
      return $this->details;
    }

    public function setname($name){
      $this->name = $name;
    }

    public function getname(){
      return $this->name;
    }

    public function setprice($price){
      $this->price = $price;
    }

    public function getprice(){
      return $this->price;
    }

    public function setimage($image){
      $this->image = $image;
    }

    public function getimage(){
      return $this->image;
    }

    public function setCreated($created){
      $this->created = $created;
    }

    public function getCreated(){
      return $this->created;
    }

    public function setModified($modified){
      $this->modified = $modified;
    }

    public function getModified(){
      return $this->modified;
    }

    /**
    * Sets the object's properties using the edit form post values in the supplied array
    *
    * @param assoc The form post values
    */

    public function storeFormValues( $params ) {

      // Store all the parameters
      $this->__construct( $params );

    }

    
    public function storeUploadedImage( $image, $name ) {
      $ext = '.png';

      file_put_contents('images/'.$name.$ext, base64_decode($image));
      $this->image = $name.$ext;
    }

    public function isMealRegistered($name){
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM meals 
              WHERE name = :name";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":name", $name, PDO::PARAM_STR );
      $st->execute();
      $row = $st->fetch();
      $conn = null;

      if ( $row ) 
        return true;
      else
        return false;
  }

    /**
    * Returns an User object matching the given F.A.Q ID
    *
    * @param int The User ID
    * @return User|false The User object, or false if the record was not found or there was a problem
    */

    public static function getById( $id ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM meals WHERE id = :id";
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      $conn = null;
      if ( $row ) return new Meal( $row );
    }

    public static function getByVendorId( $vendor_id ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM meals WHERE vendor_id = :vendor_id";
      $st = $conn->prepare( $sql );
      $st->bindValue( ":vendor_id", $vendor_id, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      $conn = null;
      if ( $row ) return new Meal( $row );
    }

    /**
    * Returns all (or a range of) User objects in the DB
    *
    * @param int Optional The number of rows to return (default=all)
    * @return Array|false A two-element array : results => array, a list of user objects; totalRows => Total number of articles
    */

    public static function getList( $numRows=1000000 ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM meals
              ORDER BY id DESC LIMIT :numRows";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->execute();
      $list = array();

      while ( $row = $st->fetch() ) {
        $user = new Meal( $row );
        $list[] = $user;
      }

      // Now get the total number of users that matched the criteria
      $sql = "SELECT FOUND_ROWS() AS totalRows";
      $totalRows = $conn->query( $sql )->fetch();
      $conn = null;
      return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function getListByVendorId( $numRows=1000000 ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM meals WHERE vendor_id = :vendor_id
              ORDER BY id DESC LIMIT :numRows";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->bindValue( ":vendor_id", $vendor_id, PDO::PARAM_INT );
      $st->execute();
      $list = array();

      while ( $row = $st->fetch() ) {
        $user = new Meal( $row );
        $list[] = $user;
      }

      // Now get the total number of users that matched the criteria
      $sql = "SELECT FOUND_ROWS() AS totalRows";
      $totalRows = $conn->query( $sql )->fetch();
      $conn = null;
      return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function searchList( $numRows=1000000, $field, $fvalue ) {
      
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM meals
              WHERE $field LIKE :fvalue
              ORDER BY id DESC LIMIT :numRows";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->bindValue( ":fvalue", "%".$fvalue."%", PDO::PARAM_STR );
      $st->execute();
      $list = array();

      while ( $row = $st->fetch() ) {
        $user = new Meal( $row );
        $list[] = $user;
      }

      // Now get the total number of users that matched the criteria
      $sql = "SELECT FOUND_ROWS() AS totalRows";
      $totalRows = $conn->query( $sql )->fetch();
      $conn = null;
      return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function getListPager($offset, $no_of_records_per_page) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM meals
              ORDER BY id DESC LIMIT :offset, :num_records";
  
      $st = $conn->prepare( $sql );
      $st->bindValue( ":offset", $offset, PDO::PARAM_INT );
      $st->bindValue( ":num_records", $no_of_records_per_page, PDO::PARAM_INT );
      $st->execute();
      $list = array();
  
      while ( $row = $st->fetch() ) {
        $user = new Meal( $row );
        $list[] = $user;
      }
  
      $conn = null;
      return $list;
    }

    public static function searchListPager($offset, $no_of_records_per_page,$field, $fvalue) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM meals
              WHERE $field LIKE :fvalue
              ORDER BY id DESC LIMIT :offset, :num_records";
  
      $st = $conn->prepare( $sql );
      $st->bindValue( ":offset", $offset, PDO::PARAM_INT );
      $st->bindValue( ":num_records", $no_of_records_per_page, PDO::PARAM_INT );
      $st->bindValue( ":fvalue", "%".$fvalue."%", PDO::PARAM_STR );
      $st->execute();
      $list = array();
  
      while ( $row = $st->fetch() ) {
        $user = new Meal( $row );
        $list[] = $user;
      }
  
      $conn = null;
      return $list;
    }

    /**
    * Inserts the current user object into the database, and sets its ID property.
    */

    public function insert() : int{

      // Does the user object already have an ID?
      if ( !is_null( $this->id ) ) trigger_error ( "Meal::insert(): Attempt to insert a User object that already has its ID property set (to $this->id).", E_USER_ERROR );
      // Insert the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql ="INSERT INTO meals
             SET vendor_id=:vendor_id,name=:name,price=:price,details=:details,image=:image";

      $st = $conn->prepare ( $sql );
      $st->bindValue( ":vendor_id", $this->vendor_id, PDO::PARAM_INT );
      $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
      $st->bindValue( ":price", $this->price, PDO::PARAM_STR );
      $st->bindValue( ":details", $this->details, PDO::PARAM_STR );
      $st->bindValue( ":image", $this->image, PDO::PARAM_STR );
      $st->execute();
      $this->id = $conn->lastInsertId();
      $conn = null;

      return $this->id;
    }

    /**
    * Updates the user object in the database.
    */

    public function update() :bool{

      // Does the user object have an ID?
      if ( is_null( $this->id ) ) trigger_error ( "Meal::update(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR );
    
      // Update the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE meals SET vendor_id=:vendor_id, name=:name, price=:price, details=:details, modified=:modified WHERE id = :id";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":vendor_id", $this->vendor_id, PDO::PARAM_INT );
      $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
      $st->bindValue( ":price", $this->price, PDO::PARAM_STR );
      $st->bindValue( ":details", $this->details, PDO::PARAM_STR );
      $st->bindValue( ":modified", date("Y/m/j G.i:s", time()), PDO::PARAM_STR );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $result = $st->execute();
      $conn = null;

      return $result;
    }

    /**
    * Deletes the current user object from the database.
    */

    public function delete() {

      // Does the user object have an ID?
      if ( is_null( $this->id ) ) trigger_error ( "Meal::delete(): Attempt to delete a User object that does not have its ID property set.", E_USER_ERROR );

      // Delete the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM meals WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}

?>