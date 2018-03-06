<h2 class="heading_b">Behavioural Indicators</h2>
<table class="uk-table uk-text-nowrap" border="1">
    <thead>
        <tr class="md-bg-light-green-100">
            <th>Competency</th>
            <th>Behavioural Indicators</th>
        </tr>
    </thead>
    <tbody class="uk-text">
        <?php
        $competencyRatingList = $this->Common->findCompetencyBehvList($id);
        //echo "<pre>";print_r($competencyRatingList); die;
        foreach ($competencyRatingList as $list) {
            ?>
            <tr>   <?php if ($list['CompetencyBehaviour']['compitency_id'] != $idss) { ?>
                <td><?php echo $this->Common->findCompetencyNameByID($list['CompetencyBehaviour']['compitency_id']); ?></td>
                <?php } else { ?>
                    <td></td>
    <?php } ?>
                <td><?php echo wordwrap(ucfirst($list['CompetencyBehaviour']['behaviour_desc']), 120, "<br />\n"); ?></td>
            </tr>
    <?php $idss = $list['CompetencyBehaviour']['compitency_id'];
} ?>
    </tbody>