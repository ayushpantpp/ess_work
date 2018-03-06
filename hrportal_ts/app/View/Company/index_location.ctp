<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Location Management
            </li>
            <li>
                 Location Master
            </li>            
        </ul>
    </div>
</div>
<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Location<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('Location', array('url' => '#', 'name' => 'msgForm','enctype'=>"multipart/form-data", 'inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
               <tr> 
                       <?php $company = $this->Common->findLocationName();
                       //print_r($company);
                    ?>
                    <th scope="row" width="253"><strong>Location:</strong>  </th>
                    <td><?php echo $this->Form->input('orgName', array('type' => 'select', 'options' => $company, 'class' => 'round_select', 'id' => 'orgName', 'maxLength' => 90)); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Latitude :</strong>  </th>
                    <td><?php echo $this->Form->input('Latitude', array('class' => 'round_select',  'id' => 'Latitude','onkeypress'=>'return isNumberKey(event)')); ?>
                        <div id="dltnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Longitude :</strong>  </th>
                    <td><?php echo $this->Form->input('Longitude', array('class' => 'round_select', 'id' => 'Longitude','onkeypress'=>'return isNumberKey(event)')); ?>
                        <div id="dlnameErr" style="color:red"></div>
                    </td>
                </tr>
               <tr>
                    <th scope="row"><strong>Radius :</strong>  </th>
                    <td><?php echo $this->Form->input('Radius', array('class' => 'round_select', 'id' => 'Radius','onkeypress'=>'return isNumberKey(event)')); ?>
                        <div id="drnameErr" style="color:red"></div>
                    </td>
                </tr>

                <tr>
                <td colspan="4">
                    <div class="submit">
                        <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'successButton'));         
                echo $this->Form->button('Reset', array('type' => 'reset', 'onclick'=>'location.reload();', 'class' => 'infoButton')); ?>
                    </div>
                </td>
            </tr>
            </table>
        </div>
    </div>
    
    <?php
    echo $this->Form->end();
    ?>

</div>


<style type="text/css">
    td{
        word-wrap: break-word;
        white-space: normal;

    }
    .td1{
        display:block;
        width:500px;
        overflow: hidden;
    }
    .highlight_word{

        background-color: #ACA;

    }
</style>


<div id="list_msg_div1">
    <h2 class="demoheaders">Location List</h2>
    <div class="travel-voucher1" style="min-height: 300px;">
<?php $company = $this->Common->LocationName(); 

if(empty($company)) { ?>
                <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                        <em>--No Records Found--</em>
                </td>
                </tr>
              <?php } ?>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%">Latitude</th>
        <th width="30%">Longitude</th> 
        <th width="5%">Radius</th>
        <th width="30%">Location</th> 
        <th width="35%">Action</th>   


    </tr>
 <!-- View -->
 <?php 
 $i=1;

foreach($company as $rows){

 ?>
    <tr class="">
        <td><?php echo $i;?></td>
        <td><?php echo $rows['Location']['latitude']?></td> 
            <td><?php echo $rows['Location']['longitude'];?></td>
            <td><?php echo $rows['Location']['in_radius'];?></td> 
            <td><?php echo $this->Common->findLocationNameByCode($rows['Location']['location_code']);?></td>   
        <td> <a href="javascript:void(0);" mid="<?php echo $rows['Location']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
       
<?php $i++; }  ?>

</table>

</div>
</div>
</div>


<script>
    
    jQuery(document).ready(function () {

        jQuery("#delete").live('click', function () {
            var id = jQuery(this).attr('mid');
            if (confirm("Are you sure you want to delete?")) {
                jQuery("#overlay").show();
                jQuery.get('<?php echo $this->webroot; ?>companies/delete_loc/' + id, {}, function (data) {
                    if (data) {
                       location.reload();
                    }
                }, 'json').error(function (e) {
                    alert("Error Occured : " + e.statusText);
                    jQuery("#overlay").hide();
                });
            }

        });

        });

    jQuery("#add").click(function () {

        doChk();
    });

    jQuery("form[name='msgForm']").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            doChk();
            return false;
        } else {

        }
    });
    

</script>
<script language=Javascript>
    function doChk() {
        var err = 0;
        var orgName = jQuery("#orgName").val();
        if (orgName == '') {
            jQuery("#dnameErr").html("<?php echo "Please select Location name."; ?>");
            err++;
            return false;
        } 
        var latitude = jQuery("#Latitude").val();
        if (latitude == '') {
            jQuery("#dltnameErr").html("<?php echo "Please Eneter Latitude ."; ?>");
            err++;
            return false;
        } 
        var longitude = jQuery("#Longitude").val();
        if (longitude == '') {
            jQuery("#dlnameErr").html("<?php echo "Please Enter Longitude ."; ?>");
            err++;
            return false;
        } 
        var radius = jQuery("#Radius").val();
        if (radius == '') {
            jQuery("#drnameErr").html("<?php echo "Please Eneter Radius."; ?>");
            err++;
            return false;
        } 
        
        if (err == 0) {
            
            var fdata = jQuery("form[name='msgForm']").serialize();
              //alert(fdata);
            jQuery.post('<?php echo $this->webroot ?>companies/add_location/', fdata, function (data) {
        
                if (data) {
                
                    createMsg(data.msg, data.type);
                    jQuery("#overlay").hide();
                    //lists();

                    if (data.type == 'success') {
                        //alert("data save");
                        location.reload();
                        return true;
                    }
                }
            }, 'json').error(function (e) {
                alert("Error : " + e.statusText);
                jQuery("#overlay").hide();
            });

        } else {
            return false;
        }
    }
 function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>	
