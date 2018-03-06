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
    
</div><table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
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
                foreach($factors as $list)
                { 
                    
                    if($i%2==0)$class='cont'; else $class='cont1';  ?> 
                     <tr class="<?php echo $class; ?>">
                        <td><?php echo $list['Appraisalfactors']['factor_name']; ?></td>
                        <td><?php if ($list['Appraisalfactors']['factor_type']) echo 'First Two Appraisal'; else echo 'After Two Appraisal'; ?></td>
                        <td><?php echo $list['Department']['dept_name']; ?></td>   
                        <td><?php if ($list['Appraisalfactors']['fac_status']) echo 'Active'; else echo 'De Active';  ?></td>
                        <td>
                        <ul>     
                        <?php if ($list['Appraisalfactors']['fac_status'] == 1) {?>    
                        <li> <a href="#" onclick ='deaactivate_factor(<?php echo $list['Appraisalfactors']['id']?>)' id ='factordeactivate' class="view vtip" title="Click to View.">Deactivate</a></li>
                        <?php } else { ?>
                        <li><a href="#" onclick ='activate_factor(<?php echo $list['Appraisalfactors']['id']?>)' id ='factoractivate' class="view vtip" title="Click to View.">Active</a></li>
                        <?php } ?>
                        </ul>
                        </td>
                    </tr>
                <?php $i++; } ?> 
                   

                  </tbody>
                </table>
                <div class="navigation">
            <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->options(array('url'=>$this->passedArgs)); ?>
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
            </div>   
              </div>
                <a href="<?php echo $this->webroot.'appraisal/addfactors'?>"  class="view vtip btn btn-success" title="Click to View.">Add Factor</a>
            </div>
          </div>
        </div>
      </div>
</div>

<script>

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
</script>    