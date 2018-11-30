<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Dashboard.aspx.cs" Inherits="LoginPage.Dashboard" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Dashboard</title>
      <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <style>

        .auto-style3 {
            height: 23px;
            text-align: center;
            width: 321px;
        }

        .auto-style4 {
            height: 23px;
            width: 321px;
        }

    </style>
</head>
<body>
    <div class="wrap">
        <form id="form1" runat="server">
                    <div>
                        <table class="auto-style3">


                            <tr>
                                <td></td>
                                <td class="auto-style4"><asp:Button ID="btnLogout" runat="server" Text="Logout" OnClick="btnLogout_Click" BackColor="#99FF99" CssClass="auto-style5" ForeColor="Black" style="font-size: small; font-weight: bold" /></td>
                            </tr>




                        </table>
                    </div>
        </form>
    </div>
</body>
</html>
