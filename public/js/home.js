/**
 * Created by jason.viado on 4/3/17.
 */
$(document).ready(function(){
    var option = {
        beforeSubmit: function(){

        },
        success:function(data){
            if(data.status == 'success'){
                $('#create-group-modal').modal('hide');
                $.each(data.data_user,function(index,item){
                    socket.emit('load group',item);
                });
                socket.emit('load group',data.thisme);
            }else{
                alert('error');
            }
        },
        complete:function(){

        },
        error:function(){

        }
    }
    //Load Post
    loadPost();
    loadFriends();
    loadFriendRequest();
    loadFindFriends();
    loadGroupChat();
    // loadNotFriends();
    // Submit Post
    $('#submitPost').on('click',function(){
        submitPost();
    })
    $('.load_more').on('click',function(){
        loadPost();
    });
    $(document).delegate('.create_group','click',function(){
       $('#create-group-modal').modal('show');
        showFriendList();
    });
    $(document).delegate('.accept_friend_request','click',function(){
       acceptFriend($(this).val());
    });
    $(document).delegate('.add_this_friend','click',function(){
        addFriend($(this).val());
    });
    $(document).delegate('.chat-box','click',function(){
        var numItems = $('.chat-footer').length;
        if (document.getElementById('chat'+$(this).data('id'))) {
            $(".this-chat-"+$(this).data('id')).css('display','block');
        } else {
            $('.footer').append('<div id="chat'+$(this).data('id')+'" class="chat-footer"><span class="chat-click" data-id="'+ $(this).data('id') +'">'+ $(this).data('name') +'</span><button type="button" class="close" aria-label="Close" data-id="'+ $(this).data('id') +'"><span aria-hidden="true">&times;</span></button><div class="chat-container this-chat-'+$(this).data('id')+'">'+
                '<div><span class="chat-click" data-id="'+ $(this).data('id') +'">'+ $(this).data('name') +'</span><button type="button" class="close" aria-label="Close" data-id="'+ $(this).data('id') +'"><span aria-hidden="true">×</span></button></div>'+
                '<div class="chat-messages"><p>test</p></div>' +
                '<form id="send-message"><input type="hidden" id="send_to_user" name="send_to_user" value="'+ $(this).data('id') +'"></form><input id="message" name="message"><button id="sends" type="button" data-id="'+ $(this).data('id') +'">Send</button></div></div>');
            loadFriendMessages($(this).data('id'),$(this).data('name'));
            $('#send_to_user').val($(this).data('id'));
        }
    });

    $("#message").on('keyup', function (e) {
        if (e.keyCode == 13) {
            // Do something
        }
    });



    $(document).delegate('.chat-click','click',function(){
        if($('.this-chat-'+$(this).data('id')).css('display') == 'none')
        {
            $(".this-chat-"+$(this).data('id')).css('display','block');
        }else{
            $(".this-chat-"+$(this).data('id')).css('display','none');
        }
    });

    $(document).delegate('.close','click',function(){
        $('#chat'+$(this).data('id')).remove();
    });


    $(document).delegate('#sends','click',function(){
       sendMessage($('#chat'+$(this).data('id')).find('#message').val(),$(this).data('id'),$('#room').val());
    });
    $('#create-group-chat').ajaxForm(option);
    $('#create-group-btn').click(function(){
        $('#create-group-chat').submit();
    })
    $('#sends-group-message').click(function(){
        sendGroupMessage($('#send-to-group').val(),$('[name="_token"]').val(),$('#group_message').val());
    });

    $(document).delegate('.open_group','click',function(){

        $('#view-group-modal').modal('show');
        $('#send-to-group').val($(this).data('id'));
        $('#removethisClass').removeClass();
        $('#view-group-modal #removethisClass').addClass('message-box col-md-12 group-'+$(this).data('id'));
        loadGroupMessage($(this).data('id'),$('#room').val());
        $('#view-group-modal .modal-header').html($(this).data('name'));

    });

    $('.close-chat-modal').on('click',function(){
        $('.friend-'+$('#send_to_user').val()).text('');
        $('.friend-'+$('#send_to_user').val()).css('display','inline-block');
    });


    var groupOpen = 0;
    var groupAddOpen = 0;
    $('.viewGroupMember').on('click',function(){
        $('.addGroupMembers').css('display','none');
        if(groupOpen == 0){
            groupAddOpen = 0;
            loadViewMembers($('#send-to-group').val());
            $('.viewGroupMembers').css('display','block');
            groupOpen = 1;
        }else{
            $('.viewGroupMembers').css('display','none');
            groupOpen = 0;
        }
    });
    $('.viewAddGroupMember').on('click',function(){
        $('.viewGroupMembers').css('display','none');
        groupOpen = 0;
        if(groupAddOpen == 0){
            loadAddViewMembers($('#send-to-group').val());

            $('.addGroupMembers').css('display','block');
            groupAddOpen = 1;
        }else{
            $('.addGroupMembers').css('display','none');
            groupAddOpen = 0;
        }
    });



    $('.friend-list').on('click',function(){
        if($('.list_friends').css('display') == 'none')
        {
            $(".list_friends").css('display','block');
        }else{
            $(".list_friends").css('display','none');
        }
    });


    $('.pending-button').on('click',function(){

        if($('.list_friends_request').css('display') == 'none')
        {
            $(".list_friends_request").css('display','block');
        }else{
            $(".list_friends_request").css('display','none');
        }
    });

    $('.group-button').on('click',function(){
        $('.group-button1').css('display','inline-block');
        $('.group-button').css('display','none');
        $('.hide-show-group').css('display','inline-block');
    });
    $('.group-button1').on('click',function(){
        $('.group-button1').css('display','none');
        $('.group-button').css('display','inline-block');
        $('.hide-show-group').css('display','none');
    });

});




function loadPost(){
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
function submitPost(){
    $.ajax({
        method : 'post',
        url : 'home_post',
        data: {
            post : $('#post').val(),
            _token : $('#_token').val(),
            user : $('#user').val()
        },
        success :function(data){
            loadPost();
            $.each(data.friends,function(index,item){
                socket.emit('load the post',item.friend_user_id);
            });
        },
        error : function(){
            alert('error');
        }
    });
}
function loadFriends(){
    var content = '<p>Friends --- Friends</p>';
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
            $('.list_friends').html(content);

            $('.pending-count').text(count2);
            $('.list_friends_request').html(content2);
            $('.list_friends_request').css('display','none');

        },error : function(){
            alert('error');
        }
    });
}

function loadFriendRequest(){
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
function loadFindFriends(){
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
function acceptFriend(id){
    $.ajax({
        method: 'get',
        url : 'accept_friend_request',
        data : {
          id : id
        },
        success : function(data){
            socket.emit('load find friends',data.user);
            socket.emit('load find friends',data.user_2);
            socket.emit('load the post',data.user);
            socket.emit('load the post',data.user_2);
        },error : function(){
            alert('error');
        }
    });
}
function addFriend(id){
    $.ajax({
        method: 'get',
        url : 'addFriend',
        data : {
            id : id
        },
        success : function(data){
            socket.emit('load find friends',data.user);
            socket.emit('load find friends',data.user_2);
            socket.emit('load the post',data.user);
            socket.emit('load the post',data.user_2);
        },error : function(){
            alert('error');
        }
    });
}
function loadFriendMessages(id){
    var content = '';
    var count = 0;
    $.ajax({
        method: 'get',
        url : 'getChatMessage',
        data : {
            id : id
        },
        success : function(data){
            $.each(data.messages,function(index,item){
                count++;
                if(item.user_id == data.current_user){
                    content = content + '<p class="mychat">'+ item.message +'</p>';
                }else{
                    content = content + '<p>'+ item.message +'</p>';
                }
            });
            if(count == 0){
                $('#chat'+id+' .chat-messages').html('No Messages');
            }else{
                $('#chat'+id+' .chat-messages').html(content);
            }

            $("#chat"+id+" .chat-messages").animate({ scrollTop: $("#chat"+id+" .chat-messages")[0].scrollHeight },0);
        },error : function(){
            alert('error');
        }
    });
}
function sendMessage(message,id,my_id){
    $.ajax({
        method: 'get',
        url : 'sendMessage',
        data : {
            message : message,
            id : id
        },
        success : function(data){
            socket.emit('load friend message',id,my_id);
            loadFriendMessages(id);
        },error : function(){
            alert('error');
        }
    });
}
function showFriendList(){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'get_friend_list',
        success : function(data){
            $.each(data.messages,function(index,item){
                if(item.status == 1){
                    content = content + '<p><input type="checkbox" id="choices[]" name="choices[]" value="'+item.friend_user_id+'"><span>'+ item.name +'</span></p>';
                }
            });
            $(".this_choice").prop('checked', false);

            $('.friend_list').html(content);
        },error : function(){
            alert('error');
        }
    });
}
function loadGroupChat(){
    var content = '<p>Groups -- Groups<span class="create_group">Create</span></p>';
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
            $('.list_friends').append(content);
        },error : function(){
            alert('error');
        }
    });
}
function loadGroupMessage(id,my_id){
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
function sendGroupMessage(group,token,group_message){
    var content = '';
    $.ajax({
        method: 'post',
        url : 'send_group_message',
        data : {
            _token : token,
            id : group,
            group : group_message
        },
        success : function(data){
            $.each(data.members,function(index,item){
                socket.emit('load group message',item,data.group);
            });
        },error : function(){
            alert('error');
        }
    });
}
function loadViewMembers(id){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'view_group_members',
        data : {
            id : id
        },
        success : function(data){
            $.each(data.members,function(index,item){
                content = content + '<p>'+ item.name +'</p>';
            });
            $('.groupMemberlist').html(content);
        },error : function(){
            alert('error');
        }
    });
}
function loadAddViewMembers(id){
    var content = '';
    $.ajax({
        method: 'get',
        url : 'view_not_group_member_list',
        data : {
            id : id
        },
        success : function(data){
            $.each(data.not_members,function(index,item){
                content = content + '<p><input type="checkbox" id="addchoices[]" name="addchoices[]" value="'+item.id+'"><span>'+ item.name +'</span></p>';
            });
            $('.groupMemberAddlist').html(content);
        },error : function(){
            alert('error');
        }
    });
}