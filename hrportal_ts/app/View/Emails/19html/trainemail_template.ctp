<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td bgcolor="#f9f9f9" width="100%;" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#666666;">

                    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10px;">
                        <tr>
                            <td background="<?php echo ('http://' . $_SERVER['HTTP_HOST'] . $this->webroot . '/img/head-bg.jpg'); ?>" style="padding: 5px 5px 5px 10px;"><a href="#"><img src="<?php echo ('http://' . $_SERVER['HTTP_HOST'] . $this->webroot . '/img/ess-logo-newsletter.png'); ?>" width="174" height="34" alt="ESS" border="0" /></a></td>
                        </tr>
                        <tr>
                            <td style="border-left:1px solid #c6c6c6; border-right:1px solid #c6c6c6; border-bottom:1px solid #c6c6c6; background-color:#fff; padding:10px;">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td valign="top" width="90%" style="padding:20px 0px 0px 0px; line-height:23px;">Dear <?php echo $name; ?><br />
                                            <br />


                                            <?php echo $mesg; ?>

                                            <div style="clear:both;">Thanks & Regards<br />
                                                <?php if (isset($sign_off)) { ?>
                                                    <?php echo $sign_off; ?>

                                                <?php } else { ?>	
                                                    The Ess Team
                                                <?php } ?>
                                            </div> </td>
                                        <td valign="top" style="display:none;"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:10px; color:#9e9e9e; line-height:16px; padding-top:8px;">DISCLAIMER : This electronic mail transmission contains confidential information intended only for the person(s) named. Any use, distribution, copying or disclosure by any other person is strictly prohibited. If you received this transmission in error, please notify the sender by reply e-mail and then destroy the message. Opinions, conclusions, and other information in this message that do not relate to the official business of Eastern Software Systems Pvt. Ltd. shall understood to be neither given nor endorsed by Eastern Software Systems Pvt. Ltd. When addressed to Eastern Software Systems Pvt. Ltd. clients, any information contained in this e-mail is subject to the terms and conditions in the governing client contract.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
