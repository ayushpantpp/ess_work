
<!-- <script src="<?php echo $this->webroot ?>js/js/altair_admin_common.min.js"></script> -->


<?php $empList = $this->Common->getAllEmployeeListDepartment($dept_code, $comp_code);
?>
<div class="uk-grid">
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <?php
            echo $this->form->input('emp_id', array('label' => "Employee List", 'type' => "select", 'empty' => ' -- Select Employee --', 'options' => $empList, 'class' => "md-input", 'id' => 'emp_id', 'data-md-selectize', 'required' => TRUE, 'onChange' => 'return getEmployeeDesg(this.value)'));
            ?>                                                            
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <span id="empDesg"></span>
        </div>
    </div>
</div>

    <?php $this->common->findDesignationName(); ?>

    <script type="text/javascript">

        function getEmployeeDesg(empId) {

            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>Competency/empdesg/' + empId,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#empDesg").html(data);
                }
            });
        }
    </script>