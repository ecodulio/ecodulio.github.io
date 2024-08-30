<?php
// Start by handling the token and redirection
$token = isset($_GET['token']) ? $_GET['token'] : null;

if (!$token) {
    // Redirect to the home page if the token is missing
    header("Location: https://www.faithbook.ph");
    exit(); // Ensure no further code is executed after the redirect
}

// Initialize output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        p {
            color: red;
            font-size: 14px;
            margin: 20px 0 0; /* Ensure margin is added at the top */
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner" id="spinner"></div>
        <h1 id="header">Confirming your email...</h1>
        <p id="message">(Please don't refresh the page)</p>
        <!-- Error message will be inserted here -->
        <?php
        // Initialize cURL session
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, "https://office.dynamicglobalsoft.com:1111");

        // Set the HTTP method to POST
        curl_setopt($ch, CURLOPT_POST, true);
        
        // Set the HTTP Authorization header with the token
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $token" 
        ));

        // Set cURL options to return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Display the error message directly
            $error = curl_error($ch);
            echo "<p style='color: red;'>asdsadError: $error</p>";
        } else {
            // Success - update the content directly
            echo "
            <script>
                document.getElementById('spinner').style.display = 'none'; // Hide spinner
                document.getElementById('header').innerText = 'Your email is now confirmed.';
                document.getElementById('message').innerText = '(Temporary page. Please replace this in production.)';
                document.querySelector('.container').innerHTML += '<a href=\"https://www.faithbook.ph\">Go back to Home</a>';
            </script>";
        }

        // Close the cURL session
        curl_close($ch);
        
        // Flush the output buffer
        ob_end_flush();
        ?>
    </div>
</body>
</html>
