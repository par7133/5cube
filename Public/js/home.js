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
 * home.js
 * 
 * JS for home.php.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode     
 */

/*
 *  Display the current hash for the config file
 *  
 *  @returns void
 */
function showEncodedPassword() {
  if ($("#Password").val() === "") {
    $("#Password").addClass("emptyfield");
    return;  
  }
  if ($("#Salt").val() === "") {
    $("#Salt").addClass("emptyfield");
    return;  
  }	   	
  passw = encryptSha2( $("#Password").val() + $("#Salt").val());
  msg = "Please set your hash in the config file with this value:";
  alert(msg + "\n\n" + passw);	
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

function setContentPos() {
  $("#cubeList").css("height", parseInt(window.innerHeight-20) + "px");
}

window.addEventListener("load", function() {
    
  if ($("#cubeList").css("display")==="none") {
    setTimeout("setFooterPos()", 9000);
  } else {
    setTimeout("setFooterPos()", 2000);  
  } 

});

window.addEventListener("resize", function() {

  if ($("#cubeList").css("display")==="none") {
    setTimeout("setFooterPos()", 9000);
  } else {
    setTimeout("setFooterPos()", 2000);  
  } 

});