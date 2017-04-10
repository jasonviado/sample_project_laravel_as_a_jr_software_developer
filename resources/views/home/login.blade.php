{{ Theme::asset()->add('css-loginReg', 'css/loginReg.css') }}
{{ Theme::asset()->add('js-loginReg', 'js/loginReg.js') }}
<div class="container">
    <!--<form method="post" action="loginUser">
        {{ csrf_field() }}
        <label>email</label><br>
        <input type="text" id="email" name="email"><br>
        <label>password</label><br>
        <input type="password" id="password" name="password"><br>
        <button type="submit">Login!</button>
    </form>-->
   <!-- <a href="{{ URL('/') }}/register">No Account? >> Register</a>-->
    <!--<form class="signUp" id="signUpForm">
        <h3>Create Your Account</h3>
        <p>Just enter your email address</br>
            and your password for join.
        </p>
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        <input type="text" name="name" placeholder="Name" required />
        <input class="w100" type="email" name="email" placeholder="Insert eMail" required autocomplete='off' />
        <input type="password" name="password" placeholder="Insert Password" required />
        <input type="password" name="confirmPassword" placeholder="Verify Password" required />
        <button class="form-btn sx log-in" type="button">Log In</button>
        <button class="btn-register form-btn dx" type="submit">Sign Up</button>
    </form>-->
    <form class="signUp" id="signUpForm" method="post" action="registerAccount">
        {{ csrf_field() }}
        <h3>Create Your Account</h3>
        <p>Just enter your email address</br>
            and your password for join.
        </p>
        <input class="w100" type="text" id="email" name="email" placeholder="Insert eMail" autocomplete='off' />
        <input type="text" id="name" name="name" placeholder="Name"/>
        <input type="password" id="password" name="password" placeholder="Insert Password" required />
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Verify Password" required />
        <button class="form-btn sx log-in" type="button">Log In</button>
        <button class="btn-register form-btn dx" type="submit">Sign Up</button>
    </form>
    <form class="signIn" method="post" action="loginUser">
        {{ csrf_field() }}
        <h3>Welcome</br>Back !</h3>
        <input type="text" placeholder="Insert eMail" name="email" />
        <input type="password" placeholder="Insert Password" name="password"/>
        <button class="form-btn sx back" type="button">Back</button>
        <button id="loginBTN"  class="form-btn dx" type="submit">Log In</button>
    </form>

</div>
