/**
 * Copyright (c) 2016, 2024, L'Isola del Tesoro
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither L'Isola del Tesoro nor the names of its affiliates 
 *       may be used to endorse or promote products derived from this software 
 *       without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * common.js
 * 
 * common javascript
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, L'Isola del Tesoro
 * @license https://opensource.org/licenses/BSD-3-Clause 
 */

/**
 * Encrypt the given string
 * 
 * @param {string} string - The string to encrypt
 * @returns {string} the encrypted string
 */
function encryptSha2(string) {
  var jsSHAo = new jsSHA("SHA-256", "TEXT", 1);
  jsSHAo.update(string);
  return jsSHAo.getHash("HEX");
}

/**
 * Open a link from any event handler
 * 
 * @param {string} href the link to open
 * @param {string} target the frame target
 * @returns {none}
 */
function openLink(href, target) {
  window.open(href, target);
}

function rnd(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min +1)) + min;
}

window.addEventListener("load", function(){

}, true);

window.addEventListener("resize", function(){

}, true);

// Global window load event handler..
window.addEventListener("scroll", function() {

}, true);