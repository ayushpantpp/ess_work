<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3> Slabs List </h3>
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
                    
                     <th> Department Name</th>
                     <th>Designation Name</th>
                     <th>Rating</th>
                     <th>Amount Increment</th>
                     </tr>
                  </thead>
                  <tbody>

                
               <?php  $auth=$this->Session->read('Auth');
                $i=1; 
                foreach($data as $slab)
                { 
                    
                    if($i%2==0)$class='cont'; else $class='cont1';  ?> 
                     <tr class="<?php echo $class; ?>">
                        <td><?php echo $slab['Department']['dept_name']; ?></td>
                       
                        <td><?php echo $slab['Designation']['desc']; ?></td>   
                        <td><?php if ($slab['Appraisalslabs']['rating_id'] == 1 ) echo 'Below Average'; elseif($slab['Appraisalslabs']['rating_id']==2) echo 'Average';elseif($slab['Appraisalslabs']['rating_id']==3) echo 'Good';elseif($slab['Appraisalslabs']['rating_id']==4) echo 'Very Good';else echo 'Excellent';  ?></td>
                        <td><?php echo $slab['Appraisalslabs']['amt_inc']; ?></td>
                    </tr>
                <?php $i++; } ?> 
                   

                  </tbody>
                </table>
                 <a href="<?php echo $this->webroot.'appraisal/addSlab'?>"  class="view vtip btn btn-success" title="Click to View.">Add Slab</a>
            </div>
          </div>
        </div>
      </div>
</div>

   