
<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3> Raised Appraisals </h3>
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
                <h2>Appraisals List</h2>
                
              <div class="clearfix"></div>
              </div>
              <div class="x_content">
                
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                    <th scope="row" width="19%">Name</th>
                    <th width="12%">Form Send Date</th>
                    <th width="12%">From Date</th>
                    <th width="12%">To Date</th>
                    <th width="11%">Status</th>
                    <th>Incremented Amount</th>
                    <th  width="13%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $zebraClass = ""; ?>
                <?php if(count($data)==0) {?>
                    <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                        <td style="text-align:center;" colspan="7">
                             <em>--No Records Found--</em>   
                        </td>
                    </tr>                        
                <?php } ?>                
                <?php foreach($data as $appraisal): ?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                    <td><?php echo ucwords(strtolower($appraisal['MyProfile']['emp_firstname'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($appraisal['Appraisals']['dt_request'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($appraisal['Appraisals']['dt_fromDate'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($appraisal['Appraisals']['dt_toDate'])); ?></td>
                    <td><?php echo $appraisal['Appraisals']['ch_status'];?></td>
                    <td><?php echo $appraisal['Appraisals']['amt_inc'];?></td>
                    <td>
                       <input type="hidden" name="nu_project_code" value="<?php //echo $appraisal['Projects']['nu_project_code']; ?>"></input>
                       <input type="hidden" name="vc_complain_no" value="<?php //echo $appraisal['Complaints']['vc_complain_no']; ?>"></input>
                       <ul class="edit-delete-icon">
                         <?php if (trim($appraisal['Appraisals']['ch_status'])=='ON HOLD') {?>
                            <li><a href="<?php echo $this->webroot.'appraisal/start/'.$appraisal['Appraisals']['id'];?>" class="btn btn-danger btn-xs" title="Start Appraisal Process">Open</a></li>
			    
                         <?php } else { ?>
                            <?php if (trim($appraisal['Appraisals']['ch_status'])=='HR') {?>
                               
                            <?php } else {?>
                               
                            <?php } ?>
                         <?php } ?>
                       </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
                </table>
              </div>
                <div class="input-boxs-timesheet">
                <div class="tab-fixed">
                <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">

                </table>
                <div class="navigation">
                <?php echo $this->Paginator->counter(); ?> Pages
                <?php echo $this->Paginator->options(array('url'=>$this->passedArgs)); ?>
                <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
                <?php echo $this->Paginator->numbers(); ?>
                <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                </div>            
               </div>
             <div class="submit">
             
            <?php echo $this->Html->link(__('GENERATE APPRAISAL FORM'), array('action' => 'pr_optionlist_html'),array('class'=>"btn btn-success")); ?> 
            </div>

    </div>
     
            </div>
          </div>
        </div>
      </div>
      
      <!-- footer content --> 
      <!--<footer>
        <div class="">
          <p class="pull-right">HR Portal by <a href="https://essindia.com/" target="_blank">ESS</a>. | <span class="lead"> <img src="images/ess-logo.png" width="" height="20" alt="Ess Logo"></span> </p>
        </div>
        <div class="clearfix"></div>
      </footer>--> 
      <!-- /footer content --> 
      
    </div>