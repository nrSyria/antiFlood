<?php

function viewCode() {
    print '<img src="code.php?op=image&u=' . rand(1, 9999999) . '" width="130">';
}

function startGenerating() {
    global $genrateTime;
    ?>
    <div id="counter">waiting time : <span id="remTime" style="color:green; fomt-weight:bold"></span></div>
    <script>
        var bgn = Date.now();
        var timer = setInterval(function () {
            var diff = Math.floor((Date.now() - bgn) / 1000);
            var rem = <?= $genrateTime ?> - diff;
            if (rem > 0) {
                var min = Math.floor(rem / 60);
                var sec = rem - min * 60;
                $('#remTime').html((min <= 9 ? '0' + min : min) + ':' + (sec <= 9 ? '0' + sec : sec));
            } else {
                clearInterval(timer);
                $('#remTime').html('00:00');

                viewTheCode();
            }
        }, 1000);

        function viewTheCode() {
            $('#counter').hide();
            $.ajax({url: 'code.php?op=genrate',
                type: 'get',
                success: function (output) {
                    $('#genCode').html(output);
                    //$('#code').show();
                },
                error: function (output) {
                    $('#genCode').html('error relode page..');
                    //$('#code').show();
                },
            });
        }
    </script>        
    <?php
}



function captchaImage($string) {
    $width = 130;
    $height = 30;
    $font_size = 20;
    $font = "./verdana.ttf";
    $font = realpath($font);
    $chars_length = strlen($string);
    $captcha_characters = str_split($string);
    $image = imagecreatetruecolor($width, $height);
    $bg_color = imagecolorallocate($image, 255, 0, 0);
    $font_color = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

    //background random-line
    $vert_line = round($width / 5);
    $color = imagecolorallocate($image, 255, 255, 255);
    for ($i = 0; $i < $vert_line; $i++) {
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $height), rand(0, $width), $color);
    }

    $xw = ($width / $chars_length);
    $x = 0;
    $font_gap = $xw / 2 - $font_size / 2;
    $digit = '';
    for ($i = 0; $i < $chars_length; $i++) {
        $letter = $captcha_characters[$i];
        $digit .= $letter;
        if ($i == 0) {
            $x = 0;
        } else {
            $x = $xw * $i;
        }
        imagettftext($image, $font_size, rand(-20, 20), $x + $font_gap, rand(21, $height - 5), $font_color, $font, $letter);
    }
    // display image
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
    die();
}

function seconds2human($ss) {
   # $seconds = $ss % 60;
    $minutes = floor(($ss % 3600) / 60);
    $hours = floor(($ss % 86400) / 3600);
    $days = floor(($ss % 2592000) / 86400);
    $months = floor($ss / 2592000);
    $results = '';
    $vals = compact('months', 'days', 'hours', 'minutes', 'seconds');
    foreach ($vals as $k => $v) {
        $results .= $v > 0 ? " $v $k," : '';
    }
    return trim($results, ',');
}


///


function WMHash() {
    # Þíã ÖÈØ ÇáåÇÔ æÊÎÕíÕå Ýí ÏÇáÉ ÇáÊÔÝíÑ æ ÇáÝß
    $num = 37;// Çí ÚÏÏ Ãæáí ( íÞÈá ÇáÞÓãÉ Úáì äÝÓå æ æÇÍÏ ÝÞØ )
    $salt = 4;// ÑÞã ØÈíÚí ÍÑ
    $maxLingth = 7;
    #$chars = range('A', 'Z');
    $chars = ['R', 'D', 'F', 'Z', 'Q', 'M', 'W', 'A', 'K', 'T']; // ãÕÝæÝÉ ãä ÚÔÑ ÇÍÑÝ ÚÔæÇÆíÉ  
    # íãßä ÇíÖÇ ÊÛííÑ ÇáãÚÇÏáÉ ÈÚäÇíÉ
    $hash = ( rand(99, 999) * $num ) + $salt;

    $hLingth = strlen("$hash");
    $restChrs = $maxLingth - $hLingth;
    if ($restChrs > 0) {
        $arr = str_split("$hash");
        for ($i = 0; $i < $restChrs; $i++) {
            $randPos = rand(0, ($hLingth - 1));
            if (isset($chars[$arr[$i]])) {
                $arr[$randPos] = $chars[$arr[$i]] . '' . $arr[$randPos];
            }else{
                $arr[$randPos] = $chars[$arr[0]] . '' . $arr[$randPos];
            }
        }
        $hash = implode('', $arr);
    }
    return $hash;
}




?>