{{ Theme::asset()->add('home-js','js/home.js') }}
{{ Theme::asset()->add('global-js','js/global.js') }}
<input type="hidden" id="room" name="room" value="{{ Auth::user()->id }}">
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ URL('/home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ URL('/profile') }}">Profile</a>
                </li>
                <li>
                    <a href="{{ URL('/messages') }}">Messages</a>
                </li>
            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group input-group">
                    <input type="text" class="form-control" placeholder="Search..">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp{{ Auth::user()->name }}</a></li>
            </ul>
        </div>
    </div>
</nav>

<div style="padding-bottom: 25px;padding-top: 80px;">
    <div class="modal" id="create-group-modal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body col-md-12">
                        <form id="create-group-chat" method="post" action="addGroup" class="col-md-12">
                            {{ csrf_field() }}
                            <input type="text" id="group_name" name="group_name">
                            <div class="friend_list">

                            </div>
                            <button id="create-group-btn" type="button">Create</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="view-group-modal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="pointer_cursor">
                        <span class="viewGroupMember">
                            View
                        </span>
                        |
                        <span class="viewAddGroupMember">
                            Add
                        </span>
                    </div>
                    <div class="viewGroupMembers">
                        <div class="groupMemberlist">
                        </div>
                    </div>
                    <div class="addGroupMembers">
                        <div class="groupMemberAddlist">
                        </div>
                    </div>
                    <div class="modal-header">
                    </div>
                    <div id="removethisClass">

                    </div>
                    <form id="send-group-chat" method="post" action="sendToGroup" class="col-md-12">
                        {{ csrf_field() }}
                        <input type="hidden" id="send-to-group" name="send-to-group" value="">
                        <textarea id="group_message" name="group_message" class="col-md-12">

                        </textarea>
                        <button id="sends-group-message" type="button">Send</button>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center">
        <div class="row">
            <div class="col-sm-3 well">
                <div class="well">
                    <p>Hello {{ Auth::user()->name }}!</p>
                    <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                </div>
<!--                <div class="well">-->
<!--                    <p><a href="#">Interests</a></p>-->
<!--                    <p>-->
<!--                        <span class="label label-default">News</span>-->
<!--                        <span class="label label-primary">W3Schools</span>-->
<!--                        <span class="label label-success">Labels</span>-->
<!--                        <span class="label label-info">Football</span>-->
<!--                        <span class="label label-warning">Gaming</span>-->
<!--                        <span class="label label-danger">Friends</span>-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div class="alert alert-success fade in">-->
<!--                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>-->
<!--                    <p><strong>Ey!</strong></p>-->
<!--                    People are looking at your profile. Find out who.-->
<!--                </div>-->
<!--                <p><a href="#">Link</a></p>-->
<!--                <p><a href="#">Link</a></p>-->
<!--                <p><a href="#">Link</a></p>-->
                <hr>
                <div>
                    <span class="pending-button">Pending Friend Requests</span>(<span class="pending-count"></span>)
                </div>
                <div class="list_friends_request">

                </div>
                <hr>
                <div>
                    Confirm Friend Requests
                </div>
                <div class="list_confirm_friends_request">

                </div>
                <hr>
                <div>
                    Find Friends
                </div>
                <div class="list_find_friends">

                </div>
                <hr>
            </div>
            <div class="col-sm-7">
                    <div class="panel-body">
                        <form id="send_post" method="post">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                            <input type="hidden" id="user" name="user" value="{{ Auth::user()->id }}">
                            <label>Post:</label><br>
                            <textarea class="col-md-12" type="text" id="post" name="post">

                            </textarea>
                        </form>
                        <button id="submitPost" type="button">POST</button>
                </div>
                <div class="post">

                </div>
            </div>


            <div class="col-sm-2 well">
                <div class="thumbnail">
                    <p>Upcoming Events:</p>
                    <img src="paris.jpg" alt="Paris" width="400" height="300">
                    <p><strong>Paris</strong></p>
                    <p>Fri. 27 November 2015</p>
                    <button class="btn btn-primary">Info</button>
                </div>
                <div class="well">
                    <p>ADS</p>
                </div>
                <div class="well">
                    <p>ADS</p>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer navbar-fixed-bottom">
    <div class="all_my_friends">
        <span class="friend-list">Friends</span>(<span class="friends-count"></span>)
        <div class="list_friends" style="display: none;">
        </div>
    </div>
</footer>