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
 * putxml.php
 * 
 * Write an xml file in the data folder.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode
 * @license https://opensource.org/licenses/BSD-3-Clause 
 */

//
// PARAMETER VALIDATION
//
$filename = filter_input(INPUT_POST, "f");
/*switch ($filename) {
  case "cube1":
  case "cube2":  
  case "cube3":
  case "cube4":  
  case "cube5":
    $filename = $filename . ".xml";
    break;
  default:
    exit(0);
} */
if (preg_match("/cube\d\d\d/", $filename)) {
  $filename = $filename . ".xml";
} else {
  exit(0);
}
$filepath = APP_DATA_PATH . PHP_SLASH . $filename;

$xmlStr = filter_input(INPUT_POST, "xml");

file_put_contents($filepath, $xmlStr);

echo json_encode([200, 'OK']);