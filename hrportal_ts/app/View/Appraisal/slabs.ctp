<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3> Slab List </h3>
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
                  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    <th>Department</th>
                    <th>Designation</th>
                     <th>Below Average</th>
                     <th>Good</th>
                     <th>Very Good</th>
                     <th>Excellent</th>
                     <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>

                
               <?php  $auth=$this->Session->read('Auth');
                $i=1; 
                foreach($slabs as $list)
                { 
                    
                    if($i%2==0)$class='cont'; else $class='cont1';  ?> 
                     <tr class="<?php echo $class; ?>">
                        <td><?php echo $list['Appraisalslabs']['dept_code']; ?></td>
                        <td><?php if ($list['Appraisalslabs']['desg_code']) echo 'First Two Appraisal'; else echo 'After Two Appraisal'; ?></td>
                        <td><?php echo $list['Appraisalslabs']['rating_id']; ?></td>   
                        <td><?php if ($list['Appraisalslabs']['fac_status']) echo 'Active'; else echo 'De Active';  ?></td>
                        <td>
                        <?php if ($list['Appraisalslabs']['fac_status'] == 1) {?>    
                        <a href="#"  class="view vtip" title="Click to View.">Deactivate</a>
                        <?php } else { ?>
                        <a href="#"  class="view vtip" title="Click to View.">Active</a>
                        <?php } ?>
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
                <a href="#"  class="view vtip btn btn-success" title="Click to View.">Add Factor</a>
            </div>
          </div>
        </div>
      </div>
      

    </div>