<?php

function sumPayments($arr)
{
    $output = 0.00;

    foreach($arr as $key => $value)
    {
        $output = floatval($output) + floatval($value['amount']);
    }

    return $output;
}

function getTotalPaymentsOfASchedule($payments)
{
    $result = 0;
    foreach($payments as $payment)
    {
        $result = floatval($result) + floatval($payment->amount);
    }

    return $result;
}

/**
 * Get Bangla Dates & numbers from English format
 * 
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function entobn($string) 
{
    $engDATE = [
        '1','2','3','4','5','6','7','8','9','0','January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Sat','Sun','Mon','Tue','Wed','Thu','Fri'
    ];
    
    $bangDATE = [
        '১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার' 
    ];
    
    return str_replace($engDATE, $bangDATE, $string);
}

/**
 * Get English Dates & numbers from Bangla
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function bntoen($string) 
{
    $engDATE = [
        '1','2','3','4','5','6','7','8','9','0','January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Sat','Sun','Mon','Tue','Wed','Thu','Fri'  
    ];
    
    $bangDATE = [
        '১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার' 
    ];
    
    return str_replace($bangDATE, $engDATE, $string);
}

function parseNumber($quantity) {

    $qty = explode(".", $quantity);

    if(count($qty) == 1)
        return [$qty[0], 0];

   return [$qty[0], $qty[1]];
}