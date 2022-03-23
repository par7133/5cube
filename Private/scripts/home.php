<?php

/**
 * Copyright 2021, 2024 5 Mode
 *
 * This file is part of 5 Cube.
 *
 * 5 Cube is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * 5 Cube is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with 5 Cube. If not, see <https://www.gnu.org/licenses/>.
 *
 * home.php
 * 
 * 5 Cube home page.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode      
 */

$curLocale = APP_LOCALE;

$password = filter_input(INPUT_POST, "Password");
if ($password==PHP_STR) {
  $password = filter_input(INPUT_POST, "Password2");
}  

if ($password !== PHP_STR) {	
  $hash = hash("sha256", $password . APP_SALT, false);

  if ($hash !== APP_HASH) {
    $password=PHP_STR;	
  }	 
} 
?>

 <script>
<?PHP if ($password != PHP_STR): ?>
  password = 1; 
<?PHP else: ?> 
  password = 0; 
<?PHP endif ?> 
  businessType = "<?PHP echo(BUSINESS_TYPE)?>";
 </script>


<!DOCTYPE html>
<head>
	
  <meta charset="UTF-8"/>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
<!--
    Copyright 2021, 2024 5 Mode

    This file is part of 5 Cube.

    5 Cube is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    5 Cube is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with 5 Cube. If not, see <https://www.gnu.org/licenses/>.
 -->
  
    
  <title>5 Cube:  Every person its prospects.</title>
	
  <link rel="shortcut icon" href="/favicon.ico?v=<?php echo(time()); ?>" />
    
  <meta name="description" content="Welcome to <?php echo(APP_NAME); ?>"/>
  <meta name="author" content="5 Mode"/> 
  <meta name="robots" content="index,follow"/>
  
  <script src="/js/jquery-3.1.0.min.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>
  <script src="/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/serialize-javascript.js" type="text/javascript"></script>
  
  <script src="/js/cube-code.js" type="text/javascript"></script>
  <script src="/js/interaction-code.js" type="text/javascript"></script>
  <script src="/js/dragndrop-code.js" type="text/javascript"></script>
  
  <script src="/js/home.js?v=<?php echo(time()); ?>" type="text/javascript" defer></script>
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="/css/style.css?v=<?php echo(time()); ?>" type="text/css" rel="stylesheet">
     
  <script>
 /*
  * Boot up code
  */

 //var fetchDataIntervalId;  

 /*
  * App starting proc
  * 
  * @returns void
  */
 function startApp() {

 <?php 

  if ($password!=PHP_STR) {
    $cubedisplay="inline";
  } else {
    $cubedisplay="none";
  }
 
  chdir(APP_DATA_PATH);

  foreach (glob("*.xml") as $filename) { ?>

    i = parseInt("<?php echo(substr(substr($filename, 0, strlen($filename)-4),4));?>");
    $("#cubeList").html($("#cubeList").html()+"<div id='cube" + i + "' class='cube' style='display:<?PHP echo($cubedisplay); ?>' order='" + i + "' onclick='selCube(this)'   draggable='true' ondragstart='onDragStart(this, event);' onmouseover='onMouseOver();'><div id='cube" + i + "name' class='cubename'>cube#" + i + "</div></div>");
    $("#cube" + i + "name").html(businessType + "#" + i);
    if (i<10) {
      newFormalName = "cube" + "00" + i;
    } else if (i<100) {
      newFormalName = "cube" + "0" + i;
    } else {
      newFormalName = "cube" + i;
    }  
    cubes[i-1] = new myCube(businessType + "#" + i, newFormalName, "<?php echo(APP_HOST)?>");
    cubes[i-1].start();
    totcubes = i;
    
 <?php
   }
 ?>

   $("#cubeList").show();

   if (password===1) { 
     ///$("#cubeList").show();

     //$("#datadetail").show();      
     //$("#debugdisplay").show();
     //alert(cubes.length);

     //$("#passworddisplay").hide();
   } 

   $("#vplayer").get(0).pause();
   $("#HCsplash").css("display","none");
   $(".header").show();

   //fetchDataIntervalId = setInterval("_fetchData()", 2000);
 }			

 /*
  * call to startApp
  * 
  * @returns void
  */
 function _startApp() {
   setTimeout("startApp()", 1000);    
 }

 /*
  * Set the elements position
  */
 function setContentPos() {

   $("#cubeList").css("height", parseInt(window.innerHeight-20) + "px"); 

   mytop = parseInt((window.innerHeight - $("#cubectrls").height()) / 2);
   mytop = mytop + parseInt($("#cubectrls").height() / 4);
   myleft = parseInt((window.innerWidth - $("#cubectrls").width()) / 2);
   myleft = myleft + parseInt($("#cubectrls").width() / 5);
   $("#cubectrls").css("top", mytop+"px");
   $("#cubectrls").css("left", (myleft+40)+"px");

   mytop = parseInt((window.innerHeight - $("#zoomedview").height()) / 2);
   myleft = parseInt((window.innerWidth - $("#zoomedview").width()) / 2);
   $("#zoomedview").css("top", mytop+"px");
   $("#zoomedview").css("left", (myleft+40)+"px");

   mytop = parseInt((window.innerHeight - $("#cubelinks").height()) / 2);
   myleft = parseInt((window.innerWidth - $("#cubelinks").width()) / 2);
   $("#cubelinks").css("top", (mytop-170)+"px");
   $("#cubelinks").css("left", (myleft+240)+"px");

   mytop = parseInt(window.innerHeight - ($("#passworddisplay").height() + 60));
   $("#passworddisplay").css("top", mytop+"px");

 }

 function setFooterPos() {
   if (document.getElementById("footerCont")) {
     //if ($("#Password").val() === "") {  
     //    tollerance = 48;
     //  } else {
     //  tollerance = 15;
     //}
     tollerance = 22;  	  
     $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
     $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance + 6) + "px");
   }
 }

 window.addEventListener("load", function() {

   setContentPos();

   if ($("#cubeList").css("display")==="none") {
     setTimeout("setFooterPos()", 9000);
   } else {
     setTimeout("setFooterPos()", 2000);  
   } 

   //Resetting secrets..
   //$("#_read_xml_cube1").val("");
   //$("#_read_xml_cube2").val("");
   //$("#_read_xml_cube3").val("");
   //$("#_read_xml_cube4").val("");
   //$("#_read_xml_cube5").val("");

   //Debug
   $("#hcube").val("");
   $("#vcube").val("");
   $("#hcur").val("");
   $("#vcur").val("");
   $("#curcube").val("");

   //Splash
   $("#HCsplash").show();	
   $("#vplayer").get(0).play();	

 }, true);


 window.addEventListener("load", function() {

   // Fisnished the Intro load the app..
   document.getElementById("vplayer").onended=_startApp;

   // A bit of preload..
   bgimg = new Image();
   bgimg.src = "../res/bg.jpg";

 });

 window.addEventListener("resize", function() {

   setTimeout("setContentPos()", 2000);  

   if ($("#cubeList").css("display")==="none") {
     setTimeout("setFooterPos()", 9000);
   } else {
     setTimeout("setFooterPos()", 2000);  
   } 

 });

// -- End Boot up code
</script>      
          
</head>
    
<body>

     <div id="HCsplash" style="padding-top: 40px; text-align:center;color:#d4b0dc;font-family:'Rampart One';display:none;">
         <div id="myh1" style="position:relative; top:80px;"><H1>5 CUBE</H1></div><br><br>
         <video id="vplayer">
            <source src="../res/cube.mp4" type="video/mp4">
         </video>
     </div>
     
      <form id="frmHC" method="POST" action="/" target="_self" enctype="multipart/form-data">
      
          <div class="header" style="margin-top:18px; display:none;">
              &nbsp;&nbsp;<a href="http://5cube.org" target="_self" style="color:#d4b0dc; text-decoration: none;"><img src="/res/1cube.png" style="width:25px;">&nbsp;5 Cube</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://github.com/par7133/5cube" style="color:#d4b0dc;"><span style="color:#d4b0dc;">on</span> github</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:info@5cube.org" style="color:#d4b0dc;"><span style="color:#d4b0dc;">for</span> feedback</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:+39-331-4029415" style="font-size:13px;background-color:#15c60b;border:2px solid #15c60b;color:#000000;height:27px;text-decoration:none;">&nbsp;&nbsp;get support&nbsp;&nbsp;</a>
         </div>
        
          <div id="debugdisplay" style="float:left;position:absolute;top:680px;left:50px;width:255px;display:none;">
               <input id="hcube" type="text"><br>
               <input id="vcube" type="text"><br>
               <input id="hcur" type="text"><br>
               <input id="vcur" type="text">
               <input id="curcube" type="text">
          </div>

         <div id="passworddisplay" style="float:left;position:fixed;top:680px;left:50px;width:255px;height:120px;background:black;text-align:left;white-space:nowrap; font-family:'Bungee Hairline'; color:#d4b0dc; font-weight:900;z-index:99999;">
               <br>  
                &nbsp;&nbsp;<input type="password" id="Password" name="Password" placeholder="password" style="font-size:18px;  background:transparent; width: 60%; border-radius:3px; font-weight:900;" value="<?php echo($password);?>" autocomplete="off">&nbsp;<input type="submit" value="<?php echo(getResource("Go", $curLocale));?>" style="text-align:left;width:25%;"><br>
                &nbsp;&nbsp;<input type="text" id="Salt" placeholder="salt" style="position:relative; top:+5px; font-size:18px; background:transparent; width: 90%; border-radius:3px; font-weight:900;" autocomplete="off"><br>
                <div style="text-align:center;">
                   <a href="#" onclick="showEncodedPassword();" style="position:relative; left:-2px; top:+5px; font-size:18px; font-weight:900; color:#d4b0dc;"><?php echo(getResource("Hash Me", $curLocale));?>!</a>
                </div>
                <!--<textarea id="log"></textarea>-->
         </div>

         <div id="cubeList" style="position:absolute; width:100%; min-height: 500px; display:none; color:#d4b0dc; border: 0px solid red;" ondragover="onDragOver(event);" ondrop="onDrop(event);"> 
             &nbsp;
          </div>

          <map name="ctrls-map">
              <area target="" alt="" title="" href="#" onclick="turnLeft();" onmouseover="zoomviewOver()" coords="408,122,120,3" shape="rect">
              <area target="" alt="" title="" href="#" onclick="turnUp();" onmouseover="zoomviewOver()" coords="411,272,525,3" shape="rect">
              <area target="" alt="" title="" href="#" onclick="turnRight();" onmouseover="zoomviewOver()" coords="407,497,115,383,407,495" shape="rect">
              <area target="" alt="" title="" href="#" onclick="turnDown();" onmouseover="zoomviewOver()"  coords="176,347,66,411,2,295,0,144,62,142,106,238,105,243,63,144,109,237" shape="poly">
          </map>

         <div id="cubectrls" style="position:absolute;width:527px;height:497px;display:none;border:0px solid green; z-index:99998; transform: rotate(-63deg);" onmouseover="zoomviewOver()" onmouseout="zoomviewOut()">
           <img src="../res/ctrlbg.png" style="width:527px;height:497px;" usemap="#ctrls-map">
         </div>

         <div id="zoomedview" style="position:absolute;width:396px;height:477px;display:none;border:0px solid red; z-index:99997">
           <div id="cubezvname" style="position:relative; top:+30px;font-size:54px;color:#bd006e;width:400px;margin:auto;text-align:center;font-family:'Bungee Hairline';font-weight:900;"></div>

           <div id="cubezv" style="float:left;background:url(../res/1cube.png);background-size:cover;width:396px;height:477px;margin:50px;vertical-align:middle;text-align:center;">
           </div>
         </div>

         <div id="cubelinks" style="position:absolute;width:496px;height:7px;display:none;border:0px solid red; z-index:99999">
           <span id="face2" target="" onclick="openDetail(this)" onmouseover="zoomviewOver()" style="position:relative;top:160px;left:10px;background:transparent;border:0px;font-size:24px;color:#44ff00;width:450px;height:120px;margin:auto;text-align:center;font-family:'Bungee Hairline';font-weight:900;white-space:nowrap;cursor:pointer; transform: rotate(+63deg);"></span><br>
           <span id="face1" target="" onclick="openDetail(this)" onmouseover="zoomviewOver()" style="position:relative;top:+280px;left:-270px;background:transparent;border:0px solid red;font-size:24px;color:#44ff00;width:450px;height:120px;margin:auto;text-align:left;font-family:'Bungee Hairline';font-weight:900;white-space:nowrap;cursor:pointer; transform: rotate(+63deg);"></span><br>
           <span id="face3" target="" onclick="openDetail(this)" onmouseover="zoomviewOver()" style="position:relative;top:+160px;left:+240px;background:transparent;border:0px;font-size:24px;color:#44ff00;width:450px;height:80px;margin:auto;text-align:left;font-family:'Bungee Hairline';font-weight:900;transform: rotate(0deg); white-space:nowrap;cursor:pointer; transform: rotate(+63deg);"></span><br>
         </div>

         <div id="datadetail" style="float:right;background:#0d0d0d;border-left:1px solid white;width:380px;height:900px;display:none;color:#44ff00;" onmouseover="zoomviewOver()">
           <span id="detailtitle" style="color:#bd006e;font-size:20px;font-weight:900;"></span><br><br>
           <span id="detaildata"></span>
         </div>

        <!--
        <input type="hidden" id="_read_xml_cube1">
        <input type="hidden" id="_read_xml_cube2">
        <input type="hidden" id="_read_xml_cube3">
        <input type="hidden" id="_read_xml_cube4">
        <input type="hidden" id="_read_xml_cube5">
   -->
   
     </form>   

    <div class="footer">
    <div id="footerCont">&nbsp;</div>
    <div id="footer"><span style="background:#0d0d0d;color:#d4b0dc;opacity:1.0;margin-right:10px;">&nbsp;&nbsp;A <a href="http://5mode.com" style="color:#d4b0dc; text-decoration:underline;">5 Mode</a> project and <a href="http://demo.5mode.com" style="color:#d4b0dc; text-decoration:underline;">WYSIWYG</a> system. Some rights reserved.</span></div>	
    </div>

<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html")): ?>
<?php include(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html"); ?> 
<?php endif; ?>	
	
</body>
</html>
