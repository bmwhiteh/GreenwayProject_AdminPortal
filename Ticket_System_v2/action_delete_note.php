<?php
            include("../MySQL_Connections/config.php");
    if(isset($_GET['noteId'])){
        $sqlDeleteNote = "DELETE FROM ticketnotes WHERE noteId =". $_GET['noteId'];
        $resultDeleteNote = $conn->query($sqlDeleteNote) or die("Delete note fail. $sqlDeleteNote End.");
    }
    
    header("location: ticket_info_single.php?ticketid=".$_GET['ticketid']."");
?>