<?php
foreach ($QuanQual as $rec)
    ;

if ($TypeId == '1') {
    ?>
    <hr>
    <h3 class="heading_a" style="text-align: center">Quantitative</h3>
    <hr>

    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="MDA"><b>MDA :</b></label>
                <span><?php echo $rec['Ministry']['ministry_name']; ?></span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Thematic Area :</b></label>
                <span><?php echo $rec['CASetType']['set_name']; ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Type :</b></label>
                <span><?php echo "Quantitative"; ?></span>
            </div>
        </div>

    </div>


    <div  class="uk-grid" data-uk-grid-margin>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Performance Indicator :</b></label>
                <span><?php echo $perf_indic['CADescThematicArea']['performance_indicator']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Measurement :</b></label>
                <span><?php
                    $measurType = array("1" => "Number", "2" => "Percent(%)", "3" => "Ratio", "4" => "Boolean(Yes/No)", "5" => "Character");
                    foreach ($measurType as $key => $val) {
                        if ($key == $rec['CAQuantitativeQualitative']['measurement_type']) {
                            echo $val;
                        }
                    }
                    ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Comment :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['comment']; ?></span>

            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
<?php } elseif ($TypeId == '2') {
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Qualitative</h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="MDA"><b>MDA :</b></label>
                <span><?php echo $rec['Ministry']['ministry_name']; ?></span>

            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Thematic Area :</b></label>
                <span><?php echo $rec['CASetType']['set_name']; ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Type :</b></label>
                <span><?php echo "Qualitative"; ?></span>
            </div>
        </div>

    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Description :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['description']; ?></span>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Performance Standards :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['performance_standard']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Performance Indicator :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['performance_indicator_qual']; ?></span>

            </div>
        </div>
    </div>


    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Analysis of the findings  :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['analysis_finding']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Progress achieved :</b></label>
                <span><?php echo $rec['CAQuantitativeQualitative']['progress_achieve']; ?></span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Challenges faced :</b></label>
                <span>
    <?php echo $rec['CAQuantitativeQualitative']['challenge_face']; ?></span>

            </div>
        </div>
    </div>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Recommendations :</b></label>
                <span>
    <?php echo $rec['CAQuantitativeQualitative']['recommendation']; ?>
                </span>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject"><b>Conclusion  :</b></label>
                <span> <?php echo $rec['CAQuantitativeQualitative']['conclusion']; ?></span>

            </div>
        </div>
    </div>
<?php } ?>

