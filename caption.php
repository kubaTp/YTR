<?php
//print_r(stream_get_wrappers());
//phpinfo();
error_reporting(0);

$captions = "<p style='color:white;'>internal error, try use YTR again</p>";

$url = $_GET['url'];
$url = json_decode('"' . $url.'"');
$url = "http://$url&fmt=json3";
  
 
if($data = file_get_contents($url))
{
    $data = json_decode($data, 1);
  
    $events = $data['events'];
    foreach($events as $e)
    {
      if(!$e['segs']) 
        continue;

      foreach($e['segs'] as $seg)
      {
        $words[] = $seg['utf8'];
      }
    }
      
    $text = implode('', $words);
      
    $text = preg_replace('#(.*?)\n(.*?)\n#', "$1 $2\n", $text);

    $captions = "<p style='red:white;'>" . $text . "</p>";
}

$video = "http://youtube.com/v/" . preg_replace('/.*v=(.*?)&.*/', '$1', $url);

print<<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube transcription</title>
    <link rel="stylesheet" href="style_1.0.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-wrap">

        <div class="logo">
            <a href="https://www.goldencodedev.pl" target="_blank">
                <img src="gc-logo.png" alt="golden code dev"/>
            </a>
        </div>

        <section>        
          Transcript for <a href=$video target=_blank>$video</a>

          <div class="captions">
            <pre>
            $captions
          </div>
        </section> 
    </div>
</body>
</html>
EOF;
?>