<?php
set_time_limit(0); 
ini_set('memory_limit','-1');
class FunctionsComponent extends object {
    var $uses = array('General');

    function initialize(&$controller) {
        //load required for component models
     
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
                
            }
        }
    }
    function main(){
       
     switch($_REQUEST['task']){
       case 'CheckTimesheet':
		if($this->DuplicateTS($_REQUEST['start_date'] ,$_REQUEST['end_date'],$_REQUEST['empID'])==true){
                     echo "Your Timesheet already exist for the period of ".$_REQUEST['start_date']." and ".$_REQUEST['end_date']."";
		}else{
			echo '1';
		}
		
	break;
	case 'CheckCustomer':

		$errString="";
           	for($i=0;$i<$_REQUEST['tot_control'];$i++){

                   
                  	if($_REQUEST['cust_id'.$i]!=''){
				
                            
				$customer_name=str_replace('~~' ,'&' , str_replace("'" ,"''" ,$_REQUEST['cust_name'.$i]));


			 	 $SQLCustomer="SELECT count(*) customer FROM makess . mst_customer WHERE VC_CUSTOMER_NAME='".trim($customer_name)."'
				and NU_CUSTOMER_CODE='".$_REQUEST['cust_id'.$i]."'";

                   

                                $ora_conn=$this->connRet();
                                $rsDup=ociparse($ora_conn,$SQLCustomer);
				ociexecute($rsDup);
				ocifetch($rsDup);
				$dup_count = ociresult($rsDup,'CUSTOMER');
				
                                
                                if($dup_count=='0'){
					$errString .=$customer_name.' , ';

				}
			}
                  }

                 
		if($errString !=''){
			$errString=substr($errString , 0 , -3);
			echo "These are invalid customer ".$errString;
		}else{
                    
			echo '2';
		}

		die;
	break;
	case 'DateCalculate':
               $currentWeeksDay='';
		list($setWeekNumber,$startdate)= explode('-',$_REQUEST['sendDate']);
		
                for($i=1;$i<=$_REQUEST['Control_Number'];$i++){
			$currentWeeksDay .=$this->WeeklySingleCombo($startdate , $i).'||';
		}
                $startDate=date('d-m-Y',$startdate); 
		$endDate = strtotime("+6 days", $startdate);
		$endDate=date('d-m-Y',$endDate);
		echo $startDate.';;'.$endDate.';;'.$currentWeeksDay;
		die;
	break;

	case 'WeekCombo':
		$currentWeeksDay =$this->WeeklySingleCombo($_REQUEST['WeekNumber'] , $_REQUEST['Control_Number'] , $_REQUEST['previousSet'],$_REQUEST['Flag']);
		echo $currentWeeksDay;
		die;
	break;
	case 'YearWeeks':
                $con=$this->connRet();
		$arrWeek=$this->SQLYearWeek($con);
		$currentWeekStart =(date('Y')==$_REQUEST['year'])?$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY']:$arrWeek['YEAR_FIRST_WK_START_DATE_DMY'];
		$currentWeekEnd=(date('Y')==$_REQUEST['year'])?$arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY']:$arrWeek['YEAR_FIRST_WK_END_DATE_DMY'];
		$WeekDayStart =(date('Y')==$_REQUEST['year'])?$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']:$arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'];

		echo $this->YearWeeksCombo($arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'] ,$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR'] ).';;'.$currentWeekStart.';;'.$currentWeekEnd.';;'.$this->WeeklySingleCombo(strtotime($WeekDayStart) , $_REQUEST['control_number']);

		die;
	break;
	case 'SetCust':
          
                                echo $this->TSMilestone($_REQUEST['cust_id'], 'name="milestone' . ($_REQUEST['Control_Number'] - 1) . '" style="width:120px;"', "","",false);

		die;
	break;
}
    }
    function connRet() {
       $db = "
    (DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 35.154.85.224)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = ORCL)
    )
  )";
        $ora_conn = ocilogon("hrpay", "hrpay", $db);
     //ocilogon
	 //oci_pconnect
        return $ora_conn;
    }
        function connRetsqa() {
       $db = "35.154.85.224:1521/ORCL";
        $ora_conn = ocilogon("makess", "makess", $db);

        return $ora_conn;
    }
 function connRetesset() {
       $db = "35.154.85.224:1521/ORCL";
        $ora_conn = ocilogon("esset", "esset", $db);

        return $ora_conn;
    }
    function connRetqsd() {
       $db = "35.154.85.224:1521/ORCL";
        $ora_conn = ocilogon("ebiz", "ebiz", $db);

        return $ora_conn;
    }

	  function connFinance() {
       $db = "35.154.85.224:1521/ORCL";
        $ora_conn = ocilogon("finance", "finance", $db);
		 return $ora_conn;
    }

	function abc(){

		echo "asdfadsfad";

	}
    function SQLYearWeek($con) {

        @$year = ($_REQUEST['year'] != '') ? $_REQUEST['year'] : date('Y');
//$dd=$year."/01/01" +2;
//$d="TO_DATE ('".$year."/01/01', 'yyyy/mm/dd')";
//$year1=$year.'/01/01';
//$cal=date('d/m/y',strtotime($year1));
//echo $cal; die;
//echo "SELECT To_Char(To_Date('".$year1."','yyyy/mm/dd'),'D')  year_first_wk_start_rrrr"; die;
 $SQLLastWeekNo = "SELECT TO_CHAR
          (TO_DATE (  TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd')
                    - TO_CHAR (TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd'), 'D')
                    + 2,
                    'dd-mm-rrrr'
                   ),
           'rrrr-mm-dd'
          ) year_first_wk_start_rrrr,
       TO_CHAR
          (TO_DATE (  TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd')
                    - TO_CHAR (TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd'), 'D')
                    + 2,
                    'dd-mm-rrrr'
                   ),
           'dd-mm-rrrr'
          ) year_first_wk_start_dmy,
       TO_CHAR
          (  TO_DATE (  TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd')
                      - TO_CHAR (TO_DATE ('" . $year . "/01/01', 'yyyy/mm/dd'), 'D')
                      + 2,
                      'dd-mm-rrrr'
                     )
           + 6,
           'dd-mm-rrrr'
          ) year_first_wk_end_dmy,
       TO_CHAR
             (TO_DATE (SYSDATE - TO_CHAR (SYSDATE, 'D') + 2, 'dd-mm-rrrr'),
              'rrrr-mm-dd'
             ) cur_year_cur_week_start_rrrr,
       TO_CHAR (TO_DATE (SYSDATE - TO_CHAR (SYSDATE, 'D') + 2, 'dd-mm-rrrr')
                + 6,
                'dd-mm-rrrr'
               ) cur_year_cur_week_end_dmy,
       TO_CHAR
              (TO_DATE (SYSDATE - TO_CHAR (SYSDATE, 'D') + 2, 'dd-mm-rrrr'),
               'dd-mm-rrrr'
              ) cur_year_cur_week_start_dmy
  FROM DUAL";
        $rsLast = oci_parse($con, $SQLLastWeekNo);
        $kj = ociexecute($rsLast);
        $k = ocifetch($rsLast);


//$SQLLastWeekNo ="SELECT To_Char(To_Date('".$year1."', 'yyyy/mm/dd' ) - To_Char(To_Date('".$year1."', 'yyyy/mm/dd' ), 'D' ) +2, 'RRRR-MM-DD' ) g,
//                        TO_Char(TO_Date('".$year1."', 'yyyy/mm/dd')- To_Char(TO_Date ('".$year1."', 'yyyy/mm/dd'), 'D' )+ 2, 'dd-mm-rrrr') year_first_wk_start_dmy,
//                        TO_Char(TO_Date ('".$year1."', 'yyyy/mm/dd')- To_Char (To_Date ('".$year1."', 'yyyy/mm/dd'), 'D')+ 2 + 6, 'dd-mm-rrrr') year_first_wk_end_dmy,
//                        TO_Date (SYSDATE - To_CHAR(SYSDATE, 'D') + 2) cur_year_cur_week_start_rrrr,
//                        SYSDATE - TO_CHAR (SYSDATE, 'D') + 2 + 6  cur_year_cur_week_end_dmy
//                FROM DUAL";
         //$SQLLastWeekNo1=$this->General->query($SQLLastWeekNo);
        // First week start date of the selected year in Y-m-d format
        $arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'] = ociresult($rsLast, 'YEAR_FIRST_WK_START_RRRR');

        // First week start date of the selected year in d-m-y format
        $arrWeek['YEAR_FIRST_WK_START_DATE_DMY'] = ociresult($rsLast, 'YEAR_FIRST_WK_START_DMY');

        // First week  End date of the selected year in d-m-y format
        $arrWeek['YEAR_FIRST_WK_END_DATE_DMY'] = ociresult($rsLast, 'YEAR_FIRST_WK_END_DMY');

        // Current Year Current week start date in Y-m-d format
        $arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR'] = ociresult($rsLast, 'CUR_YEAR_CUR_WEEK_START_RRRR');

        //Current Year Current week start date in d-m-y format
        $arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY'] = ociresult($rsLast, 'CUR_YEAR_CUR_WEEK_START_DMY');

        //Current Year Current week end date in d-m-y format
        $arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY'] = ociresult($rsLast, 'CUR_YEAR_CUR_WEEK_END_DMY');

        return $arrWeek;
    }

    function WeeklySingleCombo($startdate , $control_number='' , $selectedVal='' , $nextSet=''){
          
        $weekday='';
        $control_number=($control_number-1);
	    if($nextSet ==1){
		list($d, $m, $y)=explode('-' ,  $selectedVal);
		$weekday=date('w' , mktime(0,0,0,$m,$d,$y));
          }
      
	$str="<select name='stDate".$control_number."' id='stDate".$control_number."'  onFocus='javascript: InvlidCustomer(\"".$control_number."\");'>";

		for($i=0;$i<7;$i++){
		 	 $currentWeekDay = ($i==0)?date("d-m-Y", $startdate):date("d-m-Y" ,strtotime("+ $i days", $startdate));
			
                         $selected =($weekday !='' && $i==$weekday)?'SELECTED':(($selectedVal == $currentWeekDay)?'SELECTED':'');
			$str.="<option value='".$currentWeekDay."' ".$selected.">".$currentWeekDay."</option>";
		}

	$str.="</select>";

	return $str;
}

    function YearWeeksCombo($yearStartDate, $currentWeek) {
        $startdate = strtotime($yearStartDate);
        $all_weeks = array();
        for ($week = 0; $week <= 52; $week++) {
            $week_data = array();
            $week_data['start'] = strtotime("+$week weeks", $startdate);
            $week_data['end'] = strtotime("+6 days", $week_data['start']);
            $all_weeks[$week + 1] = $week_data;
        }

        $str= "<select class='textBox' name='sDate'  id='sDate' onChange=\"SetDate('task=DateCalculate&sendDate='+ this.value+'&Control_Number='+document.lveForm.tot_ctrl.value+'&year='+document.lveForm.ts_year.value)\">\n";
         //  $str = "<select class='textBox' name='sDate' id='sDate' onChange=\"SetDate('task=DateCalculate&sendDate=' + this.value +'&Control_Number='+document.lveForm.tot_ctrl.value+'&year='+document.lveForm.ts_year.value)\">";
        foreach ($all_weeks as $week => $week_data) {
            $thisWeek = date("Y-m-d", $week_data['start']);
            if ($thisWeek <= $currentWeek) {
                $Selected = ( $currentWeek == $thisWeek) ? 'SELECTED' : '';
                $str.="<option value='" . $week . '-' . $week_data['start'] . "' " . $Selected . ">" . date("d-m-Y", $week_data['start']) . "</option>";
            }
        }
        $str.="</select>";

        return $str;
    }

    function YearSelectList() {
?>

<select name="ts_year" id="ts_year" onchange="SetYearDate('year='+this.value+'&task=YearWeeks&control_number='+document.lveForm.tot_ctrl.value);">
<?php
        for ($i = 2008; $i <= date('Y'); $i++) {
            $selected = ($_REQUEST['ts_year'] == $i) ? 'SELECTED' : ($i == date('Y') ? 'SELECTED' : '');
            echo "<option value='" . $i . "' $selected>" . $i . "</option>";
        }
?>
</select>
    <?php
    }

        function TSMilestone($cust_id, $attrib = '', $selected_val = '', $select = true) {


              //global connRet;
        $SQL = "SELECT D . VC_DSNO, D . VC_ACTIVITY FROM hrpay . dt_costing_sheet D, hrpay . hd_costing_sheet H
               WHERE H . VC_SNO =D . VC_SNO AND H . NU_CUST_CODE='" . $cust_id . "' AND VC_MILESTONE_STATUS =1  ORDER BY to_number(vc_order)";
        $con = $this->connRet();
        $select_proj = oci_parse($con, $SQL);
        $proj = ociexecute($select_proj);
        $Num = ocifetchstatement($select_proj, $rw);
                if($select)
                        $str = "<select " . $attrib . " data-md-selectize = 'data-md-selectize'>";
                else
                        $str = "";
        if ($Num > 0) {
            for ($i = 0; $i < $Num; $i++) {
                $selected = ($selected_val == $rw['VC_DSNO'][$i]) ? 'SELECTED' : '';
                $str .="<option value='" . $rw['VC_DSNO'][$i] . "' " . $selected . ">" . $rw['VC_ACTIVITY'][$i] . "</option>";
            }
        } else {
            $str .="<option value='0'>None</option>";
        }
                if($select)
                        $str .= "</select>";
        return $str;
    }

    function DuplicateTS($start_date ,$end_date,$emp_id){
            $db=$this->connRet();
            $SQLDuplicate="SELECT COUNT(*) ts FROM mst_timesheet WHERE vc_emp_id='".$emp_id."'
            AND dt_start_date= To_Date('".$start_date."','DD-MM-YYYY')
            AND dt_end_date=To_date('".$end_date."','dd-mm-yyyy')";
            $rsDup=ociparse($db,$SQLDuplicate);
            ociexecute($rsDup);
            ocifetch($rsDup);
            $dup_count = ociresult($rsDup,'TS');
            if($dup_count >0){
                    return true;
            }else{
                    return false;
            }
    }
    function ConvertTime($time , $ReverseTime=false){
     $totSec='';
	if( $ReverseTime==false){
		$sp=explode(':' , $time);
             if(!empty($sp[0]) && !empty($sp[1])) {
	        $totSec=($sp[0]*3600)+($sp[1]*60);
             }
		return $totSec;
	}else{
		$TotHr=floor($time/3600);
		$TotHr =($TotHr < 10)?'0'.$TotHr:$TotHr;
		$TotMin=(($time%3600)/60);
		$TotMin =($TotMin < 10)?'0'.$TotMin:$TotMin;
		return ($TotHr.':'.$TotMin);
	}
    }



    //---------------------use for costing

     /*This function query at database */
       function db_query($query_str=""){
           $this->sql=$query_str;
           $this->rec_position=0;
           $connection=$this->connRet(); 
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

                    $connectinon=$this->connRet();
                    
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
//   function pagenate($sql,$page,$size){
//    $sql = "SELECT * FROM $sql WHERE ROWNUM BETWEEN {$page*$size} AND {($page*$size)+$size}";
//    return $sql;
//   }

     function SQLWeekNo($ora_conn){

	 if(!empty($_REQUEST['year'])) {
             $year=$_REQUEST['year'];}else{ $year=date('Y');
             }
	$date = mktime(1, 1, 1, $_REQUEST['month'], date("d"), $year);
	
	

	$first_day_of_month = strtotime("-" . (date("d", $date)-1) . " days", $date);
	
	
	$last_day_of_month =  strtotime("+" . (date("t", $first_day_of_month)-1) . " days", $first_day_of_month);

	 $first_day_of_month= date('d-m-Y' ,  $first_day_of_month);

	$last_day_of_month= date('d-m-Y' ,  $last_day_of_month);

	$SQLFirstWeekNo ="SELECT ROUND(TO_NUMBER(TO_CHAR(to_date('".$first_day_of_month."','dd-mm-rrrr'),'ww'))) as first_week_no FROM DUAL";
	$rsFirst=ociparse($ora_conn,$SQLFirstWeekNo);
	ociexecute($rsFirst);
	ocifetch($rsFirst);
	 $arrWeekNo['first_week_no'] = ociresult($rsFirst,'FIRST_WEEK_NO');

	$SQLLastWeekNo ="SELECT ROUND(TO_NUMBER(TO_CHAR(to_date('".$last_day_of_month."','dd-mm-rrrr'),'ww'))) as last_week_no FROM DUAL";
	$rsLast=ociparse($ora_conn,$SQLLastWeekNo);
	ociexecute($rsLast);
	ocifetch($rsLast);
	 $arrWeekNo['last_week_no'] = ociresult($rsLast,'LAST_WEEK_NO');
	return  $arrWeekNo;
}


function WeekNo($attrib='' , $first_week_no , $last_week_no , $selected=''){
	$ysd =strtotime($_REQUEST['YSD']);
	$str ="<select ".$attrib."><option value=''>Weekend</option>";
			for($i=$first_week_no-1,$k=0;$i<$last_week_no;$i++,$k++){
				$start = strtotime("+$i weeks", $ysd);
				$end = strtotime("+6 days", $start);
				$WeekEnd = date('d-m-Y', $end);
				$Selected=($i ==$selected-1)?'SELECTED':'';
				$str .='<option value="'.($i+1).'" '.$Selected.'> '.$WeekEnd.'</option>';
			}
	return $str .=	"</select>";
}

function StatusYearWeeksCombo($yearStartDate , $currentWeek='' , $attrib=''){
		
      	 //echo $yearStartDate; 
		 $startdate = strtotime($yearStartDate);
	$all_weeks = array();
	for ($week = 0; $week <= 52; $week++){
	  $week_data = array();

	  $week_data['start'] = strtotime("+$week weeks", $startdate);
	  $week_data['end'] = strtotime("+6 days", $week_data['start']);
	  $all_weeks[$week + 1] = $week_data;
	}

	$str="<select ".$attrib.">";
        $thisWeek='';
	foreach ($all_weeks as $week => $week_data){
                      // $thisWeek =date("Y-m-d",$week_data['end']);
			if($thisWeek<=$currentWeek){
			$Selected=( $week== $currentWeek)?'SELECTED':'';
			$str.="<option value='".$week."' ".$Selected.">". date("d-m-Y", $week_data['start'])."</option>";
		}
	}
	$str.="</select>";

	return $str;
      }
	  function StatusYearWeeksCombo1($yearStartDate , $currentWeek='' , $attrib=''){
		
      	 //echo $yearStartDate; 
		 $startdate = strtotime($yearStartDate);
	$all_weeks = array();
	for ($week = 0; $week <= 52; $week++){
	  $week_data = array();

	  $week_data['start'] = strtotime("+$week weeks", $startdate);
	  $week_data['end'] = strtotime("+6 days", $week_data['start']);
	  $all_weeks[$week + 1] = $week_data;
	}

	$str="<select ".$attrib.">";
        $thisWeek='';
	foreach ($all_weeks as $week => $week_data){
                      // $thisWeek =date("Y-m-d",$week_data['end']);
			if($thisWeek<=$currentWeek){
			$Selected=( $week== $currentWeek)?'SELECTED':'';
			$str.="<option value='".$week."' ".$Selected.">". date("d-m-Y", $week_data['end'])."</option>";
		}
	}
	$str.="</select>";

	return $str;
      }

//function for SQA assign
	function create_month()
	{
		$val="<select name='month' class='combo-box'>";
		$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 'December');
			$i=1;
		 $current_month=date('n');

		foreach ($months as $value)
		{
			$style="";
			if($i==$current_month)
			{
			$val.='<option value="'.$i.'" "'.$style.'">'.$value.'</option>\n';
			}
			$i++;
		}
		$val.='</select><br />';
		return $val;
	}

	function create_Year()
	{
		$currentYear=date('Y');
		$NextYear=date('Y')+5;
		$years = range ($currentYear, $NextYear);
		$val="<select name='year' class='combo-box'>";

		foreach ($years as $value)
		{
			if(date('Y')==$value)
			{
			$val.='<option value="'.$value.'">'.$value.'</option>';
			}

		}
			$val.='</select>';
		return $val;
	}

	function Insert_SQA($data,$con)
	{
             
           if(count($data['chk'])>1){
                $cnt=count($data);
                $arr=array();
                $arr=$data;
                        for($n=0;$n<$cnt;$n++){
                              $imp=implode(',',$data['chk']);
                          }
                              $data['chk']=$imp;
                              $companyid=explode(",",$data['chk']);
                                $cnt=count($companyid);
				for($i=0;$i<$cnt;$i++)
				{
  
					 $New_companyid= explode("~",$companyid[$i]);
					 $customer_name=$this->SingleValue_ess('mst_customer','VC_CUSTOMER_NAME',"NU_CUSTOMER_CODE='".$New_companyid[1]."' AND VC_COMP_CODE='".$New_companyid[0]."'");
					 $sqa_name=$this->SingleValue_hrpay('persdet','VC_EMP_NAME',"VC_EMP_CODE='".$data['empid']."'");
                      $insertid=$this->count_Rows('mst_sqa_assign')	;
					  $sql_check="SELECT id FROM makess.mst_sqa_assign WHERE sqa_id=".addslashes($data['empid'])." AND VC_COMP_CODE='".$New_companyid[0]."' AND project_id=".$New_companyid[1];
					$statement_check = ociparse($this->connRetsqa(), $sql_check);
					ociexecute($statement_check, OCI_DEFAULT);
					$nrows_check = ocifetch($statement_check, $rows_check);

					 
                               
                                         $sql_insert="INSERT INTO makess.mst_sqa_assign (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status,vc_comp_code)VALUES ('".$insertid."' , '".addslashes($data['empid'])."', '".addslashes($sqa_name)."', '".$New_companyid[1]."', '".addslashes($customer_name)."', '".$data[month]."', '".$data[year]."','A','".$New_companyid[0]."')";
                                       
                                         $statement = ociparse($this->connRetsqa(), $sql_insert);
					 ociexecute($statement, OCI_DEFAULT);
					 ocicommit($this->connRetsqa);
					 #######################
					 #INSERTION FOR HISTORY BACKUP
             				$sql_history="INSERT INTO  makess.mst_sqa_history (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status,vc_comp_code)VALUES ('".$insertid."' , '".addslashes($data['empid'])."', '".addslashes($sqa_name)."', '".$New_companyid[1]."', '".addslashes($customer_name)."', '".$data[month]."', '".$data[year]."','A','".$New_companyid[0]."')";
                                         $statement_history = ociparse($this->connRetsqa(), $sql_history);
					 ociexecute($statement_history, OCI_DEFAULT);
					 ocicommit($this->connRetsqa());
					 #######################

					 

                                }
                                
			
                                
                        }else {
							$New_companyid= explode("~",$data['chk'][0]);
					  $customer_name=$this->SingleValue_ess('mst_customer','VC_CUSTOMER_NAME',"NU_CUSTOMER_CODE='".$New_companyid[1]."' AND VC_COMP_CODE='".$New_companyid[0]."'");
			 $insertid=$this->count_Rows('mst_sqa_assign')	;
			 $sqa_name=$this->SingleValue_hrpay('persdet','VC_EMP_NAME',"VC_EMP_CODE='".$data['empid']."'");
						 $sql_check="SELECT id FROM makess.mst_sqa_assign WHERE sqa_id=".addslashes($data['empid'])." AND VC_COMP_CODE='".$New_companyid[0]."' AND project_id=".$New_companyid[1];

                                         $statement_check = ociparse($this->connRetsqa(), $sql_check);
					 ociexecute($statement_check, OCI_DEFAULT);
					 $nrows_check = ocifetch($statement_check, $rows_check);
                               
                     

                         $sql_insert="INSERT INTO makess.mst_sqa_assign (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status,vc_comp_code)VALUES ('".$insertid."' , '".addslashes($data['empid'])."', '".addslashes($sqa_name)."', '".$New_companyid[1]."', '".addslashes($customer_name)."', '".$data[month]."', '".$data[year]."','A','".$New_companyid[0]."')";
						 

			        $statement = ociparse($this->connRetsqa(), $sql_insert);
					 ociexecute($statement, OCI_DEFAULT);
					 ocicommit($this->connRetsqa);
			 #######################
			 #INSERTION FOR HISTORY BACKUP

			  $sql_history="INSERT INTO  makess.mst_sqa_history (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status)VALUES ('".$insertid."' , '".addslashes($data['empid'])."', '".addslashes($sqa_name)."', '".$companyid[$i]."', '".addslashes($customer_name)."', '".$data[month]."', '".$data[year]."','A')";
                                     
			         $statement_history = ociparse($this->connRetsqa(), $sql_history);
					 ociexecute($statement_history, OCI_DEFAULT);
					 ocicommit($this->connRetsqa());
                                
                                

                            
                        }

		return $msg="Sucessfully Assigned!!";

	}

	function SQA_employee($id="")
	{

		$query ="SELECT
			 VC_COMP_CODE, VC_EMP_CODE ,VC_EMP_NAME
		  FROM
			hrpay.persdet
		WHERE
			VC_COMP_CODE = '01' and ch_work_status in ('A','H') ORDER BY VC_EMP_NAME";
		
                $statement = ociparse($this->connRet(), $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);
             	$val="<select name='sqa_emp' class='combo-box'>";
		if ($nrows > 0)
		{
			for($i=0; $i <$nrows; $i++)
			{
				$style="";
				if($id==$rows['VC_EMP_CODE'][$i])
				{
					$style="selected='selected'";
				}
				$val.='<option value="'.$rows['VC_EMP_CODE'][$i].'" '.$style.' >'.$rows['VC_EMP_NAME'][$i].'</option>';
			}
		}
		$val.="</select>";
		return $val;
	}

	function project_name()
	{
		
		$query ="SELECT NU_CUSTOMER_CODE,VC_CUSTOMER_NAME,vc_email FROM mst_customer";

		$statement = ociparse($CONFIG1->ora_conn1, $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);

		$val.='<script language="javascript" src="js/sqa.js" type="text/javascript"></script><input type="hidden" value="'. $nrows .'" name="NRW" id="NRW" /><table width="92%" border="0" align="center" cellpadding="0" cellspacing="0"><tr bgcolor="#CCCCCC"><td width="15%"  align="center"> <input type="checkbox" value="" name="checkall" id="checkall" onclick="CheckAll()" /></td><td width="25%" ><strong>CustomerID</strong></td><td width="55%"  ><strong>Customer Name</strong></td></tr>';

		if ($nrows > 0)
		{
		for($i=0; $i <10; $i++)
		{
			if((($i)%2)=="0")
			{
			$bgcolor='#F7EAD7';
			}
			else
			{
			$bgcolor='#FFDC9D';
			}

			 $val.='<tr bgcolor="'. $bgcolor.'"><td bgcolor="'.$bgcolor.'" align="center"> <input type="checkbox" value="'.$rows['NU_CUSTOMER_CODE'][$i].'" name="Chk'.$i.'" id="Chk'.$i.'"  /></td><td  bgcolor="'. $bgcolor.'"  >'.$rows['NU_CUSTOMER_CODE'][$i].'</td><td  bgcolor="'.$bgcolor.'"  align="left">'.$rows['VC_CUSTOMER_NAME'][$i].'</td></tr>';

		}

	}
		$val.='<tr><td><input name="button" type="button" onclick="Send_closeWin()" value="    OK     " id="button"/><input name="button6" type="button" onclick="window.close()" value="Cancel" id="button"/></td></tr></table>';
		return $val;
	}


	function SingleValue_ess($table_name,$field_name,$where)
	{
		$ora_conn1=$this->connRet();
		$query="SELECT ".$field_name." FROM makess.".$table_name." WHERE ". $where;

		$statement = ociparse($ora_conn1, $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);
		$customer_name=$rows[$field_name][0];
             	return  $customer_name;

	}

	function SingleValue_hrpay($table_name,$field_name,$where)
	{
  		$ora_conn=$this->connRet();
		$query="SELECT ".$field_name." FROM hrpay.".$table_name." WHERE ". $where;
                $statement = ociparse($ora_conn, $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);
		$customer_name=$rows['VC_EMP_NAME'][0];
		return  $customer_name;
	}
	function count_Rows($table_name)
	{
                $ora_conn=$this->connRetsqa();
		$query="SELECT id FROM ".$table_name." ORDER BY id DESC";
         	$statement = ociparse($ora_conn, $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);
		return $rows['ID'][0]+1;


	}

	function pagination($table_name,$targetpage,$limit,$orderby,$type,$where)
        {


        $tbl_name=$table_name;        //your table name

        // How many adjacent pages should be shown on each side?

        $adjacents = 3;



        /*

           First get total number of rows in data table.

           If you have a WHERE clause in your query, make sure you mirror it here.

        */

        if($where!="")

        {

            $where="WHERE ".$where;

        }

          $query = "SELECT COUNT(*) as num FROM $tbl_name $where";





        //$total_pages = mysql_fetch_array(mysql_query($query));

		$statement = ociparse($this->connRetsqa(), $query);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);


        $total_pages = $rows['NUM'][0];




        /* Setup vars for query. */

        $targetpage = $targetpage;     //your file name  (the name of this file)

        $limit = $limit;                                 //how many items to show per page

        $page = 1; //$_GET['page'];

        if($page)

            $start = ($page - 1) * $limit;             //first item to display on this page

        else

            $start = 0;                                //if no page var is given, set start to 0



        /* Get data. */





      //  echo $sql = "SELECT * FROM $tbl_name $where ORDER BY $orderby $type LIMIT $start, $limit ";
	 //	   $sql = "SELECT sqa_id FROM $tbl_name ".$where." group by sqa_id ";



		$sql = "SELECT sqa_id,SQA_NAME FROM $tbl_name ".$where." group by sqa_id,SQA_NAME order by SQA_NAME ";


		 // $result = mysql_query($sql);

        $statement = ociparse($this->connRetsqa(), $sql);
		ociexecute($statement, OCI_DEFAULT);
		$nrows = ocifetchstatement($statement, $rows);


        /* Setup page vars for display. */

        if ($page == 0) $page = 1;                    //if no page var is given, default to 1.

        $prev = $page - 1;                            //previous page is page - 1

        $next = $page + 1;                            //next page is page + 1

        $lastpage = ceil($total_pages/$limit);        //lastpage is = total pages / items per page, rounded up.

        $lpm1 = $lastpage - 1;                        //last page minus 1



        /*

            Now we apply our rules and draw the pagination object.

            We're actually saving the code to a variable in case we want to draw it more than once.

        */

        $pagination = "";

        if($lastpage > 1)

        {

            $pagination .= "<div class=\"pagination\">";

            //previous button

            if ($page > 1)

                $pagination.= "<a href=\"$targetpage?page=$prev\"> Previous </a>";

            else

                $pagination.= "<span class=\"disabled\"> Previous </span>";



            //pages

            if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up

            {

                for ($counter = 1; $counter <= $lastpage; $counter++)

                {

                    if ($counter == $page)

                        $pagination.= "<span class=\"current\">$counter</span>";

                    else

                        $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";

                }

            }

            elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some

            {

                //close to beginning; only hide later pages

                if($page < 1 + ($adjacents * 2))

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $pagination.= "<span class=\"current\">$counter</span>";

                        else

                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";

                    }

                    $pagination.= "...";

                    $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";

                    $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";

                }

                //in middle; hide some front and some back

                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $pagination.= "<a href=\"$targetpage?page=1\">1</a>";

                    $pagination.= "<a href=\"$targetpage?page=2\">2</a>";

                    $pagination.= "...";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $pagination.= "<span class=\"current\">$counter</span>";

                        else

                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";

                    }

                    $pagination.= "...";

                    $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";

                    $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";

                }

                //close to end; only hide early pages

                else

                {

                    $pagination.= "<a href=\"$targetpage?page=1\">1</a>";

                    $pagination.= "<a href=\"$targetpage?page=2\">2</a>";

                    $pagination.= "...";

                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

                    {

                        if ($counter == $page)

                            $pagination.= "<span class=\"current\">$counter</span>";

                        else

                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";

                    }

                }

            }



            //next button

            if ($page < $counter - 1)

                $pagination.= "<a href=\"$targetpage?page=$next\"> Next </a>";

            else

                $pagination.= "<span class=\"disabled\"> Next </span>";

            $pagination.= "</div>\n";

        }

        $pagestart=$start+1;

        $pageend=$start+$limit;

    return $pagination=array('paging'=>$pagination,'result'=>$rows,'total_pages'=>$total_pages,'start'=>$pagestart,'limit'=>$pageend,'nrows'=>$nrows);

    }

	function Sqa_detail($where)
	{
		$sql = "SELECT * FROM mst_sqa_assign WHERE ".$where;
		$statement = ociparse($this->connRetsqa(), $sql);
		
		ociexecute($statement, OCI_DEFAULT);
		
		return $statement;

	}

	function YearName($monthid)
	{
		$year = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");

		return $year[$monthid];
	}

	function editSQA($data)
	{
		global $CONFIG1;

	}
	function deleteSQA($data)
	{
            
		
		$sql_del="DELETE FROM mst_sqa_assign WHERE SQA_ID='".$data['sqaid']."' AND PROJECT_ID='".$data['pid']."' AND VC_COMP_CODE = '".$data['compcode']."'";

		$statement = ociparse($this->connRetsqa(), $sql_del);
		ociexecute($statement, OCI_DEFAULT);
		ocicommit($this->connRetsqa());

		$sql_historyupdate="UPDATE mst_sqa_history SET status='D' WHERE SQA_ID='".$data['sqaid']."' AND PROJECT_ID='".$data['pid']."'";
		$statement1 = ociparse($this->connRetsqa(), $sql_historyupdate);
		ociexecute($statement1, OCI_DEFAULT);
		ocicommit($this->connRetsqa());

		//return $msg=$data['sqaid'];
            return $msg="Deleted Successfully!!";
	}
	function deleteSQA_All($sqaid)
	{
		$sql_del="DELETE FROM makess.mst_sqa_assign";
		$statement = ociparse($this->connRetsqa(), $sql_del);
		ociexecute($statement, OCI_DEFAULT);
		ocicommit($this->connRetsqa());
		//return $msg=$sqaid;
	    return $msg="Deleted Successfully!!";
	}
	function UpdateSQA_Assignment($data)
	{
		
        
              	$ora_conn=$this->connRetsqa();
		$statement=$this->Sqa_detail("SQA_ID='".$data['sqaid']."' AND PROJECT_ID='".$data['pid']."' AND VC_COMP_CODE='".$data['compcode']."'");
		$nrows = ocifetchstatement($statement, $rows);
                
		if($nrows>0)
		{
	
			$sql_del="DELETE FROM makess.mst_sqa_assign WHERE SQA_ID='".$data[sqaid]."' AND PROJECT_ID='".$data['pid']."' AND  VC_COMP_CODE='".$data['compcode']."'";
		         $statement = ociparse($ora_conn, $sql_del);
			ociexecute($statement, OCI_DEFAULT);
			ocicommit($ora_conn);

			$sql_del="DELETE FROM makess.mst_sqa_history WHERE SQA_ID='".$data['sqaid']."' AND PROJECT_ID='".$data['pid']."' AND VC_COMP_CODE='".$data['compcode']."'";
			$statement = ociparse($ora_conn, $sql_del);
			ociexecute($statement, OCI_DEFAULT);
			ocicommit($ora_conn);
			############
			##############

        		$customer_name=$this->SingleValue_ess('mst_customer','VC_CUSTOMER_NAME',"NU_CUSTOMER_CODE='".$data['pid']."' AND VC_COMP_CODE = '".$data['compcode']."'");
			$sqa_name=$this->SingleValue_hrpay('persdet','VC_EMP_NAME',"VC_EMP_CODE='".$data['sqa_emp']."'");
			$insertid=$this->count_Rows('mst_sqa_assign');
           		$sql_insert="INSERT INTO makess.mst_sqa_assign (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status,vc_comp_code)VALUES ('".$insertid."' , '".addslashes($data[sqa_emp])."', '".addslashes($sqa_name)."', '".$data['pid']."', '".addslashes($customer_name)."', '".$data['month']."', '".$data['year']."','A','".$data['compcode']."')";

			$statement = ociparse($this->connRetsqa(), $sql_insert);
                         ociexecute($statement, OCI_DEFAULT);
			ocicommit($this->connRetsqa());
			################################################

			 $sql_inserthistory="INSERT INTO makess.mst_sqa_history (id ,sqa_id ,sqa_name ,project_id ,project_name ,month ,year,status,vc_comp_code)VALUES ('".$insertid."' , '".addslashes($data[sqa_emp])."', '".addslashes($sqa_name)."', '".$data[pid]."', '".addslashes($customer_name)."', '".$data[month]."', '".$data[year]."','A','".$data['compcode']."')";
			 $statement1 = ociparse($this->connRetsqa(), $sql_inserthistory);
                        ociexecute($statement1, OCI_DEFAULT);
			ocicommit($this->connRetsqa());


			return $msg="SQA assignment Updated!!";

		}
	}

	function fetchSQAReport($sqaid)
	{

		global $CONFIG1;


		 $sql_report = "SELECT * FROM mst_sqa_history WHERE sqa_id=".$sqaid." AND status!='D' order by year";


		$statement = ociparse($this->connRetsqa(), $sql_report);
		ociexecute($statement, OCI_DEFAULT);

		return $statement;
	}

	function fetchProjectReport($pid)
	{
                $sql_report = "SELECT * FROM mst_sqa_history WHERE project_id=".$pid." order by year";
		
                $statement = ociparse($this->connRetsqa(), $sql_report);
		ociexecute($statement, OCI_DEFAULT);

		return $statement;
	}

//		function mailsend($to)
//		{
//			$to      = $to;
//			$subject = 'the subject';
//			$message = 'hello';
//			$headers = 'From: webmaster@example.com' . "\r\n" .
//				'Reply-To: webmaster@example.com' . "\r\n" .
//				'X-Mailer: PHP/' . phpversion();
//
//			mail($to, $subject, $message, $headers);
//		}

function revDateFormat($date)
{
         $monText='';
         $dateArr='';

	$dateArr = explode("-",$date);
        
	switch (strtoupper($dateArr[1])) 
	{
		case 'JAN':
			$monText="01";	break;
		case 'FEB':
			$monText="02";		break;
		case 'MAR':
			$monText="03";		break;
		case 'APR':
			$monText="04";		break;
		case 'MAY':
			$monText="05";		break;
		case 'JUN':
			$monText="06";		break;
		case 'JUL':
			$monText="07";		break;
		case 'AUG':
			$monText="08";		break;
		case 'SEP':
			$monText="09";		break;
		case 'OCT':
			$monText="10";		break;
		case 'NOV':
			$monText="11";		break;
		case 'DEC':
			$monText="12";		break;
	
	}
	$year = "20".$dateArr[2];
	$revDateFormat=$dateArr[0]."-".$monText."-".$year;
	
	return $revDateFormat;
	}
       function db_commit(){
	ocicommit($this->commit);
    }

    
}