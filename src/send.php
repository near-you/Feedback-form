<?php
// Файли phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Змінні, які відправляє користувач
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$text = $_POST['text'];

// Провіряєм валідність EMail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $msg = "ok";
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;

    // Налаштування Вашої пошти
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера
    $mail->Username   = 'ii7961350@gmail.com'; // Логин на почте
    $mail->Password   = 'ivan123123'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('ii7961350@gmail.com', 'Ivan'); // Адрес самой почты

    // Отримувач листа
	$mail->addAddress('cord811@hotmail.com');
	//$mail->addAddress('frankivslava@gmail.com');     

    // Прикріплення файлів до листа
if (!empty($_FILES['myfile']['name'][0])) {
    for ($ct = 0; $ct < count($_FILES['myfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['myfile']['name'][$ct]));
        $filename = $_FILES['myfile']['name'][$ct];
        if (move_uploaded_file($_FILES['myfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Невдалось прикріпити файл ' . $uploadfile;
        }
    }   
}

        // -----------------------
        // Сам лист
        // -----------------------
        $mail->isHTML(true);
    
        $mail->Subject = "З сайту: Тест форми";
        $mail->Body    = "<b>Ім'я:</b> $name <br>
		<b>Пошта:</b> $email<br>
		<b>Телефон:</b> $phone<br><br>
        <b>Повідомлення:</b><br>$text";


// Перевіряємо відправлення повідомлення
if ($mail->send()) {
    echo "$msg";
} else {
echo "Повідомлення не було відправлено. Невірно вказані настройки Вашої пошти";
}

} catch (Exception $e) {
    echo "Повідомлення не було відправлено. Причина помилки: {$mail->ErrorInfo}";
}

} else {
    echo 'mailerror';
}