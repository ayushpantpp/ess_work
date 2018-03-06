    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>FNF Details</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content"> <br />

                  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th>Sr.No</th>
                      <th>Employee</th>
                      <th>Status</th>
                      <th>Created</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                    <?php 
                    $ctr =1;
                    foreach ($finalfnf as $value) {

                      ?>
                    <tr>
                      <td><?php echo $ctr;?></td>
                      <td><?php echo $this->Common->getempinfo($value['Fnf']['emp_code']);?></td>
                      <td><?php echo $this->Common->findSatus($value['Fnf']['status']) ;?></td>
                      <td><?php echo ($value['Fnf']['created'])?date("d-M-Y",strtotime($value['Fnf']['created'])):'NA';?></td>
                      <td>
                    
                    <?php if($value['Fnf']['status'] == 1) { ?>
                      <a class="btn btn-success" href="<?php echo $this->Html->url('/fnfs/other_users/').$value['Fnf']['id'];?>">Approve</a> 
                    <?php
                   }
                   ?>
                      </td>
                    </tr>
                    <?php $ctr++;
                    }?>
                  <tbody>
                    
                  </tbody>
                  </table>
                
                  <div class="ln_solid"></div>
                </div>
            </div>
          </div>
        </div>
 
      </div>


