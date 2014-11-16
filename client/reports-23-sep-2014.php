<?php

class AdwordsReports {

    function __construct() {
        
    }

    function DownloadCampaignPerfomanceReport(AdWordsUser $user, $filePath) {
        $reportQuery = 'SELECT CampaignId, CampaignName, CampaignStatus,Impressions, Clicks,AverageCpc,Ctr FROM CAMPAIGN_PERFORMANCE_REPORT DURING LAST_30_DAYS';
        $options = array('version' => ADWORDS_VERSION);
        ReportUtils::DownloadReportWithAwql($reportQuery, $filePath, $user, 'CSV', $options);

        return $filePath;
    }

    function ProcessCampaignsReport($fileName, $clientId) {
        $handle = fopen($fileName, "r");
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            $content [] = $data;
        }

        $tmp_a = array_pop($content);
        $tot_data_daywise[] = $content[0];
        $tot_data_daywise[] = $content[1];
        $tot_data_daywise[] = $tmp_a;

        foreach ($content as $i => $value) { //For getting key in array above which all elements will be removed
            if (in_array("Campaign state", $value) && in_array("Campaign", $value)) {
                $report_header_key = $i;
                break;
            }
        }
        for ($i = 0; $i < $report_header_key; $i++) { //For remove elements
            unset($content [$i]);
        }

        $row = sizeof($content);
        $this->content = $content;
        $this->report_header_key = $report_header_key;
        $this->campaign_state = array_search('Campaign state', $content [$report_header_key]);
        $this->campaign_id = array_search('Campaign ID', $content [$report_header_key]);
        $this->campaign_name = array_search('Campaign', $content [$report_header_key]);
        $this->impressions = array_search('Impressions', $content [$report_header_key]);
        $this->clicks = array_search('Clicks', $content [$report_header_key]);
        $this->avg_cpc = array_search('Avg. CPC', $content [$report_header_key]);
        $this->ctr = array_search('CTR', $content [$report_header_key]);
        $this->insert_data($clientId);
    }

    function insert_data($client_id) {
        $limit = 40;
        $str = "INSERT INTO `aw_campaign_details` (`client_id`,`campaign_id`,
                `campaign_name`,`campaign_state`,`impressions`,`clicks`,`avg_cpc`,`ctr`) VALUES ";
        $string = $str;

        foreach ($this->content as $i => $row) {
            if ($i > $this->report_header_key) {
                $str.="(";
                $str.="'" . $client_id . "',";
                $str.="'" . $row[$this->campaign_id] . "',";
                $str.="'" . mysql_real_escape_string($row[$this->campaign_name]) . "',";
                $str.="'" . $row[$this->campaign_state] . "',";
                $str.="'" . $row[$this->impressions] . "',";
                $str.="'" . $row[$this->clicks] . "',";
                $str.="'" . str_replace(',', '', $row[$this->avg_cpc]) / 1000000 . "',";
                $str.="'" . str_replace(',', '', $row[$this->ctr]) . "'";
                $str.="),";
            }

            if ($i % $limit == 0) {
                $str = rtrim($str, ',');
                mysql_query($str) or die(mysql_error() . $str);
                $str = $string;
            }
        }
        if ($i % $limit != 0 && $i != 1) {
            $str = rtrim($str, ',');
            mysql_query($str) or die(mysql_error() . $str);
            $str = $string;
        }
    }

    function removeData($client_id) {
        $str = "delete from aw_campaign_details where client_id=$client_id";
        mysql_query($str) or die(mysql_error() . $str);
    }

    function getData($client_id) {
        $sql = "SELECT client_id,campaign_id,campaign_name,SUM(`clicks`) AS clicks_sum,
               SUM(`impressions`) AS impressions,FORMAT(AVG(avg_cpc),2) as avg_cpc,
               FORMAT((sum(clicks)/sum(impressions))*100,2) AS ctr
               FROM (`aw_campaign_details`)
               WHERE client_id = $client_id group by campaign_id";
        $res1 = mysql_query($sql) or die(mysql_error() . $sql);
        $array = array();
        if (mysql_num_rows($res1) != 0) {
            while ($res = mysql_fetch_assoc($res1)) {
                $array[] = $res;
            }
        }
        return $array;
    }

}

?>