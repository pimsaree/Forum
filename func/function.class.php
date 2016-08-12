<?php
date_default_timezone_set('Asia/Bangkok'); 
class func {
	public function cutStr($str, $maxChars='', $holder=''){

		if (strlen($str) > $maxChars ){
		$str = iconv_substr($str, 0, $maxChars,"UTF-8") . $holder;
		} 
		return $str;
	}
	public function count_time($date)
	{
		if(empty($date)) {
		return "No date provided";
		}
		 
		$periods = array("วินาที", "นาที", "ชั่วโมง", "วัน", "อาทิตย์", "เดือน", "ปี", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		 
		$now = time();
		$unix_date = strtotime($date);
		 
		// check validity of date
		if(empty($unix_date)) {
		return "Bad date";
		}
		 
		// is it future date or past date
		if($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ที่ผ่านมา";
		 
		} else {
		$difference = $unix_date - $now;
		$tense = "from now";
		}
		 
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
		}
		 
		$difference = round($difference);
		 
		/*if($difference != 1) {
		$periods[$j].= "s";
		}*/
		 
		return "$difference $periods[$j] {$tense}";
	}

	function parseText($bbtext)
	{	
	
		$bbtext = htmlspecialchars($bbtext);
		
		$bbtags = array(
		'[heading1]' => '<h1>','[/heading1]' => '</h1>',
		'[heading2]' => '<h2>','[/heading2]' => '</h2>',
		'[heading3]' => '<h3>','[/heading3]' => '</h3>',
		'[h1]' => '<h1>','[/h1]' => '</h1>',
		'[h2]' => '<h2>','[/h2]' => '</h2>',
		'[h3]' => '<h3>','[/h3]' => '</h3>',

		'[paragraph]' => '<p>','[/paragraph]' => '</p>',
		'[para]' => '<p>','[/para]' => '</p>',
		'[p]' => '<p>','[/p]' => '</p>',
		'[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
		'[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
		'[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
		'[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',

		'[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
		'[italic]' => '<span style="font-weight:bold;">','[/italic]' => '</span>',
		'[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
		'[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
		'[i]' => '<span style="font-weight:bold;">','[/i]' => '</span>',
		'[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
		'[break]' => '<br>',
		'[br]' => '<br>',
		'[newline]' => '<br>',
		'[nl]' => '<br>',
		
		'[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
		'[list]' => '<ul>','[/list]' => '</ul>',
		'[ul]' => '<ul>','[/ul]' => '</ul>',

		'[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
		'[ol]' => '<ol>','[/ol]' => '</ol>',
		'[list_item]' => '<li>','[/list_item]' => '</li>',
		'[li]' => '<li>','[/li]' => '</li>',
		'[list=1]' => '<ol>','[/list]' => '</ol>',

		'[*]' => '<li>','[/*]' => '</li>',
		'[code]' => '<code>','[/code]' => '</code>',
		'[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
		'[pre]' => '<pre>','[/pre]' => '</pre>',       
		'[quote]' => '<blockquote>','[/quote]' => '</blockquote>',
		
		'[table]' => '<table>','[/table]' => '</table>',
		'[tr]' => '<tr>','[/tr]' => '</tr>',
		'[td]' => '<td>','[/td]' => '</td>',
		
		'[sup]' => '<sup>','[/sup]' => '</sup>',
		'[sub]' => '<sub>','[/sub]' => '</sub>',
	  );

	  $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

	  $bbextended = array(
		"/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
		"/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
		"/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
		"/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
		"/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" class=\"pic-show\"/>",
		"/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" class=\"pic-show\"/>",
		"/\[size=(.*?)\](.*?)\[\/size\]/i" => "<font size=\"$1\">$2</font>",
		"/\[video](.*?)\[\/video]/i" => "<iframe src=\"http://www.youtube.com/embed/$1\" frameborder=\"0\" height=\"480\" width=\"640\"></iframe>",
		"/\[color=(.*?)\](.*?)\[\/color\]/i" => "<font color=\"$1\">$2</font>",
		"/\[font=(.*?)\](.*?)\[\/font\]/i" => "<font face=\"$1\">$2</font>",
	  );

	  foreach($bbextended as $match=>$replacement){
		$bbtext = preg_replace($match, $replacement, $bbtext);
	  }
	  return nl2br($bbtext);
	}
	public function protect($str){
		return htmlspecialchars($str);
	}
	public function grav($youremail,$size)
	{
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $youremail ) ) ) . "?d=mm&s=" . $size;
		return $grav_url;
	}
}
?>