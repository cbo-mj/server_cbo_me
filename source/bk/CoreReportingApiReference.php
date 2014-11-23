<?php
/*
 * Copyright 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Main demo class to illustrate how to access all the values returned by
 * the Core Reporting API using the Google API PHP client library. The demo
 * both queries the API and returns the results as an HTML string.
 *
 * Note: The apiAnalyticsService parameter in the constructor accepts requires
 * an apiClient object to be instantiated. This all happens outside of this
 * class. This client must be configured to $apiClient->setUseObjects(true);
 * so that the library returns an object representation of the API response
 * instead of the default representation of associative arrays.
 * @author Nick Mihailovski <api.nickm@gmail.com>
 */
class CoreReportingApiReference {

  /** @var apiAnalyticsService $analytics */
  private $analytics;

  /**
   * The Url of the main controller. Used to properly handle
   * redirects and strip the URL of additional authorization
   * parameters.
   * @var string $controllerUrl
   */
  private $controllerUrl;

  /** @var string $error */
  private $error = null;

  /**
   * Constructor.
   * @param $analytics
   * @param string $controllerUrl The Url for the main controller.
   * @internal param Google_AnalyticsService $analytics The analytics service
   *     object to make requests to the API.
   */
  function __construct(&$analytics, $controllerUrl) 
  {
    $this->analytics = $analytics;
    $this->controllerUrl;
  }


  /**
   * Returns a HTML string representation of all the data in this demo.
   * This method first queries the Core Reporting API with the provided
   * profiled ID. Then it formats and returns all the results as a string.
   * If any API errors occur, they are caught and set in $this->error.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return string The formatted results from the API.
   */
  function getHtmlOutput($tableId = null) {
  $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->queryCoreReportingApi($tableId);
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
   /**
   * Returns a HTML string representation of all the data in this demo.
   * This method first queries the Core Reporting API with the provided
   * profiled ID. Then it formats and returns all the results as a string.
   * If any API errors occur, they are caught and set in $this->error.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return string The formatted results from the API.
   */
  function getHtmlOutput_new($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->queryCoreReportingApi_new($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }

  /**
   * Queries the Core Reporting API for the top 25 organic search terms
   * ordered by visits. Because the table id comes from the query parameter
   * it needs to be URI decoded.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return GaData The results from the Core Reporting API.
   */
   function queryCoreReportingApi($tableId) {

    $optParams = array(
        'dimensions' => 'ga:source,ga:keyword',
        'sort' => '-ga:visits,ga:keyword',
        'filters' => 'ga:medium==organic',
        'max-results' => '50');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        '2014-04-01',
        '2014-08-11',
        'ga:visits',
        $optParams);
		
		
		/*	https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A88002406&metrics=ga%3Asessions&start-date=2014-07-27&end-date=2014-08-10&max-results=50
	
	
	ids	=	ga:88002406
	metrics	=	ga:sessions
	start-date	=	2014-07-27
	end-date	=	2014-08-10
	max-results	=	50*/
  }
  
  
  
  
  function queryCoreReportingApi_new($tableId,$from,$to) {

    $optParams = array(
        'dimensions' => 'ga:date,ga:source,ga:keyword,',
        'sort' => '-ga:visits,ga:keyword',
        'filters' => 'ga:medium==organic',
        'max-results' => '50');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:visits',
        $optParams);
		
  }
  
  
  function get_visitors_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
        'dimensions' => 'ga:date,ga:source,ga:keyword',
		// 'dimensions' => 'ga:date',
        'sort' => '-ga:visits,ga:keyword',
        'filters' => 'ga:medium==organic',
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:visits',
        $optParams);
		
	
  }
  
  
  function get_ga_session_and_ga_pageviews_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
        'dimensions' => 'ga:date,ga:source,ga:keyword',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
	    'dimensions' => 'ga:date',
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:sessions,ga:pageviews',
        $optParams);
		
	
  }
  
  
   /**
   * Returns a HTML string representation of all the data in this demo.
   * This method first queries the Core Reporting API with the provided
   * profiled ID. Then it formats and returns all the results as a string.
   * If any API errors occur, they are caught and set in $this->error.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return string The formatted results from the API.
   */
  function getHtmlOutput_session_and_pageviews($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_ga_session_and_ga_pageviews_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
  
  function get_avgSessionDuration_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
       'dimensions' => 'ga:date,ga:source,ga:keyword',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
	    'dimensions' => 'ga:date',
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:avgSessionDuration',
        $optParams);
		
	
  }
  
  
  function getHtmlOutput_avgSessionDuration($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_avgSessionDuration_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
   function get_pageviews_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
       'dimensions' => 'ga:date,ga:userType,ga:source,ga:keyword,ga:browser,ga:operatingSystem,ga:country',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
	   
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:pageviews',
        $optParams);
		
	
  }
  
  
  function getHtmlOutput_pageviews($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_pageviews_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
  
  function get_bounceRate_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
       'dimensions' => 'ga:date,ga:source,ga:keyword',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
	   
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:bounceRate',
        $optParams);
		
	
  }
  
  
  function getHtmlOutput_bounceRate($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_bounceRate_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
  
  function get_percentNewSessions_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
       'dimensions' => 'ga:date,ga:source,ga:keyword',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:percentNewSessions',
        $optParams);
		
	
  }
  
  
  function getHtmlOutput_percentNewSessions($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_percentNewSessions_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
  
  
   function get_totalEvents_queryCoreReportingApi($tableId,$from,$to) {

     $optParams = array(
        'dimensions' => 'ga:date,ga:source,ga:keyword',
      //  'sort' => '-ga:visits,ga:keyword',
       // 'filters' => 'ga:medium==organic',
        'max-results' => '500');

    return $this->analytics->data_ga->get(
        urldecode($tableId),
        $from,
        $to,
        'ga:totalEvents',
        $optParams);
		
	
  }
  
  
  function getHtmlOutput_totalEvents($tableId = null,$from,$to) {
 // $output = $this->getHTMLForm($tableId);

    if (isset($tableId)) {
      try {
        $results = $this->get_totalEvents_queryCoreReportingApi($tableId,$from,$to);
		
		/*print_r("<pre>");
		print_r( $results ); die;*/
		
        $output .= $this->getFormattedResults($results);

      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }
  
 
  

  /**
   * Returns the results from the API as a HTML formatted string.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getFormattedResults(&$results) {
    return implode('', array(
        $this->getReportInfo($results),
        $this->getPaginationInfo($results),
        $this->getProfileInformation($results),
        $this->getQueryParameters($results),
        $this->getColumnHeaders($results),
        $this->getTotalsForAllResults($results),
        $this->getRows($results)
    ));
    
  }

  /**
   * Returns general report information.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getReportInfo(&$results) {
    return <<<HTML
<h3>Report Information</h3>
<pre>
Contains Sampled Data = {$results->getContainsSampledData()}
Kind                  = {$results->getKind()}
ID                    = {$results->getId()}
Self Link             = {$results->getSelfLink()}
</pre>
HTML;
  }

  /**
   * Returns pagination information.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getPaginationInfo(&$results) {
    return<<<HTML
<h3>Pagination Info</h3>
<pre>
Items per page = {$results->getItemsPerPage()}
Total results  = {$results->getTotalResults()}
Previous Link  = {$results->getPreviousLink()}
Next Link      = {$results->getNextLink()}
</pre>
HTML;
  }

  /**
   * Returns profile information describing the profile being accessed
   * by the API.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getProfileInformation(&$results) {
    $profileInfo = $results->getProfileInfo();

    return<<<HTML
<h3>Profile Information</h3>
<pre>
Account ID               = {$profileInfo->getAccountId()}
Web Property ID          = {$profileInfo->getWebPropertyId()}
Internal Web Property ID = {$profileInfo->getInternalWebPropertyId()}
Profile ID               = {$profileInfo->getProfileId()}
Table ID                 = {$profileInfo->getTableId()}
Profile Name             = {$profileInfo->getProfileName()}
</pre>
HTML;
  }

  /**
   * Returns all the query parameters in the initial API query.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getQueryParameters(&$results) {
    $query = $results->getQuery();

    $html = '<h3>Query Parameters</h3><pre>';
    foreach ($query as $paramName => $value) {
      $html .= "$paramName = $value\n";
    }
    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns all the column headers for the table view.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getColumnHeaders(&$results) {
    $html = '<h3>Column Headers</h3><pre>';

    $headers = $results->getColumnHeaders();
    foreach ($headers as $header) {
      $html .= <<<HTML

Column Name = {$header->getName()}
Column Type = {$header->getColumnType()}
Data Type   = {$header->getDataType()}

HTML;
    }

    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns the totals for all the results.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getTotalsForAllResults(&$results) {

    $rowCount = count($results->getRows());
    $totalResults = $results->getTotalResults();

    $html = '<h3>Total Metrics For All Results</h3>';
    $html .= "<p>This query returned $rowCount rows. <br>";
    $html .= "But the query matched $totalResults total results. <br>";
    $html .= 'Here are the metric totals for the matched results.</p>';
    $html .= '<pre>';

    $totals = $results->getTotalsForAllResults();
    foreach ($totals as $metricName => $metricTotal) {
      $html .= "Metric Name  = $metricName\n";
      $html .= "Metric Total = $metricTotal";
    }
    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns the rows of data as an HTML Table.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getRows($results) {
    $table = '<h3>Rows Of Data</h3>';

    if (count($results->getRows()) > 0) {
      $table .= '<table border="1" width="100%">';

      // Print headers.
      $table .= '<tr>';

      foreach ($results->getColumnHeaders() as $header) {
        $table .= '<th> ' . $header->name . ' </th>';
      }
      $table .= '</tr>';

      // Print table rows.
      foreach ($results->getRows() as $row) {
        $table .= '<tr>';
		   $i = 1;
          foreach ($row as $cell) {
			  
			  if($i==1)
			  {
					$cell = date("Y-m-d",strtotime($cell));  
			  }
			  
            $table .= '<td align="center"> '
                   . htmlspecialchars($cell, ENT_NOQUOTES)
          
		           . ' </td>';
          
		  $i++;
		  }
        $table .= '</tr>';
      }
      $table .= '</table>';

    } else {
      $table .= '<p>No results found.</p>';
    }

    return $table;
  }

  /**
   * Returns an HTML form for the user to supply their Table ID. This
   * form uses GET to pass the tableId back to the controller. The
   * controller
   * then passes the ID onto the demo.
   * @param string $tableId The table ID value to add to the HTML form
   * @return string The HTML form.
   */
  private function getHtmlForm($tableId) {
    $tableId = htmlspecialchars($tableId);

    return <<<HTML
<form name="gaForm" action="$this->controllerUrl" method="get">
  <p>Please enter your Table ID <input type="text" id="tableId" name="tableId" value="$tableId"></p>
  <p>Format should be ga:xxx where xxx is your profile ID.</p>
  <input type="hidden" name="demo" value="reporting">
  <input type="submit" value="Run the demo with your table ID" />
</form>
<hr>
HTML;
  }



 /**
  * @return string Any error that occurred.
  */
  function getError() {
    return $this->error;
  }


function getProfileId(&$analytics) {

    //function getFirstprofileId(&$analytics) {
		
		

      $accounts = $analytics->management_accounts->listManagementAccounts();

        $num = count($accounts->getItems());


        for ($i=1; $i < $num; $i++) { 

          if (count($accounts->getItems()) > 0) {

            $items = $accounts->getItems();
            $firstAccountId = $items[$i]->getId(); 
            //item 0 is an account that gets listed but doesn't have any webproperties.  
            //This account doesn't show in our analytics

            $webproperties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
			
			

            if (count($webproperties->getItems()) > 0) {

              $items = $webproperties->getItems();
              $firstWebpropertyId = $items[0]->getId();

              $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstWebpropertyId);

              if (count($profiles->getItems()) > 0) {

                $items = $profiles->getItems();

                $profileId = $items[0]->getId();

              //  print "<p>Profile ID (not account id): ".  $profileId."</p>";
			  
			   print "<p>  $firstAccountId : ".  $profileId."</p>";
			  
			  
			  



              } else {
                throw new Exception('No profiles found for this user.');
              }
            } else {
              throw new Exception('No webproperties found for this user.');
            }
          } else {
            throw new Exception('No accounts found for this user.');
          }

      }

    }




}

