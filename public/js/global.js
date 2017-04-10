/**
 * Created by jason.viado on 4/3/17.
 */

var socket = io.connect('192.168.1.194:5858');
$(document).ready(function(){
    own_room = $('#room').val();

    socket.emit('join room',own_room);

    socket.on('load friends',function(){
        loadFriendsGlobal();
        loadFriendRequestGlobal();
        loadFindFriendsGlobal();
    });

    socket.on('load post',function(){
        loadPostOnce();
    });

    socket.on('load messages',function(data){
        loadFriendMessagesGlobal(data);
    });
    socket.on('load group chat',function(){
        loadGroupChatGlobal();
    });
    socket.on('load group chat receive',function(data,item){
        loadGroupMessageGlobal(data,item);
    });
});

function loadPostOnce(){
    var content = '';
    $.ajax({
        method : 'get',
        url : 'get_home_post',
        success :function(data){
            $.each(data.messages,function(index,item){

                content = content + '<div class="row">'+
                    '<div class="col-sm-3">'+
                    '<div class="well">'+
                    '<p>'+ item.name +'</p>'+
                    '<img src="bird.jpg" class="img-circle" height="55" width="55" alt="Avatar">'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-sm-9">'+
                    '<div class="well">'+
                    '<p>'+ item.user_post +'</p>'+
                    '<span>'+ item.post_date +'</span>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            });
            $('.post').html(content);
        },
        error : function(){
            alert('error');
        }
    });
}

function loadFriendsGlobal(){
    var content = '';
    var content2 = '';
    var count = 0;
    var count2 = 0;
    $.ajax({
        method: 'get',
        url : 'get_friend_list',
        success : function(data){
            $.each(data.messages,function(index,item){
                if(item.status == 1){
                    count++;
                    content = content + '<p><span class="color-red friend-'+item.friend_user_id+'"></span><span class="chat-box" data-name="'+ item.name +'" data-id="'+item.friend_user_id+'">'+ item.name +'</span></p>';
                }else{
                    count2++;
                    content2 = content2 + '<p>'+ item.name +'</p>'
                }
            });
            if(count == 0){
                content = '<p>No Friend</p>';
            }
            if(count2 == 0){
                content2 = '<p>No Friend Request Pending</p>';
            }
            $('.friends-count').text(count);
            $('.list_friends').html('<div class="hide-show-friends">'+content+'</div>');
            $('.hide-show-friends').css('display','none');
            $('.friends-button1').css('display','none');

            $('.pending-count').text(count2);
            $('.list_friends_request').html('<div class="hide-show-friends-pending">'+content2+'</div>');
            $('.hide-show-friends-pending').css('display','none');
            $('.pending-button1').css('display','none');


        },error : function(){
            alert('error');
        }
    });
}

function loadFriendRequestGlobal(){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'get_friend_request',
        success : function(data){
            $.each(data.messages,function(index,item){
                content = content + '<p>'+ item.name +' <button type="button" class="accept_friend_request" value="'+ item.friends_id +'">Accept Friend Request</button></p>'
            });
            $('.list_confirm_friends_request').html(content);
        },error : function(){
            alert('error');
        }
    });
}

function loadFindFriendsGlobal(){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'get_find_friends',
        success : function(data){
            $.each(data.messages,function(index,item){
                content = content + '<p>'+ item.name +'<button type="button" class="add_this_friend" value="'+ item.id +'">+</button></p>';
            });
            $('.list_find_friends').html(content);
        },error : function(){
            alert('error');
        }
    });
}
function loadFriendMessagesGlobal(id){
    var content = '';
    var send_to = '';
    $.ajax({
        method: 'get',
        url : 'getChatMessage',
        data : {
            id : id
        },
        success : function(data){
            $.each(data.messages,function(index,item){
                if(item.user_id == data.current_user){
                    content = content + '<p class="mychat">ME : '+ item.message +'</p>';
                }else{
                    send_to = item.user_id;
                    content = content + '<p>Others : '+ item.message +'</p>';
                }
            });
            $('.friend-'+send_to).text('(NEW)');
            $('.chat-'+id).html(content);
            $(".message-box").animate({ scrollTop: $(".message-box")[0].scrollHeight });
        },error : function(){
            alert('error');
        }
    });
}
function loadGroupChatGlobal(){
    var content = '';
    var count = 0;
    $.ajax({
        method: 'get',
        url : 'get_group_list',
        success : function(data){
            $.each(data.messages ,function(index,item){
                count++;
                content = content + '<p><span class="open_group" data-id="'+ item.id +'" data-name="'+ item.group_name +'">'+ item.group_name +'</span></p>';
            });

            if(count == 0){
                content = '<p>No Group Chat</p>';
            }

            $('.list_group').html('<div class="hide-show-group">'+content+'</div>');
            $('.hide-show-group').css('display','none');
            $('.group-button1').css('display','none');
        },error : function(){
            alert('error');
        }
    });
}
function loadGroupMessageGlobal(id,my_id){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'get_group_message',
        data : {
            id : id
        },
        success : function(data){
            $.each(data.messages ,function(index,item){
                if(item.id == my_id){
                    content = content + '<p class="mychat">ME:'+ item.messages +'</span></p>';
                }else{
                    content = content + '<p><span>'+item.name+' : </span>'+ item.messages +'</span></p>';
                }
            });
            $('.group-'+data.group_id).html(content);
            $(".message-box").animate({ scrollTop: $(".message-box")[0].scrollHeight });
        },error : function(){
            alert('error');
        }
    });
}