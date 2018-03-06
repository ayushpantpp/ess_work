<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
           
          </div>
          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
             
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 col-sm-12 col-xs-12">
    
<div class="x_panel">
              <div class="x_title">
                <h2>View Training Identification Request</h2>
                <ul class="nav navbar-right panel_toolbox">
                
                </ul>
                <div class="clearfix"></div>
              </div>
            

                   <div class="x_content">
                        <?php echo $this->Form->create('MstTrainingRequests', array('url' => array('controller' => 'trainingmasters', 'action' => 'view_manager_training_identification'),'onsubmit'=>'return formValidate();'));		
                        echo $this->Form->input('TrainingMaster.request_id', array('type' =>'hidden','value'=>@$nu_request_id));
                        echo $this->Form->input('remarks', array('type' =>'hidden','id'=>'new_remark'));
                        ?>
                                <?php if(@$requestData['MstTrainingRequests']['training_topic_type']=='E'){ 
				  echo "Existing";
				}else{
				  echo "New";
				
				}?>   				   
				</td>
				<td height="30"><strong>Training Required :</strong> &nbsp;&nbsp;
				<?php if(@$requestData['MstTrainingRequests']['training_topic_type']=='E'){
				  $dd_style = 'display:block;';
				  $txt_style = 'display:none;';
				  echo $traininghlp->getCouseName($requestData['MstTrainingRequests']['training_topic_id']);
				}else {
				  $dd_style = 'display:none;';
				  $txt_style = 'display:block;';
				  echo @$requestData['MstTrainingRequests']['training_name'];
				}?>
                               <table class="table table-striped responsive-utilities jambo_table bulk_action">
                               <tr>
                                <td width="18%" align="left" valign="top"><strong> Training Type:</strong></td>
                                <td width="20%" align="left" valign="top"><?php if(@$request['MstTrainingRequests']['training_topic_type']=='E'){ 
				echo "Existing";
				}else{
				  echo "New";
				}?></td>
                                <td width="16%" align="left" valign="top"><strong>Training Required :</strong></td>
                                <td width="46%" colspan="4" align="left" valign="top"><?php if(@$request['MstTrainingRequests']['training_topic_type']=='E'){
				  $dd_style = 'display:block;';
				  $txt_style = 'display:none;';
				  echo $this->traininghlp->getCouseName(@$request['MstTrainingRequests']['training_topic_id']);
				}else {
				  $dd_style = 'display:none;';
				  $txt_style = 'display:block;';
				  echo @$requestData['MstTrainingRequests']['training_name'];
				}?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Desired Training Date:</strong></td>
    <td align="left" valign="top"><?php echo date('d-M-Y',strtotime(@$request['MstTrainingRequests']['training_date']));?></td>
    <td align="left" valign="top"><strong>Training Duration:</strong></td>
    <td colspan="4" align="left" valign="top">
	 <?php 
	        $duraHH = @$request['MstTrainingRequests']['duration_hh'];
               
	        $duraMM = @$request['MstTrainingRequests']['duration_mm'];
	        echo $duration = $this->traininghlp->formatDuration($duraHH,$duraMM);?>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>List of Trainee ( S ):</strong></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
  <br>
  <br>
    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                   <tr class="headings">
                    <th><strong>S.N.</strong></th>
                    <th><strong>Employee Code</strong></th>
                    <th><strong>Employee Name</strong></th>
                    <th><strong>Designation</strong></th>
                    <th><strong>Registration Date </strong></th>
                   </tr>
                   </thead>
                    <tbody>
                  <?php
                        if (count(@$traineeData) > 0) {
                         $i = 1;						 
                         foreach ( @$traineeData as $value ){ 
                                $reg_id = base64_encode($value['TrainingRegistrations']['id']);
                                $traineeCode = $value['TrainingRegistrations']['trainee_code'];
                                if($i%2==0){
                                   $class = 'cont1';			
                                }else{
                                   $class  = 'cont';
                                }

                                $vc_status = $value['TrainingRegistrations']['tr_status'];

                                $vc_type = $value['TrainingRegistrations']['type'];						
                                if($vc_type==''){
                                  $status ='P';
                                }else if($vc_type==''){
                                  $status ='P';
                                }else{
                                  $status ='';
                                }
                        ?>
                   <tr class="<?php echo $class;?>">
                                <td align="center">	<?php echo $i; ?></td>
                                <td><?php echo $traineeCode;?></td>
                                <td> <?php echo $this->traininghlp->getEmpName($traineeCode);?>
                                <input type="hidden" name="data[TrainingRegistrations][trainee_code][]" value="<?php echo $traineeCode;?>"/>
                                </td>
                                <td> <?php echo $this->traininghlp->getDesg($traineeCode);?></td>
                                <td>
                                  <?php $arrr = explode(':',$value['TrainingRegistrations']['regis_date']);echo date('d-M-Y',strtotime($arrr[0]));?>
                            </td>
                     </tr>
                      <?php $i++;
                        } }?>
                    </tbody>
         </table>  
 </div>
</div>
 <div id="container" ></div>
</div>

  </div>
  </div>
 </div>






