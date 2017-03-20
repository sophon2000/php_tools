<?php
/**
 * A Example For Send Email
 */
header("content-type:text/html;charset=utf-8"); 
ini_set("magic_quotes_runtime",0); 

require_once("../vendor/autoload.php");

$mail = new PHPMailer;

$mail->SMTPDebug = 1;                                 //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->CharSet='UTF-8';                               // Set Charset

$mail->Host = 'smtp.qq.com';                          // Specify main and backup SMTP servers
$mail->Helo = 'Hello smtp.qq.com Server';             //设置smtp的helo消息头 这个可有可无 内容任意
$mail->Hostname = 'jjonline.cn';                      //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名

$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '1226900993@qq.com';                // SMTP username
$mail->Password = 'passWord';                         // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable ssl encryption, tls also accepted
$mail->Port = 465;                                    // TCP port to connect to always is 465or587 Check in network

$mail->setFrom('1226900993@qq.com', 'GeorgeBai123');  // Defined a sender  , Option sender name
$mail->addAddress('767991879@qq.com', 'Guo DaYue');   // Add a recipient can make multipart address
$mail->addReplyTo('1226900993@qq.com', 'Information');// replay address
$mail->addCC("aaaa@inspur.com");                      // 设置邮件抄送人
$mail->addBCC("bbbb@163.com");                        // 设置秘密抄送人

$mail->addAttachment('C:\wamp64\www\Develop\read.me');                       // Add attachments
$mail->addAttachment('C:\wamp64\www\Develop\composer.json', 'my.json');      // Optional name
$mail->isHTML(true);                                                         // Set email format to HTML
$mail->Subject = 'Here is the subject';                                      // Title
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';            // Body
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // compat can't use HTML
$mail->WordWrap = 80;                                                        // Set row length 


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}


/**
 * [ihttp_email 发送email]
 * @param  [type]  $to      string  [收件人邮箱]
 * @param  [type]  $subject string  [邮件主题]
 * @param  [type]  $body    string  [邮件内容]
 * @param  boolean $global  boolean [是否使用系统邮箱配置信息，默认使用]
 * @return [type]                   [发送成功返回 true, 失败返回错误信息]
 */
function ihttp_email($to, $subject, $body, $global = false,$config=array()) {
	static $mailer;
	set_time_limit(0);

	if (empty($mailer)) {
		if (!class_exists('PHPMailer')) {
			require '../vendor/autoload.php';
		}
		$mailer = new PHPMailer();
		$config = $GLOBALS['_W']['setting']['mail'];
		$config['charset'] = 'utf-8';
		if ($config['smtp']['type'] == '163') {
			$config['smtp']['server'] = 'smtp.163.com';
			$config['smtp']['port'] = 25;
		} elseif ($config['smtp']['type'] == 'qq') {
			$config['smtp']['server'] = 'ssl://smtp.qq.com';
			$config['smtp']['port'] = 465;
		} else {
			if (!empty($config['smtp']['authmode'])) {
				$config['smtp']['server'] = 'ssl://' . $config['smtp']['server'];
			}
		}

		if (!empty($config['smtp']['authmode'])) {
			if (!extension_loaded('openssl')) {
				return error(1, '请开启 php_openssl 扩展！');
			}
		}
		$mailer->signature = $config['signature'];
		$mailer->isSMTP();
		$mailer->CharSet = $config['charset'];
		$mailer->Host = $config['smtp']['server'];
		$mailer->Port = $config['smtp']['port'];
		$mailer->SMTPAuth = true;
		$mailer->Username = $config['username'];
		$mailer->Password = $config['password'];
		!empty($config['smtp']['authmode']) && $mailer->SMTPSecure = 'ssl';

		$mailer->From = $config['username'];
		$mailer->FromName = $config['sender'];
		$mailer->isHTML(true);
	}
	if ($body) {
		if (is_array($body)) {
			$body = '';
			foreach($body as $value) {
				if (substr($value, 0, 1) == '@') {
					if(!is_file($file = ltrim($value, '@'))){
						return error(1, $file . ' 附件不存在或非文件！');
					}
					$mailer->addAttachment($file);	
				} else {
					$body .= $value . '\n';
				}
			}
		} else {
			if (substr($body, 0, 1) == '@') {
				$mailer->addAttachment(ltrim($body, '@'));	
				$body = '';
			}
		}
	}
	if (!empty($mailer->signature)) {
		$body .= htmlspecialchars_decode($mailer->signature);
	}
	$mailer->Subject = $subject;
	$mailer->Body = $body;
	$mailer->addAddress($to);
	if ($mailer->send()) {
		return true;
	} else {
		return error(1, $mailer->ErrorInfo);
	}
}