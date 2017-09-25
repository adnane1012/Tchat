

<div class="container">
    <div class="card card-container">

        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"/>
        <?php if (isset($failed) && $failed ):  ?>
            <div class="alert alert-danger" role="alert">
                <span class="sr-only">Error:</span>
                Authentification Failed
            </div>
        <?php endif ?>
        <p id="profile-name" class="profile-name-card"></p>

        <form class="form-signin" method="post">
            <span id="reauth-email" class="reauth-email"></span>
            <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>

            <div id="remember" class="checkbox">
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form>
        <!-- /form -->
    </div>
    <!-- /card-container -->
</div>