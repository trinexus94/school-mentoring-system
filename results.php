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
    <title>Mentor&Monitor | Results</title>
    <link rel="stylesheet" href="./css/style.css">
    <style type="text/css">
        table{
            border-collapse: collapse;
            width: 60%;
            color: #d9645;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
            margin: auto;
        }
        th{
            background-color: #C0C0C0;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

    </style>
  </head>
  <body>
    <header>
      <div class="container">
        <div id="branding">
          <h1><span class="highlight">Mentor&Monitor</span> progress review system</h1>
        </div>
        <nav>
          <ul>
            <li ><a href="student.php">HOME</a></li>
            <li class="current"><a href="results.php">RESULTS</a></li>
            <li><a href="attendance.php">ATTENDANCE</a></li>
            <li><a href="leclist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="alert">
      <div class="container">
        <h1>view your grades here</h1>
      </div>
    </section>

    <section  >
        <div class ="graphs">
              
                
                  <form method="post" action="results.php">
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

                    <button type="submit" name="results">submit</button>
                  </form>
                
          </div>
    </section>
    <section id="alert">
            <div class="container">
              <h1>here are your results</h1>
            </div>
    </section>
    <section>
    <h1></h1>
    <?php
            if (isset($_POST['results'])) {
                // receive all input values from the form
                $sem = mysqli_real_escape_string($db, $_POST['sem']);
                $yr = mysqli_real_escape_string($db, $_POST['year']);
                $course = mysqli_real_escape_string($db, $_POST['course']);
              
                // form validation: ensure that the form is correctly filled ...
                // by adding (array_push()) corresponding error unto $errors array
                if (empty($sem)) { array_push($errors, "sem option is required"); }
                if (empty($yr)) { array_push($errors, "year option is required"); }
                if (empty($course)) { array_push($errors, "course code is required"); }
                //connect
                $db = mysqli_connect('localhost', 'root', '', 'midterm');
    
                    //get course name
                $user_check_query10 = "SELECT course_name FROM course WHERE course_code='$course'";
                $results1 = mysqli_query($db, $user_check_query10);
                $users1 = mysqli_fetch_assoc($results1);
                $course_name = $users1['course_name']; 

        $sql = "SELECT coursework, grade from grade where course='$course_name' and sem='$sem' and yr='$yr'";
        $result2 = mysqli_query($db, $sql);  
        if($result2 -> num_rows > 0){
        echo "<table>";
        echo "<tr><th>coursework</th><th>grade</th></tr>";
        while($row = $result2 -> fetch_assoc()){
            echo "<tr><td>" ;
            echo $row["coursework"];
            echo "</td><td>" ;;
            echo $row["grade"];
            echo  "</td></tr>";
        }
        echo"</table>"; 
        }
        else "0 results";
    }
    ?>
    </section>
          
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
