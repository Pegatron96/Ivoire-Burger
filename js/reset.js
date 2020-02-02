$(document).ready(function (){

    //Traitement des données du formulaire avant soumission, (focus)

    $("#register_form input").focus(function(){
        $("#status").fadeOut(800);
    });



    $("#password").keyup(function(){
        if($(this).val().length < 8){
            $("#help-inline-p").css("color", "red").html("Trop court, saissez un mot de passe d'au moins 8 caractères");
        } else if($("#confirm_password").val() != " " && $("#confirm_password").val() != $("#password").val()){
            $("#help-inline-p").css("color", "red").html("Les deux mots de passe ne correspondent pas");
            $("#help-inline-c").css("color", "red").html("Les deux mots de passe ne correspondent pas");

        } else {
            $("#help-inline-p").html('<img  class="img-thumbnail small_image" src="../img/validate.PNG" alt=""/>');
            if($("#confirm_password").val() != ""){
                $("#help-inline-c").html('<img class="img-thumbnail small_image" src="../img/validate.PNG" alt=""/>');
            }
        }

    });