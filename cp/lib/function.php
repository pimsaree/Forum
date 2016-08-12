<?php
function count_time($date)
{
if(empty($date)) {
return "No date provided";
}
 
$periods = array("sec", "min", "hr", "day", "week", "mounth", "Y", "decade");
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
$tense = "ago";
 
} else {
$difference = $unix_date - $now;
$tense = "from now";
}
 
for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
$difference /= $lengths[$j];
}
 
$difference = round($difference);
 
if($difference != 1) {
$periods[$j].= "s";
}
 
return "$difference $periods[$j] {$tense}";
}
function protect_hack($text)
{
	return htmlspecialchars($text);
}
function bbcode_format($post){ 

		$post = htmlspecialchars($post);
		
		$post = preg_replace("#(^|[\n ])([\w]+?://[^ \"\n\r\t<]*)#is", "\\1<a class='alink' href=\"\\2\" target=\"_blank\">\\2</a>", $post);
		
        $post = str_replace("\n",'END_OF_LINE',$post);

        $post = str_replace("[line]",'HORIZONTAL_LINE',$post);

        $post = str_replace("[b]",'BOLD_TEXT_START',$post);
        $post = str_replace("[/b]",'BOLD_TEXT_END',$post);

		$post = str_replace("[red]",'RED_COLOR_START',$post);
		$post = str_replace("[/red]",'RED_COLOR_END',$post);
		
		$post = str_replace("[blue]",'BLUE_COLOR_START',$post);
		$post = str_replace("[/blue]",'RED_COLOR_END',$post);	
		
		$post = str_replace("[yellow]",'YELLOW_COLOR_START',$post);
		$post = str_replace("[/yellow]",'YELLOW_COLOR_END',$post);

		$post = str_replace("[green]",'GREEN_COLOR_START',$post);
		$post = str_replace("[/green]",'GREEN_COLOR_END',$post);		
		
		$post = str_replace("[brown]",'BROWN_COLOR_START',$post);
		$post = str_replace("[/brown]",'BROWN_COLOR_END',$post);		
		
		$post = str_replace("[pink]",'PINK_COLOR_START',$post);
		$post = str_replace("[/pink]",'PINK_COLOR_END',$post);		
		
		$post = str_replace("[orange]",'ORANGE_COLOR_START',$post);
		$post = str_replace("[/orange]",'ORANGE_COLOR_END',$post);	
		
        $post = str_replace("[yt]",'YOUTUBE_START',$post);
        $post = str_replace("[/yt]",'YOUTUBE_END',$post);
		
		$post = str_replace("[h3]",'H3_START',$post);
        $post = str_replace("[/h3]",'H3_END',$post);
		
		$post = str_replace("[h4]",'H4_START',$post);
        $post = str_replace("[/h4]",'H4_END',$post);
		
		$post = str_replace("[code]",'CODE_START',$post);
		$post = str_replace("[/code]",'CODE_END',$post);

		$post = str_replace("[quote]",'QUOTE_START',$post);
		$post = str_replace("[/quote]",'QUOTE_END',$post);
		
		$post = str_replace("[img]",'IMAGE_START',$post);
		$post = str_replace("[/img]",'IMAGE_END',$post);
		
		$post = str_replace("[img2]",'IMAGE2_START',$post);
		$post = str_replace("[/img2]",'IMAGE2_END',$post);
		
		$post = str_replace("[cen]",'CENTER_START',$post);
		$post = str_replace("[/cen]",'CENTER_END',$post);
		//
		
		
        $post = str_replace("END_OF_LINE",'<br />',$post);

        $post = str_replace("HORIZONTAL_LINE",'<hr />',$post);

        $post = str_replace("BOLD_TEXT_START",'<b>',$post);
        $post = str_replace("BOLD_TEXT_END",'</b>',$post);

        $post = str_replace("YOUTUBE_START",'<center><iframe width="550" height="370" src="http://www.youtube.com/embed/',$post);
        $post = str_replace("YOUTUBE_END",'" frameborder="0" allowfullscreen></iframe></center>',$post);
		
		$post = str_replace("H3_START",'<h3>',$post);
        $post = str_replace("H3_END",'</h3>',$post);
		
		$post = str_replace("H4_START",'<h4>',$post);
        $post = str_replace("H4_END",'</h4>',$post);
		
		$post = str_replace("RED_COLOR_START",'<font color=red>',$post);
		$post = str_replace("RED_COLOR_END",'</font>',$post);
		
		$post = str_replace("BLUE_COLOR_START",'<font color=blue>',$post);
		$post = str_replace("RED_COLOR_END",'</font>',$post);	
		
		$post = str_replace("YELLOW_COLOR_START",'<font color=yellow>',$post);
		$post = str_replace("YELLOW_COLOR_END",'</font>',$post);

		$post = str_replace("GREEN_COLOR_START",'<font color=green>',$post);
		$post = str_replace("GREEN_COLOR_END",'</font>',$post);		
		
		$post = str_replace("BROWN_COLOR_START",'<font color=brown>',$post);
		$post = str_replace("BROWN_COLOR_END",'</font>',$post);		
		
		$post = str_replace("PINK_COLOR_START",'<font color=pink>',$post);
		$post = str_replace("PINK_COLOR_END",'</font>',$post);		
		
		$post = str_replace("ORANGE_COLOR_START",'<font color=orange>',$post);
		$post = str_replace("ORANGE_COLOR_END",'</font>',$post);
		
		$post = str_replace("CODE_START",'<pre>',$post);
		$post = str_replace("CODE_END",'</pre>',$post);
		
		$post = str_replace("QUOTE_START",'<div class="quote">',$post);
		$post = str_replace("QUOTE_END",'</div>',$post);
		
		$post = str_replace("IMAGE_START",'<img src="',$post);
		$post = str_replace("IMAGE_END",'"/>',$post);
		
		$post = str_replace("IMAGE2_START",'<img class="imgshow" src="',$post);
		$post = str_replace("IMAGE2_END",'"/>',$post);
		
		$post = str_replace("CENTER_START",'<center>',$post);
		$post = str_replace("CENTER_END",'</center>',$post);
        return $post;
    }
	function grav($youremail,$size)
	{
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $youremail ) ) ) . "?d=mm&s=" . $size;
		return $grav_url;
	}
	function cutStr($str, $maxChars='', $holder=''){

    if (strlen($str) > $maxChars ){
			$str = iconv_substr($str, 0, $maxChars,"UTF-8") . $holder;
	} 
	return $str;
} 
?>
