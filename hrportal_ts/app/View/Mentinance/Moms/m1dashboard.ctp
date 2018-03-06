<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
   
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Manager: MOM Dashboard</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>MOM Chart</h2>
                
                  
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div id="container" style="height: 400px"></div>
                  <br />
                   <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    <th scope="row">MOM ID</th>
                    <th class="column-title">Meeting Date</th>
                    <th class="column-title">Topic</th>
                    <th class="column-title">Sub Point</th>
                    <th class="column-title">Remark</th>
                    <th class="column-title">Action</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  
                           </tbody>
                          
                      </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

 <script type="text/javascript">
        $('.remark').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^\w ]/$,'') ); }
        );
 </script> 
        
<script type="text/javascript" >
        jQuery(document).ready(function() {
        jQuery("#startdate").datepicker({
                //inline: true,
                changeMonth: true,
                autoclose:true,
                 format: 'dd-mm-yy',
                
        });
    });
</script>
</div>
        <script type="text/javascript">
            $(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: false,
                alpha: 10,
                beta: 20,
                viewDistance: 25,
                depth: 50
            }
        },

        title: {
            text: 'Total MOM consumption, Grouped by Member'
        },

        xAxis: {
            categories: ['1','2','3','4','5','6','7']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Member'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2, 3, 5],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5, 6, 3],
            stack: 'f'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1, 4, 1],
            stack: 'g'
        }, {
            
            name: 'SSS',
            data: [2, 5, 6, 2, 1, 7, 8],
            stack: 'j'
        }, {           
            
            name: 'Janet',
            data: [3, 0, 4, 4, 3, 7, 9],
            stack: 'female'
        }]
    });
});


            
        </script>