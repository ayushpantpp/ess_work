
<?php $auth=$this->Session->read('Auth'); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
type="text/javascript"></script>

<style type="text/css">
@import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");

#feedControl {
margin-top : 0px;
margin-left: 0px;
margin-right: 0px;

font-size: 12px;
color: #9CADD0;
}
.gfg-root{
    height:110px;
}
</style>
<script type="text/javascript">
function load() {
var feed ="https://news.google.co.in/news?cf=all&hl=en&pz=1&ned=us&output=rss";
new GFdynamicFeedControl(feed, "feedControl");

}
google.load("feeds", "1");
google.setOnLoadCallback(load);
</script>

<div class="content-main">
    <center><b>Welcome Admin</b></center>
</div>


