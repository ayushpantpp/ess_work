<?php
$auth = $this->Session->read('Auth');
//$auth['User']['comp_code'];
?><div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Configurations
            </li>
            <li>
                Synchronization Control
            </li>            
        </ul>
    </div> 

</div>
<br>
<div id="add_msg_div" style=" margin-bottom: 160px;">
    <h2 class="demoheaders">Synchronization Modules<a href="#" id="create"></a></h2>
    <div class="travel-voucher" style="padding-bottom: 0;padding-top: 0;height: 100%;opacity: 0.6;background: -webkit-linear-gradient(brown 30%, white);">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="100" cellpadding="10" align="center" style="margin:0px auto;">
                <tr>
                    <td align="center">
                        <button class="sync-button button" id="attendence_sync">Sync Attendence</button><br>
                        <strong style="color: black!important;font-weight:10px;">Last Sync: </strong><span style="color: black!important;"></span>
                    </td>
                    <td align="center">
                        <button class="sync-button" id="leave_sync">Sync Leaves</button><br>
                        <strong style="color: black!important;">Last Sync: </strong><span style="color: black!important;"></span>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <button class="sync-button" id="salary_sync">Sync Salaries</button><br>
                        <strong style="color: black!important;">Last Sync: </strong><span style="color: black!important;"></span>
                    </td>
                    <td align="center">
                        <button class="sync-button" id="db_backup">Backup Database </button><br>
                        <strong style="color: black!important;">Last Backup: </strong><span style="color: black!important;"></span>
                    </td>
                </tr>

            </table>
        </div>
    </div>

</div>


</div>


<style>
    .sync-button{
        width: 60%;
        height: 100px;
        border-radius: 8px;
        color: black!important;
    }
    #attendence_sync{
        background-color: #5bc0de;
        border-color: #46b8da;
    }
    #leave_sync{
        background-color: #f44336;
        border-color: #46b8da;
    }
    #salary_sync{
        background-color: #795548;
        border-color: #795548;
    }
    #db_backup{
        background-color: #cddc39;
        border-color: #cddc39;
    }
    .sync-button {
        border-radius: 4px;
        /*background-color: #f4511e;*/
        border: none;
        color: #FFFFFF;
        text-align: center;
        font-size: 28px;
        padding: 20px;
        width: 200px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 5px;
    }

    .sync-button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .sync-button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .sync-button:hover span {
        padding-right: 25px;
    }

    .sync-button:hover span:after {
        opacity: 1;
        right: 0;
    }
</style>
<script>
    $(document).ready(function () {
        jQuery('.sync-button').click(function () {
            bool = confirm('Are you sure you want continue with this operation');
            if (bool) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot ?>Configurations/syncData/",
                    data: {"sync_value": jQuery(this).attr('id')},
                    success: function (resp) {
                        alert(resp);
                        location.reload();
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

        });
        $.getJSON("<?php echo $this->webroot ?>Configurations/lastSync/", function (resp) {
            if (resp) {
                Object.keys(resp).forEach(function (k) {
                    $('#' + k).next().next().next().text(resp[k]);

                });
            }
        });
    });

</script>