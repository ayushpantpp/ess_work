<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- page content -->



    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Task Dashboard</h3><?php //Task Manager- General Manager Dashboard ?>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Tasks Details</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                  
                  <div class="x_content">
<div class="col-md-9">
       <div id="container1" class="col-md-4"></div>
        <div id="container0" class="col-md-4"></div>
        <div id="container2" class="col-md-4"></div>

        
        </div>
        <?php $statusnew=array(0=>'Very High',1=>'High',2=>'Medium',3=>'Low');?>

            <?php $status=array(0=>'New',1=>'Start',2=>'Working',3=>'Working',4=>'Working',5=>'Working',6=>'Complete',7=>'Approved');?>
    <div class="col-md-3">

<div id="container3" class="col-md-12"> </div>
     </div>            
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    <th scope="row">S.No.</th>
                    
                    <th class="column-title">Task Name</th>
                    <th class="column-title">Assign To</th>
                    <th class="column-title">Start Date</th>
                    <th class="column-title">End Date</th>
                    <th class="column-title">Priority</th>
                    <th class="column-title">Status</th>
                    <th class="column-title">Complete</th>
                    <th class="column-title">Details</th>
                    <th class="column-title">Notification</th>
                    <th class="column-title">Action</th>
                    <th class="column-title">Alert Update</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  <?php $j=1;?>
                  <?php foreach($tabledata as $data) { ?>
                        <tr>
                               
                               <td><?php echo $j;?></td> 
                               
                               <td><?php echo $data['TaskAssign']['tname']?></td>
                               <td onmouseover="tooltip(<?php echo $data['TaskAssign']['tid'];?>)" onmouseout="tooltip_left(<?php echo $data['TaskAssign']['tid'];?>)"><?php echo $data['TaskAssign']['assignto']?> <div id="dialog_<?php echo $data['TaskAssign']['tid']; ?>"></div></td>
                               <td><?php echo $data['TaskAssign']['starttime']?></td>
                               <td><?php echo $data['TaskAssign']['endtime']?></td>
                               <?php if($data['TaskAssign']['tpriority'] == '0'){$per = 'label label-danger';}
                                  if($data['TaskAssign']['tpriority'] == '1'){$per = 'label label-warning';}
                                   if($data['TaskAssign']['tpriority'] == '2'){$per = 'label label-info';}
                                    if($data['TaskAssign']['tpriority'] == '3'){$per = 'label label-success';}
                                ?> 
                               <td class="<?php echo $per; ?>"><?php $new= $data['TaskAssign']['tpriority']; echo $statusnew[$new];?></td>
                               <td><?php $newstatus= $data['TaskAssign']['fstatus']; echo $status[$newstatus];?></td>
                             

                                 <?php if($data['TaskAssign']['fstatus'] == '0'){$per = 0;}
                                       
                                    if($data['TaskAssign']['fstatus'] == '1'){$per = 0;}
                                    if($data['TaskAssign']['fstatus'] == '2'){$per = 10;}
                                    if($data['TaskAssign']['fstatus'] == '3'){$per = 30;}
                                    if($data['TaskAssign']['fstatus'] == '4'){$per = 50;}
                                    if($data['TaskAssign']['fstatus'] == '5'){$per = 80;}
                                    if($data['TaskAssign']['fstatus'] == '6'){$per = 100;}
                                    if($data['TaskAssign']['fstatus'] == '7'){$per = 100;}

                                ?>          <td ><?php echo $per;?>%<div class="progress tight">
                                                <div class="bar bar-success" style="width: <?php echo $per;?>%;"> </div>
                                            </div></td>
                               <td><a href="#popup1" class="btn btn-primary btn-xs" 
                                      onclick="Get_Details('<?php echo $data['TaskAssign']['tid'] ?>')" class="view vtip" title="Click to View.">Click To View</a></td>
                               
                                <td>
                                    <?php if($data['TaskAssign']['fstatus'] == '7'){ echo "--N/A--"; } else {?>
                                      <?php if($data['Alert']['statusid']==3 AND $data['Alert']['emp_reply']!="" ){?>
                                         
                                          <a href="#popup6" class="btn btn-danger btn-xs" 
                                                         onclick="Get_Details6('<?php echo $data['TaskAssign']['tid']?>')" title="Click to show Alert Update.">Show Update</a>
                                       <?php }
                                              elseif($data['Alert']['statusid']==1 AND $data['Alert']['emp_reply']!=""){
                                             ?>
                                                  <a href="#popup7" class="btn btn-success btn-xs" 
                                           onclick="Get_Details7('<?php echo $data['TaskAssign']['tid'] ?>')" class="view" title="Click to Send Alert.">Task Alert</a>
                                    
                                                  <!--<a href="sendalert/<?php //echo $data['TaskAssign']['tid']?>" class="btn btn-success btn-xs" title="Click to Send Alert.">Task Alert</a>-->
                                               
                                                   
                                              <?php } 
                                              elseif($data['Alert']['statusid']==8) { ?>
                                                   <a href="" disabled="disabled" class="btn btn-success btn-xs" title="Alert Send Successfully.">Alert Sent</a>
                                               
                                              <?php } else{?>
                                                    <a href="#popup7" class="btn btn-success btn-xs" 
                                           onclick="Get_Details7('<?php echo $data['TaskAssign']['tid'] ?>')" class="view" title="Click to Send Alert.">Task Alert</a>
                                <?php  } }?>
                    
                                    
                               </td>


                                <td> <?php if($data['TaskAssign']['fstatus'] == '7'){ ?>

                                      <a href="" class="btn btn-info btn-xs" title="Click to Task Edit." disabled="disabled">Edit</a> | 
                                     <?php } else {?>
                                    <a href="taskedit/<?php echo $data['TaskAssign']['tid']?>" class="btn btn-info btn-xs" title="Click to Task Edit.">Edit</a> | <?php } ?>
                                    <a href="taskdelete/<?php echo $data['TaskAssign']['tid']?>" class="btn btn-danger btn-xs" title="Click to Task Delete.">Delete</a>
                               </td>
                               <?php $j++; ?>

                              <td><a href="#popup10" class="btn btn-info btn-xs" 
                                      onclick="Get_Details10('<?php echo $data['TaskAssign']['tid'] ?>')" class="view vtip" title="Click to View.">Click Here</a></td>




                           </tr>
                           <?php  }?>
                           </tbody>
                          
                      </tbody>
                </table>
                </div>
                     <div class="navigation navigation-left" >
                    <?php echo $this->Paginator->counter(); ?> Pages
                    <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
                    <?php echo $this->Paginator->numbers(); ?>
                    <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                  </div>
              </div>
            </div>
          </div>
        </div >
        
      </div>

<script>

function Get_Details(id)
{   //alert(id);
      $('#overlay').show();
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/view2/'+id,
        success: function(data){
     // alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
}

function Get_Details6(id)
{  // alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/getalert/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent6').html(data);
        }
    });
}

function Get_Details10(id)
{  // alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/getalertupdate/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent10').html(data);
        }
    });
}


function Get_Details7(id)
{   //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/alertcomment/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent7').html(data);
        }
    });
}
 
 
</script>      

<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent"> 
      <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
    </div>    
  </div>
</div>

<div id="popup6" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent6"> 
      <div id="container" style="width: 400px; height: 300px; margin: 0 auto"></div>
    </div>    
  </div>
</div>

<div id="popup10" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent10"> 
      <div id="container" style="width: 400px; height: 300px; margin: 0 auto"></div>
    </div>    
  </div>
</div>

<div id="popup7" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent7"> 
      <div id="container" style="width: 400px; height: 300px; margin: 0 auto"></div>
    </div>    
  </div>
</div>



<div id="popup2" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> 
    </div>    
  </div>

</div>

<script type="text/javascript">


    function tooltip(id){
         $.get('<?php echo $this->webroot;?>tasks/tooltip/'+id, function(data){
        $('#dialog_'+id).html(data);
         //$('[data-toggle="dialog"]').tooltip();           
        });

    }
    function tooltip_left(id){
        $('#dialog_'+id).html('');

    }

    $(function () {
         //$('[data-toggle="tooltip"]').tooltip();
        $.get('<?php echo $this->webroot;?>tasks/chartdata', function(data){
            var jsonArr = JSON.parse(data);
            setPieChart(4,'Resource',jsonArr);
       
        });
       setMeterChart(0,'Completed',[<?php print_r($completedTask);?>]);
       setMeterChart(1,'Pending',[<?php print_r($pendingTask);?>]);
       setMeterChart(2,'New ',[<?php print_r($notstartedTask);?>]);
  
 function setMeterChart(id,titleText,chartData){
    $('#container'+id).highcharts({
    chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: titleText + ' Tasks'
            },
    		exporting:
    		{ enabled: false },

    		credits:{
    		enabled: false
    		}, pane: {
                startAngle: -120,
                endAngle: 120,
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: 20,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',

                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'Task'
                },
                plotBands: [{
                    from: 0,
                    to: 5,
                    color: '#55BF3B' // green
                }, {
                    from: 5,
                    to: 10,
                    color: '#DDDF0D' // yellow
                }, {
                    from: 10,
                    to: 20,
                    color: '#DF5353' // red
                }]
            },

            series: [{
                name: titleText + ' :',
                data: chartData,
                tooltip: {
                    valueSuffix: 'Tasks'
                }
            }]

        },
        // Add some life
        function (chart) {
            /*if (!chart.renderer.forExport) {
                setInterval(function () {
                    var point = chart.series[0].points[0],
                        newVal,
                        inc = Math.round((Math.random() - 0.5) * 2);

                    newVal = point.y + inc;
                    if (newVal < 0 || newVal > 20) {
                        newVal = point.y - inc;
                    }

                    point.update(newVal);

                }, 300);
            }*/
        });
}
    function setPieChart(id,title,chartData){
        $('#container3').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: title + ' Allocation'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.f}</b> Employee'
            },
            plotOptions: { 
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                    enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Assign To',
                colorByPoint: true,
                data: chartData
            }]
        });
    }
});


</script>

