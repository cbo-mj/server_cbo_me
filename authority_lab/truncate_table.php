<?php
// Report all errors except E_NOTICE
include("include/connection.php");
include("include/common_function.php");  

mysql_query("TRUNCATE TABLE  `authority_lab_domain` ") or die ( mysql_error() ) ;
//mysql_query("TRUNCATE TABLE  `authority_lab_domain_engine`") or die ( mysql_error() ) ;
//mysql_query("TRUNCATE TABLE  `authority_lab_domain_tag`") or die ( mysql_error() ) ;
mysql_query("TRUNCATE TABLE  `authority_lab_group`") or die ( mysql_error() ) ;
mysql_query("TRUNCATE TABLE  `authority_lab_keywords`") or die ( mysql_error() ) ;
//mysql_query("TRUNCATE TABLE  `authority_lab_keyword_tag`") or die ( mysql_error() ) ;
mysql_query("TRUNCATE TABLE  `authority_lab_ranks`") or die ( mysql_error() ) ;
//mysql_query("TRUNCATE TABLE  `authority_lab_ranks_google_engine`") or die ( mysql_error() ) ;
mysql_query("TRUNCATE TABLE  `authority_lab_ranks_history`") or die ( mysql_error() ) ;
					  
echo "Truncate Table Successfully...";	