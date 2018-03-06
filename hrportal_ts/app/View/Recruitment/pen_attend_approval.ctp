<?php $i = 0; ?>
<div id="page_content">
    <div id="page_content_inner">
       
         <?php echo $flash = $this->Session->flash(); ?>
        <?php if ($page_name == 'ATTENDANCE_LIST') { ?>
            
        <div class="md-card">
            
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
            <h2><?php echo $page_heading; ?></h2>
          
                <?php
                echo $this->form->create('Users', array('url' => '', 'name' => 'Form1', 'action' => 'filter_attendance', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'md-input'))));
                ?>
                 <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                     <tr>
                         <td><?php echo $this->form->input('month', array('label' => false, 'type' => 'select', 'options' => $months, 'value' => $current_month, 'class' => "md-input", 'required' => true, 'id' => 'first_name')); ?></td>
                         <td><?php echo $this->form->input('year', array('label' => false, 'type' => 'select', 'options' => $years, 'value' => $current_year, 'class' => "md-input", 'required' => true)); ?></td>
                         <td><input type="submit" class="md-btn md-btn-primary" value="GO" name='post_Salary'></td>
                         <td><input type="submit" class="md-btn md-btn-danger" value="EXPORT" name='post_Salary'></td>
                    </tr>
                 </table>    
                </form>
            <div class="clearfix"></div>
        </div>
        </div></div>
        <?php } ?>
           
      <div class="md-card">  
        <div class="md-card-toolbar">
        

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Attendance List </b>
                            </h3>
                            
                          

                        
                            </div>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Reason</th>
                                <th>Attendance Date</th>
                                <th>Applied Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Out Station Duty</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 



                            if (empty($pen_attendances)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                    

                            <?php foreach ($pen_attendances as $srcdet) {
                            
                              if ($srcdet['AttendanceDetail']['status'] == 1) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    } elseif ($srcdet['AttendanceDetail']['status'] == 2) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    } elseif ($srcdet['AttendanceDetail']['status'] == 6) {
                                        $btnClass = "uk-badge uk-badge-warning";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    } elseif ($srcdet['AttendanceDetail']['status'] == 4) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    } elseif ($srcdet['AttendanceDetail']['status'] == 5) {
                                        $btnClass = "uk-badge uk-badge-success";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    } else {
                                        $btnClass = "uk-badge uk-badge-danger";
                                        $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                    }

                                if ($i % 2 == 0)
                                    $class = 'even pointer';
                                else
                                    $class = 'odd pointer';
                                ?>
                                <tr class="even pointer">
                                    <td><?php echo $i + 1; ?></td> 
                                    <td> <?php echo $srcdet['AttendanceDetail']['description'] ?></td>
                                    <td> <?php echo date('d-m-Y', strtotime($srcdet['AttendanceDetail']['atten_dt'])) ?></td>
                                    <td> <?php echo date('d-m-Y', strtotime($srcdet['AttendanceDetail']['usr_id_create_dt'])) ?></td>
                                    <td> <?php echo date('H:i', strtotime($srcdet['AttendanceDetail']['in_time'])); ?></td>
                                    <td> <?php echo date('H:i', strtotime($srcdet['AttendanceDetail']['out_time'])); ?></td>
                                    <td> <?php if($srcdet['AttendanceDetail']['is_od'] == "1") { echo "Yes"; } else {echo "No"; } ?></td>
                                    <td> <?php echo $srcdet['AttendanceDetail']['address'] ; ?></td>
                                    <td ><p class="<?php echo $btnClass;?>"> <?php echo $btnStatus ; ?></p></td>
                                    <?php if ($srcdet['AttendanceDetail']['reject_remark']) { ?>
                                        <td> <?php echo $srcdet['AttendanceDetail']['reject_remark'] ?></td>
                                <?php } else { ?>
                                        <td><p>N/A</p></td>
    <?php } ?>
                                </tr>
    <?php $i++;
} ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
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

            <div id="container" ></div>
        </div>
        <script type="text/javascript">
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>users/pen_attend_approval/"+val; 


 }
 </script>