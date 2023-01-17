<?php

/**
 * Class to handle Users
 */

class FoodCustomer
{
    // Properties

    /**
    * @var int The faq ID from the database
    */
    private $id = null;

    /** 
    * @var string firstname
    */
    private $firstname = null;

    /** 
    * @var string lastname
    */
    private $lastname = null;

    /** 
    * @var string email
    */
    private $email = null;

    /**
    * @var string password
    */
    private $password = null;

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
      if ( isset( $data['email'] ) ) $this->email = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['email'] );
      if ( isset( $data['first_name'] ) ) $this->firstname = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['first_name'] );
      if ( isset( $data['last_name'] ) ) $this->lastname = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['last_name'] );
      if ( isset( $data['password'] ) ) $this->password = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['password'] );
      if ( isset( $data['created'] ) ) $this->created = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['created'] );
      if ( isset( $data['modified'] ) ) $this->modified = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['modified'] );
      
    }

    public function setId($id){
      $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }

    public function setEmail($email){
      $this->email = $email;
    }

    public function getEmail(){
      return $this->email;
    }

    public function setFirstName($firstname){
      $this->firstname = $firstname;
    }

    public function getFirstName(){
      return $this->firstname;
    }

    public function setLastName($lastname){
      $this->lastname = $lastname;
    }

    public function getLastName(){
      return $this->lastname;
    }

    public function setPassword($password){
      $this->password = $password;
    }

    public function getPassword(){
      return $this->password;
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

    //make the password hash
    public function hashPassword($password){
      $password = hash("sha512",$password);
      return $password;
    }



    /**
    * Returns an User object matching the given F.A.Q ID
    *
    * @param int The User ID
    * @return User|false The User object, or false if the record was not found or there was a problem
    */

    public static function getById( $id ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM customers WHERE id = :id";
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      $conn = null;
      if ( $row ) return new FoodCustomer( $row );
    }

    public function emailIsRegistered( $email ) : bool {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM customers WHERE email = :email";
      $st = $conn->prepare( $sql );
      $st->bindValue( ":email", $email, PDO::PARAM_STR );
      $st->execute();
      $row = $st->fetch();
      $conn = null;

      if ( $row ) 
        return true;
      else
        return false;
    }

    /**
    * Returns all (or a range of) User objects in the DB
    *
    * @param int Optional The number of rows to return (default=all)
    * @return Array|false A two-element array : results => array, a list of user objects; totalRows => Total number of articles
    */

    public static function getList( $numRows=1000000 ) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM customers
              ORDER BY id DESC LIMIT :numRows";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->execute();
      $list = array();

      while ( $row = $st->fetch() ) {
        $user = new FoodCustomer( $row );
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
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM customers
              WHERE $field LIKE :fvalue
              ORDER BY id DESC LIMIT :numRows";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->bindValue( ":fvalue", "%".$fvalue."%", PDO::PARAM_STR );
      $st->execute();
      $list = array();

      while ( $row = $st->fetch() ) {
        $user = new FoodCustomer( $row );
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
      $sql = "SELECT * FROM customers
              ORDER BY id DESC LIMIT :offset, :num_records";
  
      $st = $conn->prepare( $sql );
      $st->bindValue( ":offset", $offset, PDO::PARAM_INT );
      $st->bindValue( ":num_records", $no_of_records_per_page, PDO::PARAM_INT );
      $st->execute();
      $list = array();
  
      while ( $row = $st->fetch() ) {
        $user = new FoodCustomer( $row );
        $list[] = $user;
      }
  
      $conn = null;
      return $list;
    }

    public static function searchListPager($offset, $no_of_records_per_page,$field, $fvalue) {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT * FROM customers
              WHERE $field LIKE :fvalue
              ORDER BY id DESC LIMIT :offset, :num_records";
  
      $st = $conn->prepare( $sql );
      $st->bindValue( ":offset", $offset, PDO::PARAM_INT );
      $st->bindValue( ":num_records", $no_of_records_per_page, PDO::PARAM_INT );
      $st->bindValue( ":fvalue", "%".$fvalue."%", PDO::PARAM_STR );
      $st->execute();
      $list = array();
  
      while ( $row = $st->fetch() ) {
        $user = new FoodCustomer( $row );
        $list[] = $user;
      }
  
      $conn = null;
      return $list;
    }

    public function getLogin($email,$password):int {
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM customers
              WHERE email = :email AND password = :password
              ORDER BY id";

      $st = $conn->prepare( $sql );
      $st->bindValue( ":email", $email, PDO::PARAM_STR );
      $st->bindValue( ":password", $this->hashPassword($password), PDO::PARAM_STR );
      $st->execute();

      while ( $row = $st->fetch() ) {
        $this->__construct( $row );
      }

      // Now get the total number of users that matched the criteria
      $sql = "SELECT FOUND_ROWS() AS totalRows";
      $totalRows = $conn->query( $sql )->fetch();
      $conn = null;
      return $totalRows[0] ;
    }

    /**
    * Inserts the current user object into the database, and sets its ID property.
    */

    public function insert() : int{

      // Does the user object already have an ID?
      if ( !is_null( $this->id ) ) trigger_error ( "FoodCustomer::insert(): Attempt to insert a User object that already has its ID property set (to $this->id).", E_USER_ERROR );
      // Insert the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql ="INSERT INTO customers
             SET first_name=:first_name,last_name=:last_name,email=:email,password=:password";

      $st = $conn->prepare ( $sql );
      $st->bindValue( ":first_name", $this->firstname, PDO::PARAM_STR );
      $st->bindValue( ":last_name", $this->lastname, PDO::PARAM_STR );
      $st->bindValue( ":email", $this->email, PDO::PARAM_STR );
      $st->bindValue( ":password", $this->hashPassword($this->password), PDO::PARAM_STR );
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
      if ( is_null( $this->id ) ) trigger_error ( "FoodCustomer::update(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR );
    
      // Update the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE customers SET first_name=:first_name, last_name=:last_name, email=:email, modified=:modified WHERE id = :id";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":first_name", $this->firstname, PDO::PARAM_STR );
      $st->bindValue( ":last_name", $this->lastname, PDO::PARAM_STR );
      $st->bindValue( ":email", $this->email, PDO::PARAM_STR );
      $st->bindValue( ":modified", date("Y/m/j G.i:s", time()), PDO::PARAM_STR );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $result = $st->execute();
      $conn = null;

      return $result;
    }
    

    /**
    * Updates the password in user object in the database.
    */
    public function updatePassword() {

      // Does the user object have an ID?
      //if ( is_null( $this->id ) ) trigger_error ( "User::update(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR );
    
      // Update the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE customers SET password=:password, modified=:modified WHERE email = :email";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":password", $this->hashPassword($this->password), PDO::PARAM_STR );
      $st->bindValue( ":modified", date("Y/m/j G.i:s", time()), PDO::PARAM_STR );
      $st->bindValue( ":email", $this->email, PDO::PARAM_STR );
      $st->execute();
      $result = $st->execute();
      $conn = null;

      return $result;
    }

    public function updatePasswordByID($oldPassword) {

      // Does the user object have an ID?
      if ( is_null( $this->id ) ) trigger_error ( "FoodCustomer::update(): Attempt to update a User object that does not have its ID property set.", E_USER_ERROR );
    
      // Update the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $sql = "UPDATE customers SET password=:password, modified=:modified WHERE id = :id AND password = :oldPassword";
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":password", $this->hashPassword($this->password), PDO::PARAM_STR );
      $st->bindValue( ":oldPassword", $this->hashPassword($oldPassword), PDO::PARAM_STR );
      $st->bindValue( ":modified", date("Y/m/j G.i:s", time()), PDO::PARAM_STR );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $result = $st->execute();
      $conn = null;

      return $result;
    }


    /**
    * Deletes the current user object from the database.
    */

    public function delete() {

      // Does the user object have an ID?
      if ( is_null( $this->id ) ) trigger_error ( "FoodCustomer::delete(): Attempt to delete a User object that does not have its ID property set.", E_USER_ERROR );

      // Delete the user
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM customers WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}

?>