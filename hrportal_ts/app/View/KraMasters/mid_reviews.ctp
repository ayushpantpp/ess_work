<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"><h3>Start Mid Reviews Process by HR </h3>
                <?php echo $this->Form->create('midReviews', array('url' =>array('controller' => 'KraMasters', 'action' => "midReviews"),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php 
                            $financialYear = $this->Common->findfyDesc($currentFinancialYear);
                            echo $this->Form->input('financialYear', array('class' => 'md-input', 'type' => 'text', 'label' => 'Financial Year', 'required' => TRUE, 'readonly' => 'readonly', 'value' => "$financialYear")); ?>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('j_date_from', array('class' => 'md-input SDate', 'type' => 'text', 'label' => 'Joining Date From', 'required' => TRUE, 'id' => 'StartDate', 'onchange' => 'getEmpListByJoiningDateByStartDate(this.value)','data-uk-datepicker' => "{format:'DD-MM-YYYY'}")); ?>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php echo $this->Form->input('j_date_to', array('class' => 'md-input EndDate', 'type' => 'text', 'label' => 'Joining Date To', 'required' => TRUE, 'id' => 'EndDate', 'format' => 'd-MM-yyyy','onchange' => 'getEmpListByJoiningDate(this.value)','data-uk-datepicker' => "{format:'DD-MM-YYYY'}")); ?>
                        </div>
                    </div>
                </div>
				
                <div style="display:none;" class="ajaxloader"><br><img style="width:20px;" src="<?php echo $this->webroot ?>/img/loader.gif"> Please wait...</div><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" id="empList">                        
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                            
                            <label for="hobbies" class="uk-form-label">Status (1 minimum):</label>
                            <span class="icheck-inline">
                                <input type="radio" name="data[midReviews][status]" id="val_check_ski"  value="1" data-md-icheck checked="" />
                                <label for="val_check_ski" class="inline-label">Active</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="data[midReviews][status]" id="val_check_ski" value="2" data-md-icheck />
                                <label for="val_check_ski" class="inline-label">De Active</label>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success">Submit</button>
                        <button type="reset" name="submit" class="md-btn md-btn-primary">Cancel</button>
                    </div>
                </div>                            

            </div>

        </div>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('midReviews', array('url' => array('controller' => 'midReviews', 'action' => 'addAppraisalProcess'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Financial Year</th>
                                <th>Appraiser Name</th>
                                <th>Status</th>                                    
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Financial Year</th>
                                <th>Appraiser Name</th>
                                <th>Status</th>                                    
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (isset($midReviewsList)) {
                                $p = 1;
                                
                                for ($i = 0; $i < count($midReviewsList); $i++) {

                                    $ctr = (($this->params['paging']['MidReviews']['page'] * $this->params['paging']['MidReviews']['limit']) - $this->params['paging']['MidReviews']['limit']) + $p;

                                    if ($midReviewsList[$i]['MidReviews']['status'] == 1) {
                                        $midReviewstatus = "<span class='uk-badge uk-badge-primary'>Active</span>";
                                        $appraisalStatus = 0;
                                    } else {
                                        $midReviewstatus = "<span class='uk-badge uk-badge-danger'>Deactive</span>";
                                        $appraisalStatus = 1;
                                    }
                                    $empDetails = $this->Common->getEmpDetails($midReviewsList[$i]['MidReviews']['emp_code']);
                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo $this->Common->findEmpName($midReviewsList[$i]['MidReviews']['emp_code']); ?></td>
                                        <td><?php echo $empDetails['MyProfile']['emp_id']; ?></td>
                                        <td><?php echo $this->Common->findfyDesc($midReviewsList[$i]['MidReviews']['financial_year']); ?></td>                                        
                                        <td><?php $managerCode = $this->Common->findEmpName($midReviewsList[$i]['MidReviews']['appraiser_code']); 
                                         if($managerCode != " "){
                                             echo $managerCode;
                                         }else{
                                             echo "N/A";
                                         }?></td>
                                        <td><?php echo $midReviewstatus; ?></td>
                                        <td>                                    
                                            <a href="<?php echo $this->webroot; ?>KraMasters/midReviews/midReviewstatus/<?php echo base64_encode($appraisalStatus)?>/<?php echo base64_encode($midReviewsList[$i]['MidReviews']['id']); ?>" onClick="return confirm('Are you sure you want to change status?');" title="Click to Delete" class="uk-badge uk-badge-success">Change Status</a>
                                        </td>                          
                                    </tr> 

        <?php $p++;
    }
} ?>

                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                            <?php
                                //echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                //echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                //echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(".EndDate").change(function () {
       // alert("sdnmbsdjms")
        var startDate = document.getElementById("StartDate").value;
        var endDate = document.getElementById("EndDate").value;

        if ((Date.parse(startDate) >= Date.parse(endDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("EndDate").value = "";
        }
    });
    
    function getEmpListByJoiningDate(enddate)
    {
        var startdate = document.getElementById("StartDate").value;
        jQuery.ajax({
			beforeSend: function(){
				if(startdate!=''){
					jQuery('.ajaxloader').show();
				}
			},
			complete: function(){
				jQuery('.ajaxloader').hide();
			},
            url: '<?php echo $this->webroot ?>KraMasters/getEmpListByJoiningDate/' + startdate + '/' + enddate,
            success: function (data) {
                //alert(data);
                jQuery('#empList').html(data);
            }
        });
    }
    
    function getEmpListByJoiningDateByStartDate(startdate)
    {
        var enddate = document.getElementById("EndDate").value;
        jQuery.ajax({
			beforeSend: function(){
				if(enddate!=''){
					jQuery('.ajaxloader').show();
				}
			},
			complete: function(){
				jQuery('.ajaxloader').hide();
			},
            url: '<?php echo $this->webroot ?>KraMasters/getEmpListByJoiningDate/' + startdate + '/' + enddate,
            success: function (data) {
                //alert(data);
                jQuery('#empList').html(data);
            }
        });
    }

</script>  