jQuery(function($){

    var launch = new Date(2019, 5, 27, 14, 0,0);
    var days = $("#days");
    var hours  = $("#hours");
    var minutes = $("#minutes");
    var seconds = $("#seconds");

    setDate();
    function setDate()
    {
        var now = new Date();
        var s = (now.getTime() + 300000)/1000;
       // var s = (launch.getTime() - now.getTime())/1000;
       var d = Math.floor(s/86400);
      //$("#days").html("<strong>" +d+ "</strong>");
        s -= d*86400;
        var m = math.floor(s/60);
        minutes.html("<strong> +m+ </strong>");
        s -= m*60;


        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);

        setTimeout(setDate, 60000);




    }



});