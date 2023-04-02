<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';
$ViewID = "";
$start_date = date("Y-m-01");
$end_date = date("Y-m-d");
$date_range = "";

if (isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != '') {
    $start_date = $_REQUEST['start_date'];
}
if (isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != '') {
    $end_date = $_REQUEST['end_date'];
}
if (isset($_REQUEST['date_range']) && $_REQUEST['date_range'] > 0) {
    $date_range = $_REQUEST['date_range'];
}

$analytics = initializeAnalytics();
$response = getReport($analytics, $ViewID, $start_date, $end_date);
$age = getAge($analytics, $ViewID, $start_date, $end_date);
$gender = getGender($analytics, $ViewID, $start_date, $end_date);
$country = getCountry($analytics, $ViewID, $start_date, $end_date);
$city = getCity($analytics, $ViewID, $start_date, $end_date);
$device = getDevices($analytics, $ViewID, $start_date, $end_date);
$sourceMedium = getSourceMedium($analytics, $ViewID, $start_date, $end_date);
$referral = getReferral($analytics, $ViewID, $start_date, $end_date);
$user = getUser($analytics, $ViewID, $start_date, $end_date);
$channel = getChannel($analytics, $ViewID, $start_date, $end_date);
$topPages = getTopPages($analytics, $ViewID, $start_date, $end_date);

///**
// * Initializes an Analytics Reporting API V4 service object.
// *
// * @return An authorized Analytics Reporting API V4 service object.
// */
function initializeAnalytics() {
    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = __DIR__ . '/name-of-the-json-file';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_AnalyticsReporting($client);

    return $analytics;
}

/**
 * Queries the Analytics Reporting API V4.
 *
 * @param service An authorized Analytics Reporting API V4 service object.
 * @return The Analytics Reporting API V4 response.
 */
function getReport($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    // Create the Metrics object.
    $users = new Google_Service_AnalyticsReporting_Metric();
    $users->setExpression("ga:users");
    $users->setAlias("Users");

    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("Sessions");

    $bounceRate = new Google_Service_AnalyticsReporting_Metric();
    $bounceRate->setExpression("ga:bounceRate");
    $bounceRate->setAlias("Bounce Rate");

    $sessionDuration = new Google_Service_AnalyticsReporting_Metric();
    $sessionDuration->setExpression("ga:avgSessionDuration");
    $sessionDuration->setAlias("Session Duration");

    $pageviews = new Google_Service_AnalyticsReporting_Metric();
    $pageviews->setExpression("ga:pageviews");
    $pageviews->setAlias("Page Views");

    $avg = new Google_Service_AnalyticsReporting_Metric();
    $avg->setExpression("ga:avgTimeOnPage");
    $avg->setAlias("Average Time On Page");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($users, $sessions, $bounceRate, $sessionDuration, $pageviews, $avg));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getAge($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $userAgeBrackets = new Google_Service_AnalyticsReporting_Dimension();
    $userAgeBrackets->setName("ga:userAgeBracket");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($userAgeBrackets));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getGender($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $userGender = new Google_Service_AnalyticsReporting_Dimension();
    $userGender->setName("ga:userGender");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($userGender));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getCountry($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $countries = new Google_Service_AnalyticsReporting_Dimension();
    $countries->setName("ga:country");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($countries));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getCity($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $cities = new Google_Service_AnalyticsReporting_Dimension();
    $cities->setName("ga:city");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($cities));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getDevices($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $devices = new Google_Service_AnalyticsReporting_Dimension();
    $devices->setName("ga:deviceCategory");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($devices));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getSourceMedium($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $sM = new Google_Service_AnalyticsReporting_Dimension();
    $sM->setName("ga:sourceMedium");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($sM));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getReferral($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $referralPath = new Google_Service_AnalyticsReporting_Dimension();
    $referralPath->setName("ga:referralPath");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($referralPath));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getUser($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $userType = new Google_Service_AnalyticsReporting_Dimension();
    $userType->setName("ga:userType");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setDimensions(array($userType));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getChannel($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("Sessions");

    $channelGrouping = new Google_Service_AnalyticsReporting_Dimension();
    $channelGrouping->setName("ga:channelGrouping");

    $ordering = new Google_Service_AnalyticsReporting_OrderBy();
    $ordering->setFieldName("ga:sessions");
    $ordering->setOrderType("VALUE");
    $ordering->setSortOrder("DESCENDING");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($sessions));
    $request->setDimensions(array($channelGrouping));
    $request->setOrderBys($ordering);

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

function getTopPages($analytics, $VIEW_ID, $start_date, $end_date) {

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($start_date);
    $dateRange->setEndDate($end_date);

    $pageviews = new Google_Service_AnalyticsReporting_Metric();
    $pageviews->setExpression("ga:pageviews");
    $pageviews->setAlias("Page Views");

    $pagePath = new Google_Service_AnalyticsReporting_Dimension();
    $pagePath->setName("ga:pagePath");

    $ordering = new Google_Service_AnalyticsReporting_OrderBy();
    $ordering->setFieldName("ga:pageviews");
    $ordering->setOrderType("VALUE");
    $ordering->setSortOrder("DESCENDING");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($pageviews));
    $request->setDimensions(array($pagePath));
    $request->setOrderBys($ordering);
    $request->setPageSize(20);

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}

require_once 'include/header.php';
?>
<div class="container mt-3">
    <h2>Google Analytics Reporting API V4</h2>  
    <form name="form" action="" method="get" class="mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3 mt-3 p-0">
                    <label>
                        <span class="addlisting">Date Range:</span>
                        <select name="date_range" onchange="get_dates(this.value);">
                            <option value="">Custom</option>
                            <option value="1" <?php echo ($date_range == 1) ? 'selected' : ''; ?>>Today</option>
                            <option value="2" <?php echo ($date_range == 2) ? 'selected' : ''; ?>>Yesterday</option>
                            <option value="3" <?php echo ($date_range == 3) ? 'selected' : ''; ?>>Last week</option>
                            <option value="4" <?php echo ($date_range == 4) ? 'selected' : ''; ?>>Last month</option>
                            <option value="5" <?php echo ($date_range == 5) ? 'selected' : ''; ?>>Last 7 days</option>
                            <option value="6" <?php echo ($date_range == 6) ? 'selected' : ''; ?>>Last 30 days</option>
                        </select>
                    </label>
                </div>
                <div class="col-md-12 col-lg-3 mt-3 p-0">
                    <label>
                        <span class="addlisting">Start Date:</span>
                        <input type="text" name="start_date" class="datepicker" id="start_date" value="<?php echo $start_date; ?>" style="width: 110px;"/>
                    </label>
                </div>
                <div class="col-md-12 col-lg-3 mt-3 p-0">
                    <label>
                        <span class="addlisting">End Date:</span>
                        <input type="text" name="end_date" class="datepicker" id="end_date" value="<?php echo $end_date; ?>" style="width: 110px;"/> 
                    </label>
                </div>
                <div class="col-md-12 col-lg-3 mt-3 p-0">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </div>
        </div>
    </form>
    <?php
    printReports($response);
    printAge($age);
    printGender($gender);
    printCountry($country);
    printCity($city);
    printDevice($device);
    printSourceMedium($sourceMedium);
    printReferral($referral);
    printUser($user);
    printChannel($channel);
    printTopPages($topPages);

    function printReports($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $metricHeaders = $report->getColumnHeader()->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Reports</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $row = $rows[$rowIndex];
                    $metrics = $row->getMetrics();
                    for ($j = 0; $j < count($metrics); $j++) {
                        $values = $metrics[$j]->getValues();
                        for ($k = 0; $k < count($values); $k++) {
                            $entry = $metricHeaders[$k];
                            if ($entry->getType() == 'PERCENT') {
                                $val = round($values[$k], 2) . "%";
                            } elseif ($entry->getType() == 'TIME') {
                                $seconds = $values[$k];
                                $secs = $seconds % 60;
                                $hrs = $seconds / 60;
                                $mins = $hrs % 60;
                                $hrs = $hrs / 60;
                                $val = (int) $hrs . ":" . (int) $mins . ":" . (int) $secs;
                            } else {
                                $val = $values[$k];
                            }
                            print '<tr>
                                        <td width="80%">' . $entry->getName() . '</td>
                                        <td width="20%">' . $val . '</td>
                                    </tr>';
                        }
                    }
                    print '</tbody>
                           </table>';
                }
            }
        }
    }

    function printAge($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Age</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printGender($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Gender</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printCountry($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Countries</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printCity($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Cities</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printDevice($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Devices</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printSourceMedium($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Source Medium</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printReferral($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Referrals</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printUser($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">New Visitor vs Returning Visitor</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printChannel($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Traffic Channels</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }

    function printTopPages($reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $rows = $report->getData()->getRows();
            if (count($rows) > 0) {
                print '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Top Pages</th>
                            </tr>
                        </thead>
                        <tbody>';
                for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                    $dimension = $rows[$rowIndex]->getDimensions();
                    $metrics = $rows[$rowIndex]->getMetrics();
                    $values = $metrics[0]->getValues();
                    print '<tr>
                                <td width="80%">' . $dimension[0] . '</td>
                                <td width="20%">' . $values[0] . '</td>
                            </tr>';
                }
                print '</tbody>
                       </table>';
            }
        }
    }
    ?>
</div>
<script>
    function get_dates(value) {
        if (value != "") {
            $.ajax({
                type: "GET",
                url: "get-dates-for-analytics.php",
                data: {
                    value: value
                }
            }).done(function (msg) {
                var date_range = msg.split(",");
                var start_date = date_range[0];
                var end_date = date_range[1];
                document.getElementById('start_date').value = start_date;
                document.getElementById('end_date').value = end_date;
            });
        }
    }
</script>