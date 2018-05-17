<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login</title>
    </head>
    <style type="text/css">
        #bodyLogInSec{
            width:80%;
            margin:auto;
        }
        #logIn{
            width:20%;
            margin:auto;
            padding:30px;
            border:1px solid black;
            border-radius:15px;
            text-align:center;
            margin-top: 50px
        }
        img{
           width:220px; 
        }
        form{
            text-align: left;
        }
    </style>
    <body>
        
        <div id="bodyLogInSec">
            <div id="logIn">
                <div id="image"><img src="images/HC_logo.png"></img></div>
                <div id="typeInSec">
                    <h2>Admin Login</h2>
        
                    <form method="POST" action="logInProcess.php">
                
                    Username: <input type="text" name="username"/> <br />
                    Password: <input type="password" name="password"/> <br />
                    <input type="submit" value="Login!" name="loginForm" />
                        
                    </form>
                </div>
            </div>
        
    </div>

    </body>
</html>

