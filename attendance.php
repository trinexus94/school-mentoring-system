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
          <li ><a href="student.php">HOME</a></li>
            <li><a href="results.php">RESULTS</a></li>
            <li class="current"><a href="attendance.php">ATTENDANCE</a></li>
            <li><a href="leclist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="alert">
      <div class="container">
        <h1>view your meetings here</h1>
      </div>
    </section>

    <section  >
        <div >
              
                <h1 style = "text-align:center">see what you lecturer said about your meeting</h1>
                  <form method="post" action="attendance.php">
                    <div style = "text-align:center">
                    <button type="submit" name="day">submit</button>
                    </div>
                  </form>
                
          </div>
    </section>
    <section id="alert">
            <div class="container">
              <h1>here are your attendance notes</h1>
            </div>
    </section>
    <section>
        <h1></h1>
    <?php
            if (isset($_POST['day'])) {
                // receive all input values from the form
                $db = mysqli_connect('localhost', 'root', '', 'midterm');

                                //get stud id
                $stud_lname=$_SESSION['lname'];
                $stud_fname=$_SESSION['fname'];
                $user_check_query1 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
                $results1 = mysqli_query($db, $user_check_query1);
                $users1 = mysqli_fetch_assoc($results1);
                $lec_id = $users1['stud_id']; 



                $sql = "SELECT lname,fname,att_date,statuss FROM lecturer JOIN stud_attendance USING (lec_id) JOIN attendance USING (att_id) WHERE stud_id='$lec_id' ";
                $result2 = mysqli_query($db, $sql);
                if($result2 -> num_rows > 0){
                  echo "<table>";
                  echo "<tr><th>lecturer</th><th>   </th><th>date</th><th>key notes</th></tr>";
                  while($row = $result2 -> fetch_assoc()){
                      echo "<tr><td>" ;
                      echo $row["lname"];
                      echo "</td><td>" ;;
                      echo $row["fname"];
                      echo  "</td><td>" ;;
                      echo $row["att_date"];
                      echo  "</td><td>" ;;
                      echo $row["statuss"];
                      echo  "</td></tr>";
                  }
                  echo"</table>"; 
                  }
                  else 
                  {echo "0 results";}

               /*
               
                $sql = "SELECT timee from meeting where datee='$day' and lecturer='$lec_id'";
                $result2 = mysqli_query($db, $sql); 
                //$user = mysqli_fetch_assoc($result2);
                //$time = $user['timee']; 
                if($result2 -> num_rows > 0){
                  while($row = $result2 -> fetch_assoc()){
                    echo $row["time"];
                    }
                  }

                                //get meeting id
                $user_check_query10 = "SELECT meeting_id FROM meeting WHERE datee='$day' and lecturer='$lec_id'";
                $results1 = mysqli_query($db, $user_check_query10);
                $users1 = mysqli_fetch_assoc($results1);
                $meeting_id = $users1['meeting_id']; 

                $sql2 = "SELECT stud_id from stud_meeting where meeting_id = '$meeting_id'";
                $result3 = mysqli_query($db, $sql2); 
                $users = mysqli_fetch_assoc($result3);
                $student_id = $users['stud_id'];

                $sql3 = "SELECT lname, fname from student where stud_id = '$student_id'";
                $result4 = mysqli_query($db, $sql3); 
                $users2 = mysqli_fetch_assoc($result4);
                $student_lname = $users2['lname'];
                $student_fname = $users2['fname'];

                //echo $student_fname;
                echo "<table>";
                //echo "<tr><th>last name</th><th>first name</th><th>meeting time</th></tr>";           
                echo "<tr><td>" ;
                echo $student_fname;
                echo "</td><td>" ;;
                echo $student_lname;
                echo "</td><td>" ;;
                //echo $time;
                echo  "</td></tr>";            
                echo"</table>"; */

    }
    ?>
    </section>
          
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
