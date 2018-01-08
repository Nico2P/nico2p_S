$(function () {

    $(".cachecube").hide();
    $(".cachechess").hide();
    $(".cachemoto").hide();
    $(".cacheos").hide();


    $( "#cube" ).hover(
        function(event) {
            $(".cachecube").toggle();
        });

    $( "#chess" ).hover(
        function(event) {
            $(".cachechess").toggle();
        });

    $( "#moto" ).hover(
        function(event) {
            $(".cachemoto").toggle();
        });

    $( "#os" ).hover(
        function(event) {
            $(".cacheos").toggle();
        });

});