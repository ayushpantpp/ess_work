<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media:960 }">
            <h3>FNFS process form </h3> 
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card" >
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('FnfDetail', array(
                    'inputDefaults' => array(
                      'label' => false, 
                      'div' => false, 
                      'error' => array(
                        'wrap' => 'span', 
                        'class' => 'my-error-class'
                        )
                      ),
                    'url' => array(
                      'controller' => 'fnfs', 
                      'action' => 'process_fnf_detail'
                      ), 
                    'id' => 'separationid', 
                    'name' => 'separation_name')
                  );
                
                echo $this->Form->input('id',array(
                    'type' => 'hidden',
                    'value' => $fnf_det['FnfDetail']['id']

                    ));
                
//                echo "<pre>";
//                print_r($fnf_det);
//                
                ?>
                <h3 class="heading_a">FNFS process</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    
                
                    <!--<div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t"> HR\'s remark </label>
                            <?php
                             echo $this->form->textarea('t', array('label'=>false,'disabled'=>'disabled','value'=>$fnf_det['FnfDetail']['remarks'],'class'=>"md-input"));
                            ?>               
                        </div>
                    </div>-->
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp"> Your remark <span id = "star" style = "display:none">*</span></label>
                            <?php
                             echo $this->form->textarea('approver_remark', array('label'=>false,'id' => 'newfld','class'=>"md-input"));
                            ?>               
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id = "new">
                            <input type="radio" class="flat" name="data[FnfDetail][status]" value="5" checked="checked" id = "approve" onClick="return checkSubmit();"><strong> Approve </strong>
                  <input type="radio" class="flat" name="data[FnfDetail][status]" value="4" id = "reject" onClick="return checkSubmit();"><strong> Reject </strong>            
                        </div>
                    </div>
                   
                </div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top"> 
                        <?php  echo $this->Form->submit('Submit',array('class'=>'md-btn md-btn-success','value'=>'submit','onClick' => 'return checkSubmit()'));?>
                    </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
        </div>
   </div>
</div>



    <script type="text/javascript">
      $(function(){

             // Dialog
        $('#dialog').dialog({
          autoOpen: false,
          width: 600,
          modal:true,
          buttons: {
            "Ok": function() {
             var cmnt=$('#cmnt').val();
     
            if(cmnt==' ')
            {     
              $('#errdis').show('slow', function() {
                   // Animation complete.
            });
            return false;
          }else{
            $(this).dialog("close");
              document.leave.submit();
            }

          },
            "Cancel": function() {
              $(this).dialog("close");
            }
          }
        });
                         

      });

    </script>
<script>

function reject(wfid,compcode,vno,sdate,edate)
{
  var wfid=document.getElementById("wf_id").value=wfid;
      var compcode=document.getElementById("ccode").value=compcode;
      var leaveno=document.getElementById("leaveno").value=vno;
      var stdate=document.getElementById("stdate").value=sdate;
      edate=document.getElementById("eddate").value=edate;
        $('#dialog').dialog('open');
  return false;
}

function getcmtval()
{
      var leaveno=document.getElementById("cmnt").value;
      var rjres=document.getElementById("rejectres").value=leaveno;
    
}

function checkSubmit() {
    
    var selected = $("#separationid input[type='radio']:checked").val();
   if(selected == 4){
       $("#star").show();
       $('#newfld').attr('required',true);
       if($("#FnfDetailApproverRemark").val() == '') {
           $("html, body").animate({ scrollTop: 0 }, "slow");
          $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Remark").show();
          return false; 
        }
   } else if(selected == 5){
   $("#star").hide();
   $('#newfld').removeAttr('required');
   }
    return true;
  }

function star(val){
if(val == 4){
   $("#star").show();  
}else{
    $("#star").hide(); 
    } 
    }
</script>
