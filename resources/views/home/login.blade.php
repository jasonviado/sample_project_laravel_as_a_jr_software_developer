<div>
    <form method="post" action="loginUser">
        {{ csrf_field() }}
        <label>email</label><br>
        <input type="text" id="email" name="email"><br>
        <label>password</label><br>
        <input type="password" id="password" name="password"><br>
        <button type="submit">Login!</button>
    </form>
    <a href="{{ URL('/') }}/register">No Account? >> Register</a>
</div>
