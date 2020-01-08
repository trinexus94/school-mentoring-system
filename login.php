<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mentor&Monitor | login</title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Mentor&Monitor</span> login </h1>
        </div>
      </div>
    </header>

    <section class ="login">
        
        <div>
            <div><h1>login</h1></div>
          <form class="form" method="post" action="login.php">
              <?php include('errors.php')?>
              <div class=input>
                <label>username</label>
            <input type="text" name="username" placeholder="enter your preferred username">
          </div>
            <br>
            <div class=input>
              <label>password</label>
            <input type="password" name="password" placeholder="enter a password">
          </div>
            <br>
            <button type="submit" name="login_user">submit</button>
          </form>
          <p>not yet registered?<a href="register.php"> register here</a></p>
        </div>
    </section>

    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
