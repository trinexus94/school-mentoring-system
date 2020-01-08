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

/*$db = mysqli_connect('localhost', 'root', '', 'midterm');*/
$query = "SELECT mentorship, count(*) as number FROM student GROUP BY mentorship";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mentor&Monitor | services</title>
    <link rel="stylesheet" href="./css/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"> </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawGrade);
        google.charts.setOnLoadCallback(drawGrade2);
        function drawChart()
        {
            var data = google.visualization.arrayToDataTable([
                ['mentorship', 'Number'],
                <?php
                    while($row = mysqli_fetch_array($result))
                    {
                        echo "['".$row["mentorship"]."',".$row["number"]."],";
                    }
                ?>
            ]);
            var options = {
                title: "percentage of students registered for mentoring",
                is3D:true
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
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
            <li class="current"><a href="services.php">SERVICES</a></li>
            <li><a href="dataentry.php">DATA ENTRY</a></li>
            <li><a href="meetings.php">MEETINGS</a></li>
            <li><a href="studlist.php">LISTS</a></li>
            <li><a href="login.php">LOGOUT</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="piechart">

    </section>
    <section id="alert">
        <div class="container">
          <h1>compare student records</h1>
        </div>
      </section>
      <section class ="graphs">
        
        <div>
          <h1>student perfomance visualization</h1>
          <form method="post" action="services.php">
           <input type="text" name="course" placeholder="enter course code.."> 
            <select name="sem">
              <option value="spring">Spring</option>
              <option value="summer">Summer</option>
              <option value="fall">Fall</option>
            </select>
            <select name="year">
              <option value="freshman">Freshman</option>
              <option value="sophomore">Sophomore</option>
              <option value="junior">Junior</option>
              <option value="senior">Senior</option>
            </select>
            <button type="submit" name="stud_grades_1">submit</button>
          </form>
        </div>
        <div id = "grade"><h1>grades</h1></div>

        <?php
        if (isset($_POST['stud_grades_1'])) {
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
            
            $query = "SELECT grade, count(*) as number FROM grade WHERE course='$course_name' AND sem='$sem' AND yr='$yr'GROUP BY grade ";
            $result = mysqli_query($db, $query);
        }
        ?>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawGrade2);
                function drawGrade2()
                {
                    var data = google.visualization.arrayToDataTable([
                        ['grade', 'Number'],
                        <?php
                            while($row = mysqli_fetch_array($result))
                            {
                                echo "['".$row["grade"]."',".$row["number"]."],";
                            }
                        ?>
                    ]);
                    var options = {
                        title: "<?php echo $course_name; ?> grade distribution",
                        is3D:true
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('grade'));
                    chart.draw(data, options);
                }
            </script>
              

    </section>

    <section id="alert">
      <div class="container">
        <h1>students ratings of the course work</h1>
      </div>
      
    </section>
    
    
  <section class ="graphs">
      
      <div>
        <h1>student ratings</h1>
        <form method="post" action="services.php">
           <input type="text" name="course" placeholder="enter course code.."> 
            <select name="sem">
              <option value="spring">Spring</option>
              <option value="summer">Summer</option>
              <option value="fall">Fall</option>
            </select>
            <select name="year">
              <option value="freshman">Freshman</option>
              <option value="sophomore">Sophomore</option>
              <option value="junior">Junior</option>
              <option value="senior">Senior</option>
            </select>
            <button type="submit" name="get_rating">submit</button>
          </form>
      </div>
      <div id = "ratings"><h1>grades</h1></div>
      <?php
        if (isset($_POST['get_rating'])) {
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
            
            $query = "SELECT rating, count(*) as number FROM rating WHERE course='$course_name' AND sem='$sem' AND yr='$yr'GROUP BY rating ";
            $result = mysqli_query($db, $query);
        }
        ?>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawGrade2);
                function drawGrade2()
                {
                    var data = google.visualization.arrayToDataTable([
                        ['rating', 'Number'],
                        <?php
                            while($row = mysqli_fetch_array($result))
                            {
                                echo "['".$row["rating"]."',".$row["number"]."],";
                            }
                        ?>
                    ]);
                    var options = {
                        title: "<?php echo $course_name; ?> course ratings",
                        is3D:true
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('ratings'));
                    chart.draw(data, options);
                }
            </script>
              

  </section>
    <footer>
      <p>Mutero Kiberi, Copyright &copy; 2019</p>
    </footer>
    <script src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"></script>
  </body>
</html>
