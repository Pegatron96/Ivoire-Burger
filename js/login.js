$("#register_form input").focus(function(){
    $("#status").fadeOut(800);
});

$("#email").keyup(function(){
    check_email();

});


function check_email() {
    $.ajax({
        type: 'post',
        url: '../users/traitement.php',
        data: {
            'email_check' : $("#email").val()
        },
        success: function(data){
            if(data == "success"){
                $("#help-inline-e").html("<img class='img-thumbnail small_image' src='../img/validate.PNG' alt='' />");
            }else{
                $("#help-inline-e").css("color", "red").html(data).fadeIn(400);
            }
        }
    });
}

