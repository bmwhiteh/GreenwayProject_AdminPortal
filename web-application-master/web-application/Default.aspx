<%-- Name: Default
    Edits:
          - 8/9/17 Bailey Whitehill
                This page is the landing page for the Admin Portal. I suggest that we move the analytics off of the 
                main page and onto a separate analysis section of the portal. This page could be converted to a ticket calendar
                or a user interface with large buttons or notifications list. 
   --%>
                


<%@ Page Title="Home" Language="C#" MasterPageFile="~/Master.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="web_application.Default" %>


<asp:Content ID="Content2" ContentPlaceHolderID="ContentBody" runat="server">

    <%--Stylesheet used for this page --%>
    <link href="css/default.css" rel="stylesheet" />

    <%--Javascript files used--%>
    <script type="text/javascript" src="scripts/Chart.min.js"></script>
    <script type="text/javascript" src="js/TicketStats.js"></script>
    <script type="text/javascript" src="js/ActivityStats.js"></script>
    <script type="text/javascript" src="js/AccountStats.js"></script>

    <%--Page Header--%>
    <div id="page-heading">
        <h1>Dashboard</h1>
        <hr style="width: 98%; color: lightgray;" />
    </div>

    <%--Quick Stats produced from the SQL Database Tables--%>
    <div class="quick_stats_div">
        <table class="quick_stats_table" style="text-align:center;">
            <tr>
                <td>
                    <h1 id="accounts"></h1>
                    <br />
                    Number of Accounts
                </td>
                <td>
                    <h1 id="total_tickets"></h1>
                    <br />
                    Ticket Count
                </td>
                <td>
                    <h1 id="active"></h1>
                    <br />
                    Active Ticket Count
                </td>
                <td>
                    <h1 id="closed"></h1>
                    <br />
                    Closed Ticket Count
                </td>
            </tr>
        </table>
    </div>

    
        
    <br />
    <br />
    <br />

    <%--HTML element "canvas" is used to display graphs --%>
    <div class="default_div">

        <h1 style="text-align: center;">Account Statistics</h1>

        <%--Gender based user graph--%>
        <div style="width: 350px; height: 350px; display: inline-block; margin-left: 25px; margin-right: 25px;">
            <canvas id="gender"></canvas>
        </div>

        <%-- Age Based user graph--%>
        <div style="width: 350px; height: 300px; display: inline-block; margin-left: 25px; margin-right: 25px;">
            <canvas id="age"></canvas>
        </div>

        <%--User Activity by Month--%>
        <div style="width: 350px; height: 300px; display: inline-block; margin-left: 25px; margin-right: 25px;">
            <canvas id="month"></canvas>
        </div>
    </div>

    <br />
    <br />

        <div class="default_div">
            <h1 style="text-align: center">Ticket Statistics</h1>

            <%--Ticket Activity Graph--%>
            <div style="width: 400px; height: 350px; display: inline-block; margin-left: 150px; margin-right: 25px;">
                <canvas id="tickets"></canvas>
            </div>

            <%--Ticket Activity Graph 2--%>
            <div style="width: 500px; height: 300px; display: inline-block; margin-left: 100px; margin-right: 25px;">
                <canvas id="bar"></canvas>
            </div>
        </div>

        <br />
        <br />

        <div>

            <br />
            <div class="default_div">
                <h1 style="text-align: center">Activity Statistics</h1>
                <br />

                <%--User activity from Fitness Tracker--%>
                <div style="width: 350px; height: 350px; display: inline-block; margin-left: 200px; margin-right: 25px;">
                    <canvas id="activities"></canvas>
                </div>

                <%--User time spent using Fitness Tracker--%>
                <div style="width: 500px; height: 300px; display: inline-block; margin-left: 100px; margin-right: 25px;">
                    <canvas id="time"></canvas>
                </div>
            </div>
        </div>
</asp:Content>
