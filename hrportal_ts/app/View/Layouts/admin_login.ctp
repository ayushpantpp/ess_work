
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot.('img/favicon.png');?>">
        <?php
        echo $this->Html->script('acl/jquery-1.5.1.min.js');
        echo $this->Html->script('acl/jquery-ui-1.8.13.custom.min.js');
        echo $this->Html->script('acl/jquery.dropdownPlain.js');
        echo $this->Html->css('acl/style.css');
        echo $this->Html->css('acl/jquery-ui-1.8.13.custom.css');
        ?>
    </head>
    <body>
        <div class="body-bg">
        <div class="wrpper">
            <!-- Header Starts -->
            <div class="new-messsages">
                <?php  //if($this->Session->flash()!=''){ ?>
                    <script type="text/javascript">$(document).ready(function(){$('#flashMessage').addClass("ui-state-highlight");})</script>
                    <?php //echo "<span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";?>
                    <cake:nocache>
			  <?php echo "<p>".$this->Session->flash()."</p>";?>
			  </cake:nocache>
                <?php //} ?>
            </div>
         <?php echo $this->element('admin_login_header'); ?>
            <!-- Header Ends -->

            <!-- Center Content Starts -->
            <div class="center-content">
           
                <!-- Left Content Starts -->
				
		       
               <?php echo $content_for_layout; ?>
			  

            </div>
            <!-- Center Content Ends -->
        </div>
        </div>
        <!-- Footer Starts -->

       <?php echo $this->element('admin_login_footer'); ?>
        <?php echo $this->element('sql_dump'); ?>
        <!-- Footer Ends -->

    </body>
</html>