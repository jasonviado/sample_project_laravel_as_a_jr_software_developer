<div>
    <form method="post" action="registerAccount">
        {{ csrf_field() }}
        <label>email</label><br>
        <input type="text" id="email" name="email"><br>
        <label>name</label><br>
        <input type="text" id="name" name="name"><br>
        <label>password</label><br>
        <input type="password" id="password" name="password"><br>
        <label>confirm password</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br>
        <button type="submit">Register!</button>
    </form>
    <a href="{{ URL('/') }}/login">Have Account? >> Login</a>
</div>