/**
 * Created by jason.viado on 4/3/17.
 */

$(document).ready(function(){
    var id = $('#room').val();
    //Load Post
    loadPost(id);
    // Submit Post
    $('#submitPost').on('click',function(){
        $.ajax({
            method : 'post',
            url : 'post',
            data: {
                post : $('#post').val(),
                _token : $('#_token').val(),
                user : $('#user').val()
            },
            success :function(data){
                loadPost(id)
            },
            error : function(){

            }
        });
    })
});
function loadPost(id){
    var content = '';
    $.ajax({
        method : 'get',
        url : 'profile_post',
        data : {
          id : id
        },
        success :function(data){
            $.each(data.messages,function(index,item){
                content = content + '<div class="indi_post"><label>'+ item.name +'</label><div class="content">'+ item.user_post +'</div><span>'+ item.post_date +'</span></div>'
            });
            $('.post').html(content);
        },
        error : function(){

        }
    });
}