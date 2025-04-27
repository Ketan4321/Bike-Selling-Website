<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #f0f0f0; /* Light text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #1e1e1e; /* Dark grey container background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }

        b {
            font-size: 24px;
            color: #f0f0f0; /* Light text for the title */
        }

        .text {
            font-size: 16px;
            color: #ccc; /* Slightly lighter text for instructions */
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #ddd; /* Light color for labels */
            display: block;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c; /* Dark input background */
            color: #f0f0f0; /* Light input text */
            font-size: 14px;
        }

        input::placeholder, select {
            color: #aaa; /* Placeholder text color */
        }

        .Btn {
            background-color: #007BFF; /* Button color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .Btn:hover {
            background-color: #218838; /* Hover effect for the button */
        }
    </style>
</head>
<body>
    <div class="container">
        <b>Forgot Password</b>
        <div class="text">Change your password here</div><br>
        <form action="validate security.php" method="POST">
            <label for="username">Enter your Username:</label><br>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>

            <label for="security_question">Security Question:</label><br>
            <select id="security_question" name="security_question" required>
                <option value="">Select a Security Question</option>
                <option value="favorite_color">What is your favorite color?</option>
                <option value="first_pet">What was the name of your first pet?</option>
                <option value="birth_city">What city were you born in?</option>
            </select><br>

            <label for="security_answer">Security Answer:</label><br>
            <input type="text" id="security_answer" name="security_answer" placeholder="Enter your answer" required><br>

            <button class="Btn" type="submit">Next</button><br>
        </form>
    </div>
</body>
</html>
