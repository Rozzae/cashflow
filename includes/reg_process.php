<?php require_once("../includes/header.php"); ?>

<?php
$un= trim($_POST["username"]);
$em= trim($_POST["email"]);
$pn= trim($_POST["phoneNumber"]);
$pw= trim($_POST["password"]);
$ques= trim($_POST["squestion"]);
$ans= trim($_POST["sanswer"]);
$cpw= trim($_POST["confirmPassword"]);
$rf= trim($_POST["register"]);

// Avoids duplicate username in the DB
$result= mysqli_query($connection,"SELECT * FROM user_details");
while ($db=mysqli_fetch_row($result)){
    if ($un == $db[1] || $em == $db[3]){
        echo '
            <div class="container">
                <div class="card text-center">
                    <div class="card text-center" style="padding-top:50px;">
                        <div class="card-header">
                            <h2>Something went wrong: Registration Failed</h2>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title"></h1>
                            <p class="card-text"><strong>Reason: </strong> Username or Email Already Exists </p>
                            <p class="card-text">click here to go back to registration</p>
                            <a href="../reg.php" class="btn btn-primary">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        ';
        return;
    }
}
// Makes sure the password fields are equal
if ($pw == $cpw){
    //Success
    $query = "SELECT username FROM user_details WHERE (ID = '{$rf}')";
    $result= mysqli_query($connection,$query);
    if (!$result){
        die("Database connection failed");
    }

    while ($db=mysqli_fetch_row($result)){
        $disrefname = $db[0];
    }

    $hpw = md5($pw); // MD5 Hashing technique
    $query = "INSERT INTO user_details
    (ID, username, password, email, phone_no, refeerer) 
    VALUES ('','{$un}','{$hpw}','{$em}','{$pn}', '{$disrefname}')";
    
    $query2 = "INSERT INTO sec_qa
    (id, email, phone, ques, answer) 
    VALUES ('','{$em}','{$pn}','{$ques}','{$ans}')";
    

    $result= mysqli_query($connection,$query);
    $result2= mysqli_query($connection,$query2);
    if (!$result || !$result2){
        die("Database connection failed: ");
    }else{
        //More Success
        header("Location: ../login.php");
        exit;
    }
} else{
    //Failed
    echo '
        <div class="container">
            <div class="card text-center">
                <div class="card text-center" style="padding-top:50px;">
                    <div class="card-header">
                        <h2>Something went wrong: Registration Failed</h2>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title"></h1>
                        <p class="card-text"><strong>Reason: </strong>Password Mismatch</p>
                        <p class="card-text">click here to go back to registration</p>
                        <a href="../reg.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    ';
    
}


?>
<?php //include '../includes/footer.php';?>

<?php require_once("../includes/close_connection.php");?>
