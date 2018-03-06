<?php
/**
 * 
 *	User login Detail Model
 * //DT_TRAINING_FEEDBACK_TRAINERS
 */
class TrainingTrainerFeedback extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'TrainingTrainerFeedback';

   
    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_feedback_trainers";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
    
	
    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = null; 


    /**
     *
     * Get Primary Key Value  
     *
     */ 

    /*
	function getPrimaryKey() {

        $count = $this->find('count');

        $primaryKey = $count + 1;

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = $i;

                $returnValue = $this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey)));

                if ($returnValue == 0) {

                    break;
                }

                $i++;
            }

            return $primaryKey;
        } else {

            return $primaryKey;
        }
    }	
	*/
}