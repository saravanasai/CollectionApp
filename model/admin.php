<?php
 
class Admin{
 
  private $phonenumber;
  private $conn;


  //table variable
  private $admin_tabel;


  public function __construct($db)
  {
     $this->conn=$db;
     $this->admin_tabel='admin_login';
  }
    //functions to perform tasks
   public function Check_hash($password,$hashed_string)
   {
       $new_hash_password=md5($password);
       if($new_hash_password===$hashed_string)
       {
         return true;
       }  
       else
       {
         return false;
       } 
   }
   public function check_user_exits($phonenumber)
   { 
     $this->phonenumber=$phonenumber;
      
      $sql="SELECT * FROM ".$this->admin_tabel." WHERE `PHONE_NUMBER`=:phonenumber";
      $stmt=$this->conn->prepare($sql);
      $stmt->bindParam('phonenumber',$this->phonenumber);

       try{
        $stmt->execute();
        $db_response=$stmt->fetch(PDO::FETCH_ASSOC); 
        return $db_response;

       }catch(PDOException $e)
       {
           echo $e;
       }

     

         
   }

   public function authenticate($phonenumber,$password)
   {
    $this->phonenumber=$phonenumber;
      
    $sql="SELECT * FROM ".$this->admin_tabel." WHERE `PHONE_NUMBER`=:phonenumber";
    $stmt=$this->conn->prepare($sql);
    $stmt->bindParam('phonenumber',$this->phonenumber);

      $stmt->execute();
      $db_response=$stmt->fetch(PDO::FETCH_ASSOC); 
      
        if($this->Check_hash($password,$db_response['PASSWORD']))
        {
           return true;
        }
        else
        {
          return false;
        }


   }
  
   public function get_admin_details()
   {
    
    
    $sql="SELECT * FROM ".$this->admin_tabel." WHERE `PHONE_NUMBER`=:phonenumber";
    $stmt=$this->conn->prepare($sql);
    $stmt->bindParam('phonenumber',$this->phonenumber);

      $stmt->execute();
      $db_response=$stmt->fetch(PDO::FETCH_ASSOC); 
      return $db_response;
   }
}
  


?>