<?php



class TimesheetHelper extends AppHelper {

   
    
    function getEmployeemarkType($arrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        $empid=array();
        foreach($arrayempid as $val)
        {
            $empid[]="'".$val."'";
        }
        $id=  implode(',', $empid);
       $info = $Personaldetails->query("SELECT count(*)AS totmarkemp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%mark%' or lower(s.vc_description) like '%sale%')  
                AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code AND s.vc_comp_code='01'
                AND p.vc_emp_id IN ($id)");
       return $info[0][0]['totmarkemp'];
       
    }
    
    function getEmployeeOtherType($arrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
         $empid=array();
        foreach($arrayempid as $val)
        {
            $empid[]="'".$val."'";
        }
        $id=  implode(',', $empid);
       $info = $Personaldetails->query("SELECT count(*)AS tototheremp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%hr%' or lower(s.vc_description) like '%account%'
                        or lower(s.vc_description) like '%quality%'or lower(s.vc_description) like '%group%'
                        or lower(s.vc_description) like '%other%'or lower(s.vc_description) like '%it support%'
                        or lower(s.vc_description) like '%management%'or lower(s.vc_description) like '%admin%'
                         or lower(s.vc_description) like '%general%') 
                        AND p.ch_work_status not in  ('T','P') AND  p.vc_dept_code=s.vc_struct_code AND s.vc_comp_code='01'
                        AND p.vc_emp_id IN ($id)");
      // pr($info);die;
       return $info[0][0]['tototheremp'];
       
    }
    
    function getEmployeeEngType($arrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
         $empid=array();
        foreach($arrayempid as $val)
        {
            $empid[]="'".$val."'";
        }
        $id=  implode(',', $empid);
       $info = $Personaldetails->query("SELECT count(*)AS totengemp FROM persdet p, mst_struct s
                    WHERE (lower(s.vc_description) like '%project%' or lower(s.vc_description) like '%product%'
                    or lower(s.vc_description) like '%production%'or lower(s.vc_description) like '%web group%'
                    or lower(s.vc_description) like '%east%'or lower(s.vc_description) like '%west%'
                    or lower(s.vc_description) like '%north%'or lower(s.vc_description) like '%south%'
                    or lower(s.vc_description) like '%overseas%')
                    AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code AND s.vc_comp_code='01'
                    AND p.vc_emp_id IN ($id)");
       return $info[0][0]['totengemp'];
       
    }
    
    function checkEmployeemarkType($newarrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        $n=array(); $sumleave=0; $sumhrs=0;
        if(count($newarrayempid)>0)
        {
            
            foreach($newarrayempid as $key=>$val)
            {
                /*$info = $Personaldetails->query("SELECT count(*)AS totmarkemp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%mark%' or lower(s.vc_description) like '%sale%')  
                AND p.ch_work_status IN('A','H') AND p.vc_dept_code=s.vc_struct_code AND s.vc_comp_code='01'
                AND p.vc_emp_id = '".$key."'");*/
				$info = $Personaldetails->query("SELECT count(*)AS totmarkemp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%mark%' or lower(s.vc_description) like '%sale%')  
                AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code  AND s.vc_comp_code='01'
                AND p.vc_emp_id = '".$key."'");
                if($info[0][0]['totmarkemp']>0)
                {
                    $tl=0; $th=0; $j=0;
                    foreach($val['leave'] as $k=>$v)
                    {
                        $tl+=$v;
                        $th+=$val['region_hrs'][$j];
                        $j++;
                    }
                    $sumleave+=$tl;
                    $sumhrs+=$th;
                }
            }
        }
        $n['lv']=$sumleave;
        $n['hr']=$sumhrs;
        
        
        
       //pr($info);die;
       return $n ;
       
    }
    
    function checkEmployeeOtherType($newarrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
        $Personaldetails = ClassRegistry::init('Personaldetails');
        $n=array(); $sumleave=0; $sumhrs=0;
        if(count($newarrayempid)>0)
        {
            
            foreach($newarrayempid as $key=>$val)
            {
                 $info = $Personaldetails->query("SELECT count(*)AS tototheremp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%hr%' or lower(s.vc_description) like '%account%'
                        or lower(s.vc_description) like '%quality%'or lower(s.vc_description) like '%group%'
                        or lower(s.vc_description) like '%other%'or lower(s.vc_description) like '%it support%'
                        or lower(s.vc_description) like '%management%'or lower(s.vc_description) like '%admin%'
                        or lower(s.vc_description) like '%general%') 
                        AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code  AND s.vc_comp_code='01'
                        AND p.vc_emp_id = '".$key."'");
                if($info[0][0]['tototheremp']>0)
                {
                    $tl=0; $th=0; $j=0;
                    foreach($val['leave'] as $k=>$v)
                    {
                        $tl+=$v;
                        $th+=$val['region_hrs'][$j];
                        $j++;
                    }
                    $sumleave+=$tl;
                    $sumhrs+=$th;
                }
            }
        }
        $n['lv']=$sumleave;
        $n['hr']=$sumhrs;
        
        
        
       //pr($info);die;
       return $n ;
       
       
    }
    
    function checkEmployeeEngType($newarrayempid=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
        $Personaldetails = ClassRegistry::init('Personaldetails');
        $n=array(); $sumleave=0; $sumhrs=0;
        if(count($newarrayempid)>0)
        {
            
            foreach($newarrayempid as $key=>$val)
            {
                 $info = $Personaldetails->query("SELECT count(*)AS totengemp FROM persdet p, mst_struct s
                    WHERE (lower(s.vc_description) like '%project%' or lower(s.vc_description) like '%product%'
                    or lower(s.vc_description) like '%production%'or lower(s.vc_description) like '%web group%'
                    or lower(s.vc_description) like '%east%'or lower(s.vc_description) like '%west%'
                    or lower(s.vc_description) like '%north%'or lower(s.vc_description) like '%south%'
                    or lower(s.vc_description) like '%overseas%')
                    AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code   AND s.vc_comp_code='01'
                    AND p.vc_emp_id = '".$key."'");
                if($info[0][0]['totengemp']>0)
                {
                    $tl=0; $th=0; $j=0;
                    foreach($val['leave'] as $k=>$v)
                    {
                        $tl+=$v;
                        $th+=$val['region_hrs'][$j];
                        $j++;
                    }
                    $sumleave+=$tl;
                    $sumhrs+=$th;
                }
            }
        }
        $n['lv']=$sumleave;
        $n['hr']=$sumhrs;
        
        
        
       //pr($info);die;
       return $n ;
         
       
      
    }
    
    
      function countEmployeeEngType($key=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
                 $info = $Personaldetails->query("SELECT count(*)AS totengemp FROM persdet p, mst_struct s
                    WHERE (lower(s.vc_description) like '%project%' or lower(s.vc_description) like '%product%'
                    or lower(s.vc_description) like '%production%'or lower(s.vc_description) like '%web group%'
                    or lower(s.vc_description) like '%east%'or lower(s.vc_description) like '%west%'
                    or lower(s.vc_description) like '%north%'or lower(s.vc_description) like '%south%'
                    or lower(s.vc_description) like '%overseas%')
                    AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code  AND s.vc_comp_code='01'
                    AND p.vc_emp_id = '".$key."'");
               
        
        
       //pr($info);die;
       return $info[0][0]['totengemp'] ;
         
       
      
    }
    
    
    function countEmployeemarkType($key=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
                $info = $Personaldetails->query("SELECT count(*)AS totmarkemp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%mark%' or lower(s.vc_description) like '%sale%')  
                AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code  AND s.vc_comp_code='01'
                AND p.vc_emp_id = '".$key."'");
                
       return $info[0][0]['totmarkemp'] ;
       
    }
    
    function countEmployeeOtherType($key=NULL)
    {
        $Personaldetails = ClassRegistry::init('Personaldetails');
        
        $Personaldetails = ClassRegistry::init('Personaldetails');
        $info = $Personaldetails->query("SELECT count(*)AS tototheremp FROM persdet p, mst_struct s
                WHERE (lower(s.vc_description) like '%hr%' or lower(s.vc_description) like '%account%'
                        or lower(s.vc_description) like '%quality%'or lower(s.vc_description) like '%group%'
                        or lower(s.vc_description) like '%other%'or lower(s.vc_description) like '%it support%'
                        or lower(s.vc_description) like '%management%'or lower(s.vc_description) like '%admin%'
                         or lower(s.vc_description) like '%general%') 
                        AND p.ch_work_status not in  ('T','P') AND p.vc_dept_code=s.vc_struct_code  AND s.vc_comp_code='01'
                        AND p.vc_emp_id = '".$key."'");
                
       return $info[0][0]['tototheremp'] ;
       
       
    }
    
}

?>