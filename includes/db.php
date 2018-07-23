<?php
    $connection = mysqli_connect('localhost', 'platformahospiwebcastigainfoeducatie', 'platformahospiwebcastigainfoeducatie', 'platformahospiwebcastigainfoeducatie');
    if (!$connection) 
    {
        die ('[DB - Hospiweb] Conectarea la baza de date nu a reusit');
    }
?>