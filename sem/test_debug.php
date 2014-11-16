<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>


<?php include('head_include1.php');?>
<script type="text/javascript">
AmCharts.themes.none = {};
</script>
<style>
	#chartfunnel {
		margin:0 auto;
		width:80%;
		height		: 435px;
		font-size	: 11px;
	}	
</style>
</head>

<body class="hybrid" style="overflow-x:hidden;">

	<?php  include('funnel_trend2.php');?>		
    <div id="chartfunnel"></div>


</body>
</html>