<table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter" >
                  <thead>
                    <tr class="headings">
                    <th class="column-title">Function Name</th>
                    <th class="column-title">Fuction Edit</th>
                    </tr>
                  </thead>
                       <tbody>
                             <?php 
                             if(isset($sr))
                             {
                             foreach ($sr as $k) { ?> 
                           <tr>
                               <td><?php  echo $k['Tasksprojectmodule']['mname']; ?></td> <!-- <td><select id = "workstatusmodule" onchange="return updatestatusmodule(this.value ,'<?php echo $k['Tasksprojectmodule']['mid']; ?>');">
                                <option value = "" <?php if($k['Tasksprojectmodule']['status'] == ''){
                                echo "selected = 'selected'";
                                } ?>>-Select-</option>
                               <option value = "1" <?php if($k['Tasksprojectmodule']['status'] == '1'){
                                echo "selected = 'selected'";
                                } ?> >Taken</option>
                               <option value = "2" <?php if($k['Tasksprojectmodule']['status'] == '2'){
                                echo "selected = 'selected'";
                                } ?> >Working</option>
                               <option value = "3" <?php if($k['Tasksprojectmodule']['status'] == '3'){
                                echo "selected = 'selected'";
                                } ?> >Completed</option>
                              </select></td>             -->
                             <td>
                           <a href="#popup1" class="btn btn-info btn-xs" 
                                      onclick="Get_Details_new('<?php echo $k['Tasksprojectmodule']['mid'] ?>')" class="view vtip" title="Click to Edit.">Edit</a> 
                              
                             </td>
                           </tr>
                             <?php } }?>
                      </tbody>
                </table>
<script type="text/javascript">

    function updatestatusmodule(status,id){
      jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/updatestatusmodule/'+status+'/'+id,
        success: function(data){
          alert(data);
           window.location.reload();
        }
    });
}

function Get_Details_new(id)
{  // alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/editfunction/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
}
</script>



<div id="popup1" class="uk-modal">
  <div class="uk-modal-dialog">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent"> 
      <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
    </div>    
  </div>
</div>
