
<?php $i=0; ?>

<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> </div>
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
          <h2>Documents Uploaded </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
            

     <div class="x_content">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="headings">

                  <th class="column-title">Sr.No </th>
                  <th> Title</th>
                  <th class="column-title">Filename </th>
                  </tr>
              </thead>
              <tbody>

                  <?php if(empty($importantDocument)) { ?>
                <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                        <em>--No Records Found--</em>
                </td>
                </tr>
              <?php } ?>

             <?php foreach($importantDocument as $srcdet)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                            <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                            <td> <?php echo $srcdet['ImportantDoc']['title']?></td>
                            <td><a href="<?php echo $this->webroot.'uploads/document/'.$srcdet['ImportantDoc']['filename'];?>" target="_blank">View File</a> <a href="#" onclick="deleteImportantDoc(<?php echo $srcdet['ImportantDoc']['id']?>);return false;"target="_blank">Delete</a> </td>
 
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
 </div>
</div>
</div>
<div class="navigation">
     <?php echo $this->Paginator->counter(); ?> Pages
     <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
     <?php echo $this->Paginator->numbers(); ?>
     <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div>

  </div>
  </div>
 </div>
 <script type="text/javascript">
function deleteImportantDoc(doc_id) {
    if (confirm('Are you sure ?')) {
        console.log(doc_id);
        $.ajax({
            url: '<?php echo $this->webroot ?>users/deleteImportantDoc/'+doc_id,
            success: function (data) {
                location.reload();

            }

        });
    }
    return false;
}
 </script>>

