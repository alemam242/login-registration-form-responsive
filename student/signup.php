<?php
include '../db_connection/connection.php';
?>

<!DOCTYPE html>
<html lang='en' data-bs-theme='light'> <!-- Set Dark Mode -->

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <!-- These meta tags are for Google -->
    <meta name='description' content='Website Description'>
    <meta name='keywords' content=''>
    <meta name='author' content='Al Emam'>

    <!-- These meta tags are for Facebook -->
    <meta property='og:site_name' content=''>
    <meta property='og:url' content='#'>
    <meta property='og:description' content='Website Description'>
    <meta property='og:title' content='Practice 1'>
    <meta property='og:image' content='#'>

    <!-- These tags are for cache control -->
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='cache-control' content='max-age=0'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='expires' content='Tue, 01 Jan 2023 12:00:00 GMT'>
    <meta http-equiv='pragma' content='no-cache'>

    <title>Student | Registration</title>

    <!-- Link your CSS -->
    <link rel='stylesheet' href=''>

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9' crossorigin='anonymous'>

    <style>
        body {
            background: linear-gradient(to right, #f06d06, #f0a302);
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .error {
            color: red;
        }
    </style>

</head>

<body>

    <!-- Control Form -->
    <?php
    // Store input
    $student_id = $class = $class_roll = $first_name = $last_name = "";
    $mobile_number = $email = $dob = $brn = $gender = "";
    $father_name = $father_occup = $mother_name = $mother_occup = "";
    $pre_address = $per_address = "";
    $password = $image = "";

    // Store errorMessage
    $firstNameErr = $lastNameErr = $emailErr = $genderErr = $passwordErr = $conPasswordErr = "";
    $fatherNameErr = $motherNameErr = $classErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = test_input($_POST["student_id"]);

        if ($_POST["class"] === "") {
            $classErr = "* Select your class";
        } else {
            $class = test_input($_POST["class"]);
        }

        $class_roll = test_input($_POST["class_roll"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["first_name"])) {
            $firstNameErr = "* Only letters and white space allowed";
        } else {
            $first_name = test_input($_POST["first_name"]);
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["last_name"])) {
            $lastNameErr = "* Only letters and white space allowed";
        } else {
            $last_name = test_input($_POST["last_name"]);
        }

        $mobile_number = test_input($_POST["mobile_no"]);

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "* Invalid email format";
        } else {
            $email = test_input($_POST["email"]);
        }

        $dob = test_input($_POST["dob"]);
        $brn = test_input($_POST["birth_reg_no"]);

        if (empty($_POST["gender"])) {
            $genderErr = "* Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["father_name"])) {
            $fatherNameErr = "* Only letters and white space allowed";
        } else {
            $father_name = test_input($_POST["father_name"]);
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["mother_name"])) {
            $motherNameErr = "* Only letters and white space allowed";
        } else {
            $mother_name = test_input($_POST["mother_name"]);
        }

        $father_occup = test_input($_POST["father_occupation"]);
        $mother_occup = test_input($_POST["mother_occupation"]);

        $pre_address = test_input($_POST["pre_address"]);
        $per_address = test_input($_POST["per_address"]);

        if ($_POST["confirm_password"] === $_POST["password"]) {
            $password = password_hash($_POST["confirm_password"], PASSWORD_BCRYPT);
        } elseif (strlen($_POST["password"]) < 8 && strlen($_POST["confirm_password"]) < 8) {
            $passwordErr = "* Password should contain 8 characters";
            $conPasswordErr = "* Password should contain 8 characters";
        } else {
            $conPasswordErr = "* Password did not match!";
        }


        $image = $_FILES['image'];

        $img_name = $image['name'];
        $tmp_loc = $image['tmp_name'];
        $location = "images/" . $img_name;


        if ($firstNameErr == "" && $lastNameErr == "" && $emailErr == "" && $fatherNameErr == "" && $motherNameErr == "" && $classErr ==  "" && $genderErr == "" && $passwordErr == "" && $conPasswordErr == "") {

            $date = date('d-m-y h:i:s');
            $active = "active";

            // echo $student_id, $class, $class_roll, $first_name, $last_name, $mobile_number, $email, $dob, $brn, $gender, $father_name, $father_occup, $mother_name, $mother_occup, $pre_address, $per_address, $img_name, $password, 'active', $date;

            $sql = "INSERT INTO student_info (student_id, class, class_roll, first_name, last_name, mobile_no, email, dob, birth_reg_no, gender, father_name, father_occupation, mother_name, mother_occupation, pre_address, per_address, image, password, active, creation_date) VALUES ('$student_id', '$class', '$class_roll', '$first_name', '$last_name', '$mobile_number', '$email', '$dob', '$brn', '$gender', '$father_name', '$father_occup', '$mother_name', '$mother_occup', '$pre_address', '$per_address', '$img_name', '$password', '$active', '$date')";


            $res = mysqli_query($con, $sql);
            if ($res) {
                if ($image != "NULL") {
                    move_uploaded_file($tmp_loc, $location);
                }
                echo "<script>alert('Registration Successful')</script>";
                echo "<script>window.open('login.php','_self')</script>";
            } else {
                die(mysqli_error($con));
            }
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>


    <!-- Registration form -->
    <div class="container text-center">
        <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert" id="passwordAlert" style="display: none !important">
            <strong id="alertMessageStrong">Wrong Password!</strong> <label id="alertMessage">Password didn't matched</label>
            <button type="button" class="btn-close" aria-label="Close" id="closeAlert" onclick="controlAlert('close')"></button>
        </div> -->
        <h2>Registration Form</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="student_id">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="class">Class</label><span class="error"><?php echo $classErr; ?></span>
                    <select class="form-control" id="class" name="class" required>
                        <option value="" selected>Select your class</option>
                        <option value="six">Six</option>
                        <option value="seven">Seven</option>
                        <option value="eight">Eight</option>
                        <option value="nine">Nine</option>
                        <option value="ten">Ten</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="class_roll">Class Roll</label> <!-- <label class="wrong">*</label> -->
                    <input type="text" class="form-control" id="class_roll" name="class_roll" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="first_name">First Name</label><span class="error"><?php echo $firstNameErr; ?></span>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="last_name">Last Name</label><span class="error"><?php echo $lastNameErr; ?></span>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mobile_no">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label><span class="error"><?php echo $emailErr; ?></span>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="birth_reg_no">Birth Registration Number</label>
                    <input type="text" class="form-control" id="birth_reg_no" name="birth_reg_no" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gender</label><br><span class="error"><?php echo $genderErr; ?></span>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="male" name="gender" value="male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="female" name="gender" value="female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="father_name">Father's Name</label><span class="error"><?php echo $fatherNameErr; ?></span>
                    <input type="text" class="form-control" id="father_name" name="father_name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mother_name">Mother's Name</label><span class="error"><?php echo $motherNameErr; ?></span>
                    <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="father_occupation">Father's Occupation</label>
                    <input type="text" class="form-control" id="father_occupation" name="father_occupation" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mother_occupation">Mother's Occupation</label>
                    <input type="text" class="form-control" id="mother_occupation" name="mother_occupation" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="pre_address">Present Address</label>
                <textarea class="form-control" id="pre_address" name="pre_address" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="per_address">Permanent Address</label>
                <input class="form-check-input" type="checkbox" value="not same" id="address" onclick="copyAddress()">
                <label class="form-check-label" for="per_address">
                    Same as Present Address
                </label>
                <textarea class="form-control" id="per_address" name="per_address" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image">Upload Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password">Password</label><span class="error"><?php echo $passwordErr; ?></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confirm_password">Confirm Password</label><span class="error"><?php echo $conPasswordErr; ?></span>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
            </div>

            <div class="d-grid gap-2 col-4 mx-auto">
                <button class="btn btn-primary" type="submit" name="submit">Register</button>
            </div>

            <div class="signup-link">
                <p>Already have an account? <a href="login.php" class="link-success">Login</a></p>
            </div>
    </div>

    </form>
    </div>





    <!-- Link Your JS -->
    <script>
        let address = null;
        let per_address = document.getElementById('per_address');
        let check = document.getElementById('address');

        function copyAddress() {
            if (check.value === "not same") {
                if (per_address.value != '') {
                    address = per_address.value;
                }

                per_address.value = document.getElementById('pre_address').value;

                check.value = "same"
            } else {
                per_address.value = address;
                check.value = "not same"
            }
        }

        function controlAlert(type, message) {
            if (type === "show") {
                document.getElementById("passwordAlert").style.display = "block";
            } else if (type === "close") {
                document.getElementById("passwordAlert").style.display = "none";
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm' crossorigin='anonymous'></script>
</body>

</html>