<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
    <style>
        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            height: 320px;
            padding:10px;
        }

        h1 {
            color: #000;
            font-size: 24px;
            font-weight: 400;
            text-align: center;
            margin-top: 20px;
        }

        form{
            text-align: center;
            display:block;
            padding: 14px 20px;
            border:1px solid black;
            border-radius:20px;
            padding-left:20px;
            background-color:#f2f2f2;
        }
        body {
            background-color: #1B371A ;

        }
        input{
            width:30%;
        }

    </style>
</head>
<body>
    <?php
    /**
     * Created by PhpStorm.
     * User: bmwhi
     * Date: 10/13/2017
     * Time: 9:51 PM
     */
    ?>

    <?php include "../Dashboard_Pages/navBar.html"; ?>
    <h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">User Profile</h1>

    <div class="contentBox">
        <form style="border:1px solid black" style="padding:2px">
            <h2>First name:</h2>
            <input type="text" placeholder="Enter First Name" name="firstName"><br>
            <h2>Last name:</h2>
            <input type="test" placeholder="Enter Last Name" name="lastName"><br>
            <h2>Email:</h2>
            <input type="test" placeholder="Enter email" name="email"><br>

            <button type="button">Change password</button>
            <button type="submit">Submit changes</button>

        </form>
    </div>

</body>
</html>

