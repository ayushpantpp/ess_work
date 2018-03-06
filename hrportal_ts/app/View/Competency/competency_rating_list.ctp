<h2 class="heading_b">Rating Guide</h2>
            <table class="uk-table uk-text-nowrap" border="1">
                <thead>
                    <tr class="md-bg-light-green-100">
                        <th>Rating Scale</th>
                        <th>Overall Achievement</th>
                        <th>Description of Rating</th>
                    </tr>
                </thead>
                <tbody class="uk-text-center">
                    <?php 
                            $competencyRatingList = $this->Common->findCompetencyRatingList();                                            
                            for ($i = 0; $i < count($competencyRatingList); $i++) {

                                    if ($competencyRatingList[$i]['CompetencyRating']['rating_scale'] == 1 && $competencyRatingList[$i]['CompetencyRating']['achievement_from'] == 60) {
                                            $overAllAchievement = "<".$competencyRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                    }else if ($competencyRatingList[$i]['CompetencyRating']['rating_scale'] == 5 && $competencyRatingList[$i]['CompetencyRating']['achievement_from'] >= 120) {
                                            $overAllAchievement = ">=".$competencyRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                    }else{
                                            $overAllAchievement = $competencyRatingList[$i]['CompetencyRating']['achievement_from']."% - ".$competencyRatingList[$i]['CompetencyRating']['achievement_to']."%";
                                    }

                    ?>
                            <tr>
                                    <td><?php echo $competencyRatingList[$i]['CompetencyRating']['rating_scale'];?></td>
                                    <td><b><?=$overAllAchievement;?></b></td>
                                    <td><?php echo ucfirst($competencyRatingList[$i]['CompetencyRating']['comment']);?></td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>