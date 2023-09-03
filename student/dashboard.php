<?php
include '../db_connection/connection.php';
session_start();

$name = "Guest";
$image = "";
if (isset($_SESSION["student_id"])) {
    $student_id = $_SESSION["student_id"];
    $sql = "select first_name,last_name,image from student_info where student_id='$student_id'";
    $res = mysqli_query($con, $sql);
    if ($res) {
        $row_count = mysqli_num_rows($res);
        if ($row_count > 0) {
            $row = mysqli_fetch_array($res);
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $image = $row["image"];

            $name = $first_name . " " . $last_name;
        }
    }
}
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

    <title>Student | Dashboard</title>

    <!-- Link your CSS -->
    <link rel='stylesheet' href=''>

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9' crossorigin='anonymous'>

    <style>
        body {
            background: linear-gradient(to bottom, #4DA0B0, #D39D38);
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
    </style>

</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 login-form">
                <h2 class="text-center">Welcome, <?= $name ?></h2>
                <div class="form-group">
                    <img src="images/<?= $image ?>" class=" rounded mx-auto d-block img-thumbnail w-25" alt="Image not Found">
                </div>
            </div>
        </div>
    </div>


    <!-- Link Your JS -->
    <script src=''></script>

    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm' crossorigin='anonymous'></script>
</body>

</html>