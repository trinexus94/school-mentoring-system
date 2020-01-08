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
    <title>Mentor&Monitor | attendance</title>
    <link rel="stylesheet" href="./css/style.css">

    <style type="text/css">
        table{
            border-collapse: collapse;
            width: 80%;
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
            <li ><a href="index.html">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="services.php">SERVICES</a></li>
            <li><a href="dataentry.php">DATA ENTRY</a></li>
            <li><a href="meetings.php">MEETINGS</a></li>
            <li class="current"><a href="studlist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="alert">
      <div class="container">
        <h1>view other information here</h1>
      </div>
    </section>

    <section  >
        <div >
              
                <h1 style = "text-align:center">what would you like to view?</h1>
                  <form method="post" action="studlist.php">
                  <div style = "text-align:center">
                  <select name="option">
                                <option value="student">student list</option>
                                <option value="course">Available courses</option>
                              </select>
                              </div>
                    <div style = "text-align:center">
                    <br>
                    <button type="submit" name="options">submit</button>
                    </div>
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
            if (isset($_POST['options'])) {
                // receive all input values from the form
                $db = mysqli_connect('localhost', 'root', '', 'midterm');
                $option = mysqli_real_escape_string($db, $_POST['option']);
                if (empty($option)) { array_push($errors, "select an option"); }
                if($option ==='student'){
                    $user_check_query1 = "SELECT lname, fname FROM student";
                    $results1 = mysqli_query($db, $user_check_query1);
                    if($results1 -> num_rows > 0){
                        echo "<table>";
                        echo "<tr><th>first name</th><th>last name</th></tr>";
                        while($row = $results1 -> fetch_assoc()){
                            echo "<tr><td>" ;
                            echo $row["fname"];
                            echo "</td><td>" ;;
                            echo $row["lname"];
                            echo  "</td></tr>";
                        }
                        echo"</table>"; 
                        }
                        else "0 results";
                }else if($option ==='course'){
                    $user_check_query1 = "SELECT course_code, course_name FROM course ";
                    $results1 = mysqli_query($db, $user_check_query1);
                    if($results1 -> num_rows > 0){
                        echo "<table>";
                        echo "<tr><th>course code</th><th>course name</th></tr>";
                        while($row = $results1 -> fetch_assoc()){
                            echo "<tr><td>" ;
                            echo $row["course_code"];
                            echo "</td><td>" ;;
                            echo $row["course_name"];
                            echo  "</td></tr>";
                            }
                        echo"</table>"; 
                    }
                    else "0 results";
                }else 
                    {echo "no option selected";}

            }

               

    ?>
    </section>
          
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
