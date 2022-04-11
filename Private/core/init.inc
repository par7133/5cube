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
 * init.inc
 * 
 * 5 Cube initialization file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2024, 5 Mode     
 */
 
error_reporting(E_ALL & ~ (E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED));  
ini_set('display_startup_errors',1);  
ini_set('display_errors',1);  
ini_set('log_errors',1);

require dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.inc";

// Checking a little the configuration..
if (!file_exists(APP_DATA_PATH)) {
  die("Data folder doesn't exist. You must create a data folder in your web app private path and configure it properly inside the config file.");
}	
if (!file_exists(APP_TEMPLATE_PATH)) {
  die("Template folder doesn't exist. You must have a tempate folder in your web app private path and configure it properly inside the config file.");
}	
if (EDITOR_PASSWORD === "" || (strlen(EDITOR_PASSWORD) < 64)) {
  die("Editor password must be set (with a 6 chars min length). You must generate an editor password and configure it properly inside the config file.");
}  

if (!file_exists(APP_DATA_PATH . "/cube001.xml")) {
  // Generating data from the template..

  for ($n=1;$n<=5;$n++) { 
    
    if (!file_exists(APP_DATA_PATH . "/cube00$n.xml")) {
      // -- generating cubeN.xml
      copy(APP_TEMPLATE_PATH . "/cube.xml.amp.template",APP_DATA_PATH . "/cube00$n.xml");
      //chmod(APP_DATA_PATH . "/cube00$n.xml", 0777);
      $xmlStr = file_get_contents(APP_DATA_PATH . "/cube00$n.xml");
      $newGuid = mb_substr(hash("sha256", mt_rand() . mt_rand() . APP_SALT, false), 0, 32);
      $xmlStr = str_replace("<guid></guid>", "<guid>" . $newGuid . "</guid>", $xmlStr);
      $xmlStr = str_replace("<business-type></business-type>", "<business-type>" . BUSINESS_TYPE . "</business-type>", $xmlStr);
      $xmlStr = str_replace("<city-zip-prov></city-zip-prov>", "<city-zip-prov>" . BUSINESS_CITY_ZIP_PROV . "</city-zip-prov>", $xmlStr);
      $xmlStr = str_replace("<country></country>", "<country>" . BUSINESS_COUNTRY . "</country>", $xmlStr);
      $xmlStr = str_replace("<password></password>", "<password>" . EDITOR_PASSWORD . "</password>", $xmlStr);
      $xmlStr = file_put_contents(APP_DATA_PATH . "/cube00$n.xml", $xmlStr);
    }  
  }  
}  

require dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "const.inc";
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "funct.inc";

// ERROR HANDLING AND LOGGING

if (DEBUG) {
  error_reporting(E_ALL | E_STRICT);  
  ini_set('display_startup_errors',1);  
  ini_set('display_errors',1);
  ini_set('log_errors',1); 
} else {
  error_reporting(E_ALL & ~ (E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED));  
  ini_set('display_startup_errors',0);  
  ini_set('display_errors',0);  
  ini_set('log_errors',1); 
}

// Set no cache headers
// for HTTP/1.0 clients
header("Expires: 0");
header("Pragma: no-cache");
// HTTP/1.1 support
header("Cache-Control: private,no-cache,max-age=0,s-maxage=0,must-revalidate");
