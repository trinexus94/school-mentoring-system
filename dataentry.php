<?php 
include('functions.php');
  //session_start(); 

  if (!isset($_SESSION['lname'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (!isset($_SESSION['fname'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mentor&Monitor | dataentry</title>
    <link rel="stylesheet" href="./css/style.css">
    
  </head>
  <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Mentor&Monitor</span> progress review system</h1>
        </div>
        <nav>
          <ul>
            <li ><a href="index.html">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li ><a href="services.php">SERVICES</a></li>
            <li class="current"><a href="dataentry.php">DATA ENTRY</a></li>
            <li><a href="meetings.php">MEETINGS</a></li>
            <li><a href="studlist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="alert">
        <div class="container">
          <h1>enter students grades</h1>
        </div>
      </section>
      
    <section class ="studgrid">
        
        <div class ="graphs">
          <form method="post" action="dataentry.php">
          <?php include('errors.php')?>
            <input type="text" name="lname" placeholder="enter student last name..">
            <input type="text" name="fname" placeholder="enter student first name..">
            <input type="text" name="code" placeholder="enter course code..">
            <select name="sem">
              <option value="spring">Spring</option>
              <option value="summer">Summer</option>
              <option value="fall">Fall</option>
            </select>
            <select name="yr">
              <option value="freshman">Freshman</option>
              <option value="sophomore">Sophomore</option>
              <option value="junior">Junior</option>
              <option value="senior">Senior</option>
            </select>
            
            <select name="coursework">
                <option value="lab">lab work</option>
                <option value="project">course project</option>
                <option value="midsem">mid semester exam</option>
                <option value="endsem">end semester exam</option>                    
            </select>
            <select name="grade">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>  
                <option value="F">F</option>                  
            </select>
            <button type="submit" name="add_grade">submit</button>
          </form>
        </div>
    </section>
    <section id="alert">
      <div class="container">
        <h1>register to be a mentor</h1>
      </div>
    </section>
    <section >
      <div class="container">
        <form method="post" action="dataentry.php">
        <?php include('errors.php')?>
        <p>would you like to be a mentor?</p>
        <input type="radio" name="mentor" value="yes">yes<br>
        <input type="radio" name="mentor" value="no">no<br>
        <button type="submit" name="lec_reg">register</button>
      </form>
      </div>
    </section>
    <section id="alert">
        <div class="container">
          <h1>student mentoring attendance </h1>
        </div>
      </section>
      
    <section class ="studgrid">
        
        <div class ="graphs">
          <form method="post" action="dataentry.php">
          <?php include('errors.php')?>
            <input type="text" name="lname" placeholder="enter student last name..">
            <input type="text" name="fname" placeholder="enter student first name..">
            <input type="date" name="meeting_date" placeholder="enter date..">
            <input type="textbox" name="comments" placeholder="comment on meeting..">
            <button type="submit" name="meeting_comments">submit</button>
          </form>
        </div>
    </section>
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
    <script src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"></script>
  </body>
</html>
