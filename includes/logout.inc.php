<?php



if (isset($_POST['logout'])){
  
  header ('Location: https://hospiweb.novacdan.ro/login');    
  session_start();
  session_unset();
  session_destroy();
  header("Refresh:1");
  
}
else
  header('Location: https://hospiweb.novacdan.ro/login');
    
?>