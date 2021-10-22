<?php

class transaction_list
{

    private $conn;
    private $table_name;

    public $by_admin;
    public function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "transaction_master";
    }

    public function transaction_today($cus_id)
    {
        $sql = "SELECT * FROM ".$this->table_name." JOIN admin_login ON transaction_master.TR_DONE_TO = admin_login.ADMIN_ID WHERE `TR_OF_CUS`=".$cus_id." AND  date(TR_ON_DATE) = current_date";
        $stmt = $this->conn->prepare($sql);

        try{
            $stmt->execute();
            $today_data=$stmt->fetchall(PDO::FETCH_ASSOC);
            return $today_data;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }

    public function transaction_edit($tr_id,$cus_id, $amount_edit)
    {

        $sql = "UPDATE ".$this->table_name." SET `TR_PAID_AMOUNT`='$amount_edit' WHERE TR_ID = '$tr_id' AND TR_OF_CUS = '$cus_id'";
        $stmt = $this->conn->prepare($sql);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
}