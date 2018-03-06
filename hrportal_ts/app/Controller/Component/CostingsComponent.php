 <?php
////////////////////////////////////////////////////////////////////////////////////////////////
//NAME -DIWAKAR UPADHYAY
//Define Class - Costing
class CostingsComponent extends object {

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

	var $comp_code;
	var $cust_code;
	var $s_no;
	var $arrCostDetails;

	public function __construct() {
		$this-> comp_code='01';
		$this-> cust_code='';
		$this-> arrCostDetails =array();

	}

	function connRet1() {
    $db = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST =35.154.85.224)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = ORCL)
    )
   )";
        $ora_conn = ocilogon("hrpay", "hrpay", $db);

        return $ora_conn;
    }


	function CostingEntry(& $err_msg ,$mode , $condt=''){

                $connection=$this->Functions->connRet();
				
		$SQL_Data=$this->CostData();
		
		if($mode=='Add'){
		//====================================================================
		//echo $_REQUEST['projval'];
			if($_REQUEST['projval']=='0' || $_REQUEST['mcost']=='0' || $_REQUEST['effort']=='0'){
			$msg="* Fields can not be left blank.";
			return false;
			}
		//===================================================================
				$this->s_no=$this->Functions->db_row_id('hd_costing_sheet',"VC_SNO");
				$SQL_Data['VC_SNO']=$this->s_no; 
				$this->Functions->db_perform('hrpay.hd_costing_sheet' , $SQL_Data);
				$this->CostingDetails();
				$msg=1;

		}else{
			//====================================================================
			if($_REQUEST['projval']=='0' || $_REQUEST['mcost']=='0' || $_REQUEST['effort']=='0'){
			$msg="* Fields can not be left blank.";
			return false;

			}
			//===================================================================

			$condt="VC_SNO='".$this->s_no."'";

			$this->Functions->db_perform('hrpay . hd_costing_sheet' , $SQL_Data ,'','update' , $condt);
			$this->CostingDetails($mode);
			$msg=2;
		}
		//header("location: costing-report.php?&empCode=".$_SESSION['empCode']."&msg=".$msg);
                return $msg;
		exit;
	}

	function CostData(){
		$SQL_Data=array('VC_COMP_CODE'=>$this->comp_code ,
				'NU_CUST_CODE'=>$this->cust_code ,
				'NU_PROJ_VALUE'=>$_REQUEST['projval'] ,
				'NU_INIT_COST'=>$_REQUEST['icost'],
				'NU_PROJ_DIFF'=>$_REQUEST['pval'] ,
				'NU_MAN_COST'=>$_REQUEST['mcost'] ,
				'NU_BUDG_EFF'=>$_REQUEST['effort'] ,
				'NU_TOT_ELAP_MNTH'=>$_REQUEST['elapmnth'] ,
				'NU_SIGN_OFF_PER'=>$_REQUEST['signoff'] ,
				'NU_BILL_AMT'=>$_REQUEST['bamt'] ,
				'NU_REAL_AMT'=>$_REQUEST['ramt'] ,
				'NU_DUE_AMT'=>$_REQUEST['damt'] ,
				'NU_DELAY_PERSON_DAYS'=>$_REQUEST['delayindays'] ,
				'NU_COST_ACT_DIFF'=>$_REQUEST['cstVSac'] ,
				'NU_BAL_MM'=>$_REQUEST['balMM'] ,
				'NU_BAL_WRK'=>$_REQUEST['balwrk'] ,
				'NU_DELAY_DAYS'=>$_REQUEST['ddays'] ,
				'NU_PROJ_PROF'=>$_REQUEST['pprofit'] ,
				'NU_TOT_EXP_COST'=>$_REQUEST['texpcost'] ,
				'NU_ACTPROF_PRJVAL_ACOST'=>$_REQUEST['prof1_pvVsac'] ,
				'NU_ACTPROF_PRJVAL_RALCOST'=>$_REQUEST['prof2_pvVsra'] ,
				'NU_TOT_ALL_WRK'=>$_REQUEST['totalpercentwork']  ,
				'NU_TOT_BUDG_DYS'=>$_REQUEST['totbdmandays'] ,
				'NU_TOT_BUDG_DYS_COST '=>$_REQUEST['totA'],
				'NU_GDTOT_BUDG_PER_DYS'=>$_REQUEST['gdBdmandays'] ,
				'NU_GDTOT_BUDG_DYS_COST'=> $_REQUEST['gdTotal_A'],
				'NU_GDTOT_ACT_MN_DAYS'=>$_REQUEST['gdTotal_acmandays'],
				'NU_GDTOT_ACT_COST'=>$_REQUEST['gdTotal_D'],
				'NU_GDTOT_EXP_MN_REL'=> $_REQUEST['gdTotal_expmonRel'],
				'NU_GDTOT_EXP_REL_AG_DL'=> $_REQUEST['gdTotal_AgDil'],
				'NU_GDTOT_EXP_REL'=>$_REQUEST['gdTotal_totexpReal'],
				'NU_GDTOT_ACT_REL'=>$_REQUEST['gdTotal_C'],
				'NU_GDTOT_ACREL_EXPREL '=>$_REQUEST['gdTotal_CB'],
				'NU_GDTOT_ACREL_BDGCST '=>$_REQUEST['gdTotal_CA'],
				'NU_GDTOT_BDCST_ACCST'=>$_REQUEST['gdTotal_DA'],
				'NU_GDTOT_ACREL_ACCST'=> $_REQUEST['gdTotal_CD'],
				'NU_PROJECT_ID'	=>$_REQUEST['projid'],
				'VC_PROJECT_EMAIL'	=>$_REQUEST['projemail']
		);
		return $SQL_Data;
	}

         function CostingDetails($mode=''){
         	foreach($this->arrCostDetails as $key =>$val){
		     /*=== Start here essbilling==============================*/
                        if($val['exMthRealDue']=='Y')
                        {
                            $val['dt_due_date']=date('d-m-Y');
                        }else{
                             $val['dt_due_date']='';
                        } 
                        if($val['exMthRealAgDlvDue']=='Y')
                        {
                            $val['dt_due_date1']=date('d-m-Y');
                        }else{
                             $val['dt_due_date1']='';
                        }  
                        $val['acVSexReal']='';
                /*=== End here essbilling==============================*/
                        
                /*=== Start here essbilling update and insert the field==============================*/       
            if($val['dsno']!='' && $val['dsno'] !='0'){
			 // $SQLUpdate="UPDATE hrpay . dt_costing_sheet SET VC_COMP_CODE='".$this->comp_code."' , VC_SNO='".$this->s_no."' ,DT_PL_ST_DATE= to_date('".$val['plStDate']."', 'dd-mm-rrrr') , DT_PL_ED_DATE= to_date('".$val['plEdDate']."', 'dd-mm-rrrr'), DT_AC_ST_DATE= to_date('".$val['acStDate']."', 'dd-mm-rrrr') , DT_AC_ED_DATE= to_date('".$val['acEdDate']."', 'dd-mm-rrrr') , NU_DELAY= '".$val['dlyNoDays']."' , VC_ACTIVITY= '".$val['Activity']."' , NU_PER_WRK = '".$val['workPercentage']."', CH_TSK_CMPL= '".$val['taskCompleted']."', NU_BUD_MAN= '".$val['bdManDays']."', NU_BUD_MAN_COST= '".$val['bdCostPerManDays']."',  NU_ACT_MAN= '".$val['acManDays']."', NU_ACT_COST= '".$val['acCost']."', NU_EXP_AMT_RL= '".$val['exMthReal']."', CH_DUE= '".$val['exMthRealDue']."', NU_EXP_AMT_AG_DL= '".$val['exMthRealAgDlv']."', CH_DUE1= '".$val['exMthRealAgDlvDue']."', NU_TOT_EXP_RL= '".$val['totExReal']."', NU_TOT_AC_RL= '".$val['acReal']."', NU_TOT_ACRL_EXPRL= '".$val['acVSexReal']."', NU_TOT_ACRL_BGCST= '".$val['acRealVSbdCost']."', NU_TOT_BGCST_ACCST= '".$val['bdVSacCost']."',  NU_TOT_ACRL_ACCST= '".$val['acRealVSacCost']."',DT_DUE_DATE=to_date('".$val['dt_due_date']."', 'dd-mm-rrrr'), DT_DUE_DATE1=to_date('".$val['dt_due_date1']."', 'dd-mm-rrrr'),VC_DUE_CURRENCY= '".$val['exMthRealCurrency']."',VC_DUE_CURRENCY1= '".$val['exMthRealAgDlvCurrency']."'   WHERE VC_DSNO='".$val['dsno']."' ";
			 $val['Activity'] = str_replace("'","",$val['Activity']);
			  $SQLUpdate="UPDATE hrpay . dt_costing_sheet SET VC_COMP_CODE='".$this->comp_code."' , VC_SNO='".$this->s_no."' ,DT_PL_ST_DATE= to_date('".$val['plStDate']."', 'dd-mm-rrrr') , DT_PL_ED_DATE= to_date('".$val['plEdDate']."', 'dd-mm-rrrr'), DT_AC_ST_DATE= to_date('".$val['acStDate']."', 'dd-mm-rrrr') , DT_AC_ED_DATE= to_date('".$val['acEdDate']."', 'dd-mm-rrrr') , NU_DELAY= '".$val['dlyNoDays']."' , VC_ACTIVITY= '".$val['Activity']."' , NU_PER_WRK = '".$val['workPercentage']."', CH_TSK_CMPL= '".$val['taskCompleted']."', NU_BUD_MAN= '".$val['bdManDays']."', NU_BUD_MAN_COST= '".$val['bdCostPerManDays']."',  NU_ACT_MAN= '".$val['acManDays']."', NU_ACT_COST= '".$val['acCost']."', NU_EXP_AMT_RL= '".$val['exMthReal']."', CH_DUE= '".$val['exMthRealDue']."', NU_EXP_AMT_AG_DL= '".$val['exMthRealAgDlv']."', CH_DUE1= '".$val['exMthRealAgDlvDue']."', NU_TOT_EXP_RL= '".$val['totExReal']."', NU_TOT_AC_RL= '".$val['acReal']."', NU_TOT_ACRL_EXPRL= '".$val['acVSexReal']."', NU_TOT_ACRL_BGCST= '".$val['acRealVSbdCost']."', NU_TOT_BGCST_ACCST= '".$val['bdVSacCost']."',  NU_TOT_ACRL_ACCST= '".$val['acRealVSacCost']."',DT_DUE_DATE=to_date('".$val['dt_due_date']."', 'dd-mm-rrrr'), DT_DUE_DATE1=to_date('".$val['dt_due_date1']."', 'dd-mm-rrrr'),VC_DUE_CURRENCY= '".$val['exMthRealCurrency']."',VC_DUE_CURRENCY1= '".$val['exMthRealAgDlvCurrency']."' ,  DT_REVISED_DATE= to_date('".$val['dt_revised_date']."', 'dd-mm-rrrr') ,  DT_COLLECTION_DATE= to_date('".$val['dt_collection_date']."', 'dd-mm-rrrr')  WHERE VC_DSNO='".$val['dsno']."' ";	

			
			$this->Functions->db_query($SQLUpdate);
			}else{
				$des_no=$this->Functions->db_row_id('dt_costing_sheet',"VC_DSNO");
				/*************************  nu_cont_milecode column added here **/
				//$SQLInsert = "INSERT INTO hrpay . dt_costing_sheet (VC_COMP_CODE , VC_SNO , VC_DSNO , DT_PL_ST_DATE , DT_PL_ED_DATE ,DT_AC_ST_DATE, DT_AC_ED_DATE, NU_DELAY, VC_ACTIVITY, NU_PER_WRK, CH_TSK_CMPL, NU_BUD_MAN, NU_BUD_MAN_COST,  NU_ACT_MAN, NU_ACT_COST, NU_EXP_AMT_RL, CH_DUE, NU_EXP_AMT_AG_DL, CH_DUE1, NU_TOT_EXP_RL, NU_TOT_AC_RL, NU_TOT_ACRL_EXPRL, NU_TOT_ACRL_BGCST, NU_TOT_BGCST_ACCST, NU_TOT_ACRL_ACCST, VC_ORDER,DT_DUE_DATE,DT_DUE_DATE1,VC_DUE_CURRENCY,VC_DUE_CURRENCY1,NU_CONT_MILECODE)  VALUES ( '".$this->comp_code."' ,'".$this->s_no."', '".$des_no."' , to_date('".$val['plStDate']."', 'dd-mm-rrrr') ,to_date('".$val['plEdDate']."', 'dd-mm-rrrr'), to_date('".$val['acStDate']."', 'dd-mm-rrrr') , to_date('".$val['acEdDate']."', 'dd-mm-rrrr')  , '".$val['dlyNoDays']."', '".$val['Activity']."', '".$val['workPercentage']."', '".$val['taskCompleted']."' , '".$val['bdManDays']."', '".$val['bdCostPerManDays']."', '".$val['acManDays']."', '".$val['acCost']."','".$val['exMthReal']."','".$val['exMthRealDue']."','".$val['exMthRealAgDlv']."','".$val['exMthRealAgDlvDue']."','".$val['totExReal']."','".$val['acReal']."','".$val['acVSexReal']."','".$val['acRealVSbdCost']."','".$val['bdVSacCost']."','".$val['acRealVSacCost']."' ,'".$des_no."',to_date('".$val['dt_due_date']."', 'dd-mm-rrrr'),to_date('".$val['dt_due_date1']."', 'dd-mm-rrrr'),'".$val['exMthRealCurrency']."','".$val['exMthRealAgDlvCurrency']."','".$val['nu_cont_milecode']."')" ;
				$SQLInsert = "INSERT INTO hrpay . dt_costing_sheet (VC_COMP_CODE , VC_SNO , VC_DSNO , DT_PL_ST_DATE , DT_PL_ED_DATE ,DT_AC_ST_DATE, DT_AC_ED_DATE, NU_DELAY, VC_ACTIVITY, NU_PER_WRK, CH_TSK_CMPL, NU_BUD_MAN, NU_BUD_MAN_COST,  NU_ACT_MAN, NU_ACT_COST, NU_EXP_AMT_RL, CH_DUE, NU_EXP_AMT_AG_DL, CH_DUE1, NU_TOT_EXP_RL, NU_TOT_AC_RL, NU_TOT_ACRL_EXPRL, NU_TOT_ACRL_BGCST, NU_TOT_BGCST_ACCST, NU_TOT_ACRL_ACCST, VC_ORDER,DT_DUE_DATE,DT_DUE_DATE1,VC_DUE_CURRENCY,VC_DUE_CURRENCY1,NU_CONT_MILECODE ,DT_REVISED_DATE, DT_COLLECTION_DATE)  VALUES ( '".$this->comp_code."' ,'".$this->s_no."', '".$des_no."' , to_date('".$val['plStDate']."', 'dd-mm-rrrr') ,to_date('".$val['plEdDate']."', 'dd-mm-rrrr'), to_date('".$val['acStDate']."', 'dd-mm-rrrr') , to_date('".$val['acEdDate']."', 'dd-mm-rrrr')  , '".$val['dlyNoDays']."', '".$val['Activity']."', '".$val['workPercentage']."', '".$val['taskCompleted']."' , '".$val['bdManDays']."', '".$val['bdCostPerManDays']."', '".$val['acManDays']."', '".$val['acCost']."','".$val['exMthReal']."','".$val['exMthRealDue']."','".$val['exMthRealAgDlv']."','".$val['exMthRealAgDlvDue']."','".$val['totExReal']."','".$val['acReal']."','".$val['acVSexReal']."','".$val['acRealVSbdCost']."','".$val['bdVSacCost']."','".$val['acRealVSacCost']."' ,'".$des_no."',to_date('".$val['dt_due_date']."', 'dd-mm-rrrr'),to_date('".$val['dt_due_date1']."', 'dd-mm-rrrr'),'".$val['exMthRealCurrency']."','".$val['exMthRealAgDlvCurrency']."','".$val['nu_cont_milecode']."' , to_date('".$val['plEdDate']."', 'dd-mm-rrrr'), to_date('".$val['dt_collection_date']."', 'dd-mm-rrrr'))" ;
				$this->Functions->db_query($SQLInsert);
				$_SESSION['sheet_no']=$this->s_no;
				/*=== End here essbilling update and insert the field==============================*/
			}
		}
		//ocicommit($ora_conn);

	}


	function DeleteEntry($id){
		global $connection,$ora_conn;
		$SQLDelete="DELETE FROM dt_costing_sheet WHERE VC_DSNO='".$id."'";
		$connection->db_query($SQLDelete);
		ocicommit($ora_conn);
		return "Record deleted successfully !";
	}



         function db_connect(){
			$this->host="".ORCL_HOST."";
			$this->sid="(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=".ORCL_HOST.")(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=".ORCL_SERVICE_NAME.")))";
			$this->connection = ocilogon(ORCL_USER_NAME,ORCL_PASSWORD,$this->sid) or die ($this->get_error_msg($this->connection,"Problem while connecting to ".$this->sid." server..."));//username,password,sid
		}


       /*This function query at database */
       function db_query($query_str=""){
		    $this->sql=$query_str;
            $connection=$this->connRet1();
		    $this->rec_position=0;
            $this->query = @ociparse($connection, $query_str);
		    @ociexecute($this->query)or die($this->get_error_msg($this->query ,"Query Error : ".$query_str));
       }

	   function db_check($table, $flds, $condt){
 			$query = "select " . $flds . " from " . $table . " where " . $condt;
			$this->db_query($query);
			$this->db_fetch_array();
			if($this->db_num_rows() > 0){
				return true;
			}
			return false;
	   }

       /*This function query at database which returns TRUE if SUCCESSFUL and FALSE if UNSUCCESSFUL */
       function db_query_return($query_str="",$db=""){
           if($query_str==""){
              $query_str=$this->query_stmt;
           }
           $this->query = ociparse($this->connection, $query_str);
            if($db=="Default") {
                   return ociexecute($this->query,OCI_DEFAULT);
           } else {
                   return ociexecute($this->query);
           }
       }


		function db_fetch_val(){
			$result=$this->db_fetch_array();
			return $result[0];
		}

		function db_row_id($table_name='',$field='',$increment='', $param='',$max_width='') {
			$increment=1;
			//echo $param;
			if($param!=''){
				 $sql="select lpad(to_char(nvl(max(substr(nvl($field,'".$param."'),".($max_width-1).")),0)+1),".$max_width.",'0') as AutoID from $table_name";
			}else{
				$sql="select nvl(max(to_number($field)),0) + $increment AS AutoID from $table_name";
			}

			$this->db_query($sql);
			$AutoID=$this->db_fetch_array();
			return $AutoID['AUTOID'][0];
		}

       function db_fetch_array($fetch_type=0,$db="DEFAULT"){
          
			$num=ocifetchstatement($this->query,$result);

			if(!is_array($result)){
				return false;
			}
			return $result;
	   }
	   function db_fetch_row(){
	   	 $result= ocifetch($this->query);
		 return ociresult($this->query ,1);
	   }



       function get_field_name($i){
           return OCIColumnName($this->query, $i+1);
       }


       function get_num_fields() {
           return @ocinumcols($this->query);
       }

       function get_field_type($i, $sql=""){
               return ocicolumntype($this->query, $i+1);
       }

       function get_field_size($i, $sql=""){
               return ocicolumnsize($this->query, $i+1);
       }


       function db_num_rows(){
		//  echo  $this->query;
          return ocirowcount($this->query);
       }


       function free(){
          ocifreestatement($this->query);
          ocilogoff($this->connection);
          unset($this);
       }


       function db_fetch_tr ($css="",$colname='y',$add='y',$update='y',$delete='y'){
          if($css!=""){
              $css_val="class=".$css;
          }
          if(!empty($colname)) {
              echo "<tr $css_val>";
              for ($i=0; $i< $this->get_num_fields(); $i++) {
                   echo "<td>".$this->get_field_name($i)."<td>";
              }
              //echo "<td>Update<td>Delete";
              echo "</tr>";
          }
          while($result=$this->db_fetch_array(1)){
                    echo "<tr $css_val>";
                           for ($j=0; $j<$this->get_num_fields(); $j++) {
                               $cname=$this->get_field_name($j);
                                   echo "<td>".$result[$cname]." <td>";
                           }
                    echo "</tr>";
          }

       }


       function get_error_msg($error_no,$msg=""){
          $log_msg=NULL;
          $error_msg="<b>Custom Error :</b> <pre><font color=red>\n\t".ereg_replace(",",",\n\t",$msg)."</font></pre>";
          $error_msg.="<b><i>System generated Error :</i></b>";
          $error_msg.="<font color=red><pre>";
                foreach(ocierror($error_no) as $key=>$val){
                        $log_msg.="$key :  ".$val."\n";
                        $error_msg.="$key : $val \n";
                }

                $error_msg.="</pre></font>";
                return $error_msg;
       }

		function get_error_msg_array($error_no){
			return ocierror($error_no);
		}

	   	function db_perform($table, $data, $pr = "", $action = 'insert', $parameters = ''){

			reset($data);

			if ($action == 'insert'){
				$query = 'insert into ' . $table . ' (';

				while (list($columns, ) = each($data)){
					$query .= $columns . ', ';
				}

				$query = substr($query, 0, -2) . ') values (';

				reset($data);

				while (list(, $value) = each($data)){
							$query .= '\'' . $value . '\',';
				}

				$query = substr($query, 0, -1) . ')';
			}elseif ($action == 'update'){

					$query = 'update ' . $table . ' set ';

					while (list($columns, $value) = each($data)){
						$query .= $columns . ' = \'' .$value. '\',';
					}

					 $query = substr($query, 0, -1) . ' where ' . $parameters;
			}

			return $this->db_query($query);
			$this->db_commit();
  		}

		function db_commit(){
			ocicommit($this->commit);
		}


                function DtRecords(){
	global $nRows,$rwCostDetail,$ora_conn,$connection;


}
}
