<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>All Rates</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of All Rates

                    <div class="clearfix"></div>
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Conveyance</th>
                                    <th>Wheeler Type</th>
                                    <th>Rate</th>
                                    <th>Effected Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($allRate as $rec) {
                                    ?>
                                    <tr>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i; ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getVehicalByID($rec['MstWheelerType']['vehical']); ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php
                                                if ($rec['MstWheelerType']['wheeler_type'] == '1') {
                                                    echo "Personal";
                                                } else {
                                                    echo "Commercial";
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['MstWheelerType']['price'] . " /KM"; ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['MstWheelerType']['effected_date'])); ?></span></td>

                                    </tr>
    <?php $i++;
} ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="uk-modal" id="modal_large">
    <div class="uk-modal-dialog uk-modal-dialog-large" >
        <button type="button" class="uk-modal-close uk-close"></button>
        <div id="showdata"></div>
    </div>
</div>