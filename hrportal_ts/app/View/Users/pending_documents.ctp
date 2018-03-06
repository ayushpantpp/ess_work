
<script>
    jQuery(document).ready(function () {
        jQuery(".allpendingDocs").change(function () {
            jQuery(".pendingDocs").prop('checked', jQuery(this).prop("checked"));
        });
    });
</script>

<?php $i = 0; ?>

<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Document List</h3>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <?php echo $this->Form->create('pendingDocuments', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'Users', 'action' => 'pendingDocuments'), 'id' => 'pendingDocuments', 'name' => 'pendingDocuments'));
                ?> 

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Check </th>
                                <th>Employee Name</th>
                                <th>Title</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                    Check All       <?php echo $this->Form->input('allpendingDocs' . $key, array('type' => 'checkbox', 'class' => 'allpendingDocs')); ?>
                            <?php
                            if (empty($documents)) {
                                echo "<tr><td colspan='4'>No Record Found</td></tr>";
                            } else {
                                foreach ($documents as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $this->Form->input('pending_docs.' . $key, array('type' => 'checkbox', 'class' => 'pendingDocs')); ?><?php echo $this->Form->input('pending_docs_vl.' . $key, array('type' => 'hidden', 'value' => $documents[$key]['EmpDocuments']['id'])); ?></td>
                                        <td><?php echo $this->Common->findEmpName($documents[$key]['EmpDocuments']['emp_code']); ?></td>
                                        <td><a href="<?php echo $this->webroot . 'uploads/document/' . $documents[$key]['EmpDocuments']['documents']; ?>" target="_blank"><?php echo $documents[$key]['EmpDocuments']['title'] ?></a></td>
                                        <td><?php echo $documents[$key]['EmpDocuments']['created_at']; ?></td>
                                    </tr>
    <?php }
}
?>                      
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>

 <?php echo $this->Form->submit('SAVE', array('name' => 'settingsave', 'class' => 'md-btn md-btn-success')); ?>
            


               <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>
               </div>

            <div id="container" ></div>
        </div>






