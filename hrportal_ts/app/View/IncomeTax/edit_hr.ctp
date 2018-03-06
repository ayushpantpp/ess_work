<!-- Center Content Starts -->
<?php echo $this->Form->create('IncomeTax', array('url' => array('controller' => 'IncomeTax', 'action' => 'edithrsaveinfo'), 'id' => 'add', 'name' => 'voucher')); 
 echo $this->Form->input('count',array('value'=>$count,'type'=>'hidden'));?>
 
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent big-table"> </div>
    </div>
</div>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
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
                       <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table class="table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
                            <thead>
                                <tr>  
                                    <th scope="row">Particulars</th>
                                    <th>Limit</th>
                                    <th width="28%">Planned Amount</th>
                                    <th width="28%"> Actual Amount</th>
                                </tr>
                            </thead>
                            <tbody id='mytbody'>
                               
                               <?php  $i= 0; foreach($incometax as $invest) {?>
                                <?php $name = $this->Common->findInvestName($invest['EmpInvestDtl']['invest_id']); 
                                      $hover_desc = $this->Common->findHover($invest['EmpInvestDtl']['invest_id']);
                                ?>   
                               <tr ><td onmouseover="bigImg(<?php echo $i;?>)"><p id='toggleSwitch_j_<?php echo $i;?>' class='hlink'><?php echo $name['OptionAttribute']['name']; ?></p>
                                     <?php echo $this->Form->input('Investment_'.$i, array('id'=>'toggleSwitch_j','value' =>$invest['EmpInvestDtl']['invest_id'] , 'type' => 'hidden', 'class' => 'required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); 
                                     echo $this->Form->input('invest_id_'.$i,array('value'=>$invest['EmpInvestDtl']['id'],'type'=>'hidden'));
                                     ?>   
                                     <div id="theBox_<?php echo $i;?>" class='hbox'><?php echo $hover_desc['InvestDtl']['hover_description']; ?></div>    
                                    </td>
                                <td><?php echo $hover_desc['InvestDtl']['invest_max_limit']; ?></td> 
                                <td><?php echo $this->Form->input('planned_'.$i, array('id'=>'planned.1', 'class' => 'required','value'=>$invest['EmpInvestDtl']['invest_amt'], 'label' => false,'type' => 'text','autocomplete' => 'off')); ?></td> <span id="errmsg"></span>
                              <td><?php echo $this->Form->input('actual_'.$i, array('id'=>'actual.1', 'class' => 'required','value'=>$invest['EmpInvestDtl']['actual_amt'], 'label' => false,'type' => 'text','autocomplete' => 'off')); ?></td> <span id="errmsg"></span>
                                </tr> 
                               <?php $i++; } ?>
                            </tbody>
                        </table>     
                    </div>
                </div>
                <div class='form-group'> 
                    
                    <input type="submit" class="btn btn-danger" value="Apply" name='post_travel'>

                </div>
            </div>
        </div>
    </div>


</div>    
<?php $this->Form->end(); ?>   
<script>
    $(document).ready(function () {
  //called when key is pressed in textbox
  $( "#planned.1" ).keypress(function() {
  console.log( "Handler for .keypress() called." );
});
});
    function bigImg(x){
     $("#toggleSwitch_j_" + x).hover(

    function() {
        $("#theBox_" + x).slideDown(500);
    }, function() {
        $("#theBox_" + x).slideUp(500);
    });
    }
   
       
 
</script>

