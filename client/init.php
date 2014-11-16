<?php
error_reporting(E_STRICT | E_ALL);

//$depth = '/../../../';
$depth = '';
define('SRC_PATH', dirname(__FILE__) . $depth . '/src/');
define('LIB_PATH', 'Google/Api/Ads/AdWords/Lib');
define('ADWORDS_VERSION', 'v201406');
define('UTIL_PATH', 'Google/Api/Ads/Common/Util');
define('ADWORDS_UTIL_PATH', 'Google/Api/Ads/AdWords/Util');


// Configure include path.
ini_set('include_path', implode(array(
    ini_get('include_path'), PATH_SEPARATOR, SRC_PATH
)));

// Include the AdWordsUser.
require_once LIB_PATH . '/AdWordsUser.php';
require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';
//require_once dirname(__FILE__) . '/../Common/ExampleUtils.php';

function pr($a){
    echo "<pre>";
    return print_r($a);
}
function formula_calculation($val1, $val2, $type) {
    $result = 0;
    $val1 = str_replace(',', '', $val1);
    $val2 = str_replace(',', '', $val2);
    //if ($val2 != 0) {
    $result = @number_format(($val1 / $val2) * $type, 2, '.', '');
    //}
    $result = str_replace(',', '', $result);
    return $result;
}