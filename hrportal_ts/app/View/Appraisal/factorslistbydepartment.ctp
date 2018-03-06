<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> </div>
  </div>
</div>

<div role="main" class="right_col">
    
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3> Factors List </h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              
              <div class="x_content">
                
                <div id="dialog" title="Remark/Comment" style="display:none">
    
              </div>
                  <?php if($factordept){ ?>
                  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                        <th></th>    
                    <th>Name</th>
                     <th>Factor Type</th>
                     <th>Department</th>
                     <th>Active</th>
                     <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>

                
               <?php  $auth=$this->Session->read('Auth');
                $i=1; 
                foreach($factordept as $list)
                { 
                    
                    if($i%2==0)$class='cont'; else $class='cont1';  ?> 
                     <tr class="<?php echo $class; ?>">
                         <td><input type='checkbox' name='factor_id[]' value='<?php echo $list['Appraisalfactors']['id'] ?>' id= "factor_id[<?php echo $i?>]" /></td> 
                        <td><?php echo $list['Appraisalfactors']['factor_name']; ?></td>
                        <td><?php if ($list['Appraisalfactors']['factor_type']) echo 'First Two Appraisal'; else echo 'After Two Appraisal'; ?></td>
                        <td><?php echo $list['Department']['dept_name']; ?></td>  
                        
                        <td><?php if ($list['Appraisalfactors']['fac_status']) echo 'Active'; else echo 'De Active';  ?></td>
                        <td>
                        
                        <?php if ($list['Appraisalfactors']['fac_status'] == 1) {?>    
                         <a href="#" onclick ='deaactivate_factor(<?php echo $list['Appraisalfactors']['id']?>)' id ='factordeactivate' class=" btn btn-primary" title="Click to View.">Deactivate</a>
                        <?php } else { ?>
                        <a href="#" onclick ='activate_factor(<?php echo $list['Appraisalfactors']['id']?>)' id ='factoractivate' class=" btn btn-primary" title="Click to View.">Active</a>
                        <?php } ?>
                        <a href="#popup1" onclick ='assign_factor(<?php echo $list['Appraisalfactors']['id']?>)' id ='factoractivate' class=" btn btn-primary" title="Click to View.">Assign</a>
                       
                        </td>
                    </tr>
                <?php $i++; } ?> 
                   

                  </tbody>
                </table>
               <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Select Employee <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <select multiple data-type="text" class="form-control s-form-item s-form-all" name="employee" id="employee">
                        <?php foreach($data as $k=>$val){ ?>
                        <option value='<?php echo $k?>'><?php echo $val ?></option>
                       
                        <?php } ?>
                      </select>
                 
                    </div>
                    
                  </div> 
                    <a href="#popup1" onclick ='submit()' id ='factoractivate' class="view vtip btn btn-success" title="Click to View.">Assign Factors</a>
                  <?php } else{ ?>
                    <p class="RejectedLeave">No Factor Assigned For This Department<p>
                  <?php } ?>
                    
              </div>
               
               
            </div>
          </div>
        </div>
       
      </div>
</div>

<script>
function submit() {
var foo = []; 
$('#employee :selected').each(function(i, selected){ 
  foo[i] = $(selected).val(); 
});
var factors = [];
$.each($("input[name='factor_id[]']:checked"), function(){            
    factors.push($(this).val());
});
alert(factors);
jQuery.ajax({
        type:"POST",
        data: {factors:factors,employee:foo},
        url: '<?php echo $this->webroot ?>appraisal/appraisalfactorconsolidatedinfo/',
        success: function(){
          $('.HRcontent').html('Factor Assigned Successfully'); 
            
        }
    });    

}
function deaactivate_factor(id)
{
jQuery.ajax({
        url: '<?php echo $this->webroot ?>appraisal/deactivatefactor/'+id,
        success: function(data){
            location.reload();
        }
    });    
}
function activate_factor(id)
{
jQuery.ajax({
        url: '<?php echo $this->webroot ?>appraisal/activatefactor/'+id,
        success: function(data){
            location.reload();
        }
    });    
}
function assign_factor(id)
{
jQuery.ajax({
        url: '<?php echo $this->webroot ?>appraisal/assignfactor/'+id,
        success: function(data){
             jQuery('.HRcontent').html(data);
        }
    });    
}
</script>    