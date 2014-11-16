<?php
require 'gapi.class.php';
require 'config.php';
$ga = new gapi(ga_email,ga_password);

if(isset($_POST['action']) && !empty($_POST['action'])) {
	
   	$frmdate 	= isset($_SESSION['from'])?explode("-",$_SESSION['from']):'';
    $todate 	= isset($_SESSION['to'])?explode("-", $_SESSION['to']):'';
    $startDate	= isset($_SESSION['from'])?date('Y-m-d', strtotime($frmdate[2]."-".$frmdate[0]."-".$frmdate[1])):date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
    $endDate	= isset($_SESSION['to'])?date('Y-m-d', strtotime($todate[2]."-".$todate[0]."-".$todate[1])):date('Y-m-t', mktime(0, 0, 0,date('m')-1, 1, date('Y')));
	
    $action = $_POST['action'];
    switch($action) {
        case 'visits' : getVisits_Pageviews_Newuser_Returninguser($ga,$startDate,$endDate,$startIndex,$maxResults);break;
        case 'keyword' : getTopVisitsByKeyword($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'pages' : getMostPopularPages($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'city' : getVisitByCity($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'referral' : getSearchengineReferral($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'browser' : getVisitsByWebBrowser($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'device' : getVisitsByMobileDevice($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'socialref' : getVisitsBySocial($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'previousMonth' : getVisitsBymonth($ga,$startDate,$endDate,$startIndex,$maxResults);break;
		case 'devicetype' : getDevicetype($ga,$startDate,$endDate,$startIndex,$maxResults);break;
        // ...etc...
    }
}

$previousYear = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')-1));
function getVisits_Pageviews_Newuser_Returninguser($ga,$startDate, $endDate, $startIndex, $maxResults)
{      
    
     $monthTotal = getReturnMOnth($startDate,$endDate); 
     if($monthTotal > 13) {
     	 $maxResults= $monthTotal;
     	 $_SESSION['monthTotal'] = $maxResults;
     }else{
     	$maxResults = '13';
     	//$_SESSION['monthTotal'] = '12';
     }
	$ga->requestReportData(ga_profile_id,array('userType'),array('visits','pageviews','visitors'),array('-visits'),'',$startDate, $endDate);
	foreach($ga->getResults() as $result)
	{
		$data_raw[(string)$result->getUserType()]=$result->getVisits();
	}
    $data['page_views'] = '';
    $data['visits'] = '';
	$data['returning']=$data_raw['Returning Visitor'];
	$data['new_visitor']=$data_raw['New Visitor'];
	$data['page_views']= $ga->getPageviews();
	$data['visits']=$ga->getVisits();
	$data['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
	
	$frmdate 	= isset($_SESSION['from'])?explode("-",$_SESSION['from']):'';
    $todate 	= isset($_SESSION['to'])?explode("-", $_SESSION['to']):'';
    $startDate	= isset($_SESSION['from'])?date('Y-m-d', strtotime($frmdate[2]."-".$frmdate[0]."-".$frmdate[1])):date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')-1));
    $endDate	= isset($_SESSION['to'])?date('Y-m-d', strtotime($todate[2]."-".$todate[0]."-".$todate[1])):date('Y-m-t', mktime(0, 0, 0,date('m')-1, 1, date('Y')));
	$ga->requestReportData(ga_profile_id,array('nthMonth'),array('visits','pageviews'),array('nthMonth'),'',$startDate, $endDate, $startIndex, $maxResults);
	
	//foreach (get_months($startDate, $endDate) as $monthName) {
	$data['month'] = get_months($startDate, $endDate);	
	
	//}
	//print_r($data['month']);
	
	foreach($ga->getResults() as $result)
	{

		$data['wk_visits'][]=(int)$result->getVisits();
		$data['wk_pages'][]=(int)$result->getPageviews();
		
	}//print_r($data); 
	 echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getTopVisitsByKeyword($ga,$startDate, $endDate, $startIndex, $maxResults)
{

	$data=array();
	$i=0;
	$filter = 'ga:keyword!=(not set)';
	$ga->requestReportData(ga_profile_id,array('keyword'),array('visits','pageviews'),array('-visits'),$filter,$startDate, $endDate, $startIndex, $maxResults);
	
	foreach($ga->getResults() as $result)
	{
		//echo $result->getKeyword()."-------------------".$result->getVisits()."<br>";
		$data[$i]['keyword']=$result->getKeyword();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	}
	 echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
	//echo $_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getMostPopularPages($ga,$startDate , $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('pagePath'),array('pageviews'),array('-pageviews'),'',$startDate, $endDate, $startIndex, $maxResults);
	foreach($ga->getResults() as $result)
	{
		//echo $result->getPagePath()."-------------------".$result->getPageviews()."<br>";
		$data[$i]['pagePath']=$result->getPagePath();
		$data[$i]['pageviews']=$result->getPageviews();
		$i++;
	}echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getVisitByCity($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('country','city'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach($ga->getResults() as $result)
	{
		//echo $result->getCountry()."---------".$result->getCity()."----------".$result->getVisits()."<br>";
		$data[$i]['city']=$result->getCity();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	} echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getSearchengineReferral($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	@$ga->requestReportData(ga_profile_id,array('source'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach(@$ga->getResults() as $result)
	{
		//echo $result->getCountry()."---------".$result->getCity()."----------".$result->getVisits()."<br>";
		$data[$i]['sources']=$result->getSource();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	} echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getVisitsByWebBrowser($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('browser'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach($ga->getResults() as $result)
	{
		//echo $result->getCountry()."---------".$result->getCity()."----------".$result->getVisits()."<br>";
		$data[$i]['browser']=$result->getBrowser();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	} echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getVisitsByMobileDevice($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('mobileDeviceInfo'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach($ga->getResults() as $result)
	{
		//echo $result->getCountry()."---------".$result->getCity()."----------".$result->getVisits()."<br>"; 
		$data[$i]['device']=$result->getmobileDeviceInfo();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	}
	//print_r($ga->getResults());
	   // $data['device']=$ga->getmobileDeviceInfo();
		//$data['visits']=$ga->getVisits();
		//$data['pages_visits']=round(($ga->getPageviews())/$ga->getVisits(),2);
	 echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
///Social Refrer

function getVisitsBySocial($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('socialNetwork'),array('visits','pageviews','organicSearches'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach($ga->getResults() as $result)
	{
		//echo $result->getCountry()."---------".$result->getCity()."----------".$result->getVisits()."<br>"; 
		$data[$i]['social']=$result->getsocialNetwork();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	}//print_r($result);
	
	echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}


function getVisitsBymonth($ga,$startDate, $endDate, $startIndex, $maxResults)
{

	$data=array();
	$i=0;
	$ga->requestReportData(ga_profile_id,array('visitCount'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);
	/*foreach($ga->getResults() as $result)
	{
		//echo $result->getKeyword()."-------------------".$result->getVisits()."<br>";
		//$data[$i]['keyword']=$result->getKeyword();
		$data[$i]['visits']=$result->getVisits();
		$data[$i]['pages_visits']=round(($result->getPageviews())/$result->getVisits(),2);
		$i++;
	}*/
	
	$data['visits'] = $ga->getVisits();
	$data['pages_views'] = $ga->getPageviews();
	
	
	echo $_GET['jsoncallback'] . '('.json_encode($data). ')';//$_GET['jsoncallback'] . '(' .array_to_json( $data ). ')';
}
function getDevicetype($ga,$startDate, $endDate, $startIndex, $maxResults)
{
	@$ga->requestReportData(ga_profile_id,array('deviceCategory'),array('visits','pageviews'),array('-visits'),'',$startDate, $endDate, $startIndex, $maxResults);

	foreach(@$ga->getResults() as $result)
	{
		$data_raw[(string)$result->getdeviceCategory()]=$result->getVisits();
	} 
	$data['desktop']=$data_raw['desktop'];
	$data['mobile']=$data_raw['mobile'];
	$data['tablet']=$data_raw['tablet'];
	echo $_GET['jsoncallback'] . '('.json_encode($data). ')';
}

function get_months($date1, $date2) {
//convert dates to UNIX timestamp
$time1  = strtotime($date1);
$time2  = strtotime($date2);
$tmp     = date('mY', $time2);

$months[] =  date('F', $time1);
//$months .= date('F', $time1).',';
while($time1 < $time2) {
  $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
  if(date('mY', $time1) != $tmp && ($time1 < $time2)) {
     $months[] = date('F', $time1);
      //$months .= date('F', $time1).',';
  }
}
$months[] = date('F', $time2);
 //$months .= date('F', $time2).',';
return $months; //returns array of month names with year
}




function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}
 function getReturnMOnth($startDate,$endDate)
{ 
	$date1 = date(strtotime($startDate));
	$date2 = date(strtotime($endDate));
	$difference = $date2 - $date1;
	$months = floor($difference / 86400 / 30 );
	
	return $months;
}
?>	