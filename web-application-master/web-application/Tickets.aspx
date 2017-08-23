<%-- Name: Tickets
    Edits:
          - 8/23/2017 Andrea Moorman
                This page is the page that shows the current Active Tickets.  It also has a button that, when clicked, allows you to create a new ticket.  
   --%>

<%@ Page Title="Tickets" Language="C#" MasterPageFile="~/Master.Master" AutoEventWireup="true" CodeBehind="Tickets.aspx.cs" Inherits="web_application.Tickets" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <%--Stylesheet used for this page --%>
    <link href="css/tickets.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

    <%--Javascript files used--%>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="js/CloseModal.js"></script>
    <script type="text/javascript" src="js/PriorityModal.js"></script>
    <script type="text/javascript" src="js/CreateTicketDialog.js"></script>
    <script src="https://use.fontawesome.com/4193f3e666.js"></script>
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentBody" runat="server">

    <%--Page Header--%>
    <div id="page-heading">
        <h1>Active Tickets</h1>
        <hr style="width: 98%; color: lightgray;" />
    </div>

    <%--Sets style for the ticket list--%>
    <div id="ticketList" style="background-color: #D3D9DF; height: 100%; width: 850px; margin: 0 auto;">

    <%--Displays a button to create a new ticket and displays the current ticket list--%>
        <div style="text-align: right;">
            <a href="" id="btnCreateTicket">Create a Ticket</a>
        </div>
        <%=ticketList %>
    </div>

    <%-- Modals --%>

    <%--The Modal for creating a new ticket.  This asks for a title, description, and type for the ticket.--%>
    <div id="createTicketDialog" title="Create a Ticket">

        <p class="validateTips">All form fields are required.</p>

        <div id="createTicketForm">
            <label for="createTitle">Title</label>
            <input type="text" name="createTitle" id="createTitle" placeholder="Title" value="" class="text ui-widget-content ui-corner-all" maxlength="75" />
            <label for="createDesc">Description</label>
            <textarea name="createDesc" id="createDesc" placeholder="Description here..." class="text ui-widget-content ui-corner-all" maxlength="150" style="height: 100px; width: 300px; resize: none;"></textarea>
            <label for="createType">Type</label>
            <select name="createType" id="createType" class="text ui-widget-content ui-corner-all">
                <option>High Water</option>
                <option>Pothole</option>
                <option>Tree/Branch</option>
                <option>Trash Full</option>
                <option>Litter</option>
                <option>Overgrown Brush</option>
                <option>Other</option>
            </select>
        </div>
    </div>

</asp:Content>
