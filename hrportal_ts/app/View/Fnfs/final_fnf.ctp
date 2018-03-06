<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>FNFS Details</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content">
                <h3 class="heading_a uk-margin-small-bottom">List of FNFS Details</h3>

                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Employee</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ctr = 1;
                            foreach ($finalfnf as $value) {
                                ?>
                                <tr>
                                    <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr; ?> </td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getempinfo($value['Fnf']['emp_code']); ?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findSatus($value['Fnf']['status']); ?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ($value['Fnf']['created']) ? date("d-M-Y", strtotime($value['Fnf']['created'])) : 'NA'; ?></span></td>
                                    <td>

                                        <?php if ($value['Fnf']['status'] == 1) { ?>
                                            <a class="btn btn-success" href="<?php echo $this->Html->url('/fnfs/other_users/') . $value['Fnf']['id']; ?>">Approve</a> 
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $ctr++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="ln_solid"></div>
                </div>
            </div>   
        </div>
    </div>
</div>