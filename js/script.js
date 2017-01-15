//funktion wird aus Courseware Sections/templates/block-wrapper.mustache als onclick aufgerufen
function addCoursewareVisibleElements(element){
   
    //das notvisible class-Element sorgt für das richtige Icon, welches bei jedem Klick wechselt
    if($(element).hasClass('notvisible'))
        {
            $(element).removeClass('notvisible');
        }
        else
        {
            $(element).addClass('notvisible');
        }
    //var url = "localhost/norden3.4/public/plugins_packages/asudau@elan-ev.de/VHSViewPlugin/visibility.php?id=" + $(element).closest('section').prop('id');
    //
//Durch Aufruf der URL mit übergebener Block ID wird letztere in der Datenbank wechselweise als (un-)sichtbar markiert
    var url = "http://norden.elan-ev.de/courseware_visible.php?id=" + $(element).closest('section').prop('id');
    //var url = "http://localhost/norden3.4/public/test.php?id=" + $(element).closest('section').prop('id');
    $.get(url, function(data, status){
    });
             
}

function hideInvisibleBlocks(){
    
    //in der Autorensicht werden die Blöcke natürlich nicht verborgen, in der Teilnehmersicht wird für die Blöcke 
    //mit entsprechenden ids aus der DB ein CSS hinzugefügt das diese verbirgt
    if (!window.location.href.includes("#author")){
   
      var url = "http://norden.elan-ev.de/courseware_visible.php?id=all";
      //var url = "http://localhost/norden3.4/public/test.php?id=all";
      $.get(url, function(invisibleBlocks, status){
        if( document.styleSheets ) {
            var myStyle = document.createElement("style");
            myStyle.setAttribute( "type", "text/css" );
            document.getElementsByTagName("head")[0].appendChild(myStyle);

            var styles = document.styleSheets.length;
            myStyle = document.styleSheets[styles-1];
            //invisibleBlocks = invisibleBlocks.replace("\"","");
            var ids = String(invisibleBlocks).split(';');
            var length = ids.length;
            var i;
            
                if( document.styleSheets[0].cssRules ) {
                    for(i = 0; i < length-1; i++){
                        myStyle.insertRule('#block-' + ids[i] + '{ display: none !important; }', myStyle.cssRules.length);
                    }
                } else {
                    if ( document.styleSheets[0].rules ) {
                        myStyle.addRule("#block-" + ids[i], "display: none; }", myStyle.rules.length);
                    }
                }
            
        }
      });
    } else {
        //da es eine Weile dauert bis alles geladen ist ist hier ein Timeout nötig
        setTimeout(function(){
            var url = "http://norden.elan-ev.de/courseware_visible.php?id=all";
            $.get(url, function(invisibleBlocks, status){
                var ids = String(invisibleBlocks).split(';');
                var length = ids.length;
                var i;
                for(i = 0; i < length-1; i++){
                    var button = document.getElementById("block-"+ ids[i]);
                    if (!!button){
                        button.getElementsByClassName("changevisibility")[0].classList.add("notvisible");
                    }
                }
            });
        }, 2000);
       }
    
    //var url = "http://localhost/norden3.4/public/test.php?id=all";
   // $.get(url, function(invisibleBlocks, status){
         //alert("Data: " + invisibleBlocks + "\nStatus: " + status);
     //    var blocks = $('[id^="block-"]');
       //  var block;
        // for (block in blocks){
         //    alert(block.prop('id'));
         //    block.style.display="none";
        // }
   // });
    
}

window.onload = hideInvisibleBlocks();
//window.onload = function(){setTimeout(hideInvisibleBlocks,2000)};