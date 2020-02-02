/*
 * FOrm validation using AJax (Asynchronous Javascript And Xml)
 *
 * Copyright 2019, Jude Ette
 *
 * CEO, Tetratech Inc
 *
 * http://github.com/pegatron18
 *
 *  ettealiezi18@univmetiers.ci.
 */


$(document).ready(function (){

    //Treating data from the form before submit, (focus)

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

    $("#firstname").keyup(function(){
        if($(this).val() != ""){
            $("#help-inline-f").html('<img class="img-thumbnail small_image" src="../img/validate.PNG" alt=""/>');
        } 

    });

    $("#lastname").keyup(function(){
        if($(this).val() != ""){
            $("#help-inline-l").html('<img class="img-thumbnail small_image" src="../img/validate.PNG" alt=""/>');
        } 

    });

    $("#confirm_password").keyup(function(){
        check_password();

    });

    $("#email").keyup(function(){
        check_email();

    });

    function check_password() {
        $.ajax({
            type: 'post',
            url: '../users/process.php',
            data: {
                'password_check' : $("#password").val(),
                'confirm_password_check' : $("#confirm_password").val()
            },
            success: function (data) {
                if(data == "success"){
                    $("#help-inline-c").html("<img  class='img-thumbnail small_image' src='../img/validate.PNG' alt=''/>");
                    $("#help-inline-p").html("<img class='img-thumbnail small_image' src='../img/validate.PNG' alt=''/>");
                }else{
                    $("#help-inline-c").css("color", "red").html(data);
                }
            }
        });

    }

    function check_email() {
    $.ajax({
        type: 'post',
        url: '../users/process.php',
        data: {
            'email_check' : $("#email").val()
        },
        success: function(data){
            if(data == "success"){
                $("#help-inline-e").html("<img class='img-thumbnail small_image' src='../img/validate.PNG' alt='' />");
            }else{
                $("#help-inline-e").css("color", "red").html(data);
            }
        }
    });
}

//Traitement des données du formulaire après soumission (submit)

    $("#register_form").submit(function(){
        var status = $("#statut");
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        var email = $("#email").val();
        var isSuccess = true;

        if(firstname == ""){

            $("#help-inline-f").css("color", "red").html("Saisissez votre nom de famille");
            isSuccess = false;
        }
         if(lastname == ""){
            $("#help-inline-l").css("color", "red").html("Saisissez votre prénom");
            isSuccess = false;
        }

        if(password == ""){
            $("#help-inline-p").css("color", "red").html("Créez un mot de passe s'il vous plaît");
            isSuccess = false;
        }

        if(password != confirm_password){
            $("#help-inline-p").css("color", "red").html("les deux mots de passe ne correspondent pas");
            $("#help-inline-c").css("color", "red").html("les deux mots de passe ne correspondent pas");
            isSuccess = false;
        }

        if(email == ""){
            $("#help-inline-e").css("color", "red").html("Adresse e-mail invalide");
            isSuccess = false;
        }
        
        if(isSuccess){
            $.ajax({
                type: 'post',
                url: '../users/process.php',
                data: {
                    'firstname': firstname,
                    'lastname': lastname,
                    'password': password,
                    'confirm_password': confirm_password,
                    'email': email,
                },

                beforeSend: function () {
                    $("#register").attr("value", "traitement en cours..");



                },
                
                success: function(data){
                    if(data != "register_success"){
                        //$("#register").attr("value", "Inscription");
                        //status.html(data).fadeIn(400);
                      //  $("#register").addClass("btn-primary").css("color", "white");
                       // $("#register").attr("value", "Inscription terminé");
                      //  status.html("<span class='alert alert-success'>Un e-mail de confirmation vous a été envoyé pour confirmer votre compte</span>").fadeIn(400);
                       // $(".form-group").hide();
                    }else{
                        $("#register").attr("value", "Inscription terminé");
                       status.html("<span class='alert alert-success'>Un e-mail de confirmation vous a été envoyé pour confirmer votre compte</span>").fadeIn(400);
                       $(".form-group").hide();

                         
                    }
                }
            });
        }

    });



});