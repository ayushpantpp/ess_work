<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'empcomplaint/';?>">Complaint Management System</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'empcomplaint/type';?>">Select Type</a>
            </li>            
            <li>
                Add
            </li>            
        </ul>
    </div>
</div>
<h2 class="demoheaders">Add Ebizframe10 Customers </h2>
<?php
echo $this->Form->create('Empcomplaint', array(
    'url' => 'addebiztencustomers',
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


<div class="travel-voucher1">
<div class="input-boxs-timesheet">
<table class="exp-voucher" width="100%" cellpadding="5" cellspacing="1">

       

        
	<tr class="cont1">
            <td width="30%"><strong>Ebizframe 10 </strong> </td>
            <td colspan="3" style="text-align:right;" width="70%">
                <a href="view_summary"><b>View List</b></a>
            </td>
    </tr>  
<tr class="cont1">
            <td align='right' style='text-align:right;' width="30%"> &nbsp; 
            <strong>Existing</strong> &nbsp;&nbsp;<input type='radio' value='0' name='vc_typecustomer' checked  onClick='changevalueInCustomerList();' id='vctypecustomerID' >
            </td>
            <td colspan="3" width="70%">
               <strong> New </strong> &nbsp;&nbsp;<input type='radio' value='1' name='vc_typecustomer' onClick='changevalueInCustomerList();' id='vctypecustomerID1' >

            </td>
    </tr>  
	<tr class="cont1" id='customer_name_rowexsist_id'>
            <td align='right' style='text-align:right;' width="30%"><strong>Customer List</strong> </td>
            <td colspan="3" width="70%"><?php
            
            echo $this->Form->input('Mstcomplaintcustomer.vc_customer_code', 
            array('label' => false,	'div' => false,'type' => 'select','options' => array(''=>'Select')+$customerslist,
            'class' => 'round_select'));
			?>
			
                
            </td>
    </tr>
	<tr class="cont1" style="display:none;" id='customer_name_row_id'>
            <td  style='text-align:right;' width="30%"><strong>Customer Name </strong></td>
            <td colspan="3" width="70%">
			<?php
				echo $this->Form->input('Mstcomplaintcustomer.vc_customer_name', 
array('label' => false,	'div' => false,	'type' => 'text','value'=>'','class' => 'round_select','maxlength'=>100));
			?>
             <!--   <input type="text" value ="" maxlength='100' name ="data[Mstcomplaintcustomer][vc_customer_name]">-->
            </td>
			<?php echo $form->hidden('Mstcomplaintcustomer.vc_comp_code',array('value'=>'01')); ?>

    </tr>  	
	
</table>
</div>
</div>


<div align="center" class="submit"> <?php echo $form->submit('Save',array('class'=>'successButton','onclick'=>'return validate();'));?></div>
<?php echo $form->end(); ?>
<script language="javascript">
    //jQuery('document').ready(function(){
            
			function changevalueInCustomerList(){
                            var checkedvalue =       $('input[name$="vc_typecustomer"]:checked').val();
                            // alert(checkedvalue);
                            if(checkedvalue=='1'){

                                   $('#customer_name_row_id').show();	
                                   $('#MstcomplaintcustomerVcCustomerName').val('');
                                    $('#customer_name_rowexsist_id').hide();	
                                    //customer_name_rowexsist_id

                            }else{
                                    $('#MstcomplaintcustomerVcCustomerName').val($('#MstcomplaintcustomerVcCustomerCode option:selected').text());
                                    $('#customer_name_row_id').hide();
                                    $('#customer_name_rowexsist_id').show();

                            }
			
                        }
                            function validate(){ 
                            
                                        var checkedvalue = $('input[name$="vc_typecustomer"]:checked').val();
					// alert(checkedvalue);
                                            if(checkedvalue=='0'){                                         
                                           $('#MstcomplaintcustomerVcCustomerName').val($('#MstcomplaintcustomerVcCustomerCode option:selected').text());
                                           }
                                    
                                        if(checkedvalue=='0' && $('#MstcomplaintcustomerVcCustomerCode').val()==''){
					 alert('Please select from the customer list.');
					 return false;
					 }
					
					 if(checkedvalue=='1'){

                                            if($('#MstcomplaintcustomerVcCustomerName').val()==''){
						   alert('Please enter the customer name.')
                                                   return false;
                                            }

                                                }

                                        }

   // });
</script><html><head></head><body></body></html>