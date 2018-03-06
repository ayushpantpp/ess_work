<div role="main" class="right_col">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Pending Dependents</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content"> <br>
                <?php echo $this->Form->create('dependentsApproval', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'Users', 'action' => 'dependentsApproval'), 'id' => 'dependentsApproval', 'name' => 'pendingDocuments'));
                ?>
                        <div class="form-group col-md-12 col-sm-6 col-xs-6">
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                <th class="headings">Sr.No.</th>
                                <th class="headings">Employee Name</th>
                                <th class="headings">Member Name</th>
                                <th class="headings">Relation</th>
                                <th class="headings">Occupation</th>
                                <th class="headings">DOB</th>
                                <th class="headings">Gender</th>
                                <th>Action</th>
                                </thead>
                                <?php if(empty($documents)){echo "<tr><td colspan='4'>No Record Found</td></tr>";}else{
                                    foreach ($documents as $key => $value) {?>
                                <tr>
                                    <td><?php echo $key+1;?></td>
                                    
                                    <td><?php echo $this->common->finddepEmpName($documents[$key]['DependentDetails']['myprofile_id']); ?></td>
                                    <td><?php echo $documents[$key]['DependentDetails']['member_name'] ?></td>
                                    <td><?php echo $documents[$key]['DependentDetails']['relation'];?></td>
                                    <td><?php echo $documents[$key]['DependentDetails']['occupation'] ?></td>
                                    <td><?php echo date('d-M-Y',strtotime($documents[$key]['DependentDetails']['Dob']));?></td>
                                    <td><?php echo $this->common->findGenderName($documents[$key]['DependentDetails']['gender']);?></td>
                                    <td> <a class="btn btn-danger btn-xs" href="<?php echo $this->webroot;?>users/dependentsApproval/<?php echo base64_encode($documents[$key]['DependentDetails']['id']);?>/" title="Click to Edit.">Approve</a>
                                     <a class="btn btn-danger btn-xs" href="<?php echo $this->webroot;?>users/dependentsReject/<?php echo base64_encode($documents[$key]['DependentDetails']['id']);?>/" title="Click to Edit.">Reject</a>
                                    </td>
                                </tr>
                                    <?php }}?>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery(".allpendingDocs").change(function () {
            jQuery(".pendingDocs").prop('checked', jQuery(this).prop("checked"));
        });
    });
</script>
