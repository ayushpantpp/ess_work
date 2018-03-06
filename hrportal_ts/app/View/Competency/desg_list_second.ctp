<!-- <script src="<?php echo $this->webroot ?>js/js/altair_admin_common.min.js"></script> -->
<?php $desgList = $this->Common->getAllDesignationByDept($deptCode); ?>

<div class="uk-width-medium-1-2">
    <label>Designation List</label>
    <div class="parsley-row"> 
        <select name="data[desg_id]" required="" id="employee_id" class="md-input" data-placeholder="Select Designation..." data-md-selectize = "data-md-selectize" onChange = 'return getEmployeebyDesg(this.value)'>
            <option value=''> -- Select Designation -- </option>
            <?php
            $p = "01";
            foreach ($desgList as $k) {
                ?>
            <option value='<?php echo $k ?>'> <?php echo ucwords(strtolower($this->Common->findDesignationName($k, $p))); ?></option>
        <?php } ?>
        </select> 
    </div>
</div>

<div class="uk-width-medium-1-2" id="empList1"></div>


<script type="text/javascript">

        function getEmployeebyDesg(desgCode) {

            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>Competency/EmpListSecond/' + desgCode+"/<?php echo $deptCode;?>",
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#empList1").html(data);
                }
            });
        }
    </script>



