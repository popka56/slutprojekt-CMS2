<?php
    //Dessa behövs så allt fungerar som det ska
    $path = preg_replace('/wp-content.*$/', '', __DIR__);
    require_once($path.'wp-load.php');

    //Sanera, om formuläret skickades
    if(isset($_POST['formWasSubmitted']) && $_POST['formWasSubmitted'] == '1' ){
        try{
            //Sanera våra värden
            $email = sanitize_email($_POST['email']);

            //Skicka till databas
            $table_name = $wpdb->prefix . 'inquiries';

            $wpdb->insert( 
	            $table_name, 
	            array( 
		            'time' => current_time('mysql'), 
                    'email' => $email,
                    'paid' => 0, 
	            ) 
            );

            //Returnera en respons till användaren
            $response = ['success' => 1, 'message' => 'Tack! Du kommer snart få fakturan på mejlen.'];
            echo json_encode($response);
        }
        catch(Exception $e){
            $response = ['success' => 0, 'message' => 'Något gick fel när du skickade skriv in din mejl!'];
            echo json_encode($response);
        }
    }