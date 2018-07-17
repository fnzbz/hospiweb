<?php
    require '../../../includes/db.php';
    session_start();
    
    if(isset($_POST['text_diag']) && !empty($_POST['text_diag']))
    {
        $textCurat = mysqli_real_escape_string($connection, $_POST['text_diag']);
        if(isset($_SESSION['utilizator_edit']))
        {
            $id = $_SESSION['utilizator_edit'];
            
            $query_select = "SELECT * FROM diagnostic_pacient WHERE accountID = '$id'";
            $res = $connection->query($query_select);
            if($res->num_rows)
            {
                $name = $_SESSION['utilizator'];
                $query_Update = "UPDATE diagnostic_pacient SET text = '$textCurat', time = CURRENT_TIMESTAMP, medic = '$name' WHERE accountID = '$id'";
                mysqli_query($connection, $query_Update);

                header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id=' . $_SESSION['utilizator_edit']);         
            }
            else
            {
                $idx = $_SESSION['utilizator'];
                $query_Insert = "INSERT INTO diagnostic_pacient (accountID, text, medic) VALUES ('$id', '$textCurat', '$idx')";
                
                mysqli_query($connection, $query_Insert);

                header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id=' . $_SESSION['utilizator_edit']); 
            }
        }
    }
    else
        header('Location: https://hospiweb.novacdan.ro/panel/profil/utilizator?id=' . $_SESSION['utilizator_edit']); 
?>