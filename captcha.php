<?php

function generate_captcha() {
    $width = 160;
    $height = 50;
    $characters = '0123456789';
    $rand_string = '';

    for ($i = 0; $i < 4; $i++) {
        $rand_string .= $characters[rand(0, strlen($characters) - 1)];
    }

    $image = imagecreatetruecolor($width, $height);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);

    imagestring($image, 10, 10, 10, $rand_string, $text_color);

    ob_start();
    imagepng($image);
    $captcha_data = ob_get_contents();
    ob_end_clean();

    return $captcha_data;
}

$captcha = generate_captcha();
header('Content-Type: image/png');
echo $captcha;
