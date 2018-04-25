/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready(function() {
    document.getElementById("flex-header").innerHTML = "<div style='position:relative;width: 50%;padding-bottom: 16%;'><iframe id='logo-iframe' style='position:absolute;width:100%;height:100%;' src='' frameborder='0'></iframe></div>";
    document.getElementById('logo-iframe').src = 'https://www.jobstarter.de/media/logos/horizontal_neu.html';
    document.getElementById("flex-header").style.height='125px';
});