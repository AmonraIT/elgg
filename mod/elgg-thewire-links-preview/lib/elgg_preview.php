<?php

// e-Webstar.net/?q=78jk45ui
function fix_encoding_str($str)
{
        $cur_encoding = mb_detect_encoding($str) ;
        if($cur_encoding == "UTF-8" && mb_check_encoding($str,"UTF-8"))
                return $str;
        else
                return utf8_encode($str);
}
 
function elgg_preview($excerpt, $width=420, $height=315) {
 
        preg_match_all("#http.*://[^\s\\n]*#", $excerpt, $matches);
        foreach ($matches[0] as &$url) {
 
                //YOUTUBE
                if (strpos($url, "youtube.com") !== false
                 || strpos($url, "youtu.be") !== false) {
                        preg_match("#\?v=([a-zA-Z0-9\-_]+)#", $url, $match);
                        if ($match[1] == "") {
                                preg_match("#youtu.be/([a-zA-Z0-9\-_]+)#", $url, $match);
                        }
                        $excerpt=str_replace($url, "<iframe frameborder=\"0\" width='$width' height='$height' allowfullscreen src=\"https://www.youtube.com/embed/$match[1]?html5=1&fs=1\"></iframe>", $excerpt);
                        continue;
                }
 
                //DAILYMOTION
                if (strpos($url, "dailymotion.com") !== false) {
                        preg_match("#/video/([a-zA-Z0-9]+)#", $url, $match);
                        $excerpt =  str_replace($url, "<iframe frameborder=\"0\" width=\"$width\" height=\"$height\" allowfullscreen html src=\"https://www.dailymotion.com/embed/video/$match[1]\"></iframe>", $excerpt);
                        continue;
                }
 
                //VIMEO
                if (strpos($url, "vimeo.com") !== false) {
                        preg_match("#vimeo.com/([0-9]+)#", $url, $match);
                        $excerpt =  str_replace($url, "<iframe frameborder=\"0\" width='$width' height='$height' allowfullscreen src=\"https://player.vimeo.com/video/$match[1]\"></iframe>",$excerpt);
                        continue;
                }
 
                //SOUNDCLOUD
                if (strpos($url, "soundcloud.com") !== false) {
                      $excerpt =  str_replace($url, "<iframe frameborder=\"0\" width=100% height=166 src=\"https://w.soundcloud.com/player/?url=$url&auto_play=false&color=915f33&theme_color=00FF00\"></iframe>",$excerpt);
                        continue;
                }
 
                //JAMENDO
                if (strpos($url, "jamendo.com") !== false) {
                        if (strpos($url, "/track/") !== false) {
                                preg_match("#/track/([0-9]*)#", $url, $match);
                                $excerpt=str_replace($url, "<iframe id=\"widget\" scrolling=\"no\" frameborder=\"0\" width=\"400\" height=\"170\" src=\"//widgets.jamendo.com/v3/track/$match[1]?tracklist=true&width=400&tracklist_n=4\"></iframe>", $excerpt);
                                continue;
                        } else if (strpos($url, "/list/") !== false) {
                                preg_match("#/list/a([0-9]*)#", $url, $match);
                                $excerpt=str_replace($url, "<iframe id=\"widget\" scrolling=\"no\" frameborder=\"0\" width=\"400\" height=\"310\" src=\"//widgets.jamendo.com/v3/album/$match[1]?tracklist=true&width=400&tracklist_n=4\"></iframe>", $excerpt);
                                continue;
                        }
                }
 
                //IMG
                if (strpos($url, ".jpg") !== false
                  ||strpos($url, ".jpeg") !== false
                  ||strpos($url, ".png") !== false
                  ||strpos($url, ".gif") !== false) {
 
                        $excerpt=str_replace($url, "<a rel=\"nofollow\" target=\"_blank\" href=\"$url\"><img src=\"$url\" alt=\"$url\"/ width=\"$width\"></a>", $excerpt);
                        continue;
 
                }
 
                //VIDEO
                if (strpos($url, ".ogv") !== false
                  ||strpos($url, ".webm") !==false) {
                        $excerpt=str_replace($url,"<video  width=\"$width\" controls=\"true\" src=$url>$url</video>", $excerpt);
                        continue;
                }
 
                //OTHERS SITES
                $name=preg_replace("#/#", "_", $url);
                if (!file_exists(elgg_get_data_path()."/url_cache/title/$name")) {
                        $html=file_get_contents($url);
                        preg_match("#<title>\s*([^<\\n]*)\s*</title>#", $html, $mtitle);
                        preg_match("#<\s*meta[^>]*[a-z]=\"(og:|)[dD]escription\"[^>]*>#", $html, $match);
 
                        if ($match[0] != "") {
                                preg_match("#content=\"([^\"]*)#", $match[0], $mdesc);
                                if ($mdesc[1] != "") {
                                        $desc=fix_encoding_str($mdesc[1]);
                                }
                        }
                        if ($mtitle[1] != "") {
                                $title=fix_encoding_str($mtitle[1]);
                        }
                        file_put_contents(elgg_get_data_path()."/url_cache/title/$name", $title);
                        file_put_contents(elgg_get_data_path()."/url_cache/desc/$name", $desc);
 
                } else {
                        $title=file_get_contents(elgg_get_data_path()."/url_cache/title/$name");
                        $desc=file_get_contents(elgg_get_data_path()."/url_cache/desc/$name");
                }
 
                if ($title != "") {
                        if ($desc != "") {
                                $desc="<br/><i class=\"elgg-site-extract\">$desc</i>";
                        }
                        $excerpt=str_replace($url, "<span style=\"display: inline-block;\" class=\"elgg-site-preview\"><a rel=\"nofollow\" target=\"_blank\" href=\"$url\">$title</a>$desc</span>", $excerpt);
                }
        }
 
	//TOTOZ PREVIEW
        preg_match('/.*\[:(.*)\].*/', $excerpt, $matches);
        if (sizeof($matches) >= 2) {
                $excerpt = preg_replace("/\[:(.*)\]/", "<a href=\"http://totoz.eu/img/$1\"><img src=\"http://totoz.eu/img/$1\" alt=\"$1\"/></a>", $excerpt);
        }
 
        return $excerpt;
}
?>
