<div id="page_content">
    <div id="page_content_inner">
    <?php echo $flash = $this->Session->flash(); ?>
        <span class="momStatus"></span>
              <div class="md-card">  
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
                <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                </div>
            </div>
                <h3 class="md-card-toolbar-heading-text">
                <b>Selected Candidates</b>
                </h3>
        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">   
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                <th class="filter-false remove sorter-false">Sr.No</th>
                                <th>Candidate Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $auth = $this->Session->read('Auth'); ?>
                            <?php if (count($pending_leave_employee) == 0) { ?>
                                 <?php } ?>
                                <tr>
                                    <td><input type="checkbox" data-md-icheck  <?php echo $payChacked; ?> name="id[]" class="ts_checkbox" value="<?php echo $rec['DtTravelVoucher']['id']; ?>"></td>                        
                                    <td><?php echo "1"; ?></td>
                                    <td><?php echo "Ayush Pant"; ?></td>
                                    <td><?php echo "PHP ADM"; ?></td>
                                    <td><?php echo "Sr Software Engineer"; ?>
                                    </td>
                                    <td><?php echo "12-DEC-2017"; ?></td>
                                    <td>
                                            <a class="uk-badge uk-badge-success" href="#"  Title="View Details">Details</a>
                                    </td>
                                    <td>
                                            <a class="uk-badge uk-badge-warning" href="#"  Title="Copy Link">InterView Rating</a>/
                                            <a class="uk-badge uk-badge-danger" href="#"  Title="Copy Link">Download Resume</a>
                                    </td>
                                </tr>
                                <tr>
                                      <td><input type="checkbox" data-md-icheck  <?php echo $payChacked; ?> name="id[]" class="ts_checkbox" value="<?php echo $rec['DtTravelVoucher']['id']; ?>"></td>                        
                                  
                                    <td><?php echo "2"; ?></td>
                                    <td><?php echo "Anita Yadav"; ?></td>
                                    <td><?php echo "PHP ADM"; ?></td>
                                    <td><?php echo "Sr Software Engineer"; ?>
                                    </td>
                                    <td><?php echo "12-DEC-2017"; ?></td>
                                    <td>
                                            <a class="uk-badge uk-badge-success" href="#"  Title="View Details">Details</a>
                                    </td>
                                         <td>
                                            <a class="uk-badge uk-badge-warning" href="#"  Title="Copy Link">Fill Rating</a>/
                                                    <a class="uk-badge uk-badge-danger" href="#"  Title="Copy Link">Download Resume</a>
                                     </td>
                                </tr>
                                <tr>
                                      <td><input type="checkbox" data-md-icheck  <?php echo $payChacked; ?> name="id[]" class="ts_checkbox" value="<?php echo $rec['DtTravelVoucher']['id']; ?>"></td>                        
                                  
                                    <td><?php echo "3"; ?></td>
                                    <td><?php echo "Rahul Tripathi"; ?></td>
                                    <td><?php echo "PHP ADM"; ?></td>
                                    <td><?php echo "Sr Software Engineer"; ?></td>
                                    <td><?php echo "12-DEC-2017"; ?></td>
                                    <td>
                                            <a class="uk-badge uk-badge-success" href="#"  Title="View Details">Details</a>
                                    </td>
                                    <td>
                                            <a class="uk-badge uk-badge-warning" href="#"  Title="Copy Link">Fill Rating</a>
                                            /
                                            <a class="uk-badge uk-badge-danger" href="#"  Title="Copy Link">Download Resume</a>
                                    </td>
                                </tr>
                                <tr>
                                      <td><input type="checkbox" data-md-icheck  <?php echo $payChacked; ?> name="id[]" class="ts_checkbox" value="<?php echo $rec['DtTravelVoucher']['id']; ?>"></td>                        
                                  
                                    <td><?php echo "4"; ?></td>
                                    <td><?php echo "Rishabh Gupta"; ?></td>
                                    <td><?php echo "PHP ADM"; ?></td>
                                    <td><?php echo "Sr Software Engineer"; ?></td>
                                    <td><?php echo "12-DEC-2017"; ?></td>
                                    <td>
                                            <a class="uk-badge uk-badge-success" href="#"  Title="View Details">Details</a>
                                    </td>
                                    <td>
                                        <a class="uk-badge uk-badge-warning" href="#"  Title="Copy Link">Fill Rating</a>
                                        /<a class="uk-badge uk-badge-danger" href="#"  Title="Copy Link">Download Resume</a>
                                    </td>
                                </tr>
                        </tbody>
                        <div id="dialog" title="Remark/Comment" style="display:none">
                            <div>
                                <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 600px; height:200px;" onKeypress="getcmtval()" > </textarea>
                                <div class="ui-widget" id="errdis" style="display:none">
                                    <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                            <strong></strong> Please write rejection reason.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="wf_id" name="wf_id" value=''/>
                        <input type="hidden" id="leaveno" name="leave_no" value=""/>
                        <input type="hidden" id="ccode" name="comp_code" value=""/>
                        <input type="hidden" id="stdate" name="start_date" value=""/>
                        <input type="hidden" id="eddate" name="end_date" value=""/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                    </table>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
  <script type="text/javascript">
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>leaves/approval/"+val; 


 }
 </script>