<?php
session_start();//continues the session containing prevouse information

if (!isset($_SESSION['username'])) { //if not set, it means that admin hasn't logged in
    header("Location: logIn.php"); //redirects users to login page
    exit;
}
// echo $_SESSION['userId'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Collected Samples</title>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/layout.css" type="text/css" />
        <link rel="stylesheet" href="css/inventory.css" type="text/css" />
    </head>
    <body>
        <div id="bodyWrapper">
            <div class="mainDivs" id="nav">
                    <ul id="homeNav">
                        <li><a id="homeBtn" class="navBtn" href="home.php">Home</a></li>
                    </ul>
                    <ul id="pagesNav">
                      <li><a class="navBtn" href="samplingRequests.php">Sampling Orders</a></li>
                      <li><a class="navBtn active" href="collectedSamples.php">Collected Samples</a></li>
                      <li><a class="navBtn" href="sampleReports.php">Sampling Reports</a></li>
                      <li><a class="navBtn" href="admin.php">Admin</a></li>
                    </ul>
                    <ul id="logOutNav">
                        <li id="logOutBtn"><a class="navBtn" href="logout.php">Log Out</a></li>
                    </ul>
            </div>
            
            <div class="mainDivs" id="collectiveInfo">
                <div id="search">
                    <div id="searchInputDiv" class="searchBox1">
                        <input id="searchInput" onkeyup="search()" placeholder="Search by Company.." type="text" name="search"/>
                    </div>
                    <div id="searchBtnDiv" class="searchBox1">
                        <button id="searchBtn">|Search</button>
                    </div>
                </div>
                <div id="records">
                    <div id="inventory">
                        <div class="title">
                            <div>Current Sampling Requests</div>
                        </div>
                        <div class="table">
                            <table id="currentInventory"></table>
                        </div>
                    </div>
                </div>
                <div id="footer1" class="footer"><center>PRIORITY SAMPLING</center></div>
            </div>
            
            <div class="mainDivs" id="individualInfo">
                <div id="dateTimeInfo">
                    <div class="dateUserInfo" id="logo"><img id="logoImg" src="images/logo.png"></img></div>
                    <div class="dateUserInfo" id="blankSpace"></div>
                    <div class="dateUserInfo" id="dayUserInfo">
                        <div id="currentDate"></div>
                        <div id="currentTime"></div>
                        <div id="userNameLName"><?= $_SESSION[adminFullName]?></div>
                    </div>
                </div>
                
                <div id="recordInfo">
                    <div id="updateRec" title="Dialog Title" class="infoSection popUpBox ">
                            <form class="popup-content animate">
                            <div class="infoSection">Adding Sample Report</div>
                                <div class="sampId" style="display:hidden"></div>
                                <div class="collectedSampId" style="display:hidden"></div>
                                    <label for="sampSubTime">Sample Submission Time:</label>
                                    <input id="sampSubTime" type="time" step="2" name="sampSubTime"/> <br>
                                    <label for="woNum">W.O. Number:</label>
                                    <input id="woNum" name="woNum"/> <br>
                                <input type="submit" onclick='addingSampleReport()' value="Submit" name="updateForm">
                                <button id="cancelbtn" type="button"  onclick="document.getElementById('updateRec').style.display='none'" class="cancelbtn">Cancel</button>
                            </form>
                    </div>
            <!--UPDATING THE COLLECTED REC-->
                    <div id="updateCollReq" title="Dialog Title" class="infoSection popUpBox ">
                            <form class="popup-content animate">
                            <div class="infoSection">Adding Sample Report</div>
                                <div class="sampId" style="display:hidden"></div>
                                <div class="collectedSampId" style="display:hidden"></div>
                                    
                                    <label for="actSampAmnt">Actual Sample Amount:</label>
                                    <input id="actSampAmnt" name="actSampAmnt"/> <br>
                                    <label for="actdate">Date:</label>
                                    <input id="actdate" type="date" name="actdate"/> <br>
                                    
                                <input type="submit" onclick='updtCollReq()' value="Submit" name="updateForm">
                                <button id="cancelbtn" type="button"  onclick="document.getElementById('updateRec').style.display='none'" class="cancelbtn">Cancel</button>
                            </form>
                    </div>
                        
                    <div id="currentRecInfo"><center> <span>&#8678; SELECT A RECORD</span></center></div>
                    
                </div>
                
                <div id="footer2" class="footer"><center>POWERD BY HARVEST CUBE</center></div>
            </div>
            
        </div>
    </body>
    
<!--LIBRARY SCRIPTS-->
    <script src="js/moment.js"></script>
    <script src="js/printThis.js"></script>
    <script src="js/jspdf.min.js"></script>

    <script>
    ///////////////GETTING RECORDS///////////////
    
            ////////GETTING THE REQUEST
                $(document).ready(function() {
                    var request=[];
                    
                    $.ajax({
                        url: "getSamplingReq.php", //the page containing php script
                        type: "get", //request type,
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            request=data;
                            
                            $("#currentInventory").append("<tr><th>Company</th> <th>LotName</th> <th>Request Date</th> <th>Status</th> </tr>");
                            
                            for(var i in request){
                                
                            if (request[i].status==="collected"){
                                
                                var compId = request[i].compId_name;
                                
                                    console.log(compId);
                                    
                                    if ($.isNumeric(compId)){
                                        
                                        console.log("itsNumeric");
                                        
                                        var custId=request[i].compId_name;
                                        
                                            $.ajax({
                                                type: "GET",
                                                url: "getCustomer.php",
                                                data: {
                                                    "custId":custId,
                                                }
                                            })
                                            
                                            .done(function(data) {
                                                console.log("done!");
                                                
                                                var customer = JSON.parse(data);
                                                console.log(customer);
                                                console.log(customer[0].name);
                                            
                                            $("#currentInventory").append("<tr class='sampReq' id="+request[i].Id+"> <td>"+customer[0].name+"</td> <td>" + request[i].lotName +"</td> <td>"+request[i].requestDate+"</td> <td>"+request[i].status+"</td> </tr>");    
                                                
                                            })
                                            .fail(function(xhr, status, errorThrown) {
                                                console.log("Sorry, there was a problem!");
                                            })
                                            .always(function(xhr, status) {
                                                console.log("The request is complete!");
                                            });
                                    }else{
                                        $("#currentInventory").append("<tr class='sampReq' id="+request[i].Id+"> <td>"+request[i].compId_name+"</td> <td>" + request[i].lotName +"</td> <td>"+request[i].requestDate+"</td> <td>"+request[i].status+"</td> </tr>");
                                    }
                                }
                            }
                        }
                    });
                    
        });
                

    
    ///////////////ADDING USER DATE AND TIME INFO///////////////   
    
            ////////GETTING THE SIDE C TIME INFO
                $(document).ready(function() {
                    var interval = setInterval(function() {
                        var momentNow = moment();
                        $('#currentDate').html(momentNow.format('dddd') + ': '
                                            + momentNow.format('MMM Do YY'));
                        $('#currentTime').html(momentNow.format('A hh:mm:ss'));
                    }, 100);
        });
                
 
    
    ///////////////ADDING MAIN RECORD INFO TO SIDE C//////////////
            $(document).ready(function(){
            $('#currentInventory').on('click', function(e){
                var reqId = $(e.target).closest('tr').attr('id');
                console.log(reqId);
                
                $.ajax({
                    type: "GET",
                    url: "getCollectedSamp.php",
                    data: {
                        "reqId":reqId,
                    }
                })
                
                .done(function(data) {
                    
                    var collectedSampInfo = JSON.parse(data);
                    console.log(collectedSampInfo);
                
             //appending id to div for edit and delete use later
                $('.collectedSampId').html("");
                $('.collectedSampId').append(collectedSampInfo[0].Id);
                $('.collectedSampId').css("display", "none");
                    
            //////////Clearing Existing Div INNER Info
                    $('#currentRecInfo').html('');
                
            //////////INVENTORY INFO/////////
            
                //CREATING INVENTORY INFO DIV
                    var collsampInfoSec=$("<div></div>");
    				collsampInfoSec.attr("id", "collsampInfoSec");
    				// collsampInfoSec.attr("class", "infoSection");
    				
    			//CREATING INVENTORY INFO TITLE DIV	
                    var collSampInfo=$("<div></div>");
    				collSampInfo.append("Collected Sample Info");
    				collSampInfo.attr("class", "secTitle");
    				collSampInfo.attr("id", "collSampInfo");
    				collSampInfo.css("font-size", "30px");
    		      //APPENDING TO INVENTORY DIV	
    				collsampInfoSec.append(collSampInfo);
                    
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var actSampAmnt=$("<div></div>");
    				actSampAmnt.append("Actual Sample Amount: "+collectedSampInfo[0].actSampleAmount);
    				actSampAmnt.attr("class", "recInfo");
    				actSampAmnt.attr("id", "actSampAmnt");
    			  //APPENDING TO INVENTORY DIV	
    				collsampInfoSec.append(actSampAmnt);
    				
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var sampDate=$("<div></div>");
    				sampDate.append("Grower: "+collectedSampInfo[0].sampDate);
    				sampDate.attr("class", "recInfo");
    				sampDate.attr("id", "sampDate");
    			  //APPENDING TO INVENTORY DIV	
    				collsampInfoSec.append(sampDate);
    				
    				
    			//CREATING INVENTORY INFO User DIV	
    				var collUserName=$("<div></div>");
    				collUserName.append("Added by: "+collectedSampInfo[0].userName);
    				collUserName.attr("class", "recInfo");
    				collUserName.attr("id", "collUserName");
    			  //APPENDING TO INVENTORY DIV	
    				collsampInfoSec.append(collUserName);
    				
    			//CREATING INVENTORY INFO Date Time DIV	
    				var collDateTime=$("<div></div>");
    				collDateTime.append("Date added : "+collectedSampInfo[0].date +" / "+ collectedSampInfo[0].time);
    				collDateTime.attr("class", "recInfo2");
    				collDateTime.attr("id", "collDateTime");
    			  //APPENDING TO INVENTORY DIV	
    				collsampInfoSec.append(collDateTime);
    			
    // 			/////APPENDING INVENTORY INFO DIV TO CURRENT RECORD BODY DIV
    				$('#currentRecInfo').append(collsampInfoSec);
    				
    		//////////BUTTONS/////////
    		    
    		    //CREATING THE BUTTON INFO DIV
                    var buttons=$("<div></div>");
    				buttons.attr("id", "buttonSec");
    				buttons.attr("class", "infoSection");
    				
    			//CREATING PRINT/DOWNLOAD BUTTONS	
    				var btnInfo=$("<div></div>");
    				btnInfo.append("<button id='addSamp' onclick='displayPopUp()'>Add Sample Report</button> <button id='invPrint' onclick='printFunction()'>Print</button> <button id='invDownload' onclick='generatePDF()'>Download</button>");
    				btnInfo.attr("class", "recInfo3");
    			  //APPENDING TO INVENTORY DIV	
    				buttons.append(btnInfo);
    				
    			//CREATING EDIT/DELETE BUTTONS	
    				var btnInfo2=$("<div></div>");
    				btnInfo2.append("<button id='invEdit' onclick ='updateCollectReq()'>Update </button> <button onclick='deleteCollRecord()' id='invDelete'>Delete</button>");
    				btnInfo2.attr("class", "recInfo4");
    			  //APPENDING TO INVENTORY DIV	
    				buttons.append(btnInfo2);
    				
    		/////APPENDING INVENTORY INFO DIV TO CURRENT RECORD BODY DIV
    				$('#currentRecInfo').append(buttons);
    				
    				
    			
                })
                .fail(function(xhr, status, errorThrown) {
                    console.log("Sorry, there was a problem!");
                })
                .always(function(xhr, status) {
                    console.log("The request is complete!");
                });
        
       
       
        //////ADDING MAIN SAMPLING REQUEST INFO
                $.ajax({
                    type: "GET",
                    url: "getSampRequest.php",
                    data: {
                        "reqId":reqId,
                    }
                })
                
                .done(function(data) {
                    
                    var sampReq = JSON.parse(data);
                    console.log(sampReq);
                    console.log(sampReq[0].lotName);
                
                //appending id to div for edit and delete use later
                $('.sampId').html("");
                $('.sampId').append(sampReq[0].Id);
                $('.sampId').css("display", "none");
                    
                
            //////////INVENTORY INFO/////////
    				
    			//CREATING INVENTORY INFO DIV
                    var sampReqInfo=$("<div></div>");
    				sampReqInfo.attr("id", "sampReqInfo");
    				// sampReqInfo.attr("class", "infoSection");
    				
    			//CREATING INVENTORY INFO TITLE DIV	
                    var SectTitle=$("<div></div>");
    				SectTitle.append("Sampling Request Info");
    				SectTitle.attr("class", "secTitle");
    				SectTitle.attr("id", "invTitle");
    				SectTitle.css("font-size", "30px");
    		      //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(SectTitle);
                        
                        
                        var compId = sampReq[0].compId_name;
                        
                            if ($.isNumeric(compId)){
                                        
                                        console.log("itsNumeric");
                                        
                                        var custId=request[i].compId_name;
                                        
                                            $.ajax({
                                                type: "GET",
                                                url: "getCustomer.php",
                                                data: {
                                                    "custId":custId,
                                                }
                                            })
                                            
                                            .done(function(data) {
                                                console.log("done!");
                                                
                                                var customer = JSON.parse(data);
                                                console.log(customer);
                                                console.log(customer[0].name);
                                            
                                            //CREATING REQUEST INFO CUSTOMER DIV
                                                var reqCust=$("<div></div>");
                                				reqCust.append("Customer: "+customer[0].name);
                                				reqCust.attr("class", "recInfo");
                                				reqCust.attr("id", "reqCust");
                                		      //APPENDING TO INVENTORY DIV
                                				sampReqInfo.append(reqCust);
                                                
                                            })
                                            .fail(function(xhr, status, errorThrown) {
                                                console.log("Sorry, there was a problem!");
                                            })
                                            .always(function(xhr, status) {
                                                console.log("The request is complete!");
                                            });
                                    }else{
                                        //CREATING REQUEST INFO CUSTOMER DIV
                                                var reqCust=$("<div></div>");
                                				reqCust.append("Customer: "+sampReq[0].compId_name);
                                				reqCust.attr("class", "recInfo");
                                				reqCust.attr("id", "reqCust");
                                		      //APPENDING TO INVENTORY DIV
                                				sampReqInfo.append(reqCust);
                                    }
                    
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var reqLotName=$("<div></div>");
    				reqLotName.append("Lot Name: "+sampReq[0].lotName);
    				reqLotName.attr("class", "recInfo");
    				reqLotName.attr("id", "reqLotName");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqLotName);
    				
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var reqGrower=$("<div></div>");
    				reqGrower.append("Grower: "+sampReq[0].grower);
    				reqGrower.attr("class", "recInfo");
    				reqGrower.attr("id", "reqGrower");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqGrower);
    				
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var reqRanch=$("<div></div>");
    				reqRanch.append("Ranch: "+sampReq[0].ranch);
    				reqRanch.attr("class", "recInfo");
    				reqRanch.attr("id", "reqRanch");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqRanch);
    				
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var reqSampleSize=$("<div></div>");
    				reqSampleSize.append("Sample Size: "+sampReq[0].sampleSize);
    				reqSampleSize.attr("class", "recInfo");
    				reqSampleSize.attr("id", "reqSampleSize");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqSampleSize);
    				
    			//CREATING INVENTORY INFO AMOUNT DIV	
    				var reqDate=$("<div></div>");
    				reqDate.append("Request Date: "+sampReq[0].requestDate);
    				reqDate.attr("class", "recInfo");
    				reqDate.attr("id", "reqDate");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqDate);
    				
    			//CREATING INVENTORY INFO User DIV	
    				var reqUserName=$("<div></div>");
    				reqUserName.append("Added by: "+sampReq[0].userName);
    				reqUserName.attr("class", "recInfo");
    				reqUserName.attr("id", "reqUserName");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqUserName);
    				
    			//CREATING INVENTORY INFO User DIV	
    				var reqStatus=$("<div></div>");
    				reqStatus.append("Status: "+sampReq[0].status);
    				reqStatus.attr("class", "recInfo");
    				reqStatus.attr("id", "reqStatus");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqStatus);
    				
    				        if (sampReq[0].status==="requested"){
    				            reqStatus.css("color", "red");
    				        }else if (sampReq[0].status==="collected"){
    				            reqStatus.css("color", "orange");
    				        }else{
    				            reqStatus.css("color", "green");
    				        }
    				
    			//CREATING INVENTORY INFO Date Time DIV	
    				var reqDate=$("<div></div>");
    				reqDate.append("Date added : "+sampReq[0].date +" / "+ sampReq[0].time);
    				reqDate.attr("class", "recInfo2");
    				reqDate.attr("id", "reqDate");
    			  //APPENDING TO INVENTORY DIV	
    				sampReqInfo.append(reqDate);
    			
    			/////APPENDING INVENTORY INFO DIV TO CURRENT RECORD BODY DIV
    				$('#currentRecInfo').append(sampReqInfo);
    				
    				
    		////////ADDING THE DOWNLOAD INFO FUNCTION/////
    			
                })
                .fail(function(xhr, status, errorThrown) {
                    console.log("Sorry, there was a problem!");
                })
                .always(function(xhr, status) {
                    console.log("The request is complete!");
                });
                
                
                
            })
        });
    

    
    ///////////////PRINT & DOWNLOAD FUNCTIONS///////////////
    
            //////// INVENTORY PRINT FUNCTION
                function printFunction(){
                    $("#invPrint").click(function(){
                       $('#collsampInfoSec').printThis({
                           importCSS: true,
                            importStyle: true,//thrown in for extra measure
                            // loadCSS: "css/layout.css",
                       });
                    })
        };
                
            /////// INVENTORY DOWNLOAD PDF
                function generatePDF(){
                    var collSampInfo= $("#collSampInfo").html();
                    var actSampAmnt= $("#actSampAmnt").html();
                    var sampDate= $("#sampDate").html();
                    var collUserName= $("#collUserName").html();
                    var collDateTime= $("#collDateTime").html();
                    
                    // console.log(inventoryAmount);
                    
                    
                    var imgData = 'data:image/png;base64,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'
                        
            
                        var doc = new jsPDF("p", "pt", "letter");
                        
                        doc.canvas.height = 200 * 11;
                        doc.canvas.width = 200 * 8.5;
                        
                         margins = {
                          top: 40,
                          bottom: 60,
                          left: 40,
                          width: 522
                        };
                    
                    /////THIS ADDS THE IMAGE
                        doc.addImage(imgData, 'JPEG', 40, 40, 90, 60)
                        
                    /////THIS IS A TITLE STYLED FOR PDF
                        doc.setFontSize(18)
                        doc.setTextColor(157, 31, 96)
                        doc.setFont('courier')
                        doc.setFontType('bold')
                        doc.text(40, 150, collSampInfo); //(X(SIDE TO SIDE), Y(UP DOWN), TEXT(WHAT GOES INSIDE)
            
                    /////THIS IS AN INFO PEICE STYLED FOR PDF
                        doc.setFontSize(12)
                        doc.setTextColor(0, 0, 0)
                        doc.setFont('courier')
                        doc.text(50, 180, actSampAmnt);  
                        
                    /////THIS IS AN INFO PEICE STYLED FOR PDF
                        doc.setFontSize(12)
                        doc.setTextColor(0, 0, 0)
                        doc.setFont('courier')
                        doc.text(300, 180, sampDate); 
                
                doc.setLineWidth(.8)
                doc.line(40, 185, 560, 185)
                        
                    /////THIS IS AN INFO PEICE STYLED FOR PDF
                        doc.setFontSize(12)
                        doc.setTextColor(0, 0, 0)
                        doc.setFont('courier')
                        doc.text(50, 205, collUserName);  
                        
                   /////THIS IS AN INFO PEICE STYLED FOR PDF
                        doc.setFontSize(12)
                        doc.setTextColor(0, 0, 0)
                        doc.setFont('courier')
                        doc.text(300, 205, collDateTime);  
                        
                doc.setLineWidth(.8)
                doc.line(40, 210, 560, 210)
                        
                        // adding page
                        // doc.addPage()
                        // // adding text to the second page
                        // doc.text(20, 20, 'Do you like that?')
                        
                        doc.save("SampleCollection.pdf");
                        
                        
            }
            

    
    //////////////UPDATING RECORD POPUP WINDOW//////////////
    
            ////////ADDING TO COLLECTED SAMPLES
                    function displayPopUp(){
                        $("#updateRec").attr("style","display:block;")
                        
                       
                }
                
                 function addingSampleReport(){
                            
                            var sampReq=$(".sampId").html();
                            var collectedSampId=$("#collectedSampId").html();
                            
                            var sampSubTime=$("#sampSubTime").val();
                            var woNum=$("#woNum").val();
                            
                            var date= moment().format('YYYY-MM-DD');
                            var time= moment().format('hh:mm:ss');
                            
                            console.log(sampReq);
                            console.log(collectedSampId);
                            console.log(sampSubTime);
                            console.log(woNum);
                         
                            $.ajax({
                                type: "GET",
                                url: "addSampReport.php",
                                data: {
                                    "sampReq": sampReq,
                                    "collectedSampId": collectedSampId,
                                    "sampSubTime": sampSubTime,
                                    "woNum": woNum,
                                    "date": date,
                                    "time": time,
                                }
                            })
                            
                             updateSampStatus();
                        
                        }
                        
            ////////UPDATING COLLECTION REC
                    function updateCollectReq(){
                        
                        $("#updateCollReq").attr("style","display:block;")
                        
                        var sampId=$(".sampId").html();
                        var collectedSampId=$(".collectedSampId").html();
                        
                        console.log(sampId);
                        console.log(collectedSampId);
                    
                    $.ajax({
                            type: "GET",
                            url: "getCollRec.php",
                            data: {
                                "sampId":sampId,
                                "collectedSampId":collectedSampId
                            }
                        })
                        
                        .done(function(data) {
                            
                            var collRec = JSON.parse(data);
                            console.log(collRec);
                            console.log(collRec[0].Id);
                            
                            
                        $("#actSampAmnt").attr("value", collRec[0].actSampleAmount);
                        
                        
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log("Sorry, there was a problem!");
                        })
                        .always(function(xhr, status) {
                            console.log("The request is complete!");
                        });
                    }
                
                 function updtCollReq(){
                            
                            var sampReq=$(".sampId").html();
                            var collectedSampId=$(".collectedSampId").html();
                            
                            var actSampAmnt=$("#actSampAmnt").val();
                            var actdate=$("#actdate").val();
                            
                            var date= moment().format('YYYY-MM-DD');
                            var time= moment().format('hh:mm:ss');
                            
                            console.log(sampReq);
                            console.log(collectedSampId);
                            console.log(actSampAmnt);
                            console.log(actdate);
                         
                            $.ajax({
                                type: "GET",
                                url: "updateColl.php",
                                data: {
                                    "sampReq": sampReq,
                                    "collectedSampId": collectedSampId,
                                    "actSampAmnt": actSampAmnt,
                                    "actdate": actdate,
                                    "date": date,
                                    "time": time,
                                }
                            })
                            
                        
                        }
                        
            /////////GETTING UPDATING RECORD - FUNCTION
                    function updateSampStatus(){
                        
            			var sampId=$('.sampId').html();
                        
                     
                        $.ajax({
                            type: "GET",
                            url: "updateSampStatus2.php",
                            data: {
                                "sampId":sampId,
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
    

    
    //////////////DELETING AND ADDING RECORDS//////////////
            
            /////////DELETING INVENTORY RECORD - FUNCTION
                    function deleteCollRecord(){
                        
            			var collectedSampId=$('.collectedSampId').html();
            			var sampId=$('.sampId').html();
            			
            			var response=confirm ("Are You Sure You Want To Delete The Collection Entry:  "+ $('#reqCust').html() + "  " +$("#reqLotName").html());
            			
                        if (response == true) {
                            
                            $.ajax({
                                
                                type: "GET",
                                url: "deleteCollRec.php",
                                data: {
                                    "collectedSampId":collectedSampId,
                                    "sampId" :sampId
                                }
                            })
                            } else {
                                console.log("no");
                            }
                }
                        
            /////////ADDING TO INVENTORY - RECORD FUNCTION
                     function addToInventory(){
                        
            			var invComod=$('#inventoryCommodity').val();
            			var invAmount=$('#comodAmount').val();
            			var invOwner=$('#inventoryOwner').val();
                        var date= moment().format('YYYY-MM-DD');
                        var time= moment().format('hh:mm:ss');
                     
                        $.ajax({
                            type: "GET",
                            url: "addToInventory.php",
                            data: {
                                "invComod":invComod,
                                "invAmount":invAmount,
                                "invOwner":invOwner,
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
                        
         /////////////SEARCH FUNCTION///////////////////
    
            function search() {
              var input;
              var filter;
              var table;
              var tr;
              var td; 
              var i;
              input = document.getElementById("searchInput");
              filter = input.value.toUpperCase();
              table = document.getElementById("currentInventory");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                      } else {
                        tr[i].style.display = "none";
                      }
                }       
              }
        }
                
    </script>
</html>