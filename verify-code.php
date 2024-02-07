<?php
// 开启session
session_start();

// 获取提交验证码
$submittedCode = $_POST['verification_code'];
// 获取生成验证码
$generatedCode = $_SESSION['verification_code'];

// 判断验证码是否正确
if ($submittedCode == $generatedCode) {
    echo "验证码验证成功！";
} else {
    echo "验证码验证失败，请重新输入！";
}