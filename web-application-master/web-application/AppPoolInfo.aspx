<!---
    Name: AppPoolInfo
    Edits:
          - 8/9/17 Bailey Whitehill
                This looks like it gets the current user's name which 
                will allow for persistent user authentication of information
--->
<%@ Page Language="C#" %>

<% Response.Write(System.Security.Principal.WindowsIdentity.GetCurrent().Name); %>