<!DOCTYPE html>
<html>
    <head>
        <title>Outside User Sampling Request</title>
    </head>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
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
                    <h2>Request Sampling</h2>
        
                    <form>
                    <label for="lotName">Lot Name:</label>
                    <input type="text" id="lotName" name="lotName"/><br>
                    <label for="sampleSize">Sample Size:</label>
                    <input type="text" id="sampleSize" name="sampleSize"/><br>
                    <label for="compName">Company:</label>
                    <input type="text" id="compName" name="compIdName"/><br>
                    <label for="requestDate">Request Date:</label>
                    <input type="date" id="requestDate" name="requestDate"/><br>
                    <input type="submit" onclick="requestSampling()" value="Submit"/>
                    
                </form>
                <a id="homeBtn" href="home.php">Return Home</a>
                </div>
            </div>
        
        </div>
        
    </body>
    <!--LIBRARY SCRIPTS-->
    <script src="js/moment.js"></script>
    <script src="js/printThis.js"></script>
    <script src="js/jspdf.min.js"></script>
    <script>
        function requestSampling(){
            
            var lotName=$('#lotName').html();
			var sampleSize=$('#sampleSize').val();
			var compName=$('#compName').val();
			var requestDate=$('#requestDate').val();
            var date= moment().format('YYYY-MM-DD');
            var time= moment().format('hh:mm:ss');
            
            console.log(date);
             
            $.ajax({
                    type: "GET",
                    url: "addSamplingReq.php",
                    data: {
                        "lotName":lotName,
                        "sampleSize":sampleSize,
                        "compName":compName,
                        "requestDate":requestDate,
                        "date": date,
                        "time": time
                    }
                })
                
                .done(function(data) {
                    console.log("done!");
                })
                .fail(function(xhr, status, errorThrown) {
                    console.log("Sorry, there was a problem!");
                })
                .always(function(xhr, status) {
                    console.log("The request is complete!");
                });
        }
    </script>
    
</html