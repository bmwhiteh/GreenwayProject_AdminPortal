<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Analytics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        $(Accordian_Style);

        function Accordian_Style() {
            var Accordion = function (el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                // Variables privadas
                var links = this.el.find('.link');
                // Evento
                links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
            };

            Accordion.prototype.dropdown = function (e) {
                var $el = e.data.el;
                $this = $(this);
                $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
                }

            };

            var accordion1 = new Accordion($('#accordion1'), false);
            var accordion2 = new Accordion($('#accordion2'), false);

        }

    </script>
    <style>
        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
        }

        * {
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background-color: #1B371A ;

        }

        ul { list-style-type: none; }

        a {
            color: #b63b4d;
            text-decoration: none;
        }

        /** =======================
         * Contenedor Principal
         ===========================*/


        h1 {
            color: #000;
            font-size: 24px;
            font-weight: 400;
            text-align: center;
            margin-top: 20px;
        }

        h1 a {
            color: #c12c42;
            font-size: 16px;
        }

        .accordion {
            width: 100%;
            max-width: 200px;
            margin: 30px auto 20px;
            display: block;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            background-color: #448B41;

        }

        .menu_background{
            background-color: #448b41;
        }



        .accordion .link {
            cursor: pointer;
            display: block;
            padding: 15px 15px 15px 42px;
            color: #4D4D4D;
            font-size: 14px;
            font-weight: 700;
            border-bottom: 1px solid #CCC;
            position: relative;
            -webkit-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .accordion li:last-child .link { border-bottom: 0; }

        .accordion li i {
            position: absolute;
            top: 16px;
            left: 12px;
            font-size: 18px;
            color: #595959;
            -webkit-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        /*
        .accordion li i.fa-chevron-down {
            right: 12px;
            left: auto;
            font-size: 16px;
        }*/

        .accordion li.open .link { color: white; }

        .accordion li.open i { color: white; }

        .accordion li.open i.fa-chevron-down {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        /**
         * Submenu
         -----------------------------*/


        .submenu {
            display: none;
            background-color: #55ad52;
            font-size: 14px;
        }




        .submenu a {
            display: block;
            text-decoration: none;
            color: #d9d9d9;

            -webkit-transition: all 0.25s ease;
            -o-transition: all 0.25s ease;
            transition: all 0.25s ease;
        }

        .submenu a:hover {
            background: #77be74;
            color: #FFF;
        }

        figcaption {
            margin:auto;
            text-align: center;

        }

    </style>
</head>
<body>

<?php include "../Dashboard_Pages/navBar.html"; ?>


<div class="contentBox">

    <h1 style="margin-bottom: 30px; margin-top:0px; color: white;"><br/><br/>Data Analysis for Viridian</h1>

    <table style="margin:auto;">
        <tr style="vertical-align: top">
            <?php if(($_GET["show"] == "userActivities")|| ($_GET["show"]=="ticketDensity")):?>
                <td>
                    <h3>Choose a Heat Map</h3>

                    <ul id="accordion1" class="accordion">

                        <li class="menu_background">
                            <div class="link">Heat Map</div>
                            <ul class="submenu" style="display:block">
                                <li><a href="#">By User Activity</a></li>
                                <li><a href="#">By Ticket Density</a></li>
                            </ul>

                        </li>
                    </ul>
                </td>

            <?php else: ?>




                <td>
                    <h3>Choose an Analytic</h3>
                    <ul id="accordion2" class="accordion">

                        <li class="menu_background">
                            <div class="link">Tracked Activities</div>
                            <ul class="submenu"<?php if($_GET["show"]=="trackedActivities"):?>style="display:block;"<?php endif?>>
                                <li><a href="#">By Activities</a></li>
                                <li><a href="#">By Time of Day</a></li>
                            </ul>
                        </li>
                        <li class="menu_background">
                            <div class="link">User Information</div>
                            <ul class="submenu" <?php if($_GET["show"]=="userInformation"):?>style="display:block;"<?php endif?>>
                                <li><a href="#">By Height</a></li>
                                <li><a href="#">By Weight</a></li>
                                <li><a href="#">By Gender</a></li>
                                <li><a href="#">By Age</a></li>
                                <li><a href="#">By Activities</a></li>
                            </ul>
                        </li>
                        <li class="menu_background">
                            <div class="link"<?php if($_GET["show"]=="maintenanceTickets"):?>style="display:block;"<?php endif?>>Ticket Information</div>
                            <ul class="submenu">
                                <li><a href="#">By Ticket Type</a></li>
                                <li><a href="#">By Ticket Status</a></li>
                            </ul>
                        </li>
                    </ul>



                </td>
            <?php endif?>

            <td style="width:100px;">

            </td>
            <td>


                <?php if($_GET["show"] == "userActivities"): include "Heat_Maps/user_activities.php";
                    elseif ($_GET["show"]=="ticketDensity"): include "Heat_Maps/ticket_density.php";
                    elseif ($_GET["show"]=="userInformation"): include "Graphs/user_information.php";
                    elseif ($_GET["show"]=="trackedActivities"): include "Graphs/tracked_activities.php";
                    elseif ($_GET["show"]=="maintenanceTickets"): include "Graphs/maintenance_information.php";
                    endif;
                ?>
            </td>
        </tr>

    </table>
</div>

</body>
</html>

