define(function(require) {

    var elgg = require("elgg");
    var $ = require("jquery");

    $( "#world" ).click(function() {
      $('#thewire-textarea').val($('#thewire-textarea').val()+' world'); 

      e.preventDefault();
    });

    $( "#cow" ).click(function() {
        $('#thewire-textarea').val($('#thewire-textarea').val()+' cow'); 

        e.preventDefault();
    });

    $( "#island" ).click(function() {
      $('#thewire-textarea').val($('#thewire-textarea').val()+' island'); 

      e.preventDefault();
    });

    $( "#flamingo" ).click(function() {

        if ($('#enable-flamingo').val() == "true") {

            $("#flamingo img").css('border', "0px solid");

            $('#enable-flamingo').val('false'); 

        } else if ($('#enable-flamingo').val() == "false") {

            $("#flamingo img").css('border', "solid 2px green");  

            $('#enable-flamingo').val('true'); 

        }


    });
    
});