
<?php echo $form->create('Leave_Report', array('url' => array('controller' => 'leaves', 'action' => 'countlvallempleaverecord'), 'id' => 'empsearch')); ?>
<div class="wrpper">
    <!-- Center Content Starts -->



    <div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
            <ul>
                <li> <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a></li>
                <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
                <li><?php echo $html->link(' Leave Report', $html->url('/selfservices/#leave', true)); ?> </li>
            </ul>
        </div>
    </div>

    <h2 class="demoheaders">Leave Records Query Form </h2>

    <div class="travel-voucher">
        <div class="input-boxs">
            <table width="100%" border="0" cellspacing="5" cellpadding="5">
                
                
                <tr>
                    <th scope="row">Employee Name :</th>
                      <td> 
                          <?php echo $form->input('Leave_Report.vc_emp_code', array('type' => 'select', 'label' => false, 'options' => $emplist, 'default' => '', 'class' => 'round_select','style'=>'width:148px;')); ?>
                      </td>
                </tr>
             
                <tr>
                   
                    <td class="submit-form" colspan="1"  style="width:45% ; float: none;    text-align: right;">
                        <input type="submit" class="taskbutton" id="value" value="Display" name="data[Leave_Report][submit]" 
                    </td>
                     <td class="submit-form" colspan="1"  style="width:55% ;  margin-left: 20px; float: none;    text-align: left;">
                        <input type="submit" class="taskbutton" id="exceldownload" value="Download Excel" name="data[Leave_Report][submit]" >
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <!-- Center Content Ends -->

</div>


<?php $form->end(); ?>