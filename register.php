<?php
session_start();
require "database.php";
require "countries.php";
require "sendmail.php";
  // Functions 
  function pathTo($destination) {
    echo "<script>window.location.href = '$destination.php'</script>";
}


// Check if 'status' key is set in the session, if not, set it to 'invalid'
if (!isset($_SESSION['status']) || $_SESSION['status'] == 'invalid'){
    //Set Default Invalid 
    $_SESSION['status'] = 'invalid';  
    
    
}

// check if status is valid and direct to home page
if ($_SESSION['status'] == 'valid') {
    pathTo('dashboard');
}

// Set to PH time
date_default_timezone_set('Asia/Manila');

// Error messages
$pass_error = "";
$email_error = "";
$form_error = "";
$country_error = "";
$age_error = "";
$position_error = "";

// Initialize input values
$first_name = $last_name = $middle_name = $email = $age = $street_address = $suburb = $city = $state = $postcode = $country = "";

if(isset($_POST['create'])){
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $middle_name = trim($_POST['middle_name']);
    $fullname = $first_name . " " . $middle_name . " " . $last_name;
    $email = trim($_POST['email']);
    $age = (int)$_POST['age'];
    $password = trim(md5($_POST['password']));
    $confirm_password = trim(md5($_POST['confirm_password']));
    $street_address = $_POST['street_address'];
    $suburb = trim($_POST['suburb']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $postcode = trim($_POST['postcode']);
    $country = trim($_POST['country']);
    $position = trim($_POST['position']);
    $role = "employee";


    // Set the expiration for token
    $expiration = date("Y-m-d H:i:s", strtotime("+10 minutes"));
    $hash_verify_code = md5($verificationCode);

    // Check if the password contains alphanumeric and matches
    $chk_password = $_POST['password'];
    $chk_cpassword = $_POST['confirm_password'];
    if (!preg_match('/[A-Za-z]/', $chk_password) || !preg_match('/\d/', $chk_password)) {
        $pass_error = "Password must contain at least one letter and one number.";
    } elseif ($chk_password !== $chk_cpassword) {
        $pass_error = "Passwords do not match.";
    }

    // Check if employee hasn't chosen a country
    if($country === "null"){
        $country_error = "Please Choose Your Country";
    }

    // Check if employee hasn't chosen a position
    if($position === "null"){
        $position_error = "Please Choose Your Position";
    }

    // Check if age is valid (18-85)
    if($age < 18 || $age > 85){
        $age_error = "Age must be between 18 and 85 years.";
    }

    $chk_email = "SELECT email FROM employee WHERE email = '$email'";
    $chk_email_query = mysqli_query($conn, $chk_email);

    // Check if email already exists
    if(mysqli_num_rows($chk_email_query) > 0){
        $email_error = 'Email already Exists';
    } elseif (empty($pass_error) && empty($email_error) && empty($country_error) && empty($age_error) && empty($position_error)) {
        // Insert employee data
        $query_insert = "INSERT INTO employee (fullname, email, age, password, street_address, suburb, city, state, postcode, country, verify_token, expiration_token, role, position) 
                         VALUES('$fullname', '$email', $age, '$password', '$street_address', '$suburb','$city', '$state', '$postcode', '$country', '$hash_verify_code','$expiration', '$role', '$position')";

        $query_run = mysqli_query($conn, $query_insert);

        if($query_run){
            $last_id = mysqli_insert_id($conn);
            sendmail_verify($email, $fullname, $verificationCode);
            $_SESSION['id'] = $last_id;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['verify_code'] = $hash_verify_code;
            header("Location: verify-email.php");
        } else {
            $form_error = 'Registration Failed';
        }
        header("Location: verify-email.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>

<body class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist">
     <!-- logo -->
    <div>
        <img src="assets/r-logo.svg" alt="" class="fixed -top-40 -right-40">
        <div class="border-2 h-[840px] w-[840px] fixed -top-40 -right-40 rounded-full  bg-[#62F3FF] opacity-5 blur-3xl"></div>
    </div>

    <form action="" method="post" id="form" class="w-1/2  flex flex-col gap-10 mt-[14rem] ml-[15rem] z-10">
       
        <div>
            <p id="h-text" class="text-4xl font-semibold mb-2">Create Account</p>
            <p id="p-text">Already A Member? <span class="text-[#62F3FF] hover:underline"><a href="login.php">Log in</a></span></p>

        </div>

        <!-- input fields -->
        <div class="flex flex-col gap-8">
            <!-- fullname -->
            <div class="flex gap-2">
                <div class="relative font-sans w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($first_name); ?>"
                        name="first_name"
                        type="text"
                        id="first-name"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        First name
                    </label>
                </div>

                <div class="relative font-sans  w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($last_name); ?>"
                        name="last_name"
                        type="text"
                        id="last-name"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Last name
                    </label>
                </div>

                <div class="relative font-sans w-full">
                    <input 
                        class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF] text-white placeholder-transparent"
                        value="<?= htmlspecialchars($middle_name); ?>"
                        name="middle_name"
                        type="text"
                        id="middle-name"
                        placeholder=" ">
                    <label 
                        class="absolute left-1 text-[#757575] pointer-events-none transform -translate-y-6 transition duration-150 
                            peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:-left-1 
                            peer-placeholder-shown:translate-y-2 peer-placeholder-shown:scale-90 
                            peer-placeholder-shown:left-1 peer-focus:text-[#62F3FF] peer-valid:scale-90">
                            Middle name (Optional)
                        </label>
                </div>
            </div>

            <!-- Email & Age -->
            <div>
                <div class="flex gap-2">
                    <div class="relative font-sans w-1/2">
                        <div>
                            <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                                value="<?= htmlspecialchars($email); ?>"
                                name="email"
                                type="email"
                                id="email"
                                required>
                            <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                                Email
                            </label>
                        </div>
                        <span class="text-red-500"><?= $email_error;?></span>
                    </div>

                    <div class="relative font-sans w-1/2">
                        <input class="no-spinner w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                            value="<?= htmlspecialchars($age); ?>"
                            name="age"
                            type="number"
                            id="age"
                            required>
                        <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                            Age
                        </label>
                        <span class="text-red-500"><?= $age_error;?></span>
                    </div>

                    <div class="relative font-sans w-1/2">
                        <select name="position" id="" class="w-full p-[9px] bg-transparent  border border-[#38373E] rounded-xl  text-[#757575] relative">
                            <option value="null" class="bg-[#29282F] text-white">Choose your position</option>
                            <option value="Developer" class="bg-[#29282F] text-white">Developer</option>
                            <option value="Designer" class="bg-[#29282F] text-white">Designer</option>
                        </select>
                        <span class="text-red-500"><?= $position_error;?></span>
                    </div>

                    
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex gap-2">
                    <div class="relative font-sans w-1/2">
                        <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                            name="password"
                            type="password"
                            minlength="8"
                            maxlength="32"
                            id="password"
                            required>
                        <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                            Password
                        </label>
                    </div>

                    <div class="relative font-sans w-1/2">
                        <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                            name="confirm_password"
                            type="password"
                            minlength="8"
                            maxlength="32"
                            id="confirm-password"
                            required>
                        <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                            Confirm password
                        </label>
                    </div>
                </div>
                <span class="text-red-500"><?=$pass_error;?></span>
            </div>

            <!-- street address & Suburb -->
            <div class="flex gap-2">
                <div class="relative font-sans w-1/2">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($street_address); ?>"
                        name="street_address"
                        type="text"
                        id="street-address"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Street Address
                    </label>
                </div>

                <div class="relative font-sans w-1/2">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($suburb); ?>"
                        name="suburb"
                        type="text"
                        id="suburb"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Suburb
                    </label>
                </div>
            </div>

            <div class="flex gap-2">
                <div class="relative font-sans w-1/4">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($city); ?>"
                        name="city"
                        type="text"
                        id="city"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        City
                    </label>
                </div>

                <div class="relative font-sans w-1/4">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($state); ?>"
                        name="state"
                        type="text"
                        id="state"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        State
                    </label>
                </div>

                <div class="relative font-sans w-1/4">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2  transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        value="<?= htmlspecialchars($postcode); ?>"
                        name="postcode"
                        type="text"
                        id="postcode"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Postcode
                    </label>
                </div>
                <div class="w-1/4 ">
                    <select  class="w-full p-[9px] bg-transparent  border border-[#38373E] rounded-xl  text-[#757575] relative" name="country" id="country"  value="null" <?= $country === "null" ? "selected" : ""; ?> required>
                        <option value="null"  class="bg-[#29282F] text-white">Select your country</option>
                        <?php foreach ($countries as $option): ?>
                            <option value="<?= htmlspecialchars($option) ?>" <?= $country == $option ? "selected" : "" ?> class="bg-[#29282F] text-white"><?php echo htmlspecialchars($option); ?></option>
                        <?php endforeach; ?>
                                    
                    </select>
                    <span class="text-red-500"><?=$country_error?></span>
                </div>
            </div>

        </div>

        <input type="submit" value="Create Account" name="create" class="bg-[#62F3FF] w-1/5 py-3 rounded-full text-black font-semibold text-lg hover:cursor-pointer" id="button">
        

</form>
</body>


<style>

    /* design scroll option tags */
    select::-webkit-scrollbar {
        width: 8px; /* Width of the scrollbar */
    }

    select::-webkit-scrollbar-track {
    background-color: #38373E; /* Track color */
    }


    select::-webkit-scrollbar-thumb{
    background-color: #555; /* Hover color */
    border-radius: 10px;
    }

    /* Chrome, Safari, Edge, Opera */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    .no-spinner[type=number] {
        -moz-appearance: textfield;
    }
  
  @media only screen and (max-width: 1440px) {

        body{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #form{
            margin: 0;
        }

         #form div label{
            font-size: 13px;
            top: 2px;
        }

        #form select{
            font-size: 13px;
        }

        #button{
            font-size: 15px;
            padding-block: 8px;
        }
  }


  @media only screen and (max-width: 430px) {
        #form{
            padding-inline: 2rem;
            gap: 25px;
            width: 100%;
        }
        #form div{
            width: 100%;
            flex-direction: column;
            gap: 10px;
        }

        #form select{
            width: 100%;
           padding: 12px;
        }
        #button{
            width: 70%;
            align-self: center;
        }
        #h-text{
            font-size: 25px;
            margin-bottom: 0px;
        }

        #p-text{
            font-size: 12px;
        }
        
    }
</style>
    
</html>