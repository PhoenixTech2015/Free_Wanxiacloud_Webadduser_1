<?php
session_start();

// 生成一个包含4位数字的验证码
$verificationCode = strval(rand(1000, 9999));

// 存储验证码到会话中
$_SESSION['verification_code'] = $verificationCode;

// 创建一个图像
$image = imagecreate(120, 40);

// 设置背景颜色为白色
$backgroundColor = imagecolorallocate($image, 255, 255, 255);

// 设置文本颜色为黑色
$textColor = imagecolorallocate($image, 0, 0, 0);

// 在图像上写入验证码
imagestring($image, 5, 30, 12, $verificationCode, $textColor);

// 输出图像
header('Content-type: image/png');
imagepng($image);

// 释放内存占用
imagedestroy($image);
