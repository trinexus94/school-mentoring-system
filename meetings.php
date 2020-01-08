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
    <title>Mentor&Monitor | meeting</title>
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
            <li ><a href="index.html">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="services.php">SERVICES</a></li>
            <li><a href="dataentry.php">DATA ENTRY</a></li>
            <li class="current"><a href="meetings.php">MEETINGS</a></li>
            <li><a href="studlist.php">LISTS</a></li>
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
        <div class ="graphs">
              
                
                  <form method="post" action="meetings.php">
                  <?php include('errors.php')?>
                  <select name="daya">
                      <option value="monday">monday</option>
                      <option value="tuesday">tuesday</option>
                      <option value="wednesday">wednesday</option>
                      <option value="thursday">thursday</option>
                      <option value="friday">friday</option>
                    </select>

                    <button type="submit" name="day">submit</button>
                  </form>
                
          </div>
    </section>
    <section id="alert">
            <div class="container">
              <h1>here are your scheduled meetings</h1>
            </div>
    </section>
    <section>
    <h1></h1>
    <?php
            if (isset($_POST['day'])) {
                // receive all input values from the form
                $db = mysqli_connect('localhost', 'root', '', 'midterm');
                $data = mysqli_real_escape_string($db, $_POST['daya']);
              
                // form validation: ensure that the form is correctly filled ...
                // by adding (array_push()) corresponding error unto $errors array
                if (empty($data)) { array_push($errors, "day is required"); }


                                //get lec id
                $lec_lname=$_SESSION['lname'];
                $lec_fname=$_SESSION['fname'];
                $user_check_query1 = "SELECT lec_id FROM lecturer WHERE lname='$lec_lname' AND fname='$lec_fname'";
                $results1 = mysqli_query($db, $user_check_query1);
                $users1 = mysqli_fetch_assoc($results1);
                $lec_id = $users1['lec_id']; 



                $sql1 = "SELECT lname,fname,timee FROM student JOIN stud_meeting USING (stud_id) JOIN meeting USING (meeting_id) WHERE lecturer='$lec_id' AND datee='$data' ";
                $result2 = mysqli_query($db, $sql1);
                if($result2 -> num_rows > 0){
                  echo "<table>";
                  echo "<tr><th>last name</th><th>first name</th><th>time</th></tr>";
                  while($row = $result2 -> fetch_assoc()){
                      echo "<tr><td>" ;
                      echo $row["lname"];
                      echo "</td><td>" ;;
                      echo $row["fname"];
                      echo  "</td><td>" ;;
                      echo $row["timee"];
                      echo  "</td></tr>";
                  }
                  echo"</table>"; 
                  }
                  else 
                  {echo "0 results";}

    }
    ?>
    </section>
          
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
  </body>
</html>
