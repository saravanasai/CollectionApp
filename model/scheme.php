<?php


class scheme{

    private $conn;
    //table feilds
    public $scheme_name;
    public $scheme_start_date;
    public $scheme_end_date;
    public $scheme_active_status;
    public $scheme_dl_status;

    //tables
    private $table_name;
    public function __construct($db)
    {
         $this->conn=$db;
         $this->table_name='scheme_master';
    }

    public function register_scheme()
    {

        $sql="INSERT INTO ".$this->table_name."(`SCHEME_NAME`,`SCHEME_START_DATE`,`SCHEME_END_DATE`) VALUES (:schemen_name,:fromdate,:todate)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('schemen_name',$this->scheme_name);
        $stmt->bindParam('fromdate',$this->scheme_start_date);
        $stmt->bindParam('todate',$this->scheme_end_date);

        try{

              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }

    public function get_all_scheme()
    {
        $sql="SELECT * FROM ".$this->table_name." WHERE 1";
        $stmt=$this->conn->prepare($sql);
        try{
         $stmt->execute();
         $all_scheme_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         return $all_scheme_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }


    public function delete_scheme($id)
    {

        $sql="UPDATE ".$this->table_name." SET `SCHEME_DL_STATUS`=0 WHERE `SCHEME_ID`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('id',$id);
        try{

              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }

}


?>