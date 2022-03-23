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

if ($password != PHP_STR): ?>
   <script>
   password = 1; 
 </script>
<?PHP else: ?> 
   <script>
   password = 0; 
 </script>
  <?PHP endif ?> 


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
  
  <script src="/js/home.js?v=<?php echo(time()); ?>" type="text/javascript" defer></script>
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="/css/style.css?v=<?php echo(time()); ?>" type="text/css" rel="stylesheet">
     
   <script>
    
    /*
     * CUBE CODE
     */

    var cubes = []; // Cube array
    var curcube; // Current cube
    var _selectedcube = 0; // Selected cube
    
    var totcubes = 0;
    
    /*
     * myCube Class
     * 
     * @param string myname Current name of the cube
     * @param array mymap Face map
     * @param string myformalName Formal name of the cube 
     * @returns myCube
     */
    function myCube(myname, myformalName) {
      
      // Examples of cube moves:
      
      //  0, 0, 1, 0, 0
      //  0, 0, 5, 0, 0   hcur = [3, 4]
      //  1, 2, 3, 4, 1   vcur = [3, 5]     shift(hlist[1,4]); set jolly = hlist[4];
      //  0, 0, 6, 0, 0   jolly = 1
      //  0, 0, 1, 0, 0 

      //  1 turn 1 face up
      //  0, 0, 5, 0, 0
      //  0, 0, 3, 0, 0   hcur = [6, 4] 
      //  5, 2, 6, 4, 5   vcur = [6, 3]     shift(vlist[1,4]); set jolly = vlist[4];
      //  0, 0, 1, 0, 0   jolly = 5
      //  0, 0, 5, 0, 0
      
      //  1 turn 1 face left
      //  0, 0, 4, 0, 0
      //  0, 0, 5, 0, 0   hcur = [2, 3] 
      //  4, 1, 2, 3, 4   vcur = [2, 5]     shift(hlist[1,4]); set jolly = hlist[4];
      //  0, 0, 6, 0, 0   jolly = 4
      //  0, 0, 4, 0, 0
      
      //  1 turn 1 face left
      //  0, 0, 3, 0, 0
      //  0, 0, 5, 0, 0   hcur = [1, 2]
      //  3, 4, 1, 2, 3   vcur = [1, 5]     shift(hlist[1,4]); set jolly = hlist[4];
      //  0, 0, 6, 0, 0   jolly = 3
      //  0, 0, 3, 0, 0

      //  1 turn 1 face rght
      //  0, 0, 4, 0, 0
      //  0, 0, 5, 0, 0   hcur = [1, 2]
      //  4, 1, 2, 3, 4   vcur = [1, 5]     shift(hlist[1,4]); set jolly = hlist[4];
      //  0, 0, 6, 0, 0   jolly = 3
      //  0, 0, 4, 0, 0

      // Properties
      this.name = myname;
      this.map = ["Address", "Contacts", "Other Info", "Menu", "Pictures", "Password"];
      this.formalName = myformalName;
      this.guid = "";
      this.password = "";
      this.xml = "";
      this.hcube = [0,1,2,3,0];
      this.vcube = [0,5,2,4,0];
      this.hlist = [1,2,3,0];
      this.vlist = [5,2,4,0];
      this.jolly = 0;
      this.hcur = [this.hcube[2], this.hcube[3]];
      this.vcur = [this.vcube[2], this.vcube[3]];      
      
      // Methods
      this.updateCube = myupdateCube;
      this.turnLeft = myturnLeft;
      this.turnRight = myturnRight;
      this.turnUp = myturnUp;
      this.turnDown = myturnDown;
      this.getFace = mygetFace;
      this.gethcube = mygethcube;
      this.getvcube = mygetvcube;
      this.gethcur = mygethcur;
      this.getvcur = mygetvcur;
      this.getname = mygetname;
      this.getguid = mygetguid;
      this.getpassword = mygetpassword;
      this.getxml = mygetxml;
      this.savedata = mysavedata;
      this.start = mystart;
      // -- Methods End
    
      /*
       * Execute horizontal / vertical movement of the cube
       * 
       * @param char Update direction
       * @returns void
       */
      function myupdateCube(tthis, upddir) {
      
        if (upddir=='h') {

		      tthis.hcube[0] = tthis.jolly;
		      for(i=1;i<=tthis.hlist.length;i++) {
		        tthis.hcube[i] = tthis.hlist[i-1];
		      }        
          tthis.vcube[2] = tthis.hcube[2];
          tthis.vcube[0] = tthis.jolly;        
          tthis.vcube[4] = tthis.jolly;
        } else {

		      tthis.vcube[0] = tthis.jolly;
		      for(i=1;i<=tthis.vlist.length;i++) {
		        tthis.vcube[i] = tthis.vlist[i-1];
		      }        
          tthis.hcube[2] = tthis.vcube[2];
          tthis.hcube[0] = tthis.jolly;        
          tthis.hcube[4] = tthis.jolly;
        }
      
        tthis.hcur = [tthis.hcube[2], tthis.hcube[3]];
        tthis.vcur = [tthis.vcube[2], tthis.vcube[3]];      
      }

      /*
       * Move the current cube to the left
       * 
       * @returns void
       */
      function myturnLeft() {
        var newhlist = [];
        
        var newfirst = this.hlist.pop();

        newhlist[0] = newfirst;
        newhlist[1] = this.hlist[0];
        newhlist[2] = this.hlist[1];
        newhlist[3] = this.hlist[2];
        this.hlist = newhlist;
        
        this.jolly = this.hlist[3];
        
        // Save the horizzontal movement..
        this.updateCube(this, 'h');
      }

      /*
       * Move the current cube to the right
       * 
       * @returns void
       */
      function myturnRight() {
        var newhlist = [];
        
        var newlast = this.hlist.shift();

        newhlist[0] = this.hlist[0];
        newhlist[1] = this.hlist[1];
        newhlist[2] = this.hlist[2];
        newhlist[3] = newlast;        
        this.hlist = newhlist;
        
        this.jolly = this.hlist[3];
        
        // Save the horizzontal movement..
        this.updateCube(this, 'h');
      }

      /*
       * Move the current cube upward
       * 
       * @returns void
       */
      function myturnUp() {
        var newvlist = [];
        
        var newfirst = this.vlist.pop();

        newvlist[0] = newfirst;
        newvlist[1] = this.vlist[0];
        newvlist[2] = this.vlist[1];
        newvlist[3] = this.vlist[2];
        this.vlist = newvlist;
        
        this.jolly = this.vlist[3];
        
        // Save the vertical movement..
        this.updateCube(this, 'v');
      }

      /*
       * Move the current cube downward
       * 
       * @returns void
       */
      function myturnDown() {
        var newvlist = [];
        
        var newlast = this.vlist.shift();

        newvlist[0] = this.vlist[0];
        newvlist[1] = this.vlist[1];
        newvlist[2] = this.vlist[2];
        newvlist[3] = newlast;
        this.vlist = newvlist;
        
        this.jolly = this.vlist[3];

        // Save the vertical movement..
        this.updateCube(this, 'v');
      }
      
      /*
       * Get the cube face associated to the given coordinates [v0|v1|h0|h1]
       * 
       * @returns string
       */
      function mygetFace(iface) {
        // v0 = front
        // v1 = up
        // h0 = front
        // h2 = right
        switch (iface) {
          case "h0":
            return this.map[this.hcur[0]];
            break;
          case "h1":
            return this.map[this.hcur[1]];
            break;
          case "v0":
            return this.map[this.vcur[0]];
            break;
          case "v1":
            return this.map[this.vcur[1]];
            break;
        }
      }
      
      /*
       * Expose the current horizontal list of the cube, for debug purpose
       * 
       * @returns string  
       */
      function mygethcube() {
        return this.hcube.toString();
      }

      /*
       * Expose the current vertical list of the cube, for debug purpose
       * 
       * @returns string  
       */
      function mygetvcube() {
        return this.vcube.toString();
      }

      /*
       * Expose the current horizontal position of the cube, for debug purpose
       * 
       * @returns string  
       */
      function mygethcur() {
        return this.hcur.toString();
      }

      /*
       * Expose the current vertical position of the cube, for debug purpose
       * 
       * @returns string  
       */
      function mygetvcur() {
        return this.vcur.toString();
      }

      /*
       * Get the cube name
       * 
       * @returns string
       */
      function mygetname() {
        return this.name;
      }

      /*
       * Save the cube data locally
       * 
       * @returns void     
       */ 
      function mysavedata() {

        //fileName = myformalName; 
        var ffileName = this.formalName; 
        var xxml = this.xml;

        $.ajax({
          method: "POST",
          async: false,
          url: "/putxml",
          dataType: "json",
          jsonp: false,
          data: {
            f: ffileName,
            xml: xxml
          },
          success: function( data ) {
            // Handle 'no match' indicated by [ "" ] response
            //response( data.length === 1 && data[0].length === 0 ? [] : data );
            if (data.length < 1 || data.length === 1) {
              alert("An error happened saving the data (#1)!");
            } else if (data.length === 2 && data[0] === 200) {
              //alert("Data saved successfully!");
            } else {
              alert("An error happened saving the data (#2)!");
              //alert(data[0]);
              //alert(data[1]);
              //alert(data[2]);
              //alert(data[3]);
              //alert(data[4]);
            }
          },
          error: function (responseData, textStatus, errorThrown) {
            alert("POST failed: " + errorThrown + " data: " + responseData.responseText);
          }
        });
      }

      /*
       * Cube init procedure: 
       * - read the xml data associated with the cube
       * 
       * @returns void
       */
      function mystart() {
        bConnectionOK = false;
        var xhttp = new XMLHttpRequest();
        var xmluri = "https://<?PHP echo(APP_HOST);?>/getxml?f=" + this.formalName;
        //alert(xmluri);
        xhttp.open("GET", xmluri, true);  
        xhttp.send();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            bConnectionOK = true;
            
            xml = this.responseText
            
            cubes[parseInt(myformalName.substr(4))-1].xml = xml;
            //$("#_read_xml_" + myformalName).val(xml);

            //alert(this.responseText);

            re = new RegExp("\<guid\>(.*)\<\/guid\>", "igsu");
            a = re.exec(xml);
            if (!a || a.length===0) {
              document.write("Data access error (#2)<br><br>");
              return;
            } else {
              //alert(a);
              cubes[parseInt(myformalName.substr(4))-1].guid = a[1];  
              //alert(cubes[parseInt(myformalName.substr(4))-1].guid);
            }  

            re = new RegExp("\<password\>(.*)\<\/password\>", "igsu");
            a = re.exec(xml);
            if (!a || a.length===0) {
              document.write("Data access error (#3)<br><br>");
              return;
            } else {
              //alert(a);
              cubes[parseInt(myformalName.substr(4))-1].password = a[1];  
              //alert(cubes[parseInt(myformalName.substr(4))-1].guid);
            }  

          } else {

            if ((this.readyState == 4 && this.status == 0) && (!bConnectionOK)) {
              document.write("Data access error (#1)<br><br>");
            } 
          }  
        }
      }

      /*
       * Get the guid of the cube
       * 
       * @returns string
       */
      function mygetguid() {
        return this.guid;   
      }  

      /*
       * Get the editor password of the cube
       * 
       * @returns string
       */
      function mygetpassword() {
        return this.password;   
      }  

      /*
       * Get the xml data associated with the cube
       * 
       * @returns string
       */
      function mygetxml() {
        return this.xml;   
      }  
    }  
    // -- End myCube class
    
    /*
     * Select a cube 
     * 
     * @param <interfaceEl> tthis selected cube
     * @returns void
     */
    function _selCube(tthis) {
      //alert($(tthis).attr("order"));
      var _cubeorder = parseInt($(tthis).attr("order"));
      _selectedcube = _cubeorder-1;
      curcube = cubes[_selectedcube];
      
      // Debug info..
      $("#curcube").val(curcube.getname());
      //alert("curcube="+_selectedcube);
    }

    /*
    function _fetchData() {
      data1_exists = $("#_read_xml_cube1").val() !== "";
      data2_exists = $("#_read_xml_cube2").val() !== "";
      data3_exists = $("#_read_xml_cube3").val() !== "";
      data4_exists = true;
      data5_exists = true;
      //data4_exists = $("#_read_xml_cube4").val() !== "";
      //data5_exists = $("#_read_xml_cube5").val() !== "";

      if (data1_exists && 
          data2_exists &&
          data3_exists &&
          data4_exists &&
          data5_exists ) {
    
          cubes[0].xml = $("#_read_xml_cube1").val();
          cubes[1].xml = $("#_read_xml_cube2").val();
          cubes[2].xml = $("#_read_xml_cube3").val();
          cubes[3].xml = $("#_read_xml_cube4").val();
          cubes[4].xml = $("#_read_xml_cube5").val();
          
          clearInterval(fetchDataIntervalId);
          
      } else {
          fetchDataIntervalId = setInterval("_fetchData()", 2000);
      }
    }*/

  // -- End CUBE CODE
  </script>  

     <script>
              
    /*
     * Interaction / Interface code
     */          
              
    timeoutId=0;
    var oldtthis; // Old cube
    
    var lineOldVal = ""; // Old value for a detail line
    var lineNewVal = ""; // New value for a detail line

    var dataChanged = false;

    /*
    function zoominCube_old(tthis) {    
      $(tthis).css("width","396px");
      $(tthis).css("height","477px");
      $(tthis).css("margin","0px");
    }

    function zoomoffCube_old(tthis) {    
      $(tthis).css("width","130px");
      $(tthis).css("height","159px");
      $(tthis).css("margin","50px");
    } 
    /*

    /*
     * Select the given cube 
     * 
     * @param <interfaceEl> selected cube
     * @returns void
     */
    function selCube(tthis) {    
  
      if (password === 1) {
  
        _selCube(tthis);
      
        // Clean the old selected..
        $(oldtthis).css("color","#d4b0dc");
        $(oldtthis).css("text-decoration","none");
        oldtthis = tthis;
        // Decore the selected one..
        $(tthis).css("color","#bd006e");
        $(tthis).css("text-decoration","underline");
        $("#cubezvname").html(curcube.getname());

        // Reset the detail view
        $("#detailtitle").html("");
        $("#detaildata").html("");
        $("#datadetail").hide(); 

        // Update ZOOMED VIEW interface..
        $("#face1").html("<span id='facelet1'>" + curcube.getFace('h0') + "</span> &horbar;&horbar;&horbar;&horbar;&horbar;&xodot; ");
        $("#face2").html("<span id='facelet2'>" + curcube.getFace('v1') + "</span>");
        $("#face3").html("&xodot;&horbar;&horbar;&horbar;&horbar; <span id='facelet3'>" + curcube.getFace('h1') + "</span>");
        $("#face1").attr("target", curcube.getFace('h0'));
        $("#face2").attr("target", curcube.getFace('v1'));
        $("#face3").attr("target", curcube.getFace('h1'));

        clearTimeout(timeoutId);

        // Update body background..
        $(document.body).css("background","url('../res/bg.jpg')");
        $(document.body).css("background-size","cover");

        // Display ZOOMED VIEW interface and controls 
        $("#cubeList").css("width", "700px");
        $("#cubectrls").show();
        $("#zoomedview").show();
        $("#cubelinks").show();
      }  
    } 

    /*
     * Turn the current cube to the left
     * 
     * @returns void
     */    
    function turnLeft() {

      curcube.turnLeft();
      
      // Update ZOOMED VIEW interface..
      $("#face1").html("<span id='facelet1'>" + curcube.getFace('h0') + "</span> &horbar;&horbar;&horbar;&horbar;&horbar;&xodot; ");
      $("#face2").html("<span id='facelet2'>" + curcube.getFace('v1') + "</span>");
      $("#face3").html("&xodot;&horbar;&horbar;&horbar;&horbar; <span id='facelet3'>" + curcube.getFace('h1') + "</span>");
      $("#face1").attr("target", curcube.getFace('h0'));
      $("#face2").attr("target", curcube.getFace('v1'));
      $("#face3").attr("target", curcube.getFace('h1'));
      
      // Display the debug info..
      visInfo();      
    }  

    /*
     * Turn the current cube to the right
     * 
     * @returns void
     */    
    function turnRight() {

      curcube.turnRight();
      
      // Update ZOOMED VIEW interface..
      $("#face1").html("<span id='facelet1'>" + curcube.getFace('h0') + "</span> &horbar;&horbar;&horbar;&horbar;&horbar;&xodot; ");
      $("#face2").html("<span id='facelet2'>" + curcube.getFace('v1') + "</span>");
      $("#face3").html("&xodot;&horbar;&horbar;&horbar;&horbar; <span id='facelet3'>" + curcube.getFace('h1') + "</span>");
      $("#face1").attr("target", curcube.getFace('h0'));
      $("#face2").attr("target", curcube.getFace('v1'));
      $("#face3").attr("target", curcube.getFace('h1'));
      
      // Display the debug info..
      visInfo();      
    }  
    
    /*
     * Turn the current cube to upward
     * 
     * @returns void
     */    
    function turnUp() {

      curcube.turnUp();

      // Update ZOOMED VIEW interface..
      $("#face1").html("<span id='facelet1'>" + curcube.getFace('h0') + "</span> &horbar;&horbar;&horbar;&horbar;&horbar;&xodot; ");
      $("#face2").html("<span id='facelet2'>" + curcube.getFace('v1') + "</span>");
      $("#face3").html("&xodot;&horbar;&horbar;&horbar;&horbar; <span id='facelet3'>" + curcube.getFace('h1') + "</span>");           
      $("#face1").attr("target", curcube.getFace('h0'));
      $("#face2").attr("target", curcube.getFace('v1'));
      $("#face3").attr("target", curcube.getFace('h1'));

      // Display the debug info..
      visInfo();      
    }  

    /*
     * Turn the current cube to downward
     * 
     * @returns void
     */    
    function turnDown() {

      curcube.turnDown();

      // Update ZOOMED VIEW interface..
      $("#face1").html("<span id='facelet1'>" + curcube.getFace('h0') + "</span> &horbar;&horbar;&horbar;&horbar;&horbar;&xodot; ");
      $("#face2").html("<span id='facelet2'>" + curcube.getFace('v1') + "</span>");
      $("#face3").html("&xodot;&horbar;&horbar;&horbar;&horbar; <span id='facelet3'>" + curcube.getFace('h1') + "</span>");
      $("#face1").attr("target", curcube.getFace('h0'));
      $("#face2").attr("target", curcube.getFace('v1'));
      $("#face3").attr("target", curcube.getFace('h1'));

      // Display the debug info..
      visInfo();
    }  

    /*
     * Hide the ZOOMED VIEW
     * 
     * @returns void
     */
    function hideZoomedview() {
      
      // Clean the old selected..
      $(oldtthis).css("color","#d4b0dc");
      $(oldtthis).css("text-decoration","none");
      oldtthis = null;
      
      // Reset the detail view
      $("#detailtitle").html("");
      $("#detaildata").html("");
      $("#datadetail").hide();      
      
      // Hide ZOOMED VIEW interface and controls 
      $("#cubeList").css("width", "100%");
      $("#cubelinks").hide();
      $("#zoomedview").hide();
      $("#cubectrls").hide();
      
      // Reset body background..
      $(document.body).css("background","#0d0d0d");
    }
    
    /*
     * Mouse over handle for ZOOMED VIEW 
     * 
     * @returns void
     */
    function zoomviewOver() {
      clearTimeout(timeoutId);
    }

    /*
     * Mouse out handle for ZOOMED VIEW 
     * 
     * @returns void
     */
    function zoomviewOut() {    
      timeoutId = setTimeout(hideZoomedview,1500);
    }    
    
    /*
     * Display the debug info
     * 
     * @returns void
     */
    function visInfo() {
      $("#hcube").val(curcube.gethcube());
      $("#vcube").val(curcube.getvcube());
      $("#hcur").val(curcube.gethcur());
      $("#vcur").val(curcube.getvcur());
      $("#curcube").val(curcube.getname());
    }
    
    /*
    function eachNode(rootNode, callback) {
      if (!callback) {
        const nodes = []
        eachNode(rootNode, function(node) {
          nodes.push(node.nodeName)
          //nodes.push(node)
        })
        return nodes
      }

      if (false === callback(rootNode)) {
        return false
      }

      if (rootNode.hasChildNodes()) {
        const nodes = rootNode.childNodes
        for (let i = 0, l = nodes.length; i < l; ++i) {
          if (false === eachNode(nodes[i], callback)) {
            return
          }
        }
      }
    }
    */
    
    /*
     * Get the data for the given detail / face
     * 
     * @param string xmlStr, the current cube xml data
     * @param string detail, the requested detail
     * @returns string, the detail data 
     */
    function getDetailData(xmlStr, detail) {

      var ret = "";
      var re;
      
      detail = detail.toLowerCase();
      
      xmlStr = xmlStr.replace('<?xml version="1.0" encoding="UTF-8"?>',"");
      xmlStr = xmlStr.replace('<details>',"");
      xmlStr = xmlStr.replace('</details>',"");
      xmlStr = xmlStr.replaceAll('\n',"");
      xmlStr = xmlStr.replaceAll(String.fromCharCode(9), "");
      xmlStr = xmlStr.replaceAll(String.fromCharCode(10), "");
      xmlStr = xmlStr.replaceAll(String.fromCharCode(13), "");
      xmlStr = xmlStr.replaceAll("   ", "");
      xmlStr = xmlStr.replaceAll("  ", "");
      xmlStr = escape(xmlStr);
      xmlStr = xmlStr.replaceAll("%0A", "");
      xmlStr = xmlStr.replaceAll("%20%20%20%20%20", "");
      xmlStr = xmlStr.replaceAll("%20%20%20%20%", "");
      xmlStr = xmlStr.replaceAll("%20%20%", "");
      //xmlStr = unescape(xmlStr);
      //alert(xmlStr);
      
      switch (detail) {
        case "address":
          re = new RegExp("detail%20face%3D%22address%22.+/country", "igsu");
          break;
        case "contacts":
          re = new RegExp("detail%20face%3D%22contacts%22.+/cell", "igsu");
          break;
        case "other info":
          re = new RegExp("detail%20face%3D%22other%20info%22.+/description", "igsu");
          break;
        case "menu":
          re = new RegExp("detail%20face%3D%22menu%22.+/menu3", "igsu");
          break;
        case "pictures":
          re = new RegExp("detail%20face%3D%22pictures%22.+/pic5", "igsu");
          break;
        case "password":
          re = new RegExp("detail%20face%3D%22password%22.+/password", "igsu");
          break;
      }        
      s = re.exec(xmlStr);
      if (!s || s.length===0) {
        ret = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error! #1";
        return ret;
      }
      xmlStr = s[0];
      xmlStr = "<"+xmlStr+"></detail>";
      xmlStr = unescape(xmlStr);
      //alert(xmlStr);
      const parser = new DOMParser();
      const doc = parser.parseFromString(xmlStr, "text/xml");
      x = doc.getElementsByTagName("detail");
      if (x.length===0) {
        ret = "Error! #2";
        return ret;
      }
      ret += "<div style='padding:10px'>";
      for (i = 0; i < x[0].childNodes.length; i++) {
        if (x[0].childNodes[i].nodeType === 1) {
          if (x[0].childNodes[i].getAttributeNode("type")) {
            mytype = x[0].childNodes[i].getAttributeNode("type");
            if (mytype.value==="pic") {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' placeholder='https://'  onkeyup='storePicData(this)'></div>";
            } else {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)'></div>";
            }  
          } else {  
            if (x[0].childNodes[i].nodeName === "business-type") {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)' style='color:green' readonly></div>";
            } else if (x[0].childNodes[i].nodeName === "guid") {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)' style='color:green' readonly></div>";
            } else if (x[0].childNodes[i].nodeName === "password") {
              if (password===1) {
                ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)' style='color:green' readonly></div>";
              }
            } else if (x[0].childNodes[i].nodeName === "city-zip-prov") {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)' style='color:green' readonly></div>";
            } else if (x[0].childNodes[i].nodeName === "country") {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)' style='color:green' readonly></div>";
            } else {
              ret += "<div style='float:left;width:35%;text-align:right;height:32px;vertical-align:middle;padding-top:3px;font-weight:900;white-space:nowrap;'>" + x[0].childNodes[i].nodeName + "&nbsp;&nbsp;</div><div style='float:right;width:65%;height:32px;'>" + "<input type='text' id='cube-detail-" + x[0].childNodes[i].nodeName + "' value='" + x[0].childNodes[i].textContent + "' onkeyup='storeData(this)'></div>";  
            }  
          }  
        }  
      }
      if ((detail==="pictures") || (detail==="menu")) {
        ret += "<div style='padding-left:80px;clear:both;'><br>you can use eg. Goolge Drive or Microsoft OneDrive to host your pictures.</div>"
      }
      ret += "</div>";
      return ret;
    }  

    /*
     * Store the old data of the text control
     * 
     * @param {InterfaceEl} tthis, the text control under editing
     * @returns void     
     */ 
    /*function storeOldData(tthis) {
      //alert("keypress");
    
      lineOldVal = $(tthis).val();
    }*/

    /*
     * Store in the cube object the new data of the text control
     * 
     * @param {InterfaceEl} tthis, the text control under editing
     * @returns void     
     */ 
    function storeData(tthis) {
      
      //alert("keyup");
    
      lineNewVal = $(tthis).val();
      //alert(lineNewVal);
      
      nodeName = tthis.id;
      nodeName = nodeName.replace("cube-detail-","");
      //alert(nodeName);
      
      xmlStr = curcube.getxml();
      //$("#log").html($("#log").html() + "old=" + "/(\<" + nodeName + "\>).*(\<\/" + nodeName + "\>)/gs" + "\n");
      //$("#log").html($("#log").html() + "new=" + lineNewVal + "\n");
      //alert("<" + nodeName + ">" + lineNewVal + "</" + nodeName + ">");
      //re = "/(\<" + nodeName + "\>).*(\<\/" + nodeName + "\>)/gs";
      
      switch (nodeName) {
        case "name":
          re = /(\<name>).*(\<\/name>)/gs;
          break;
        case "address-line1":
          re = /(\<address-line1>).*(\<\/address-line1>)/gs;
          break;
        case "address-line2":
          re = /(\<address-line2>).*(\<\/address-line2>)/gs;
          break;
        case "address-line3":
          re = /(\<address-line3>).*(\<\/address-line3>)/gs;
          break;
        case "city-zip-prov":
          re = /(\<city-zip-prov>).*(\<\/city-zip-prov>)/gs;
          break;
        case "country":
          re = /(\<country>).*(\<\/country>)/gs;
          break;
        case "tel":
          re = /(\<tel>).*(\<\/tel>)/gs;
          break;
        case "fax":
          re = /(\<fax>).*(\<\/fax>)/gs;
          break;
        case "cell":
          re = /(\<cell>).*(\<\/cell>)/gs;
          break;
        case "description":
          re = /(\<description>).*(\<\/description>)/gs;
          break;
      }  
            
      xmlStr = xmlStr.replace(re, "$1" + lineNewVal + "$2");
      //xmlStr = xmlStr.replace("<" + nodeName + ">" + lineOldVal + "</" + nodeName + ">", "<" + nodeName + ">" + lineNewVal + "</" + nodeName + ">");
      //alert(xmlStr);
      
      curcube.xml = xmlStr;
      
      dataChanged = true;
    }

    /*
     * Store in the cube object the new pic data
     * 
     * @param {InterfaceEl} tthis, the text control under editing
     * @returns void     
     */ 
    function storePicData(tthis) {
      
      //alert("keyup");
      
      lineNewVal = $(tthis).val();
      
      nodeName = tthis.id;
      nodeName = nodeName.replace("cube-detail-","");
      //alert(nodeName);
      
      xmlStr = curcube.getxml();
      
      switch (nodeName) {
        case "menu1":
          re = /(\<menu1\stype\=\"pic\">).*(\<\/menu1>)/gs;
          break;
        case "menu2":
          re = /(\<menu2\stype\=\"pic\">).*(\<\/menu2>)/gs;
          break;
        case "menu3":
          re = /(\<menu3\stype\=\"pic\">).*(\<\/menu3>)/gs;
          break;
        case "pic1":
          re = /(\<pic1\stype\=\"pic\">).*(\<\/pic1>)/gs;
          break;
        case "pic2":
          re = /(\<pic2\stype\=\"pic\">).*(\<\/pic2>)/gs;
          break;
        case "pic3":
          re = /(\<pic3\stype\=\"pic\">).*(\<\/pic3>)/gs;
          break;
        case "pic4":
          re = /(\<pic4\stype\=\"pic\">).*(\<\/pic4>)/gs;
          break;
        case "pic5":
          re = /(\<pic5\stype\=\"pic\">).*(\<\/pic5>)/gs;
          break;
      }  
      
      xmlStr = xmlStr.replace(re, "$1" + lineNewVal + "$2")
      //xmlStr = xmlStr.replace("<" + nodeName + " type=\"pic\">" + lineOldVal + "</" + nodeName + ">", "<" + nodeName + " type=\"pic\">" + lineNewVal + "</" + nodeName + ">");
      //alert(xmlStr);
      
      curcube.xml = xmlStr;
      
      dataChanged = true;
    }

    function _saveData() {
      if (dataChanged) {
        curcube.savedata();
        //saveData();
        dataChanged = false;
      }  
    }  

    setInterval("_saveData()", 1500);

    /*
     * Display the given data detail
     * 
     * @param <interfaceEl> selected cube
     * @returns void
     */
    function openDetail(tthis) {
      myhtml = getDetailData(curcube.getxml(), $(tthis).attr("target"));
      $("#detailtitle").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + $(tthis).attr("target") + ":");
      $("#detaildata").html(myhtml);
      $("#datadetail").show();      
      //alert(curcube.getxml());
    }

  // -- End Interaction / Interface code
  </script>
 
     <script>
    
    /*
     * Boot app code
     */
    
    //var fetchDataIntervalId;  
    
    /*
     * App starting proc
     * 
     * @returns void
     */
    function startApp() {

      // Init document background..
      //$(document.body).css("background","#0d0d0d");

      // Cubes initialization..
      //mymap = ["Address", "Contacts", "Other Info", "Menu", "Pictures", "Password"]; 
      //cubes[0] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#1", mymap, "cube1");
      //cubes[0].start();
      //cubes[1] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#2", mymap, "cube2");
      //cubes[1].start();
      //cubes[2] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#3", mymap, "cube3");
      //cubes[2].start();
      //cubes[3] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#4", mymap, "cube4");
      //cubes[3].start();
      //cubes[4] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#5", mymap, "cube5");                                
      //cubes[4].start();
      
    <?php 
      chdir(APP_DATA_PATH);
      foreach (glob("*.xml") as $filename) { ?>
        i = parseInt("<?php echo(substr(substr($filename, 0, strlen($filename)-4),4));?>");
        $("#cubeList").html($("#cubeList").html()+"<div id='cube" + i + "' class='cube' order='" + i + "' onclick='selCube(this)'   draggable='true' ondragstart='onDragStart(this, event);' onmouseover='onMouseOver();'><div id='cube" + i + "name' class='cubename'>cube#" + i + "</div></div>");
        $("#cube" + i + "name").html("<?PHP echo(BUSINESS_TYPE)?>#" + i);
        if (i<10) {
          newFormalName = "cube" + "00" + i;
        } else if (i<100) {
          newFormalName = "cube" + "0" + i;
        } else {
          newFormalName = "cube" + i;
        }  
        cubes[i-1] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#" + i, newFormalName);
        cubes[i-1].start();
        totcubes = i;
    <?php
      }    
    ?>
      
      //$("#cube1name").html(cubes[0].getname());
      //$("#cube2name").html(cubes[1].getname());
      //$("#cube3name").html(cubes[2].getname());
      //$("#cube4name").html(cubes[3].getname());
      //$("#cube5name").html(cubes[4].getname());                        
   
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

    }

    window.addEventListener("load", function() {

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

  // -- End Boot app code
  </script>      
          
     <script>
                            
  /*
   * Drag-n-drop code
   */                           
  
    function onDragStart(tthis, e) {
      //e.preventDefault();
      tthisorder = parseInt($(tthis).attr("order"));
      //objName = document.getElementById("objName").value;
      //alert(objName);
      jsonData = serialize( cubes[tthisorder-1] );
      //alert(jsonData);
      e.dataTransfer.setData('text/plain', jsonData);
      document.body.style.cursor="move";
    }

    function onDragOver(e) {
      e.preventDefault();
      const id = e.dataTransfer.getData('text/plain');
      document.body.style.cursor="pointer";     
    }  

    function onDragOverOff(e) {
      e.preventDefault();
      document.body.style.cursor="not-allowed";     
    }  

    function onDrop(e) {
      e.preventDefault();
      mys=e.dataTransfer.getData('text/plain');
      //alert(mys);
      
      newcube = deserialize(mys);
      
      bfound=false;
      for (i=0;i<totcubes;i++) {
        if (cubes[i].getguid() === newcube.getguid()) {
          bfound=i;
          break;
        }  
      }
      
      if (bfound===false) {
        n=totcubes+1;
        cubes[n-1] = newcube;
        cubes[n-1].name = "<?PHP echo(BUSINESS_TYPE)?>#" + n;
        if (n<10) {
          newFormalName = "cube" + "00" + n;
        } else if (n<100) {
          newFormalName = "cube" + "0" + n;
        } else {
          newFormalName = "cube" + n;
        }  
        cubes[n-1].formalName = newFormalName;
        $("#cubeList").html($("#cubeList").html()+"<div id='cube" + n + "' class='cube' order='" + n + "' onclick='selCube(this)'  draggable='true' ondragstart='onDragStart(this, event);' onmouseover='onMouseOver();'><div id='cube" + n + "name' class='cubename'>cube#" + n + "</div></div>");
        $("#cube"+n+"name").html(cubes[n-1].getname());
        totcubes=n;
      } else {
        
        if (cubes[i].getpassword() === newcube.getpassword()) {
          pwd2 = prompt("password confirmation:");
          if (cubes[i].getpassword() != pwd2) {
            $("#cubeList").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permission denied.");  
            return;
          }  
        } else {
          $("#cubeList").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permission denied.");  
          return;
        }  
       
        n=bfound+1;
        cubes[n-1] = newcube;
        cubes[n-1].name = "<?PHP echo(BUSINESS_TYPE)?>#" + n;
        if (n<10) {
          newFormalName = "cube" + "00" + n;
        } else if (n<100) {
          newFormalName = "cube" + "0" + n;
        } else {
          newFormalName = "cube" + n;
        }  
        cubes[n-1].formalName = newFormalName;
        //$("#cubeList").html($("#cubeList").html()+"<div id='cube" + n + "' class='cube' order='" + n + "' onclick='selCube(this)'><div id='cube" + n + "name' class='cubename'>cube#" + n + "</div></div>");
        $("#cube"+n+"name").html(cubes[n-1].getname());
      }

      cubes[n-1].savedata();

      document.body.style.cursor="normal";
      
      /*
      n=totcubes+1;
      $("#cubeList").html($("#cubeList").html()+"<div id='cube" + n + "' class='cube' order='" + n + "' onclick='selCube(this)'><div id='cube" + n + "name' class='cubename'>cube#" + n + "</div></div>");
      //cubes[n-1] = new myCube("<?PHP echo(BUSINESS_TYPE)?>#"+n, "cube"+n);
      cubes[n-1] = deserialize(mys);
      cubes[n-1].name = "<?PHP echo(BUSINESS_TYPE)?>#" + n;
      newFormalName = "cube" + n;
      cubes[n-1].formalName = newFormalName;
      $("#cube"+n+"name").html(cubes[n-1].getname());
      totcubes=n;
      //newObj.start();
      cubes[n-1].savedata();
      document.body.style.cursor="normal";
      */
    }

    function onDropOff(e) {
      e.preventDefault();
      document.body.style.cursor="not-allowed";
      e.stopPropagation();
    }

    function onMouseOver() {
      document.body.style.cursor="pointer";     
    }
  
  // -- End drag-n-drop code
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

     <script>
                                                               
    setContentPos();                                           
    
  </script>                                                              
      
  </body>
  </html>
