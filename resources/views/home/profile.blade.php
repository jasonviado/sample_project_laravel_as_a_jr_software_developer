{{ Theme::asset()->add('profile-js','js/profile.js') }}
<input type="hidden" id="room" name="room" value="{{ Auth::user()->id }}">
<div class="header">
    <div class="left_nav">
        <ul>
            <li>
                <a href="{{ URL('/') }}/home">Home</a>
            </li>
            <li>
                <a href="{{ URL('/') }}/profile">Profile</a>
            </li>
            <li>
                <a href="{{ URL('/') }}/messages">Messages</a>
            </li>
        </ul>
    </div>
    <div class="right_nav">
        <ul>
            <li>
                <a href="{{ URL('/') }}/settings">Account Settings</a>
            </li>
            <li>
                <a href="{{ URL('/') }}/privacy">Privacy Policy</a>
            </li>
            <li>
                <a href="{{ URL('/') }}/logout">Logout</a>
            </li>
        </ul>
    </div>
</div>
<div>
    <div class="body">
        <div class="body_left">
            <p>Hello {{ Auth::user()->name }}!</p>
        </div>
        <div class="body_center">
            <div class="text_area">
                <form method="post" action="post">
                    {{ csrf_field() }}
                    <input type="hidden" id="user" name="user" value="{{ Auth::user()->id }}">
                    <label>Post:</label><br>
                    <textarea type="text" id="post" name="post"></textarea>
                    <button type="submit">POST</button>
                </form>
            </div>
            <div class="post">
            </div>
        </div>
        <div class="body_right">
        </div>
    </div>
</div>