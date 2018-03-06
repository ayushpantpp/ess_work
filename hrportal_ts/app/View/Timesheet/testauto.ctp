<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
            <div class="md-card-content large-padding">
<div class="frmSearch">
	<input type="text" id="search-box" placeholder="Country Name" />
	<div id="suggesstion-box"></div>
</div>
</div>
</div>

<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "getdtl",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#32CD32 url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});
//To select country name
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>