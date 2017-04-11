{{ Theme::asset()->add('css-loginReg', 'css/loginReg.css') }}
{{ Theme::asset()->add('js-loginReg', 'js/loginReg.js') }}
<div class="container">
    <form class="loginForm signUp">
        <h3>Welcome</br>Back !</h3>
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <input type="text" placeholder="Insert eMail" id="email" name="email" />
        <span class="error-message error-email"></span>
        <input type="password" placeholder="Insert Password" id="password" name="password"/>
        <span class="error-message error-password"></span>
        <button class="form-btn sx back" type="button">Sign Up</button>
        <button id="loginBTN"  class="form-btn dx" type="submit">Log In</button>
    </form>
    <form class="signIn registerForm" id="signUpForm" method="post">
        <h3>Create Your Account</h3>
        <p>Just enter your email address</br>
            and your password for join.
        </p>
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <input class="w100" type="text" id="email2" name="email2" placeholder="Insert eMail" autocomplete='off' />
        <span class="error-message error-email2"></span>
        <input type="text" id="name" name="name" placeholder="Name"/>
        <span class="error-message error-name"></span>
        <input type="password" id="password2" name="password2" placeholder="Insert Password" />
        <span class="error-message error-password2"></span>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Verify Password" /><br>
        <span class="error-message error-confirm_password"></span>
        <button class="form-btn sx log-in" type="button">Back</button>
        <button class="btn-register form-btn dx" type="submit">Sign Up</button>
    </form>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closeModal" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Firstbook Registration</h4>
                </div>
                <div class="modal-body">
                    <p>Successful Register!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
