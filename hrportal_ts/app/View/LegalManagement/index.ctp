<script>
    window.setInterval(function() {
$('#blinkText').toggle();
}, 700);
</script>
<div id="page_content">
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <?php /* <div class="heading_actions" id="blinkText">
            <?php if($notiFlage=="Yes"){ ?>
            <span class="uk-text-success"> <?php echo date("d/m/Y", strtotime($Next_h)); ?> </span><a class="uk-text-danger" data-uk-tooltip="{pos:'bottom'}" >is next hearing date of case numbers <?php echo $AllCases;?> </a>                             
            <?php }?>
        </div> */?>
        <h1>Case Receive</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Case Received 
                
                <a  class="md-btn md-btn-primary uk-float-right" href="<?php echo $this->Html->url('case_receive'); ?>">Case Entry</a></h3>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Case Number</th>
                                <th>PSC file Number</th>
                                <th>Ministry</th>
                                <th>Case Type</th>
                                <th>Action Officer</th>
                                <th>Subject</th>
                                <th>Date of Service</th>
                                <th class="filter-false remove sorter-false">Case Details</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($CaseReceive as $rec){ ?>
                            <tr>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['court_case_number'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['psc_file_number'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['Ministry']['ministry_name']." [".$rec['Ministry']['ministry_code']."]";?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findCaseType($rec['CaseReceive']['case_type_id']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['MyProfile']['emp_full_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['subject'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['CaseReceive']['date_of_service']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('case_details/'.base64_encode($rec['CaseReceive']['id'])); ?>">Case Details</a>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('case_receive_edit/'.base64_encode($rec['CaseReceive']['id'])); ?>">Edit</a>
                                        | <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('case_receive_edit/'.base64_encode($rec['CaseReceive']['id']).'/del'); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                    </span>
                                </td>
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   </div>
</div>
