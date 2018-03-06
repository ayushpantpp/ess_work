<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Error Occurred</h1>
    </div>
    <div id="page_content_inner">
        <div class="md-card">  
            <div class="md-card-content large-padding">
            <div class="error_page_header">
        <div class="uk-width-8-10 uk-container-center">
        </div>
    </div>
    <div class="error_page_content">
        <div class="uk-width-8-10 uk-container-center">
            <h2><?php echo $message; ?></h2>
            <p class="uk-text-large">
                The Page Do Not exist , please check if URL is correct or not.
               
            </p>
            <a href="#" onclick="history.go(-1);return false;">Go back to previous page</a>
        </div>
    </div>
                <?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
 </div>
    </div>
</div>






