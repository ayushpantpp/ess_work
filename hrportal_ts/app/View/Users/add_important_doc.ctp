    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Upload Important Document</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Upload Document</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                <form id="demo-form4" data-parsley-validate enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST" action="saveUpload" >
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input name="title" type="text" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload Document</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input class="avatar-input" id="docInput" name="doc_file" type="file" class="form-control col-md-7 col-xs-12">
                       
                    </div>
                </div>
               <div class='form-group'>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Category</label> 
                <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control" name="important_doc">
                <?php foreach($important as $key=>$val){?>   
                <option value="<?php echo $key?>"><?php echo $val;?></option>
                <?php } ?>
                 </select>
                </div>    
               </div>    
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>

              </div>
            </div>
          </div>
        </div>
      </div>
 

      </div>


          
