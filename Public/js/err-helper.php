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
 * err-helper.php
 * 
 * JS Error helper.
 * 
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode    
 */

require "../../Private/core/init.inc";

use OpenGallery\OpenGallery\Err;

header("Content-Type: text/javascript");


// PARAMETERS VALIDATION AND NORMALIZATION

?>

var ERR_NO = "<?php echo ERR_NO; ?>";
var ERR_KEY = "<?php echo ERR_KEY; ?>";
var ERR_MSG = "<?php echo ERR_MSG; ?>";
var ERR_SCRIPT = "<?php echo ERR_SCRIPT; ?>";
var ERR_LINE = "<?php echo ERR_LINE; ?>";
var ERR_STACK = "<?php echo ERR_STACK; ?>";

var A_ERR_NO = {
  <?php
    $start=true;
    foreach (Err::$A_ERR_NO as $key => $value) {
      if (!$start) {
        echo ",\n";
      } else {
        $start=false;
      }
      echo "'$key':\"$value\"";
    }
    echo "\n";
  ?>
}; 

var A_ERR_MSG = {
  <?php
    $start=true;
    foreach (Err::$A_ERR_MSG as $key => $value) {
      if (!$start) {
        echo ",\n";
      } else {
        $start=false;
      }
      echo "'$key':\"$value\"";
    }
    echo "\n";
  ?>
};  

var A_ERR_EXTDES_MSG = {
  <?php
    $start=true;
    foreach (Err::$A_ERR_EXTDES_MSG as $key => $value) {
      if (!$start) {
        echo ",\n";
      } else {
        $start=false;
      }
      echo "'$key':\"$value\"";
    }
    echo "\n";
  ?>
};  


function clearErrors() {
  $(".form-error").each(function(index, Element) {
     $(this).hide();
  });
  
  $(".form-error-adapt").each(function(index, Element) {
     $(this).hide();
  });
}
