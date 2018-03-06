<?php
if (empty($jsonp)) {  
?>
    <div class="div-border1">
	<table class="table-bg" width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
            <td colspan="6" class="td-height1" style="font-weight:bold;"><?php if($rejectcmnt[0][0]['VC_REJECT_COMMENT']!="") { ?><?php echo $rejectcmnt[0][0]['VC_REJECT_COMMENT']; ?> <?php } else { ?> No Comment Found  <?php } ?></td>
        </tr>
        
        </table>
</div>
<?php
}else {
    echo "adfadsfadsfdshfkjad";
    $object = json_encode($addresses[0]['td_member_contact_details']);
    $i_contact_id = $addresses[0]['td_member_contact_details']['i_conatct_id'];
    echo "$jsonp($i_member_id,$i_contact_id,\"$organazation_name\",$object);";
}
?>