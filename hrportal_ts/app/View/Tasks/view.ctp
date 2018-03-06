<table class="table table-striped responsive-utilities jambo_table bulk_action" >
                  <thead>
                    <tr class="headings">
                      
                    <th class="column-title">Project Name</th>
                    <th class ="coloum-title">Assign Function<th>
                    </tr>
                  </thead>
                       <tbody>
                               <?php if(isset($sr))
                                { 
                                  for($i=0;$i<count($sr); $i++){
                               ?> 
                               <tr> 
                                     <td><?php echo $sr[$i]['TP']['pname']?></td>
                                     <td><?php echo $sr[$i]['TM']['mname']?></td>
                                     
                               </tr>
                                <?php }}?>
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
</script>
