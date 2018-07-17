<?php
    require 'db.php';
    
    function generateEmail($to, $code)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $subject = "HospiWeb - resetare parola";
        $link = 'https://hospiweb.novacdan.ro/pass-reset?code=' . $code;
        $message = 'Iti poti reseta parola contului tau accesand urmatorul link: ' . $link;
        $result = mail($to, $subject, $message, $headers);
        if($result == true)
            header('Location: https://hospiweb.novacdan.ro/challenge?succes=1');
        else
            header('Location: https://hospiweb.novacdan.ro/challenge?eroare=3');
    }
    
    function genRandStr($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        return $randomString;
    }
    
    if(!empty($_POST['mail']) && isset($_POST['mail']) && !empty($_POST['CNP']) && isset($_POST['CNP']))
    {
        $mail = $_POST['mail'];
        $CNP = filter_input(INPUT_POST, 'CNP', FILTER_SANITIZE_STRING);
        
        $newMail = filter_var($mail, FILTER_SANITIZE_EMAIL);  
        $sqlSelect = "SELECT * FROM utilizatori WHERE mail = '$newMail' AND CNP = '$CNP'";
        
        $result = $connection->query($sqlSelect);
        $row = $result->fetch_assoc();
        $rows = $result->num_rows;
        
        if($rows) 
        { if ($row['confirmedEmail'] == 1){
            $sqlSelect_mailDB = "SELECT * FROM password_reset_req WHERE email = '$newMail' AND CNP = '$CNP'";

            $selectRes = $connection->query($sqlSelect_mailDB);
            $rows_mailDB = $selectRes->num_rows;
            
            $row = $selectRes->fetch_assoc();
            if(!$rows_mailDB)
            {
                $code = genRandStr(25);
                $sqlInsert = "INSERT INTO password_reset_req (CNP,email,code,createTimestamp,expireTimestamp) VALUES ('$CNP', '$newMail', '$code', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()+1800)";
                mysqli_query($connection, $sqlInsert);
                generateEmail($newMail, $code);
            }
            else
            {
                if($row['expireTimestamp'] <= time())
                {
                    $sqlQuery_del = "DELETE FROM password_reset_req WHERE email = '$newMail' AND CNP = '$CNP'";
                    mysqli_query($connection, $sqlQuery_del);
                    
                    $code = genRandStr(25);
                    $sqlInsert = "INSERT INTO password_reset_req (CNP,email,code,createTimestamp,expireTimestamp) VALUES ('$CNP', '$newMail', '$code', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()+1800)";
                    mysqli_query($connection, $sqlInsert);
                    generateEmail($newMail, $code);
                }
                else
                    header('Location: https://hospiweb.novacdan.ro/challenge?eroare=2');
            }
        } else header('Location: https://hospiweb.novacdan.ro/challenge?eroare=3');
        }
        else
           header('Location: https://hospiweb.novacdan.ro/challenge?eroare=1');
    }
    else
        header('Location: https://hospiweb.novacdan.ro/challenge');

?>