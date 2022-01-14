<?php
// Include config file
require_once "../config/index.php";

// Define variables and initialize with empty values
$name = $birth_date = $age = $gender = "";
$name_err = $birth_date_err = $age_err = $gender_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Masukan Nama Anda : ";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Masukan Nama yang Valid";
    } else{
        $name = $input_name;
    }

    
    $input_birth_date = trim($_POST['birth_date']);
    $birth_date = $input_birth_date;
    

    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $address_err = "Masukan Umur Anda : ";
    } else{
        $age = $input_age;
    }

    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $address_err = "Masukan Jenis Kelamin : ";
    } else{
        $gender = $input_gender;
    }


    // Check input errors before inserting in database
    if(empty($name_err) && empty($birth_date_err) && empty($age_err) && empty($gender_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO singer (name, birth_date, age, gender) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_birth_date, $param_age, $param_gender);

            // Set parameters
            $param_name = $name;
            $param_birth_date = $birth_date;
            $param_age = $age;
            $param_gender = $gender;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah Penyanyi</h2>
                    </div>
                     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($birth_date_err)) ? 'has-error' : ''; ?>">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="<?php echo $birth_date; ?>">
                            <span class="help-block"><?php echo $birth_date_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                            <label>Umur</label>
                            <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                            <span class="help-block"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label>Jenis Kelamin</label>
                            <input type="text" name="gender" class="form-control" value="<?php echo $gender; ?>">
                            <span class="help-block"><?php echo $gender_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>