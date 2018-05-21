<?php

include("../MySQL_Connections/config.php");


    $sql = "SELECT * FROM `colorSchemes`";
    $result = $conn->query($sql) or die("Query fail");
        


?>
<html>
    <head>
        <title>Color Scheme Viewer</title>
        <style>
            td{
                width:30px;
                height:30px;
            }
        </style>
    </head>
    <body>
        
        <table>
            <tr>
                <th>Red</th>
                <th>Green</th>
                <th>Yellow</th>
                <th>Blue</th>
                <th>Orange</th>
                <th>Purple</th>
                <th>Pink</th>
                <th>Brown</th>
                <th>Black</th>
            </tr>
            <?php
                                   //baseColors Viridian,   Atlantean   Carmine     DayBreak    Sangria     Sapphire    Autumnal    Espresso    Gunmetal    High Roller LemonDrop   Sakura      City-Blue   GoldCity
                $baseColors     = ["#FFFFFF",   "#55ad52",  "#007393",  "#9a3432",  "#ca4d27",  "#a04664",  "#3366CC",  "#DFAE2E",  "#bb9966",  "#71618f",  "#fffbb6",  "#ffdf30",  "#b8226f",  "#C9A23A", "#003056"];
                $blueArray      = ["#0247FE",   "#3c8e86",  "#0156d9",  "#3041c1",  "#3448c8",  "#2a47d8",  "#094cf6",  "#4466c0",  "#305cd8",  "#2e51d2",  "#356bf0",  "#416dca",  "#423acc",  "#4867b9", "#013aa2"]; //High Water 
                $yellowArray    = ["#FEFE33",   "#a1d144",  "#d8e941",  "#ead633",  "#f9ec32",  "#f0e23a",  "#d5e052",  "#f8ee32",  "#ede540",  "#dbd74a",  "#fefd6e",  "#fef933",  "#f4dd3c",  "#dcc238", "#cbd53a"]; //Pot Hole
                $brownArray     = ["#663300",   "#625214",  "#3d4d3b",  "#73330c",  "#7a3808",  "#7a3a23",  "#57423d",  "#84520c",  "#774714",  "#6c4a48",  "#8c652e",  "#8c5e0c",  "#7f2e21",  "#93651a", "#4c3216"]; //Tree Branch
                $purpleArray    = ["#8601AF",   "#753d8e",  "#5729a5",  "#8c108a",  "#941094",  "#8b0fa0",  "#7a10b3",  "#9c2c8f",  "#93279d",  "#830faa",  "#a440b1",  "#a4388f",  "#9008a2",  "#9a318c", "#7208a2"]; //Trash Full
                $orangeArray    = ["#FC600A",   "#db6f18",  "#ca6425",  "#ed5910",  "#f75e0d",  "#f35d13",  "#ca623a",  "#ec8b1e",  "#dc7c38",  "#e06025",  "#fda657",  "#fd9319",  "#f55a14",  "#ed7418", "#ca5619"]; //Litter
                $greenArray     = ["#66B032",   "#62af3a",  "#38955e",  "#739132",  "#75a130",  "#729b3c",  "#579a60",  "#84b031",  "#7baa3f",  "#69984e",  "#8cc353",  "#85b932",  "#76943e",  "#84ac34", "#337044"]; //Overgrown Brush
                $redArray       = ["#FE2712",   "#ed3418",  "#7f4d52",  "#b3312a",  "#fb2913",  "#eb2d22",  "#cb3740",  "#f93b16",  "#e05a38",  "#db3631",  "#fe5133",  "#fe4316",  "#f02625",  "#f93316", "#982b2d"]; //Vandalism
                $pinkArray      = ["#C21460",   "#9c4a5b",  "#9b276a",  "#ba1a57",  "#c42252",  "#b82361",  "#a52476",  "#cb4251",  "#c03562",  "#a62f70",  "#d14e76",  "#d14754",  "#c01763",  "#c43f55", "#741f5c"]; //Suspicious Persons
                $blackArray     = ["#808080",   "#758b74",  "#667d84",  "#857170",  "#8f766e",  "#887279",  "#6d7a93",  "#938970",  "#8c857b",  "#7d7a83",  "#a09f8e",  "#999370",  "#8b6d7d",  "#92886e", "#606c76"]; //Other
                
                
                
                
            ?>
            
            
        </table>
        
            <?php while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
                        switch ($row['name']){
                            case 'Viridian':
                                $backgroundColor="#1B371A";
                                $TopBoxColor="#448b41";
                                $MidBoxColor="#55ad52";
                                $BottomBoxColor="#77be74";
                                $colorArray = [$blueArray[1],$yellowArray[1],$brownArray[1],$purpleArray[1],$orangeArray[1],$greenArray[1],$redArray[1],$pinkArray[1],$blackArray[1]];
                                break;
                            case 'Atlantean':
                               $backgroundColor="#003f6a";
                                $TopBoxColor="#005066";
                                $MidBoxColor="#007393";
                                $BottomBoxColor="#008cb3";
                                $colorArray = [$blueArray[2],$yellowArray[2],$brownArray[2],$purpleArray[2],$orangeArray[2],$greenArray[2],$redArray[2],$pinkArray[2],$blackArray[2]];
                                break;
                            case 'Carmine':
                               $backgroundColor="#440201";
                                $TopBoxColor="#782827";
                                $MidBoxColor="#9a3432";
                                $BottomBoxColor="#c1413e";
                                $colorArray = [$blueArray[3],$yellowArray[3],$brownArray[3],$purpleArray[3],$orangeArray[3],$greenArray[3],$redArray[3],$pinkArray[3],$blackArray[3]];
                                break;
                            case 'Daybreak':
                               $backgroundColor="#bd2327";
                                $TopBoxColor="#d43727";
                                $MidBoxColor="#ca4d27";
                                $BottomBoxColor="#e19226";
                                $colorArray = [$blueArray[4],$yellowArray[4],$brownArray[4],$purpleArray[4],$orangeArray[4],$greenArray[4],$redArray[4],$pinkArray[4],$blackArray[4]];
                                break;
                            case 'Sangria':
                               $backgroundColor="#30151e";
                                $TopBoxColor="#7d374e";
                                $MidBoxColor="#a04664";
                                $BottomBoxColor="#b95f7d";
                                $colorArray = [$blueArray[5],$yellowArray[5],$brownArray[5],$purpleArray[5],$orangeArray[5],$greenArray[5],$redArray[5],$pinkArray[5],$blackArray[5]];
                                break;
                            case 'Sapphire':
                               $backgroundColor="#0D0038";
                                $TopBoxColor="#333399";
                                $MidBoxColor="#3366CC";
                                $BottomBoxColor="#3399FF";
                                $colorArray = [$blueArray[6],$yellowArray[6],$brownArray[6],$purpleArray[6],$orangeArray[6],$greenArray[6],$redArray[6],$pinkArray[6],$blackArray[6]];
                                break;
                            case 'Autumnal':
                               $backgroundColor="#A12B21";
                                $TopBoxColor="#C66629";
                                $MidBoxColor="#DFAE2E";
                                $BottomBoxColor="#838A2D";
                                $colorArray = [$blueArray[7],$yellowArray[7],$brownArray[7],$purpleArray[7],$orangeArray[7],$greenArray[7],$redArray[7],$pinkArray[7],$blackArray[7]];
                                break;
                            case 'Espresso':
                               $backgroundColor="#754719";
                                $TopBoxColor="#996633";
                                $MidBoxColor="#bb9966";
                                $BottomBoxColor="#ffcc99";
                                $colorArray = [$blueArray[8],$yellowArray[8],$brownArray[8],$purpleArray[8],$orangeArray[8],$greenArray[8],$redArray[8],$pinkArray[8],$blackArray[8]];
                                break;
                            case 'Gunmetal':
                               $backgroundColor="#434345";
                                $TopBoxColor="#54486a";
                                $MidBoxColor="#71618f";
                                $BottomBoxColor="#8676a2";
                                $colorArray = [$blueArray[9],$yellowArray[9],$brownArray[9],$purpleArray[9],$orangeArray[9],$greenArray[9],$redArray[9],$pinkArray[9],$blackArray[9]];
                                break;
                            case 'High Roller':
                               $backgroundColor="#fde968";
                                $TopBoxColor="#fdee87";
                                $MidBoxColor="#fffbb6";
                                $BottomBoxColor="#fafad2";
                                $colorArray = [$blueArray[10],$yellowArray[10],$brownArray[10],$purpleArray[10],$orangeArray[10],$greenArray[10],$redArray[10],$pinkArray[10],$blackArray[10]];
                                break;
                            case 'Lemon Drop':
                               $backgroundColor="#f6d91e";
                                $TopBoxColor="#f9ae17";
                                $MidBoxColor="#ffdf30";
                                $BottomBoxColor="#ffeaa4";
                                $colorArray = [$blueArray[11],$yellowArray[11],$brownArray[11],$purpleArray[11],$orangeArray[11],$greenArray[11],$redArray[11],$pinkArray[11],$blackArray[11]];
                                break;
                            case 'Sakura':
                               $backgroundColor="#6c1442";
                                $TopBoxColor="#6C0A3E";
                                $MidBoxColor="#b8226f";
                                $BottomBoxColor="#eb74ad";
                                $colorArray = [$blueArray[12],$yellowArray[12],$brownArray[12],$purpleArray[12],$orangeArray[12],$greenArray[12],$redArray[12],$pinkArray[12],$blackArray[12]];
                                break;
                            case 'City':
                               $backgroundColor="#003056";
                                $TopBoxColor="linear-gradient(#91662F, #C9A23A, #FBF295)";
                                $MidBoxColor="linear-gradient(#91662F,#FBF295, #C9A23A)";
                                $BottomBoxColor="linear-gradient(#FBF295, #C9A23A, #91662F)";
                                $colorArray = [$blueArray[13],$yellowArray[13],$brownArray[13],$purpleArray[13],$orangeArray[13],$greenArray[13],$redArray[13],$pinkArray[13],$blackArray[13]];
                                break;
                            case 'GoldCity':
                               $backgroundColor="#6c1442";
                                $TopBoxColor="#6C0A3E";
                                $MidBoxColor="#b8226f";
                                $BottomBoxColor="#eb74ad";
                                $colorArray = [$blueArray[14],$yellowArray[14],$brownArray[14],$purpleArray[14],$orangeArray[14],$greenArray[14],$redArray[14],$pinkArray[14],$blackArray[14]];
                                break;
                        }
                        
                        
            
            
            ?>
            <table style="border:6px solid black">
                <tr><th colspan="4">Color Scheme: <?php echo $row['name'];?></th></tr>
                <tr>
                    <td>Background<br/>Color</td>
                    <td>Top Box <br/>Color</td>
                    <td>Mid Box <br/>Color</td>
                    <td>Bottom Box <br/>Color</td>
                
                </tr>
                 <tr>
                    <td style="background-color:<?php echo $backgroundColor;?>"></td>
                    <td style="background-color:<?php echo $TopBoxColor;?>"></td>
                    <td style="background-color:<?php echo $MidBoxColor;?>"></td>
                    <td style="background-color:<?php echo $BottomBoxColor;?>"></td>
                
                </tr>
                <tr>
                    <td>High Water</td>
                    <td>Pothole</td>
                    <td>Tree/Branch</td>
                    <td>Trash Full</td>
                    <td>Litter</td>
                    <td>Overgrown Brush</td>
                    <td>Vandalism</td>
                    <td>Suspicious Persons</td>
                    <td>Other</td>
                </tr>
                
                <tr>
                    <td style="background-color:<?php echo $colorArray[0];?>;"></td>
                    <td style="background-color:<?php echo $colorArray[1];?>"></td>
                    <td style="background-color:<?php echo $colorArray[2];?>"></td>
                    <td style="background-color:<?php echo $colorArray[3];?>"></td>
                    <td style="background-color:<?php echo $colorArray[4];?>"></td>
                    <td style="background-color:<?php echo $colorArray[5];?>"></td>
                    <td style="background-color:<?php echo $colorArray[6];?>"></td>
                    <td style="background-color:<?php echo $colorArray[7];?>"></td>
                    <td style="background-color:<?php echo $colorArray[8];?>"></td>
                </tr>
            </table>
            <br/><br/>
            <?php } ?>
    </body>
</html>