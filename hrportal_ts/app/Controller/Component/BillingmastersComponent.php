<?php
class BillingMastersComponent{

     var $uses = array('General');
    var $components = array('Functions');


    function initialize(&$controller) {

        //load required for component models
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
            }
        }
    }



       var $s_no;
	var $designation;
	var $rate_type;
	var $rate;
	var $effective_date;

	function BillingMaster(){
		$this-> s_no=0;
		$this-> designation=0;
		$this-> rate_type=0;
		$this-> price='00.00';
		$this-> effective_date='';
	}

	function Billing(& $err_msg ,$mode , $condt=''){

           
          $con=$this->General->query("SELECT COUNT (S_NO) as SNO FROM hrpay . mst_rate WHERE $condt");
           if($con[0][0]['SNO']=='0'){
                if($mode=='Add'){
                            $ora_conn=$this->Functions->connRet();
                            $maxsno="SELECT MAX (S_NO) as Sno FROM hrpay . mst_rate";
                            $maxid= ociparse($ora_conn, $maxsno);
                            ociexecute($maxid);
                            $num_sno = ocifetchstatement($maxid, $maxsno);
                            $sno=$maxsno['SNO'][0];
                            $sno=$sno+1;
                                       
                            $this->General->query("INSERT INTO hrpay . mst_rate  (VC_DESG_CODE, CH_TYPE, NU_AMOUNT, VC_EFFECTIVE_FROM, S_NO) VALUES ('".$this ->designation."',
						'".$this ->rate_type."',
						'".$this->price."',
						'".$this->effective_date. "','".$sno."')");
                                  $msg=1;
			}else{
                            $SQL_Data=$this->BillingData();
    			    $condt="S_NO='".$this->s_no."'";
                
                            $this->General->query("UPDATE hrpay . mst_rate SET ".$SQL_Data." WHERE ".$condt."");
                            $msg=2;
			}
                        header("location: billingmaster?msg=".$msg);
			//header("location: billing-list.php?msg=".$msg);
			exit;
		}else{
                        $err_msg="Price already exist for the  period & designation you have selected";
		        return $err_msg;
                }
	}


        function BillingData(){
            
		$SQL_Data="VC_DESG_CODE='".$this->designation."',
                           CH_TYPE='".$this->rate_type."',
	                   NU_AMOUNT = '".$this ->price."',
                           VC_EFFECTIVE_FROM='".$this->effective_date."'";
		return $SQL_Data;
	}
}