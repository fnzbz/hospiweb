<?php
    function generateEmail($to, $code, $page, $page_error, $errno_success, $errno_error, $subject = 'schimbare mail')
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $subject = "HospiWeb - ".$subject;
        $link = 'https://hospiweb.novacdan.ro/'.$page.'?code='.$code;
        $message = 'Iti poti schimba e-mailul contului tau accesand urmatorul link: ' . $link;
        $result = mail($to, $subject, $message, $headers);
        if($result == true)
        {
            $link_success = "Location: https://hospiweb.novacdan.ro/".$page_error."?succes=".$errno_success;
            header($link_success);
        }
        else
        {
            $link_error = "Location: https://hospiweb.novacdan.ro/".$page_error."?eroare=".$errno_error;    
            header($link_error);
        }
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
?>