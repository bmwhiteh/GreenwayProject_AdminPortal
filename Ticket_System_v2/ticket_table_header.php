<?php

    /*
    *   Author: Bailey Whitehill
    *   Description: This is a header file for the ticket viewing pages to reduce the amount of duplicate code. 
                      It must contain the scripts for the viewing ticket and adding a ticket modals.
    *
    */
     include("../Dashboard_Pages/navBar.php"); 
     require_once("../Login_System/verifyAuth.php"); 

    $sqlTicketTypes = "SELECT `strTicketType`,`intTypeId` FROM `tickettypes` LIMIT 0, 30 ";
    $resultTicketTypes = $conn->query($sqlTicketTypes) or die("Query fail");
    require_once("modal_add_ticket.php");
    
?>
<!--DOCTYPE html-->
<html>
    <head>
    
      <script src="../js/jquery-3.2.1.min.js"></script>
      <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>

      <!---Ticket System CSS--->
      <link rel="stylesheet" href="../Ticket_System_v2/ticket_system.css">
      
      <!---Bootrap for the Modals--->
      <link rel="stylesheet" href="./bootstrap.css">
      <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
      
      <!---Javascript file to use Google Maps API--->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&libraries=visualization"></script>
      
      
      <!---Javascript to open & Close Modals, and populate the Google Maps with the Markers--->
            <script src=/Ticket_System_v2/functions.js></script>
      
    </head>
    <?php
        if (isset($_COOKIE['page_number'])) {
            $pageno = $_COOKIE['page_number'];
        } else {
            $pageno = 1;
            setcookie("page_number", $pageno, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
        
        if(isset($_COOKIE['page_view'])){
            $view = $_COOKIE['page_view'];
            
        }else{
            $view = "cards";
            setcookie("page_view", $view, time() + (86400 * 30), "/"); // 86400 = 1 day

        }
        
        if(isset($_COOKIE['ticket_status'])){
            $status = $_COOKIE['ticket_status'];
            
        }else{
            $status = "open";
            setcookie("ticket_status", $status, time() + (86400 * 30), "/"); // 86400 = 1 day

        }
        
        
        if(isset($_POST['ticketid'])){$id = $_POST['ticketid'];}elseif (isset($_GET['ticketid'])){$id = $_GET['ticketid'];}
    ?>
    <body class="genericBody" onLoad="FilterResults(<?php echo $pageno?>, 'all');<?php if(isset($id)){echo "openTicket($id,0,0)";}?>">
            <div id="txtLoading" class="txtLoading"></div>

     <div class="contentBox" >
        
        <div class="theBox">
<br/><br/>
     <div class="header_box">
        <div class="header_options_title">Ticket Options</div>

          <div>
             <form name="setViewPreferences" onChange="FilterResults(<?php echo $pageno;?>, 'all');">
               <table>
                 <tr>
                    <td>
                        <input type="checkbox" name="ShowUserTickets"  id="ShowUserTickets" >
                        My Tickets Only
                    </td>
                    <input type="hidden" id="userId" name="userId" value="<?php echo $_COOKIE['user'];?>">
                   <td class="header_options_td_30">
                      Ticket Status: <br/>
                            
                       <select name="statOpenClosed" id="statOpenClosed" >
                          
                          <option value="open" <?php if ($_COOKIE['ticket_status'] == "open"){echo "selected";}?>>Open</option>
                         <option value="closed" <?php if ($_COOKIE['ticket_status'] == "closed"){echo "selected";}?>>Closed</option>
                          <option value="all" <?php if ($_COOKIE['ticket_status'] == "all"){echo "selected";}?>>All</option>
                       </select>
                   </td>
                   <td class="header_options_td_30">
                      Ticket View:<br/>
                      
                      <input type="radio" id="cardView" name="ticketView" class="header_options_view"  <?php if($_COOKIE['page_view'] == "cards"){echo "checked";}?>/>
                      <label for="cardView">
                        <img src="/Ticket_System_v2/Iconography/cards_icon.png" class="header_options_view_img" title="View As Cards" id="viewCards">
                      </label>

                  
                  <input type="radio" id="tableView" name="ticketView" class="header_options_view"  <?php if($_COOKIE['page_view'] == "table"){echo "checked";}?>/>
                  <label for="tableView" >
                          <img src="/Ticket_System_v2/Iconography/table_icon.png" class="header_options_view_img"  title="View As Table" id="viewTable" >

                  </label>
                   </td>
                   <td class="header_options_td_30"><button class="header_add_ticket" type="button" name="myBtn" id="myBtn" onClick="openModal();initialize();">Add Ticket</button></td>
                 </tr>
               </table>
               
             </form>
            

        </div> 
        
      
      
     </div>
    
      
    
      <!---View Ticket Modal Window--->
      <div id="myTicket" class="modal" style="display:none;"></div>



  

      <div id="TicketTable"></div>

</div>
      
      </div>
     
</body>
</html>