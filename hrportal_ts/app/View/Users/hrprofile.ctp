<div class="breadCrumbHolder module">
    <div class="breadCrumb	module" id="breadCrumb0">
        <ul>
            <li>
                <a title="Home" class="vtip" href="#">Home</a>
            </li>
            <li>Self Services </li>
            <li>Hr Profile </li>
        </ul>
    </div>
</div>
<h2 class="demoheaders">Hr Profile</h2>
<div class="travel-voucher1">
    <div class="input-boxs">
        <div class="travel-voucher1">
			<form action="" method="post" name="official_form" id="official_form" enctype="multipart/form-data">
				<!--fieldset>
					<legend>Employee Detail</legend-->
					<table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher">
					<tr class="head"><th>Name</th><th>Action</th></tr>
					<?php foreach ($user as $us)
						{ ?>
						<tr class="cont1">
							<td><?php echo $us['UserDetail']['emp_name']; ?></td>
							<td><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$this->webroot;?>users/empprofiletohr?doc_id=<?php echo $us['UserDetail']['doc_id'];?>">View / Edit</a></td>
						</tr>
						<?php } ?>
					</table>
				<!--/fieldset-->
			</form>
		</div>
	</div>
</div>