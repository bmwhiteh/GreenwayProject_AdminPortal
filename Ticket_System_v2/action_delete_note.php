<?php
    
    /*
    *   Author: Bailey Whitehill
    *   Description: Allow Managers to delete notes
    *
    */
    
    //connect to the database
    include("../MySQL_Connections/config.php");
    
    //as long as we have the noteid, we can delete it
    if(isset($_GET['noteId'])){
        $sqlDeleteNote = "DELETE FROM ticketnotes WHERE noteId =". $_GET['noteId'];
        $resultDeleteNote = $conn->query($sqlDeleteNote) or die("Delete note fail. $sqlDeleteNote End.");
    }
    
    header("location: ticket_table_header.php");
?>