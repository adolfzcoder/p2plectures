<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully.";
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

* {
    font-family: 'Quicksand', sans-serif;
    font-weight:  300; 
    margin:  0; 
}

html, body {
    height:  100vh; 
    width:  100vw;
    margin:  0 0; 
    display:  flex; 
    align-items:  flex-start; 
    justify-content:  flex-start; 
    background:  #f3f2f2; 
}

h4 {
    font-size:  24px; 
    font-weight:  600; 
    color:  #000; 
    opacity:  .85; 
}

label {
    font-size:  12.5px; 
    color:  #000;
    opacity:  .8;
    font-weight:  400; 
}

form {
    padding:  40px 30px; 
    background:  #fefefe; 
    display:  flex; 
    flex-direction:  column;
    align-items:  flex-start; 
    padding-bottom:  20px; 
    width:  300px; 
}

.floating-label {
    position:  relative; 
    margin-bottom:  10px;
    width:  100%; 
}

input {
    font-size:  16px; 
    padding:  20px 0px; 
    height:  56px; 
    border:  none; 
    border-bottom:  solid 1px rgba(0,0,0,.1); 
    background:  #fff; 
    width:  280px; 
    box-sizing:  border-box; 
    transition:  all .3s linear; 
    color:  #000; 
    font-weight:  400;
    -webkit-appearance:  none; 
}

input:focus {
    border-bottom:  solid 1px blue; 
    outline: 0; 
    box-shadow:  0 2px 6px -8px rgba(blue, .45);
}

button {
    -webkit-appearance:  none; 
    width: auto;
    min-width:  100px;
    border-radius:  24px; 
    text-align:  center; 
    padding:  15px 40px;
    margin-top:  5px; 
    background-color:  blue; 
    color:  #fff; 
    font-size:  14px;
    margin-left:  auto; 
    font-weight:  500; 
    box-shadow:  0px 2px 6px -1px rgba(0,0,0,.13); 
    border:  none;
    transition:  all .3s ease; 
    outline: 0; 
}

button:hover {
    transform:  translateY(-3px);
    box-shadow:  0 2px 6px -1px rgba(blue, .65);
}

.session {
    display:  flex; 
    flex-direction:  column; 
    width:  auto; 
    height:  auto; 
    margin:  auto auto; 
    background:  #ffffff; 
    border-radius:  4px; 
    box-shadow:  0px 2px 6px -1px rgba(0,0,0,.12);
}

@media only screen and (min-width: 768px) {
    .session {
        flex-direction:  row;
    }
}

    </style>
</head>
<body>
    <div class="session">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h4>Sign Up</h4>
            <div class="floating-label">
                <input type="text" name="username" placeholder="username " required>
                
            </div>
            <div class="floating-label">
                <input type="email" name="email" placeholder="email" required>
                
            </div>
            <div class="floating-label">
                <input type="password" name="password" placeholder="password" required>
                
            </div>
            <button type="submit">Sign Up</button><br>
            <a href="index.php">Listen to Lectures</a><br>
        <a href="login.php">Login</a>
        </form>
        
    </div>
</body>
</html>

