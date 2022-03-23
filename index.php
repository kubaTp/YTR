<?php
function encodeURIComponent($str) 
{
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

$code =<<<EOF
var regexp = new RegExp(/playerCaptionsTracklistRenderer.*?(youtube.com\/api\/timedtext.*?)"/);
var match = regexp.exec(document.body.innerHTML);
if(!match)
{
    alert("captions not found, please reload page");
    return;
}
var url = regexp.exec(document.body.innerHTML)[1];
//alert(encodeURIComponent(url));
open('http://localhost/YTR/caption.php?url=' + encodeURIComponent(url));
EOF;

$code = encodeURIComponent($code);

print<<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube transcription</title>
    <link rel="stylesheet" href="style.css">
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
        <h3>YTR - YouTube transcriber</h3>
        Drag link to your boomark section and if you want to have YTR just click this bookmarket 
        when watching youtube video
        <a href="javascript:(function(){ $code })();"> 📜YTR📜 </a>  
        </section> 
    </div>
</body>
</html>
EOF;

?>