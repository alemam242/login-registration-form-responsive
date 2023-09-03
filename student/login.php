<?php
session_start();
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

    <title>Student | Login</title>

    <!-- Link your CSS -->
    <link rel='stylesheet' href=''>

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9' crossorigin='anonymous'>

    <style>
        body {
            background: linear-gradient(to bottom, #8692f7, #a3be8c);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
        }

        .login-form .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
        }
    </style>

</head>

<body>

    <?php
    $idErr = $passwordErr = "";
    $student_id = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = test_input($_POST["student_id"]);

        if (strlen($_POST["password"]) < 8) {
            $passwordErr = " * Password must be at least 8 characters";
        } else {
            $password = test_input($_POST["password"]);
        }

        $sql = "select password from student_info where student_id='$student_id' ";
        $res = mysqli_query($con, $sql);
        if ($res) {
            $row_count = mysqli_num_rows($res);

            if ($row_count > 0) {
                $student_password = mysqli_fetch_array($res)["password"];
                if (password_verify($password, $student_password)) {
                    $_SESSION["student_id"] = $student_id;
                    echo "<script>window.open('dashboard.php','_self')</script>";
                } else {
                    $passwordErr = " * Wrong password!";
                }
            } else {
                $idErr = " * student id not found";
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

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 login-form">
                <h2 class="text-center">Login</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="student_id">Student ID</label><span class="error"><?php echo $idErr; ?></span>
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label><span class="error"><?php echo $passwordErr; ?></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="d-grid gap-2 col-4 mx-auto">
                        <button class="btn btn-warning" type="submit" name="submit">Login</button>
                    </div>
                </form>
                <div class="signup-link">
                    <a href="#" class="link-danger">Forgot Password?</a>
                </div>
                <div class="signup-link">
                    <p>Don't have any account? <a href="signup.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>





    <!-- Link Your JS -->
    <script>

    </script>

    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm' crossorigin='anonymous'></script>
</body>

</html>