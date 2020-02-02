(function ($){
    $(".addpanier").click(function(event){
        event.preventDefault();
        $.get($(this).attr("href"),{},function(data){
        if(data.error){
            $(".modal-body").html(data.message);
        }else{
            $(".modal-body").html(data.message);
            $(".c").html("<i class='fa fa-shopping-cart'></i>");

        }
        }, 'json');

    });
})(jQuery);