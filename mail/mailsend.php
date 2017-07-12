<?php

header("Content-Type: text/html;charset=utf-8");
//require_once 'mail.class.php';
require_once ('email.class.php');
$isSub = isset($_POST['sub']) ? $_POST['sub'] : "";

if ($isSub) {
    $replyMail = isset($_POST['mail_addr']) ? $_POST['mail_addr'] : "";
    $mail_type = isset($_POST['mail_type']) ? $_POST['mail_type'] : "";
    $mail_txtar = isset($_POST['txta']) ? $_POST['txta'] : "";

    $t = isset($_POST['type']) ? $_POST['type'] : "";

    $isEn = $_POST['$isEn'];

    $content = '';
    if ($replyMail)
        $content.= '他的回复邮件是：' . $replyMail . '   ';
    if ($mail_type)
        $content.='意见类型：' . $mail_type . '   ';
    if ($mail_txtar)
        $content.='意见内容：' . $mail_txtar;

    // 只需要把这部分改成你的信息就行
//    $sm = new smail("send@nomura-sh.cn", "sendtome", "mail.nomura-sh.cn");
//    $sm = new smail("paino1@126.com", '', "smtp.126.com");
//    $end = $sm->sendMail("paino1@126.com", "paino1", "您收一条来自客户的意见", $content);
//    $end = $sm->send("hr@nomura-sh.cn", "Nomura Sh", "您收一条来自客户的意见", $content);
    //##########################################
    $smtpserver = "smtp.yeah.net"; //SMTP服务器
    $smtpserverport = 25; //SMTP服务器端口
    $smtpusermail = "paino1@yeah.net"; //SMTP服务器的用户邮箱
    if ($t)
        $smtpemailto = "hr@nomura-sh.cn"; //发送给谁
    else
        $smtpemailto = "info@nomura-sh.cn";
//    $smtpemailto = "paino1@126.com";
    $smtpuser = "paino1@yeah.net"; //SMTP服务器的用户帐号
    $smtppass = 'mk123456'; //SMTP服务器的用户密码
    if ($isEn) {
        $mailsubject = 'You have received a feedback from customers'; //邮件主题
    } else {
        $mailsubject = '您收一条来自客户的意见';
    }
    $mailbody = $content; //邮件内容
    $mailtype = "TXT"; //邮件格式（HTML/TXT）,TXT为文本邮件
##########################################
    $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = FALSE; //是否显示发送的调试信息
    $end = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

    if ($end) {
//        echo $end;
        if ($isEn) {
            $msg = 'Thanks for your suggestion, we will give a feedback soon.';
        } else {
            $msg = '感谢您的提交！我们会及时给您回复。';
        }
        $str = '<script>alert("' . $msg . '");window.history.back();</script>';
    } else {
        if ($isEn) {
            $msg = 'Failure, please retry.';
        } else {
            $msg = '很抱歉，提交失败，请重试。';
        }
        $str = '<script>alert("' . $msg . '");window.history.back();</script>';
//        echo "发送成功！";
//    echo $replyMail . ' and ' . $mail_type . ' and ' . $mail_txtar;
    }
} else {
    $str = '<script>alert("Invalid request, please try again.");window.history.back();</script>';
}
echo $str;
exit(0);
//$mailsend = 'send@nomura-sh.cn';
//$service = 'mail.nomura-sh.cn';
?>