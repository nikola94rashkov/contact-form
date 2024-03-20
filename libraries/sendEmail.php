<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $ok = 'ok';
    $error = 'error';
    $response = array(
        'status' => '',
        'error' => array(),
        'ok' => array()
    );

    function addResponse ($array, $input, $message, $status) {
        $array['status'] = $status;
        $array[$status][$input] = $message;

        return $array;
    }

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();                                            
        $mail->Host       = $_SERVER['HTTP_PHP_MAILER_HOST'];
        $mail->SMTPAuth   = true;    
        $mail->Port       = $_SERVER['HTTP_PHP_MAILER_PORT'];                           
        $mail->Username   = $_SERVER['HTTP_PHP_MAILER_USERNAME'];
        $mail->Password   = $_SERVER['HTTP_PHP_MAILER_PASSWORD'];       
    } catch (Exception $e) {
        $response = addResponse($response, 'error', $e->getMessage(), $error);
        exit(json_encode($response));
    }           

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
   
    if($contentType == 'application/json') {
        $data = file_get_contents("php://input");
        $form = json_decode($data, true);

        if(is_array($form)) {
            foreach($form as $key => $value) {
                $form[$key] = trim(filter_var($value, FILTER_SANITIZE_STRING));
            }

            if(empty($form['name'])){
                $response = addResponse($response, 'name', 'Error. Name cannot be empty.', $error);
            }

            if(empty($form['phone'])){
                $response = addResponse($response, 'phone', 'Error. Phone cannot be empty.', $error);
            } else if (!preg_match('/^[0-9]+$/', $form['phone'])) {
                $response = addResponse($response, 'phone', 'Error. Input must be a valid phone number.', $error);
            }

            if(empty($form['message'])){
                $response = addResponse($response, 'message', 'Error. Message cannot be empty.', $error);
            }

            if(empty($form['email'])){
                $response = addResponse($response, 'email', 'Error. Email cannot be empty.', $error);
            } else if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                $response = addResponse($response, 'email', 'Error. Input must be a valid email.', $error);
            }

            foreach($response['error'] as $field => $message) {
                if(!empty($message)) {
                    exit(json_encode($response));
                }
            }

            try {
                $mail->setFrom('contactformnr@gmail.com', 'Mailer');
                $mail->Subject = "Email from: {$form['name']}, phone: {$form['phone']}";
                $mail->Body = $form['message'];
                $mail->addAddress($form['email']);

                $mail->send();
            } catch(Exception $e) {
                $response = addResponse($response, 'error', $e->getMessage(), $error);
                exit(json_encode($response));
            }

            $response = addResponse($response, 'message', 'Success! Message has been sent.', $ok);
            exit(json_encode($response));
        }
    }

    $response = addResponse($response, 'error', 'Error!!', $error);
    exit(json_encode($response));
