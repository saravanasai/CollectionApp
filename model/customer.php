<?php

 include_once('../utility/utility.php');
 class Customer{

    //variables for table insertion
    public $cus_name;
    public $cus_sur_name;
    public $cus_pr_ph_no;
    public $cus_se_ph_no;
    public $cus_place_id;
    public $cus_ref_by_id;
    public $cus_pl_id;
    public $cus_sh_id;
    public $cus_com_one;
    public $cus_com_two;
    public $cus_id;


    private $conn;
    public $util;
    //tables
    private $table_name;
    private $Join_table_1_name;
    private $Join_table_2_name;
    private $Join_table_3_name;
    private $Join_table_4_name;
    private $transaction_table_name;
    private $Collection_master;

    public function __construct($db)
    {
         $this->conn=$db;
         $this->table_name='customer_master';
         $this->Join_table_1_name='place_master';
         $this->Join_table_2_name='plan_master';
         $this->Join_table_3_name='agent_master';
         $this->Join_table_4_name='admin_login';
         $this->Collection_master='collection_master';
         $this->transaction_table_name='transaction_master';
         $this->util=new Util();
    }

    //function parts

    public function validate_user_info_feild($data)
    {
            if($this->util::validate_is_empty($data->cus_name))
        {
            if($this->util::validate_is_empty($data->cus_sur_name))
            {
                if($this->util::validate_is_empty($data->cus_pm_ph_no)||true)
                {
                    if($this->util::validate_phonenumber_length($data->cus_pm_ph_no)||true)
                    {
                            if($this->util::validate_is_empty($data->cus_place_id))
                            {
                                if($this->util::validate_is_empty($data->cus_ref_by))
                                {
                                    if($this->util::validate_is_empty($data->cus_pl_id))
                                    {
                                        if($this->util::validate_is_empty($data->cus_sh_id))
                                        {
                                            $this->cus_name=$data->cus_name;
                                            $this->cus_sur_name=$data->cus_sur_name;
                                            $this->cus_pr_ph_no=$data->cus_pm_ph_no;
                                            $this->cus_se_ph_no=$data->cus_se_ph_no;
                                            $this->cus_place_id=$data->cus_place_id;
                                            $this->cus_ref_by_id=$data->cus_ref_by;
                                            $this->cus_pl_id=$data->cus_pl_id;
                                            $this->cus_sh_id=$data->cus_sh_id;
                                            $this->cus_com_one=$data->cus_com_one;
                                            return true;
                                        }
                                        else
                                        {
                                            http_response_code(200);
                                            echo json_encode(["status"=>"0","data"=>"Choose the Customer Scheme"]);
                                        }

                                    }
                                    else
                                    {
                                        http_response_code(200);
                                        echo json_encode(["status"=>"0","data"=>"Choose the Customer Plan"]);
                                    }
                                }
                                else
                                {
                                    http_response_code(200);
                                    echo json_encode(["status"=>"0","data"=>"Choose the Customer Reffered By"]);
                                }

                            }
                            else
                            {
                                http_response_code(200);
                                echo json_encode(["status"=>"0","data"=>"Choose the Customer Place"]);
                            }
                    }
                    else
                    {
                        http_response_code(200);
                        echo json_encode(["status"=>"0","data"=>"Enter a Valid Phone Number"]);
                    }
                }else
                {
                    http_response_code(200);
                    echo json_encode(["status"=>"0","data"=>"Customer Phone Number Feild is Empty"]);
                }

            }else
            {
                http_response_code(200);
                echo json_encode(["status"=>"0","data"=>"Customer Sur Name Feild is Empty"]);
            }

        }
        else
        {
            http_response_code(200);
            echo json_encode(["status"=>"0","data"=>"Customer Name Feild is Empty"]);
        }
    }
    public function validate_user_info_feild_on_update($data)
    {
            if($this->util::validate_is_empty($data->cus_name))
        {
            if($this->util::validate_is_empty($data->cus_sur_name))
            {
                if($this->util::validate_is_empty($data->cus_pm_ph_no)||true)
                {
                    if($this->util::validate_phonenumber_length($data->cus_pm_ph_no)||true)
                    {
                            if($this->util::validate_is_empty($data->cus_place_id))
                            {


                                            $this->cus_name=$data->cus_name;
                                            $this->cus_sur_name=$data->cus_sur_name;
                                            $this->cus_pr_ph_no=$data->cus_pm_ph_no;
                                            $this->cus_se_ph_no=$data->cus_se_ph_no;
                                            $this->cus_place_id=$data->cus_place_id;
                                            $this->cus_com_one=$data->cus_com_one;
                                            $this->cus_com_two=$data->cus_com_two;
                                            $this->cus_id=$data->cus_id;
                                            return true;


                            }
                            else
                            {
                                http_response_code(200);
                                echo json_encode(["status"=>"0","data"=>"Choose the Customer Place"]);
                            }
                    }
                    else
                    {
                        http_response_code(200);
                        echo json_encode(["status"=>"0","data"=>"Enter a Valid Phone Number"]);
                    }
                }else
                {
                    http_response_code(200);
                    echo json_encode(["status"=>"0","data"=>"Customer Phone Number Feild is Empty"]);
                }

            }else
            {
                http_response_code(200);
                echo json_encode(["status"=>"0","data"=>"Customer Sur Name Feild is Empty"]);
            }

        }
        else
        {
            http_response_code(200);
            echo json_encode(["status"=>"0","data"=>"Customer Name Feild is Empty"]);
        }
    }
    public function check_customer_exist()
    {
        $sql="SELECT * FROM ".$this->table_name." WHERE CUS_PM_PH_NO='".$this->cus_pr_ph_no."'";
        $stmt=$this->conn->prepare($sql);
       try{
               $stmt->execute();
               $response=$stmt->fetchall(PDO::FETCH_ASSOC);
               return (count($response)>0)?false:true;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_all_customer()
    {

        $sql="SELECT * FROM ".$this->table_name.",plan_master,place_master,agent_master WHERE `CUS_PLACE_ID`=place_master.PLACE_ID AND `CUS_REF_BY`= agent_master.AGENT_ID AND `CUS_PLAN_ID`=plan_master.PL_ID; ";
        $stmt=$this->conn->prepare($sql);


        try{
         $stmt->execute();
         $all_agents_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         return $all_agents_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_single_customer()
    {

        $sql="SELECT *
         FROM ".$this->table_name.",plan_master,place_master,agent_master,collection_master WHERE `CUS_PLACE_ID`=place_master.PLACE_ID AND `CUS_REF_BY`= agent_master.AGENT_ID AND `CUS_PLAN_ID`=plan_master.PL_ID AND `CUS_ID`=:id AND `COL_FOR_CUS_ID`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('id',$this->cus_id);

        try{
         $stmt->execute();
         $single_customer_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);

         return $single_customer_fetched;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function searchCustomer($data)
    {
        $sql = "SELECT * FROM " . $this->table_name ." WHERE `CUS_NAME` like '%" . $data . "%' OR `CUS_PM_PH_NO` like '%" . $data . "%' OR `CUS_ID` like '%".$data."%'";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute();
            $customer_fetched = $stmt->fetchall(PDO::FETCH_ASSOC);
            return $customer_fetched;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function register_customer()
    {
        $sql="INSERT INTO ".$this->table_name."(`CUS_NAME`, `CUS_SUR_NAME`, `CUS_PM_PH_NO`, `CUS_SE_PH_NO`, `CUS_PLACE_ID`, `CUS_REF_BY`, `CUS_PLAN_ID`,`CUS_COM_ONE`,`CUS_SCHEME_ID`)
        VALUES (
            '".$this->cus_name."',
            '".$this->cus_sur_name."',
            '".$this->cus_pr_ph_no."',
            '".$this->cus_se_ph_no."',
            '".$this->cus_place_id."',
            '".$this->cus_ref_by_id."',
            '".$this->cus_pl_id."',
            '".$this->cus_com_one."',
            ".$this->cus_sh_id.")";
        $stmt=$this->conn->prepare($sql);

        try{
                if($stmt->execute())
                {
                    $last_id = $this->conn->lastInsertId();

                    $sql="SELECT * FROM ".$this->Join_table_2_name." WHERE `PL_ID`=:id";
                    $stmt=$this->conn->prepare($sql);
                    $stmt->bindParam("id",$this->cus_pl_id);

                    if($stmt->execute())
                    {
                        $plan_amount_fetch=$stmt->fetchall(PDO::FETCH_ASSOC);

                        $planAmount = (number_format($plan_amount_fetch[0]['PL_AMOUNT'])) * 12;

                        $sql = "INSERT INTO `collection_master`(`COL_FOR_CUS_ID`, `CUS_TOTAL_DUE`, `COL_DUE_BALANCE`)
                        VALUES (
                            '".$last_id."',
                            '".$planAmount."',
                            '".$planAmount."')";
                        $stmt=$this->conn->prepare($sql);
                        if($stmt->execute()){
                            return true;
                        }
                    }
                }
        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }
    public function check_customer_exist_by_cus_id()
    {

        $sql="SELECT * FROM ".$this->table_name." WHERE  CUS_ID='".$this->cus_id."'";

        $stmt=$this->conn->prepare($sql);
       try{
               $stmt->execute();
               $response=$stmt->fetchall(PDO::FETCH_ASSOC);
               return (count($response)>0)?true:false;

        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }
    public function update_customer()
    {
        $sql="UPDATE ".$this->table_name."
         SET
        `CUS_NAME`=:cus_name,
        `CUS_SUR_NAME`=:cus_sur_name,
        `CUS_PM_PH_NO`=:cus_ph_no,
        `CUS_SE_PH_NO`=:cus_se_ph_no,
        `CUS_PLACE_ID`=:cus_place_id,
        `CUS_COM_ONE`=:cus_com_one,
        `CUS_COM_TWO`=:cus_com_two WHERE `CUS_ID`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('cus_name',$this->cus_name);
        $stmt->bindParam('cus_sur_name',$this->cus_sur_name);
        $stmt->bindParam('cus_ph_no',$this->cus_pr_ph_no);
        $stmt->bindParam('cus_se_ph_no',$this->cus_se_ph_no);
        $stmt->bindParam('cus_place_id',$this->cus_place_id);
        $stmt->bindParam('cus_com_one',$this->cus_com_one);
        $stmt->bindParam('cus_com_two',$this->cus_com_two);
        $stmt->bindParam('id',$this->cus_id);


        try{
              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }
    public function get_single_customer_transaction()
    {
        $sql="SELECT `CUS_ID`,`CUS_NAME`,`CUS_SUR_NAME`,`CUS_PM_PH_NO`,
        `CUS_PLACE_ID`,
        `PL_AMOUNT`,`PLACE_NAME`,`TR_PAID_AMOUNT`,`TR_ON_DATE`,`TR_ON_TIME`,`USERNAME` AS TO_ADMIN
        FROM ".$this->transaction_table_name.",plan_master,place_master,admin_login,customer_master WHERE `CUS_PLACE_ID`=place_master.PLACE_ID AND `TR_DONE_TO`= admin_login.ADMIN_ID  AND `CUS_PLAN_ID`=plan_master.PL_ID AND `TR_OF_CUS`=:id  AND transaction_master.TR_OF_CUS=customer_master.CUS_ID";
       $stmt=$this->conn->prepare($sql);
       $stmt->bindParam('id',$this->cus_id);

       try{
        $stmt->execute();
        $single_customer_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);

        return $single_customer_fetched;
       }
       catch(PDOException $e)
       {
           echo $e;
       }
    }

    public function update_complement($com_1,$com_2)
    {

        $sql="UPDATE ".$this->table_name."
         SET
        `CUS_COM_ONE`=:cus_com_one,
        `CUS_COM_TWO`=:cus_com_two WHERE `CUS_ID`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('cus_com_one',$com_1);
        $stmt->bindParam('cus_com_two',$com_2);
        $stmt->bindParam('id',$this->cus_id);


        try{
              return $stmt->execute()?true:false;
        }
        catch(PDOException $e)
        {
            echo $e;
        }

    }

    public function super_complement_update()
    {

        $sql="UPDATE `customer_master` SET `CUS_COM_TWO`='1' WHERE 1";
        $stmt=$this->conn->prepare($sql);
        return $stmt->execute()?true:false;

    }

    public function super_count_by_plan()
    {
         //section to get a count of customer by plan
        $sql="SELECT `PL_ID`,`PL_AMOUNT` FROM ".$this->Join_table_2_name." ";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        $all_plans_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
        $total_plan_count=count($all_plans_fetched);
        $plan_count=[];
        for ($i=0; $i <$total_plan_count ; $i++) {

             $sql="SELECT COUNT(`CUS_PLAN_ID`) as total FROM `".$this->table_name."` WHERE `CUS_PLAN_ID`=".$all_plans_fetched[$i]['PL_ID']."";
             $stmt=$this->conn->prepare($sql);
             $stmt->execute();
             $result=$stmt->fetch(PDO::FETCH_ASSOC);
             $plan_count[$i]=$result['total'];

        }
           return $plan_count;
    }

    public function super_count_by_place()
    {
         //section to get a count of customer by place
         $sql="SELECT `PLACE_ID`,`PLACE_NAME` FROM ".$this->Join_table_1_name." ";
         $stmt=$this->conn->prepare($sql);
         $stmt->execute();
         $all_places_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         $total_place_count=count($all_places_fetched);
         $place_count=[];
         for ($i=0; $i <$total_place_count ; $i++) {

              $sql="SELECT COUNT(`CUS_PLACE_ID`) as total FROM `".$this->table_name."` WHERE `CUS_PLACE_ID`=".$all_places_fetched[$i]['PLACE_ID']."";
              $stmt=$this->conn->prepare($sql);
              $stmt->execute();
              $result=$stmt->fetch(PDO::FETCH_ASSOC);
              $place_count[$i]=$result['total'];

         }
            return $place_count;
    }



    public function super_count_by_agent()
    {
         //section to get a count of customer by agent
         $sql="SELECT `AGENT_ID`,`AGENT_NAME`,`AGENT_PH_NO` FROM ".$this->Join_table_3_name." ";
         $stmt=$this->conn->prepare($sql);
         $stmt->execute();
         $all_agent_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
         $total_agent_count=count($all_agent_fetched);
         $agent_count=[];
         for ($i=0; $i <$total_agent_count ; $i++) {

              $sql="SELECT COUNT(`CUS_REF_BY`) as total FROM `".$this->table_name."` WHERE `CUS_REF_BY`=".$all_agent_fetched[$i]['AGENT_ID']."";
              $stmt=$this->conn->prepare($sql);
              $stmt->execute();
              $result=$stmt->fetch(PDO::FETCH_ASSOC);
              $agent_count[$i]=$result['total'];

         }
            return $agent_count;
    }

    public function super_transaction($fromdate,$todate)
    {
        $sql="SELECT
        `TR_ID`,
        `TR_PAID_AMOUNT`,
        `TR_ON_DATE`,
        `PLACE_NAME`,
        `CUS_ID`,
        `CUS_NAME`,
        `CUS_PM_PH_NO`
        FROM ".$this->transaction_table_name.",plan_master,place_master,customer_master WHERE `CUS_PLACE_ID`=place_master.PLACE_ID  AND `CUS_PLAN_ID`=plan_master.PL_ID AND  place_master.PLACE_DL_STATUS!=0 AND `TR_OF_CUS`=customer_master.CUS_ID AND `TR_ON_DATE` BETWEEN :formdate AND :todate";
        //  var_dump($sql);
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam('formdate',$fromdate);
        $stmt->bindParam('todate',$todate);
       try{
        $stmt->execute();
        $single_customer_fetched=$stmt->fetchall(PDO::FETCH_ASSOC);
        return $single_customer_fetched;
       }
       catch(PDOException $e)
       {
           echo $e;
       }
    }
 }


?>
