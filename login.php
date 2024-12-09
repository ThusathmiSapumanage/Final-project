<?php
    include 'config.php';

    $userName = $_POST['txtName'];
    $password = $_POST['txtPassword'];
    $userType = $_POST['userType']; 

    if ($userType == "Customer") {
        $sql = "SELECT * FROM userlogin WHERE userName = '$userName' AND userPass = '$password' AND userType = 'Customer'";

        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo "<script>alert('Login successful, redirecting to the dashboard...');</script>";
            echo "<script>window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Login unsuccessful. Please check your credentials.');</script>";
            echo "<script>window.location.href = 'adminlog.html';</script>";
        }
    }

    if ($userType == "Admin") {
        $sql = "SELECT * FROM userlogin WHERE userName = '$userName' AND userPass = '$password' AND userType = 'Admin'";

        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo "<script>alert('Login successful, redirecting to the dashboard...');</script>";
            echo "<script>window.location.href = 'supplierM.html';</script>";
        } else {
            echo "<script>alert('Login unsuccessful. Please check your credentials.');</script>";
            echo "<script>window.location.href = 'adminlog.html';</script>";
        }
    }
?>
