<?php
 //time zone
 date_default_timezone_set('Asia/Colombo');

 function convertTimeReadableFormat($time) {
    $time_ago = strtotime($time);
    $current_time = time();
    $time_difference = $current_time - $time_ago;

    $seconds = $time_difference;
    $minutes = round($seconds / 60); // value 60 is seconds
    $hours = round($seconds / 3600); // value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400); // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks = round($seconds / 604800); // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months = round($seconds / 2629440); // value 2629440 is (365+365+365+365+366)/5/12*24*60*60
    $years = round($seconds / 31553280); // value 31553280 is 365+365+365+365+366/5*24*60*60

    if ($seconds <= 60) {
        return "Just now";
    }
    else if($minutes <= 60 ){
        if($minutes == 1){
            return 'one minute ago';
        }
        else{
            return $minutes.' minutes ago';
        }
    }
    else if($hours <= 24 ){
        if($hours == 1){
            return 'one hour ago';
        }
        else{
            return $hours.' hours ago';
        }
    }
    else if($days <= 7 ){
        if($days == 1){
            return 'yesterday';
        }
        else{
            return $days.' days ago';
        }
    }
    else if($weeks <= 4.3 ){
        if($weeks == 1){
            return 'a week ago';
        }
        else{
            return $weeks.' weeks ago';
        }
    }
    else if($months <= 12 ){
        if($months == 1){
            return 'a month ago';
        }
        else{
            return $months.' months ago';
        }
    }
    else{
        if($years == 1){
            return 'one year ago';
        }
        else{
            return $years.' years ago';
        }
    }


 }


?>