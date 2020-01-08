<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$user_type ="";
$lname="";
$fname="";
$password="";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'midterm');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $user_type = mysqli_real_escape_string($db, $_POST['user_type']);
  $lname = mysqli_real_escape_string($db, $_POST['lname']);
  $fname = mysqli_real_escape_string($db, $_POST['fname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) {array_push($errors, "username required");}
  if (empty($user_type)) { array_push($errors, "User type is required"); }
  if (empty($lname)) { array_push($errors, "Last name is required"); }
  if (empty($fname)) { array_push($errors, "First name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = sha1($password_1);//encrypt the password before saving in the database
    if($user_type===student)
    {
      $query = "INSERT INTO student (lname, fname, email,username) 
          VALUES( '$lname', '$fname' ,'$email','$username')";
          mysqli_query($db, $query);
          $query1 = "INSERT INTO users (user_type, username, password) 
  			  VALUES( '$user_type', '$username', '$password')";
          mysqli_query($db, $query1);
          $_SESSION['lname'] = $lname;
          $_SESSION['fname'] = $fname;
          $_SESSION['success'] = "You are now logged in";
          header('location: student.php');
    }else if($user_type===lecturer)  
    {
      $query = "INSERT INTO lecturer (lname, fname, email , username) 
          VALUES( '$lname', '$fname' ,'$email', '$username')";
          mysqli_query($db, $query);
          $query1 = "INSERT INTO users (user_type, username, password) 
  			  VALUES( '$user_type', '$username', '$password')";
          mysqli_query($db, $query1);
          $_SESSION['lname'] = $lname;
          $_SESSION['fname'] = $fname;
          $_SESSION['success'] = "You are now logged in";
          header('location: dataentry.php');
    }
    //$_SESSION['lname'] = $lname;
    //$_SESSION['fname'] = $fname;
  //	$_SESSION['success'] = "You are now logged in";
  	//header('location: dataentry.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = sha1($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);
		//$logged_in_user = mysqli_fetch_assoc($results);
  	if (mysqli_num_rows($results) == 1) {
				$logged_in_user = mysqli_fetch_assoc($results);	
      if($logged_in_user['user_type']=='lecturer' ){
        $query = "SELECT * FROM lecturer WHERE username='$username'";
        $myresults = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($myresults);
        if($user) {  
        $_SESSION['lname'] = $user['lname'];
        $_SESSION['fname'] = $user['fname'];
  	    $_SESSION['success'] = "You are now logged in as a lec";
      header('location: dataentry.php');
        }
  	}elseif($logged_in_user['user_type']=='student'){
      $query = "SELECT * FROM student WHERE username='$username'";
      $myresults = mysqli_query($db, $query);
      $user = mysqli_fetch_assoc($myresults);
      if($user) {
      $_SESSION['lname'] = $user['lname'];
      $_SESSION['fname'] = $user['fname'];
  	  $_SESSION['success'] = "You are now logged in as a student";
      header('location: student.php');
      }
    }
		}
	}
  	else {
  		array_push($errors, "Wrong username/password combination");
					}
	
	
		}
	
// ADD STUDENT RECORDS
if (isset($_POST['add_grade'])) {
  // receive all input values from the form
  $stud_lname = mysqli_real_escape_string($db, $_POST['lname']);
  $stud_fname = mysqli_real_escape_string($db, $_POST['fname']);
  $sem = mysqli_real_escape_string($db, $_POST['sem']);
  $coursework= mysqli_real_escape_string($db, $_POST['coursework']);
  $yer = mysqli_real_escape_string($db, $_POST['yr']);
  $grade = mysqli_real_escape_string($db, $_POST['grade']);
  $code = mysqli_real_escape_string($db, $_POST['code']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($stud_lname)) { array_push($errors, "student last name is required"); }
  if (empty($stud_fname)) { array_push($errors, "student first name is required"); }
  if (empty($code)) { array_push($errors, "course code is required"); }
  if (empty($sem)) { array_push($errors, "semester is required"); }
  if (empty($yer)) { array_push($errors, "year is required"); }
  if (empty($coursework)) { array_push($errors, "coursework is required"); }
  if (empty($grade)) { array_push($errors, "grade is required"); }

  if (count($errors) == 0) {

    //get lec id
    $lec_lname=$_SESSION['lname'];
    $lec_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT lec_id FROM lecturer WHERE lname='$lec_lname' AND fname='$lec_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $lec_id = $users1['lec_id']; 
    
    //get student id
    $user_check_query10 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
    $results1 = mysqli_query($db, $user_check_query10);
    $users1 = mysqli_fetch_assoc($results1);
    $stud_id = $users1['stud_id']; 

    //get course name
    $user_check_query10 = "SELECT course_name FROM course WHERE course_code='$code'";
    $results1 = mysqli_query($db, $user_check_query10);
    $users1 = mysqli_fetch_assoc($results1);
    $course_name = $users1['course_name']; 

  // first input grades
  	$query = "INSERT INTO grade (sem, yr, course, coursework, grade) 
  			  VALUES( '$sem', '$yer', '$course_name', '$coursework', '$grade')";
    mysqli_query($db, $query);

    $newquery = "SELECT grade_id from grade where sem = '$sem' and yr = '$yer' and course = '$course_name' and coursework = '$coursework' and grade='$grade'";
    $result4 = mysqli_query($db, $newquery);

    $last_user = mysqli_fetch_assoc($result4);
    $last_id = $last_user['grade_id'];
    $query2 = "INSERT INTO stud_grade (stud_id,lec_id,grade_id) VALUES('$stud_id','$lec_id' ,'$last_id')";
    mysqli_query($db, $query2);
  }
    
}

// ... 
// lecturer register for mentoring
if (isset($_POST['lec_reg'])) {
  // receive all input values from the form
  $mentor = mysqli_real_escape_string($db, $_POST['mentor']);
  

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($mentor)) { array_push($errors, "mentoring option is required"); }
  if (count($errors) == 0) {
    //get student id
    $lec_lname=$_SESSION['lname'];
    $lec_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT lec_id FROM lecturer WHERE lname='$lec_lname' AND fname='$lec_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $lec_id = $users1['lec_id'];  
  // enter mentoring option
  	$query = "UPDATE lecturer SET mentorship = '$mentor' WHERE lec_id = '$lec_id'";
    mysqli_query($db, $query);
  }
    
}

// RATE COURSEWORK
if (isset($_POST['rating'])) {
  // receive all input values from the form
  $course = mysqli_real_escape_string($db, $_POST['course']);
  $sem = mysqli_real_escape_string($db, $_POST['sem']);
  $coursework= mysqli_real_escape_string($db, $_POST['coursework']);
  $yer = mysqli_real_escape_string($db, $_POST['year']);
  $rating = mysqli_real_escape_string($db, $_POST['ratings']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($course)) { array_push($errors, "course is required"); }
  if (empty($sem)) { array_push($errors, "semester is required"); }
  if (empty($yer)) { array_push($errors, "year is required"); }
  if (empty($coursework)) { array_push($errors, "coursework is required"); }
  if (empty($rating)) { array_push($errors, "rating is required"); }

  if (count($errors) == 0) {

    //get stud id
    $stud_lname=$_SESSION['lname'];
    $stud_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $stud_id = $users1['stud_id'];  

    //get course name
    $user_check_query10 = "SELECT course_name FROM course WHERE course_code='$course'";
    $results1 = mysqli_query($db, $user_check_query10);
    $users1 = mysqli_fetch_assoc($results1);
    $course_name = $users1['course_name']; 
    

  // first input rating
  	$query = "INSERT INTO rating (course,sem, yr, coursework, rating) 
  			  VALUES( '$course_name', '$sem', '$yer', '$coursework','$rating')";
    mysqli_query($db, $query);

    $newquery = "SELECT rating_id from rating where sem = '$sem' and yr = '$yer' and course = '$course_name' and coursework = '$coursework' and rating='$rating'";
    $result4 = mysqli_query($db, $newquery);

    $last_user = mysqli_fetch_assoc($result4);
    $rating_id = $last_user['rating_id'];
    $query2 = "INSERT INTO stud_rating (stud_id,rating_id) VALUES('$stud_id','$rating_id')";
    mysqli_query($db, $query2);
  }
    
}
//
// schedule meeting
if (isset($_POST['meeting'])) {
  // receive all input values from the form
  $llec = mysqli_real_escape_string($db, $_POST['llec']);
  $flec = mysqli_real_escape_string($db, $_POST['flec']);
  $course= mysqli_real_escape_string($db, $_POST['course']);
  $day = mysqli_real_escape_string($db, $_POST['day']);
  $time = mysqli_real_escape_string($db, $_POST['time']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($course)) { array_push($errors, "course is required"); }
  if (empty($llec)) { array_push($errors, "lecturer last name is required"); }
  if (empty($flec)) { array_push($errors, "lecturer first name is required"); }
  if (empty($day)) { array_push($errors, "day is required"); }
  if (empty($time)) { array_push($errors, "time is required"); }

    //get stud id
    $stud_lname=$_SESSION['lname'];
    $stud_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $stud_id = $users1['stud_id']; 
    
    //get lec id
    $user_check_query10 = "SELECT lec_id FROM lecturer WHERE lname='$llec' AND fname='$flec'";
    $results1 = mysqli_query($db, $user_check_query10);
    $users1 = mysqli_fetch_assoc($results1);
    $lec_id = $users1['lec_id']; 

      // first check the database to make sure 
  // time is not booked
  $user_check_query = "SELECT * FROM meeting WHERE lecturer = '$lec_id' AND datee = '$day'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['timee'] === $time) {
      array_push($errors, "time period is chosen");
    }

  }
  if (count($errors) == 0) {
    
  // first schedule meeting
  	$query = "INSERT INTO meeting (course,datee, timee, lecturer) 
  			  VALUES( '$course', '$day', '$time', '$lec_id')";
    mysqli_query($db, $query);

    $newquery = "SELECT meeting_id from meeting where course = '$course' and datee = '$day' and lecturer = '$lec_id' and timee='$time'";
    $result7 = mysqli_query($db, $newquery);

    $last_users = mysqli_fetch_assoc($result7);
    $meeting_id = $last_users['meeting_id'];
    $query2 = "INSERT INTO stud_meeting (stud_id,lec_id,meeting_id) VALUES('$stud_id','$lec_id','$meeting_id')";
    mysqli_query($db, $query2);
  }
    
}
//
// student Register for mentoring
if (isset($_POST['ment_status'])) {
  // receive all input values from the form
  $mentor = mysqli_real_escape_string($db, $_POST['mentStatus']);
  

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($mentor)) { array_push($errors, "mentoring option is required"); }
  if (count($errors) == 0) {
    //get student id
    $stud_lname=$_SESSION['lname'];
    $stud_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $stud_id = $users1['stud_id'];  
  // enter mentoring option
  	$query = "UPDATE student SET mentorship = '$mentor' WHERE stud_id = '$stud_id'";
    mysqli_query($db, $query);

  } 
}

// comment on attendance
if (isset($_POST['meeting_comments'])) {
  // receive all input values from the form
  $stud_lname = mysqli_real_escape_string($db, $_POST['lname']);
  $stud_fname = mysqli_real_escape_string($db, $_POST['fname']);
  $date = mysqli_real_escape_string($db, $_POST['meeting_date']);
  $comments= mysqli_real_escape_string($db, $_POST['comments']);
  
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($stud_lname)) { array_push($errors, "student last name is required"); }
  if (empty($stud_fname)) { array_push($errors, "student first name is required"); }
  if (empty($date)) { array_push($errors, "meeting date is required"); }
  if (count($errors) == 0) {
    //get lec id
    $lec_lname=$_SESSION['lname'];
    $lec_fname=$_SESSION['fname'];
    $user_check_query1 = "SELECT lec_id FROM lecturer WHERE lname='$lec_lname' AND fname='$lec_fname'";
    $results1 = mysqli_query($db, $user_check_query1);
    $users1 = mysqli_fetch_assoc($results1);
    $lec_id = $users1['lec_id']; 
    
    //get student id
    $user_check_query10 = "SELECT stud_id FROM student WHERE lname='$stud_lname' AND fname='$stud_fname'";
    $results1 = mysqli_query($db, $user_check_query10);
    $users1 = mysqli_fetch_assoc($results1);
    $stud_id = $users1['stud_id']; 

  // first input attendance details
  	$query = "INSERT INTO attendance (att_date, statuss) 
  			  VALUES( '$date', '$comments')";
    mysqli_query($db, $query);

    $newquery = "SELECT att_id from attendance where att_date = '$date' and statuss = '$comments'";
    $result4 = mysqli_query($db, $newquery);

    $last_user = mysqli_fetch_assoc($result4);
    $last_id = $last_user['att_id'];
    $query2 = "INSERT INTO stud_attendance (stud_id,lec_id,att_id) VALUES('$stud_id','$lec_id' ,'$last_id')";
    mysqli_query($db, $query2);
  }
}


?>