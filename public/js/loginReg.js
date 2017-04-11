/**
 * Created by victor.taguines on 4/10/17.
 */
$(document).ready(function(){

    $(".back").click(function(){
        $('.loginForm').get(0).reset();
        $('span').html(' ');
        $('.loginForm input').css({'margin-bottom':'25px','border-color':'#ccffcc'});
        $(".signIn").addClass("active-dx");
        $(".signUp").addClass("inactive-sx");
        $(".signUp").removeClass("active-sx");
        $(".signIn").removeClass("inactive-dx");
    });
    $(".log-in").click(function(){
        $('.registerForm').get(0).reset();
        $('span').html(' ');
        $('.registerForm input').css({'margin-bottom':'25px','border-color':'#ccffcc'});
        $(".signUp").addClass("active-sx");
        $(".signIn").addClass("inactive-dx");
        $(".signIn").removeClass("active-dx");
        $(".signUp").removeClass("inactive-sx");
    });
    $('#loginBTN').click(function(e){
        e.preventDefault();
        var myData = $('.loginForm').serialize();
        $.ajax({
            url:"loginUser",
            method:"POST",
            data:myData,
            dataType:"json",
            success: function(data){
                $.each( data.messages, function( key, value ) {
                    $('.error-'+key).text(value);
                    $('#'+key).css({'margin-bottom':'0','border-color':'red'});
                });
                $('span').css('display', 'block');
                if(data.status == 'success'){
                    window.location.href = 'home';
                }else if(data.status == 'invalid-user'){
                    $('.error-password').text('Invalid Password');
                    $('.loginForm #password').css({'margin-bottom':'0','border-color':'red'});
                }
            }
        });
    });
    $('.btn-register').click(function(e){
        e.preventDefault();
        var myData = $('.registerForm').serialize();
        $.ajax({
            url:"registerAccount",
            method:"POST",
            data:myData,
            dataType:"json",
            success:function(data){
                $.each(data.messages,function(key, value){
                    $('.error-'+key).text(value);
                    $('#'+key).css({'margin-bottom':'0','border-color':'red'});
                });
                $('span').css('display', 'block');
                if(data.status == 'success'){
                    $('#myModal').modal('show');
                }

            }
        });
    });
    $('.closeModal').click(function(){
        $('.log-in').trigger('click');
    });
});