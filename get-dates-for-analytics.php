<?php
$date_range = $_REQUEST['value'];
if ($date_range == 1) {
    $start_date = date("Y-m-d");
    $end_date = $start_date;
} elseif ($date_range == 2) {
    $start_date = date("Y-m-d", strtotime("yesterday"));
    $end_date = $start_date;
} elseif ($date_range == 3) {
    $start_date = date("Y-m-d", strtotime("last week monday"));
    $end_date = date("Y-m-d", strtotime("last week sunday"));
} elseif ($date_range == 4) {
    $start_date = date("Y-m-d", strtotime("first day of previous month"));
    $end_date = date("Y-m-d", strtotime("last day of previous month"));
} elseif ($date_range == 5) {
    $start_date = date("Y-m-d", strtotime("7 days ago"));
    $end_date = date("Y-m-d", strtotime("yesterday"));
} else {
    $start_date = date("Y-m-d", strtotime("30 days ago"));
    $end_date = date("Y-m-d", strtotime("yesterday"));
}
print_r($start_date . ',' . $end_date);
?>
