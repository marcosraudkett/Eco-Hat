<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Login.aspx.cs" Inherits="LoginPage.Login" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Login required</title>
      <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <style>

        .auto-style1 {
            height: 23px;
        }
        .auto-style2 {
            height: 23px;
            text-align: center;
        }
        .auto-style3 {
            height: 23px;
            text-align: center;
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
                            <td><strong><asp:Label ID="Label1" runat="server" Text="Username" CssClass="auto-style4" ForeColor="#666699"></asp:Label></strong></td>
                            <td class="auto-style3"><asp:TextBox ID="txtUserName" runat="server"></asp:TextBox></td>
                        </tr>

                        <tr>
                            <td><strong><asp:Label ID="Label2" runat="server" Text="Password" CssClass="auto-style4" ForeColor="#666699"></asp:Label></strong></td>
                            <td class="auto-style3"><asp:TextBox ID="txtPassword" runat="server" TextMode="Password" CssClass="auto-style5"></asp:TextBox></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="auto-style3"><asp:Button ID="btnLogin" runat="server" Text="Login" OnClick="btnLogin_Click" BackColor="#99FF99" CssClass="auto-style5" ForeColor="Black" /></td>
                        </tr>

                        <tr>
                            <td class="auto-style1"></td>
                            <td class="auto-style2"><asp:Label ID="lblErrorMessage" runat="server" Text="Username or password incorrect" ForeColor="#FF6600" CssClass="auto-style6" Font-Bold="True" style="font-size: large"></asp:Label></td>
                        </tr>



                    </table>
                </div>
            </form>
    </div>
</body>
</html>
