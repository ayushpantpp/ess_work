<span class="uk-text-upper uk-text-small"><h3>Uploaded Files !</h3></span>

<div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Uploaded Files</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($Allfiles as $rec){
                            
                            ?>
                            <tr>
                                <td class="uk-text-small uk-text-center"><?php echo $i; ?> </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseFiles']['file_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" href="<?php echo $this->Html->url('download/'.$rec['CaseFiles']['id']); ?>">View</a>
                                    </span>
                                </td>
                                
                                
                            </tr>
                            <?php $i++; }?>
                        </tbody>
                    </table>
                </div>


 