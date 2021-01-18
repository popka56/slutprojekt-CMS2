<?php
    $path = preg_replace('/wp-content.*$/', '', __DIR__);
    require_once($path.'wp-load.php');
    
    if(isset($_POST['formWasSubmitted']) && $_POST['formWasSubmitted'] == '1' ){
        try{

            //Sanera och spara våra värden
            $subject = $_POST['title'];
            if($_POST['name'] != "" && $_POST['name'] != null){
                $name = sanitize_text_field($_POST['name']);
            }
            else{
                throw new Exception('Du måste skriva ett namn.');
            }
            if($_POST['email'] != "" && $_POST['email'] != null){
                $email = sanitize_email($_POST['email']);
            }
            else{
                throw new Exception('Du måste skriva in en e-post.');
            }
            if($_POST['message'] != "" && $_POST['message'] != null){
                $text = sanitize_textarea_field($_POST['message']);
            }
            else{
                throw new Exception('Du måste skriva ett meddelande.');
            }
            if($_POST['file'] != "" && $_POST['file'] != null){
                $filetype = wp_check_filetype($_POST['file']);
                if($filetype['ext'] != 'pdf'){
                    throw new Exception('Bifogad fil är inte en pdf.');
                }
            }

            //Konstruera meddelandet
            $message = $text . '\n \n' . $name . '\n' . $email;
            $headers = array(
                'Reply-To: ' . $name . '<' . $email . '>',
                'From: My Name <myname@example.com>'
              );
            $attachments = $_POST['file'];

            //Skicka mailet (admin email måste vara av samma domän som sidan för att komma fram)
            wp_mail(get_option('admin_email'), $subject, $message, $headers, $attachments);  

            //Returnera något till användaren
            $response = ['success' => 1, 'message' => 'Ditt meddelande har skickats!'];
            echo json_encode($response);
        }
        catch(Exception $e){
            $response = ['success' => 0, 'message' => 'Oväntat fel! Alla fält med asterisk (*) måste fyllas i.'];
            echo json_encode($response);
        }
    }