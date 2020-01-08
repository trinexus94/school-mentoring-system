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
    <title>Mentor&Monitor | Welcome</title>
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
            <li class="current"><a href="student.php">HOME</a></li>
            <li><a href="results.php">RESULTS</a></li>
            <li><a href="attendance.php">ATTENDANCE</a></li>
            <li><a href="leclist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="showcase">
      <div class="container">
        <h1>student mentoring system</h1>
        <p>Here the teacher can mentor and monitor the students perfomance and progress at the click of a button</p>
      </div>
    </section>

    <section id="alert">
      <div class="container">
        <h1>rate your coursework for the semester</h1>
      </div>
    </section>

    <section class ="studgrid" >
        <div class ="graphs">
              
                
                  <form method="post" action="student.php">
                  <?php include('errors.php')?>
                    <input type="text" name="course" placeholder="enter course code..">
          
                    <select name="year">
                      <option value="freshman">Freshman</option>
                      <option value="sophomore">Sophomore</option>
                      <option value="junior">Junior</option>
                      <option value="senior">Senior</option>
                    </select>
          
                    <select name="sem">
                      <option value="spring">Spring</option>
                      <option value="summer">Summer</option>
                      <option value="fall">Fall</option>
                    </select>
          
                    <select name="coursework">
                      <option value="lab">lab work</option>
                      <option value="project">course project</option>
                      <option value="midsem">mid semester exam</option>
                      <option value="endsem">end semester exam</option>
                      
                    </select>
          
                    <select name="ratings">
                      <option value="1">1 star</option>
                      <option value="2">2 star</option>
                      <option value="3">3 star</option>
                      <option value="4">4 star</option>
                      <option value="5">5 star</option>
                    </select>
                    <button type="submit" name="rating">submit</button>
                  </form>
                
          </div>

    </section>
    <section id="alert">
        <div class="container">
          <h1>schedule a meeting with the lecturer</h1>
        </div>
      </section>
    <section class ="studgrid" >
        <div class ="graphs">
              
             
                  <form method="post" action="student.php">
                  <?php include('errors.php')?>
                    <input type="text" name="course" placeholder="select course..">
                    <input type="text" name="flec" placeholder="enter lecturer first name..">
                    <input type="text" name="llec" placeholder="enter lecturer last name..">
                    <select name="day">
                      <option value="monday">monday</option>
                      <option value="tuesday">tuesday</option>
                      <option value="wednesday">wednesday</option>
                      <option value="thursday">thursday</option>
                      <option value="friday">friday</option>
                    </select>

                    <select name="time">
                      <option value="8-9">8-9</option>
                      <option value="9-11">9-11</option>
                      <option value="12-1">12-1</option>
                      <option value="2-4">2-4</option>
                      <option value="4-5">4-5</option>
                    </select>
                    <button type="submit" name="meeting">submit</button>
                  </form>
                
          </div>

    </section>
    <section id="alert">
      <div class="container">
        <h1>register for mentoring session</h1>
      </div>
    </section>
  <section class ="studgrid" >
      <div >
        <p>would you like to register for mentoring?</p>
        <form method="post" action="student.php">
        <?php include('errors.php')?>
        <input type="radio" name="mentStatus" value="yes">yes<br>
        <input type="radio" name="mentStatus" value="no">no<br>
        <button type="submit" name="ment_status">register</button>
      </form>    
        </div>

  </section>
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
