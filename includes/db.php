<?php
    $connection = mysqli_connect('localhost', 'navem', 'navem', 'navem');
    if (!$connection) 
    {
        die ('[DB - Hospiweb] Conectarea la baza de date nu a reusit');
    }
?>