<!--DOCTYPE html-->
<html>
    <head>
        <style>
         /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 15%; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
      <script>
          function openModal(){
              document.getElementById("myModal").style.display="block";
          }
      </script>
    </head>
    <body>
        
    
    
      
      
    

<div style="float: right; margin: 30px 50px 0px 50px">
    <button style="width:100px; height:50px;" type="button" name="myBtn" onClick="openModal();">Add Ticket</button>
    
</div>   




<?php

    $sqlTicketTypes = "SELECT `strTicketType`,`intTypeId` FROM `tickettypes` LIMIT 0, 30 ";
    $resultTicketTypes = $conn->query($sqlTicketTypes) or die("Query fail");

?>

<!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <h3 class="modal-title">Add New Maintenance Ticket</h3>
                <div class="modal-body">
                <form action="./action_add_ticket.php" method="get" class="form-horizontal" role="form">
                    <!--Use a default user id for all employee-created tickets and add a note with the name of the author-->
                    <input type="hidden" name="intUserId" value="999">
                    <input type="hidden" name="dtSubmitted" value="<?php echo date("Y-m-d")?>">
                    
                    
                    <input type="hidden" name="strTime" value="<?php echo date("H:i:s")?>">
                    
                        <!--Title of Ticket-->
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="content" name="strTitle"/>
                            </div>
                        </div>
                        
                        <!--Description-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="dtSend" >Ticket Description</label>
                            <div class="col-sm-10">
                                <textarea name="strDescription"  class="form-control" id="dtSend"></textarea>
                            </div>
                        </div>
                        
                         <!--Upload an Image if available-->
                         <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Upload Image</label>
                            <div class="col-sm-10">
                                 <input type="file" class="form-control" name="strImageFilePath">

                            </div>
                        </div>
                        
                        <!--Ticket Type-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="strNotificationType">Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="strNotificationType" name="intTypeId">
                                     <?php while($row = $resultTicketTypes->fetch_array(MYSQLI_ASSOC)){ ?>
                                        <option value="<?php echo $row['intTypeId']?>"><?php echo $row['strTicketType']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="dtSend" >Urgent</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="bitUrgent" class="form-control">
                    
                            </div>
                        </div>
                        
                        <!--Submit Button-->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
    
                    </form>
                </div>
            </div>

        </div>
        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // When the user clicks on <span> (x), close the modal
            document.getElementById("closeModal").onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        



<div>
    <!--Different View Options-->
    <div style="text-align:center;padding:10px;">
        <span style="font-size: 20px; font-weight:bold;">View As:</span>
        <?php 
            $current_file_name = basename($_SERVER['PHP_SELF']);
            if($current_file_name == 'ticket_table_table.php'){
                $icon_style_table="border: 3px solid black;padding:10px; background-color:green;";
                $icon_style_list="border: none; background-color:none;";
                $icon_style_cards="border: none; background-color:none;";
            } else if($current_file_name == 'ticket_table_list.php'){
                 $icon_style_table="border: none; background-color:none;";
                $icon_style_list="border: 3px solid black;padding:10px; background-color:green;";
                $icon_style_cards="border: none; background-color:none;";
            } else if($current_file_name == 'ticket_table_cards.php'){
                 $icon_style_table="border: none; background-color:none;";
                $icon_style_list="border: none; background-color:none;";
                $icon_style_cards="border: 3px solid black;padding:10px; background-color:green;vertical-align:middle";
            } else {
                 $icon_style_table="border: none; background-color:none;";
                $icon_style_list="border: none; background-color:none;";
                $icon_style_cards="border: none; background-color:none;";

            }
            echo $icon_style;
        ?>
        <a href="ticket_table_list.php?tickets=<?php echo $_GET['tickets']?>" style="<?php echo $icon_style_list;?>"><img src="list_icon.png" style="width:30px;vertical-align:middle;" title="View As List"></a> &nbsp; 
        <a href="ticket_table_cards.php?tickets=<?php echo $_GET['tickets']?>" style="<?php echo $icon_style_cards;?>"><img src="cards_icon.png" style="width:30px;vertical-align:middle;" title="View As Cards"></a> &nbsp; 
        <a href="ticket_table_table.php?tickets=<?php echo $_GET['tickets']?>" style="<?php echo $icon_style_table;?>"><img src="table_icon.png" style="width:30px;vertical-align:middle;" title="View As Table"></a>
    </div>
    
    
     <!--Different View Options-->
    <div style="text-align:center; margin:auto;">
        <a href="ticket_table_table.php?tickets=open">
            <?php if($_GET['tickets'] == "open"){?>
                <img src="open_only_icon.png" style="width:200px; vertical-align:middle;">                
            <?php }else if($_GET['tickets'] == "closed"){?>
                <img src="open_icon.png" style="width:200px; vertical-align:middle;">
            <?php } ?>
        </a> &nbsp; 
        <a href="ticket_table_table.php?tickets=closed">
            <?php if($_GET['tickets'] == "open"){ ?>
                <img src="closed_icon.png" style="width:200px; vertical-align:middle;">
            <?php }else if($_GET['tickets'] == "closed"){ ?>
                <img src="closed_only_icon.png" style="width:200px; vertical-align:middle;">
            <?php } ?>
        </a> &nbsp; 
    </div>   
    
    
    <!--<div style="font-size:28px; font-weight:bold;text-align:center;">
        <?php 
        if($_GET['tickets'] == "open"){
            echo 'Open Tickets';
        }
        else if($_GET['tickets'] == "closed"){
            echo 'Closed Tickets';
        }
        else{
            echo 'All Tickets';
        }?>
    </div>-->
</div>
<br/>
    
           
</body>
</html>