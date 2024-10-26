<?php

require_once('../TCPDF/tcpdf_import.php');
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$name = $_POST['name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['Email'];
$address = $_POST['address'];
$donation_amount = (int)$_POST['rating']; 
$comments = $_POST['comments'];

// 创建数据库连接
$servername = "localhost";   // 数据库服务器地址
$username = "CS380B";          // 数据库用户名
$password = "YZUCS380B";              // 数据库密码
$dbname = "CS380B";     // 要连接的数据库名称
$conn = new mysqli($servername, $username, $password, $dbname);
// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO s1111442 (name, phone_number, email, address, donation_amount, comments) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssis", $name, $phone_number, $email, $address, $donation_amount, $comments); 

if (!$stmt->execute()) {
  echo "Error: " . $sql . "<br>" . $stmt->error;
}

// 关闭连接
$stmt->close();
$conn->close();
/*---------------- Print PDF Start -----------------*/
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('cid0jp','', 12); 
$pdf->AddPage();

// 設定 CSS 樣式
$css = '
    <style>
        .header { font-size: 18px; text-align: center; margin-bottom: 20px; color: rgb(31, 88, 173);}
        .table { border: 1px solid black; width: 480px; height: 200px;}
        .table td { border: 1px solid black; }
        .table th { background-color: LightGrey; border: 1px solid black; }
    </style>
';

// 表格 HTML
$html = $css . '
    <div class="header">捐款確認表單</div>
	<p>捐款者資料:</p>
    <table class="table">
        <tr height = "25%">
            <th>姓名:</th>
			<td>' . $name . '</td>
			<th>電話:</th>
            <td>' . $phone_number . '</td>
        </tr>
        <tr height = "25%">
            <th>Email:</th>
            <td colspan = "3">' . $email . '</td>
        </tr>
        <tr height = "25%">
            <th>地址:</th>
            <td colspan = "3">' . $address . '</td>
        </tr>
        <tr height = "25%">
            <th>捐款金額:</th>
            <td colspan = "3">' . $donation_amount . ' 元</td>
        </tr>
    </table>
';

/*---------------- Print PDF End -------------------*/
$pdfFileName = 'donation_form.pdf';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();


/*
$pdf->Output($pdfFileName, 'F'); // 保存 PDF 文件
$pdfFilePath = 'http://140.138.155.243/s1111442/public_html/HW2/' . $pdfFileName; // 设置 PDF 文件的 URL
$pdf->Output('donation_form.pdf', 'F'); // 保存 PDF 到伺服器 ('F' 代表存儲)


$qrCode = new QrCode($pdfFilePath); // 使用 PDF 文件的 URL 生成 QR Code
$qrCode->setSize(300);
$qrCode->setMargin(10);

$qrCodeImage = 'qrcode.png'; // 定义 QR Code 图像路径
$writer = new PngWriter();
$writer->write($qrCode)->saveToFile($qrCodeImage); // 保存 QR Code 图片

$pdf->writeHTML($html);
$pdf->lastPage();
*/

$pdf->Output('order.pdf', 'I');
/*---------------- Sent Mail Start -----------------*/
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/*$qrCode = new QrCode("捐款者: $name，金額: $donation_amount");
$qrCode->setSize(300);
$qrCode->setMargin(10);
$qrCode->writeFile('qrcode.png'); // 儲存 QR Code 圖片*/

$mail = new PHPMailer(true);
try {
	// 伺服器設定
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com'; // 設定SMTP主機
	$mail->SMTPAuth = true;
	$mail->Username = 'x59271648@gmail.com'; // SMTP用戶名
	$mail->Password = 'utqh ngcz npnm iyab'; // SMTP密碼
	$mail->SMTPSecure = 'tls'; // 加密方式
	$mail->Port = 587; // SMTP埠號
	
	// 收件人設定
	$mail->setFrom('x59271648@gmail.com', '1111442');
	$mail->addAddress($email, $name); // 添加收件人
	
	// 郵件內容
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8'; // 設定字符編碼為 UTF-8
	$mail->Subject = '捐款確認信';
	$mail->Body = "
		<h1>感謝您的捐款！</h1>
		<p>以下是您提供的資訊：</p>
        <ul>
            <li>姓名： $name</li>
            <li>電話： $phone_number</li>
            <li>Email: $email</li>
            <li>地址： $address</li>
            <li>捐款金額： $donation_amount 元</li>
			<li>意見： $comments</li>
        </ul>
        <p>感謝您的支持！</p>
    ";
	//$mail->addAttachment('qrcode.png'); // 附加QR Code
	
	// 寄送郵件
	if (!$mail->send()) {
		print ("<p>郵件發送失敗！</p>");
	} 
} catch (Exception $e) {
	echo "郵件發送失敗：{$mail->ErrorInfo}";
}

/*---------------- Sent Mail End -------------------*/

?>
