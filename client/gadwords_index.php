<?php
session_start();
if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}
include("include/setting.php");
$redirectUri = redirectUri;
?>
<style>
    .container_24 {
    margin-left: 1%;
    margin-right: 1%;
    width: 98%;
}
.wrapper {
    float: left;
    position: relative;
    width: 100%;
}
.contennmenu_wrap {
    margin-top: 128px;
}
body {
    color: #333333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 20px;
}
.grid_24 {
    display: inline;
    float: left;
    margin-left: 1%;
    margin-right: 1%;
    position: relative;
}
.border_1 {
    border: 1px solid #e1e1e1;
}
.p20 {
    padding: 20px;
}
.font_color10 {
    color: #007cbf !important;
}
.fontsz20 {
    font-size: 20px !important;
}
.border-bottom-blue {
    border-bottom: 1px solid #007cbf;
}
.pb10 {
    padding-bottom: 10px;
}
.mb10 {
    margin-bottom: 10px;
}
.fontsz18 {
    font-size: 18px;
}
.border_none {
    border: medium none !important;
}
.f_left {
    float: left;
}
.mb30 {
    margin-bottom: 30px;
}
.mt10 {
    margin-top: 10px;
}
.btn-lg, .input-group-lg .btn {
    display: inline-block;
    font-size: 14px;
    line-height: 20px;
    padding: 8px 12px;
}
.btn-info {
    background-color: #3498db;
}
.btn-info {
    background-color: #49afcd;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffffff;
}
a {
    text-decoration: none !important;
}
a {
    text-decoration: none;
}
</style>
<title>Adwords</title>
<div class="container_24 ">
 <?php
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	print "<a href='dashboard.php'>Dashboard</a></p>";
	?>
  <div class="wrapper">
    <div class="conten_wrapper">
      <div class="wrapper mb10">
        <div class="date_box grid_24 ">
          
        </div>
      </div>
      <div class="wrapper">
        <div class="grid_24">
          <div class="border_1 p20 wrapper">
            <div class="border-bottom-blue pb10 mb10 fontsz20 font_color10">Link Your Adwords Account</div>
            <div class="ppc-bullets">
              
            </div>
                <a href="Javascript:void(0);" onClick="window.parent.location.href='<?php echo $redirectUri;?>';" class="btn-lg btn-info f_left border_none fontsz18 mb30 mt10">Login with Google Account</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>

