<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function build_calendar($month,$year,$title) { // REMOVED: $dateArray

    // Today:
    $today_date = date("d");
    $today_date = ltrim($today_date, '0');

    // Tomorrow:
    $tomorrow_date = ($today_date + 1);

    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('S','M','T','W','T','F','S');
    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    // How many days does this month contain?
    $numberDays = date('t',$firstDayOfMonth);
    // Retrieve some information about the first day of the month in question.
    $dateComponents = getdate($firstDayOfMonth);
    // What is the name of the month in question?
    $monthName = $dateComponents['month'];
    // What is the index value (0-6) of the first day of the month in question.
    $dayOfWeek = $dateComponents['wday'];
    // Create the table tag opener and day headers
    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$title</caption>"; //$monthName $year removed
    $calendar .= "<tr>";

    // Create the calendar headers
    //foreach($daysOfWeek as $day) {
    //    $calendar .= "<th class='header'>$day</th>";
    //}

    // Create the rest of the calendar
    // Initiate the day counter, starting with the 1st.
    $currentDay = 1;
    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.
    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek' class='shade'>&nbsp;</td>";
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        // Seventh column (Saturday) reached. Start a new row.
        if ($dayOfWeek == 7) {
              $dayOfWeek = 0;
              $calendar .= "</tr><tr>";
        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        if($title == 'Today' && $currentDayRel == $today_date ){
              $calendar .= "<td class='day highlighted' rel='$date'><span>$currentDay</span></td>";
        }

        else if($title == 'Tomorrow' && $currentDayRel == $tomorrow_date ){
              $calendar .= "<td class='day highlighted' rel='$date'><span>$currentDay</span></td>";
        }

        else if($title == 'All Month'){
              $calendar .= "<td class='day highlighted' rel='$date'><span>$currentDay</span></td>";
        }

        else {
          $calendar .= "<td class='day' rel='$date'><span>$currentDay</span></td>";
        }
        // Increment counters
        $currentDay++;
        $dayOfWeek++;
    }

    // Complete the row of the last week in month, if necessary
    if ($dayOfWeek != 7) {
         $remainingDays = 7 - $dayOfWeek;
         $calendar .= "<td colspan='$remainingDays' class='shade'>&nbsp;</td>";
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;

}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <title>Calendar</title>
  <style type="text/css">
  table { font-family: 'helvetica neue', helvetica, sans-serif; /*background-image: url('blankcalendaricon.png'); background-size: 100% 100%; background-repeat: no-repeat;*/ /*width: 246px; height: 236px;*/ }
  caption { display: block; margin: 0 auto; background-color: #D21D0D; background-image: url('blankcalendaricon-top.png'); background-size: 100% 100%; background-repeat: no-repeat; padding: 11px 10px; border-radius: 20px 20px 0 0; font-weight: 700; color: #f6f6f6; font-size: 20px; letter-spacing: 0.05rem; text-shadow: 1px 2px 2px rgba(0,0,0,0.2); }
  tbody { display: inline-block; padding: 13px 21px 22px 19px; background-color: #f1f1f1; background-image: url('blankcalendaricon-body.png'); background-size: 100% 100%; background-repeat: no-repeat; border-radius: 0 0 20px 20px; }
  td { text-align: right; background-color: #c5c5c5; padding: 2px 4px; }
  td.highlighted { background-color: #c50000; }
  td.shade { background-color: transparent; }
  td span { visibility: hidden; }
  </style>
</head>

<body>

<?php
// Today
$dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];
$title = 'Today';

echo build_calendar($month,$year,$title); //REMOVED: $dateArray
?>
<?php
// Tomorrow
$dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];
$title = 'Tomorrow';

echo build_calendar($month,$year,$title);

?>

<?php
// Next Week
$dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];
$title = 'Next Week';

echo build_calendar($month,$year,$title);

?>

<?php
// All Month
$dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];
$title = 'All Month';

echo build_calendar($month,$year,$title);

?>

</body>
</html>
