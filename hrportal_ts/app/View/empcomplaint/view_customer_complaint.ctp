<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li>

            </li>
        </ul>
    </div>
</div>
<?php
echo $form->create('Empcomplaint', array(
    'url' => '/empcomplaint/view_customer_complaint',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);
?>
<h2 class="demoheaders">View Tickets</h2>
<div class="travel-voucher">

   <table width="100%" border="0" cellspacing="2" cellpadding="3">
        <tr>
            <th scope="row" style="text-align:left;font-size:11px;" width="10%"><strong>Start Date&nbsp;</strong>  :</th>
            <td valign="top"><?php echo $form->input('startdate', array('value' => isset($this->passedArgs['startdate']) ? $this->passedArgs['startdate'] : '')); ?></td>
            <th scope="row" style="text-align:left;font-size:11px;"><strong>End Date&nbsp;</strong>  :</th>
            <td valign="top"><?php echo $form->input('enddate', array('value' => isset($this->passedArgs['enddate']) ? $this->passedArgs['enddate'] : '')); ?></td>
            <th scope="row"  style="text-align:left;font-size:11px;"><strong>Project &nbsp;</strong> : </th>
            <td valign="top">
                <?php echo $form->select('project', array('' => '--Select Project--', $project_type), (isset($this->passedArgs['project']) ? $this->passedArgs['project'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px; width:180px;")); ?>
            </td>


        </tr>
        <tr>
        <!--	<th scope="row" style="text-align:left;font-size:11px;"><strong>Complaint Sub Type&nbsp;</strong>:  </th>
<td valign="top">
            <?php// echo $form->select('subtype', array('' => '--Select Complaint sub type--', $sub_complaint_type), (isset($this->passedArgs['subtype']) ? $this->passedArgs['subtype'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;")); ?>
            <?php //echo $form->select('priority', array('' => '---', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), (isset($this->passedArgs['priority'])?$this->passedArgs['priority']:'') ,array('empty' => false)); ?>
</td> -->
            <th scope="row"  style="text-align:left;font-size:11px;"><strong>Priority&nbsp;</strong> : </th>
            <td valign="top">
                <?php echo $form->select('priority', array('' => '-Select-', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), (isset($this->passedArgs['priority']) ? $this->passedArgs['priority'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:155px")); ?>
            </td>
            <th scope="row" style="text-align:left;font-size:11px;"><strong>Category&nbsp;</strong> : </th>
            <td valign="top">
                <?php echo $form->select('ctype', array('' => '--Select Category--', $complaint_type), (isset($this->passedArgs['ctype']) ? $this->passedArgs['ctype'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:155px")); ?>

            </td>
            <th scope="row" style="text-align:left;font-size:11px;"><strong>Status&nbsp;</strong>  :</th>
            <td valign="top">
                <?php echo $form->select('stage', $complaintrecorded, (isset($this->passedArgs['stage']) ? $this->passedArgs['stage'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:180px"));
                ?>
                <?php // echo $form->select('priority', array('' => '---', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), (isset($this->passedArgs['priority'])?$this->passedArgs['priority']:'') ,array('empty' => false)); ?>
            </td>

        </tr>

        <tr>
           <!-- <th scope="row" style="text-align:left;font-size:11px;"><strong>Resolution&nbsp;</strong>:  </th>
            <td valign="top">
                <?php// echo $form->select('resolutiontype', array('' => '--Select resolution--', $resolution,), (isset($this->passedArgs['resolutiontype']) ? $this->passedArgs['resolutiontype'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:150px;")); ?>

            </td> -->
			<th scope="row" style="text-align:left;font-size:11px;"><strong>Module&nbsp;</strong>:  </th>
            <td valign="top">
                <?php echo $form->select('module', array('' => '--Select Module--', $module,), (isset($this->passedArgs['module']) ? $this->passedArgs['module'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:155px")); ?>

            </td>
			<th scope="row" style="text-align:left;font-size:11px;"><strong>Application Name&nbsp;</strong> : </th>
            <td valign="top">
                <?php echo $form->select('applicationtype', array('' => '--Select Name --', $application_name), (isset($this->passedArgs['applicationtype']) ? $this->passedArgs['applicationtype'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:155px")); ?>

            </td>
            <th scope="row"  style="text-align:left;font-size:11px;"><strong>Application Type&nbsp;</strong> : </th>
            <td valign="top">
                <?php echo $form->select('problemtype', array('' => '--Select Type --', $problem_in_form_report), (isset($this->passedArgs['problemtype']) ? $this->passedArgs['problemtype'] : ''), array('empty' => false, 'style' => "text-align:left;font-size:11px;width:180px"));
                ?></td>
            


        </tr> 

    </table>
</div>
<div align="center" class="submit">
    <input type="submit" value="Search" class="successButton" style="margin: 0 10px;">
    <input type="submit" value="Export to Excel"  name="data[Download]" class="successButton">
</div>
<?php echo $form->end(); ?>
<table border="0" width="100%"  cellspacing="1" cellpadding="0"  class="exp-voucher">

    <tr class="head">
        <th align="left">SI No.</th>
        <th align="left">Ticket No</th>
        <th align="left">Date</th>
        <th align="left">Logged By/Customer</th>
        <th align="left">Description</th>
        <th align="left">Priority</th>
        <th align="left">Status</th>
        <th align="left">View</th>

    </tr>
    <?php
    $i = 0;
    if($pageno == 1) {
    $j = 1;
	}else{
	$j=(($pageno*10)+1);
	}
    if (isset($data)) {
        foreach ($data as $customerdata):
            //pr($data);
            ?>
            <tr class="cont">
                <td  align="left"><?php echo $j; ?></td>
                <td style="overflow: hidden;white-space: nowrap;"><?php echo $data[$i]['Complaints']['vc_complain_no'] ?></td>
                <td style="overflow: hidden;white-space: nowrap;"><?php echo date('d-m-Y', strtotime($data[$i]['Complaints']['dt_complain_date'])) ?></td>
                <td align="left"><?php echo $data[$i]['Complaints']['vc_logged_by'] ?></td>
                <td align="left"><?php echo $data[$i]['Complaints']['vc_desc'] ?></td>
                <td style="overflow: hidden;white-space: nowrap;"><?php echo $data[$i]['Complaints']['vc_priority'] ?></td>                                       
                <td style="overflow: hidden;white-space: nowrap;"><?php echo $data[$i]['Complaints']['vc_stage'] ?></td>

                <td style="overflow: hidden;white-space: nowrap;">     <ul class="edit-delete-icon">

                        <li style="border:none;"> <a href="<?php echo $this->webroot . 'complaint/view/' . $data[$i]['Complaints']['vc_complain_no']; ?>" class="edit vtip" title="View">Edit</a></li></ul>

                </td>
            </tr>							


            <?php
            $i++;
            $j++;
        endforeach;
    }
    ?>
</table>
    <?php if (isset($data)) { ?>
    <div class="navigation">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
<?php } ?>	
</div>  

<script type="text/javascript">

    /*    jQuery(document).ready(function(){
     jQuery('#EmpcomplaintStartdate, #EmpcomplaintEnddate').datepicker({'dateFormat':'dd-mm-yy'});
     });*/
    jQuery(document).ready(function() {
        // jQuery('#EmpcomplaintStartdate, #EmpcomplaintEnddate').datepicker({'dateFormat':'dd-mm-yy'});
        $("#EmpcomplaintStartdate").datepicker({
            'dateFormat': 'dd-mm-yy',
            numberOfMonths: 1,
            onSelect: function(selected) {

                $("#EmpcomplaintEnddate").datepicker("option", "minDate", selected)

            }

        });

        $("#EmpcomplaintEnddate").datepicker({
            'dateFormat': 'dd-mm-yy',
            numberOfMonths: 1,
            onSelect: function(selected) {
                $("#EmpcomplaintStartdate").datepicker("option", "maxDate", selected)

            }

        });
    });
</script>
