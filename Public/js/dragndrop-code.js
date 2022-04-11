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
 * dragndrop-code.js
 * 
 * Drg-n-drop Code for home.php.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode     
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
    cubes[n-1].name = businessType + "#" + n;
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
      pwd2en = encryptSha2(pwd2);
      if (cubes[i].getpassword() != pwd2en) {
        $("#cubeList").html("<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permission denied.");  
        return;
      }  
    } else {
      $("#cubeList").html("<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permission denied.");  
      return;
    }  

    n=bfound+1;
    cubes[n-1] = newcube;
    cubes[n-1].name = businessType + "#" + n;
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

}

function onDropOff(e) {
  e.preventDefault();
  document.body.style.cursor="not-allowed";
  e.stopPropagation();
}

function onMouseOver() {
  document.body.style.cursor="pointer";     
}
  

