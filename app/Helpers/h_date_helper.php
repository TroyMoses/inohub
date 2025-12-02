
<?php

if ( ! function_exists('h_current_date_time'))
{
	function h_current_date_time()
	{
		return date('Y-m-d H:i:s');
	}
}

if ( ! function_exists('h_format_date_diff'))
{

	function h_format_date_diff($date_1)
	{
		$past = new DateTime($date_1);
		$now = new DateTime();
		$interval = $now->diff($past);
		return $interval->format('%y years, %m months, %d days');

	}
}

if ( ! function_exists('h_format_date_display'))
{

	function h_format_date_display($date)
	{
		$dateTime = new DateTime($date);
        $day = $dateTime->format('j');
        $dayWithSuffix = $day . h_getDaySuffix($day);
        return $dateTime->format('D, ') . $dayWithSuffix . $dateTime->format(' M Y');
	}
}

if ( ! function_exists('h_getDaySuffix'))
{
    function h_getDaySuffix($day)
    {
        if (!in_array(($day % 100), [11, 12, 13])) {
            switch ($day % 10) {
                case 1:  return 'st';
                case 2:  return 'nd';
                case 3:  return 'rd';
            }
        }
        return 'th';
    }
}
