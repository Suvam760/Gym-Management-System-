<?php
include "config.php";

// Initialize variables to prevent undefined variable warnings
$id = $name = $date = $amount = '';

if (isset($_POST["submit"])) {
    // Validate and sanitize inputs
    $id = mysqli_real_escape_string($connection, $_POST["id"]);
    $name = mysqli_real_escape_string($connection, $_POST["name"]);
    $date = mysqli_real_escape_string($connection, $_POST["date"]);
    $amount = mysqli_real_escape_string($connection, $_POST["amount"]);
    
    // Basic validation
    if (!empty($id) && !empty($name) && !empty($date) && !empty($amount)) {
        // Use prepared statement to prevent SQL injection
        $ins = "INSERT INTO billing (id, name, date, amount) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $ins);
        mysqli_stmt_bind_param($stmt, "ssss", $id, $name, $date, $amount);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Billing record added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($connection) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-warning'>Please fill in all fields!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - Gym Management System</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .navbar-brand img {
            height: 40px;
        }
        form {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    
<!-- nav bar start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="admin-login.php"><img src="img/TT.png" alt="Gym Logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Gym Management System</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="coach.php">Coach</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">Members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="membership.php">Membership</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="receptionist.php">Receptionist</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="billing.php">Billing</a>
      </li>
    </ul>
  </div>
</nav>
<!-- nav bar ends -->

<div class="container">
    <!-- form start -->
    <form method="POST" action="">
        <h2 class="mb-4">Billing Information</h2>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="id">Member ID</label>
                <input type="text" name="id" class="form-control" id="id" placeholder="ID" value="<?php echo htmlspecialchars($id); ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="name">Member Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="date">Billing Date</label>
            <input type="date" name="date" class="form-control" id="date" value="<?php echo htmlspecialchars($date); ?>">
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount" value="<?php echo htmlspecialchars($amount); ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>