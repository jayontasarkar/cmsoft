<?php 

namespace App\Http\Helpers;

class LanguageConverter
{
	private $engDate = [
		'1','2','3','4','5','6','7','8','9','0','January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Sat','Sun','Mon','Tue','Wed','Thu','Fri'	

	];

	private $banDate = [
		'১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
	বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
	বুধবার','বৃহস্পতিবার','শুক্রবার'
	];

	public function cvt_to_bangla($string)
	{
		return str_replace($this->engDate, $this->banDate, $string);
	}

	public function cvt_to_english($string)
	{
		return str_replace($this->engDate, $this->banDATE, $string);
	}
}