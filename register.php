<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mentor&Monitor | lregister</title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Mentor&Monitor</span> register </h1>
        </div>
      </div>
    </header>

    <section class ="login">
        
        <div>
          <form class="form" method="post" action="register.php">
          <?php include('errors.php'); ?>
            <div class=input>
                <label>username</label>
            <input type="text" name="username" placeholder="enter your preferred username"></div><br>
            <div class=input>
                <label>last name</label>
            <input type="text" name="lname"  placeholder="enter your last name"></div><br>
            <div class=input>
                <label>first name</label>
            <input type="text" name="fname"  placeholder="enter your first name"></div><br>
            <div class=input>
                <label>email</label>
            <input type="email" name="email"  placeholder="enter your email"></div><br>
            <div class=input>
                <label>user type</label>
            <select name="user_type" >
              <option value="lecturer">lecturer</option>
              <option value="student">student</option>
            </select>
          </div>
            <br>
          
            <div class=input>
              <label></label>
            <input type="password" name="password_1" label="password" placeholder="enter a password"></div><br>
          
            <div class=input>
                <label>confirm password</label>
            <input type="password" name="password_2"  placeholder="confirm password">
          </div>
            <br>
            <button type="submit" name="reg_user">submit</button>
          </form>
          <p>already registered?<a href="login.php"> login here</a></p>
        </div>
    </section>

    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
