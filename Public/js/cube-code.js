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
 * cube-code.js
 * 
 * Cube Code for home.php.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode     
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
function myCube(myname, myformalName, myAPP_HOST) {

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
    var xmluri = "https://" + myAPP_HOST + "/getxml?f=" + this.formalName;
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
