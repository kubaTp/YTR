<?php
    //error_reporting(0);
    $html = file_get_contents($_POST['video']);
    
    $dom = new DOMDocument;
    @$dom->loadHtml($html);
    $htmlElement = $dom->getElementsByTagName("body");

    $content = [];
    foreach ($htmlElement->item(0)->childNodes as $element) 
    {    
        $content[] = $element->nodeValue . PHP_EOL;     
    }

    $content = implode(" ", $content);
    $pattern = '/playerCaptionsTracklistRenderer.*?(youtube.com\/api\/timedtext.*?)"/';
    $matches = [];

    preg_match($pattern, $content, $matches);

    if(sizeof($matches) > 0)
    {
        $link = $matches[1];
        $link = json_decode('"' . $link . '"');
        $link .= "&fmt=json3";
        //print($link);

        $ytrcap = json_decode(file_get_contents("https://" . $link));
        print("<pre>");
        print_r($ytrcap);

        //$ytrcap = json_decode($ytrcap);
        //print_r($ytrcap);
    }

?>