<?php
App::import('Model', 'VwLeavereport');
$VwLeavereport = new VwLeavereport;
$auth = $this->Session->read('Auth');
?>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb	module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link('Leave', $html->url('/selfservices/#leave', true)); ?> </li>
        </ul>
    </div>
</div>
<h2 class="demoheaders">Region Wise Leave Record</h2>
<div class="travel-voucher1">
    <div class="input-boxs">
       
            <table border="1" width="100%" align="center"   cellpadding="1" cellspacing="1" class="exp-voucher">
               
                <thead>
                    <tr class="head">
                        <th>Employee Name</th>
                        <th>Total Leave</th>
                        <th>EL</th>
                        <th>CL</th>
                        <th>ML</th>
                        <th>LWP</th>
                        <th>P</th>
                        <th>R</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($report)>0)
                    { 
                        foreach($report as $val)
                        {
                        ?>
                    
                         <tr class="cont1">
                             <td colspan="1"><?php echo $val[0]['VC_EMP_NAME']?> </td>
                             <td colspan="1"><?php echo $val[0]['NU_TOT_LEAVES']?>  </td>
                             <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('E',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                              <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('C',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                              <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('M',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                              <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('L',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                             <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('P',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                             <td colspan="1">
                                 <?php echo $VwLeavereport->leavetype('R',$val[0]['VC_EMP_CODE'],$conditions1);?>
                             </td>
                         </tr>
                    <?php
                        }
                       }else{?>
                        <tr class="cont1"><td colspan="8">No Record Found </td></tr>
                     <?php }
                    ?>
                    
            </tbody>
        </table>
    </div>
</div>



