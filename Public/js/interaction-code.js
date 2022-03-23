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
 * interaction-code.js
 * 
 * Interaction Code for home.php.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode     
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
