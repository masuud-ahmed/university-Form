<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Registration Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .form-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .checkbox-group,
        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 5px;
        }

        .checkbox-group label,
        .radio-group label {
            display: flex;
            align-items: center;
            font-weight: normal;
        }

        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 8px;
        }

        input[type="file"] {
            padding: 10px 0;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: opacity 0.3s;
        }

        .btn-clear {
            background-color: #f44336;
            color: white;
        }

        .btn-register {
            background-color: #4CAF50;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .form-section {
                padding: 10px;
            }

            .checkbox-group,
            .radio-group {
                grid-template-columns: 1fr;
            }

            .form-buttons {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php
$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload handling
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Function to handle file upload
    function handleFileUpload($fileInput, $uploadDir) {
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
            $fileName = basename($_FILES[$fileInput]['name']);
            $targetPath = $uploadDir . time() . '_' . $fileName;
            
            if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetPath)) {
                return true;
            }
        }
        return false;
    }

    // Handle file uploads
    $uploadSuccess = true;
    $requiredFiles = ['passportPhoto', 'secondaryCertificate', 'birthCertificate', 'registrationReceipt'];
    
    foreach ($requiredFiles as $file) {
        if (!handleFileUpload($file, $uploadDir)) {
            $uploadSuccess = false;
            $errorMessage = "Error uploading files. Please try again.";
            break;
        }
    }

    // Handle optional sponsor letter if sponsorship is "yes"
    if (isset($_POST['sponsorship']) && $_POST['sponsorship'] === 'yes') {
        handleFileUpload('sponsorLetter', $uploadDir);
    }

    if ($uploadSuccess) {
        $successMessage = "Registration successful! Your files have been uploaded.";
    }
}
?>

    <div class="container">
        <h1>University Registration Form</h1>
        
        <?php if ($successMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <div class="form-group">
                    <label for="firstName">First name:</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                
                <div class="form-group">
                    <label for="middleName">Middle name:</label>
                    <input type="text" id="middleName" name="middleName">
                </div>
                
                <div class="form-group">
                    <label for="lastName">Last name:</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
                
                <div class="form-group">
                    <label for="pinCode">Pin code:</label>
                    <input type="text" id="pinCode" name="pinCode" required>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="faculty">Faculty:</label>
                    <select id="faculty" name="faculty" required>
                        <option value="">Select Faculty</option>
                        <option value="computing">Faculty of Computing</option>
                        <option value="management">Faculty of Management Sciences</option>
                        <option value="medicine">Faculty of Medicine</option>
                        <option value="education">Faculty of Education</option>
                        <option value="social">Faculty of Social Sciences</option>
                        <option value="economics">Faculty of Economics</option>
                        <option value="accountancy">Faculty of Accountancy</option>
                        <option value="law">Faculty of Law</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="male" required>
                            Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" required>
                            Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Marital status:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="maritalStatus" value="single" required>
                            Single
                        </label>
                        <label>
                            <input type="radio" name="maritalStatus" value="married" required>
                            Married
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="secondarySchool">Secondary school:</label>
                    <select id="secondarySchool" name="secondarySchool" required>
                        <option value="">Select School</option>
                        <option value="school1">School 1</option>
                        <option value="school2">School 2</option>
                        <option value="school3">School 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="placeOfBirth">Place of birth:</label>
                    <select id="placeOfBirth" name="placeOfBirth" required>
                        <option value="">Select Place</option>
                        <option value="mogadishu">Mogadishu</option>
                        <option value="hargeisa">Hargeisa</option>
                        <option value="kismayo">Kismayo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="residence">Residence:</label>
                    <select id="residence" name="residence" required>
                        <option value="">Select Residence</option>
                        <option value="warta">Warta Nabada</option>
                        <option value="hodan">Hodan</option>
                        <option value="wadajir">Wadajir</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="graduationYear">Graduation Year:</label>
                    <input type="date" id="graduationYear" name="graduationYear" required>
                </div>

                <div class="form-group">
                    <label>Sponsorship:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="sponsorship" value="yes">
                            Yes
                        </label>
                        <label>
                            <input type="radio" name="sponsorship" value="no">
                            No
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="passportPhoto">Passport size photo (jpg or png):</label>
                    <input type="file" id="passportPhoto" name="passportPhoto" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="secondaryCertificate">Secondary certificate (pdf):</label>
                    <input type="file" id="secondaryCertificate" name="secondaryCertificate" accept=".pdf" required>
                </div>

                <div class="form-group">
                    <label for="birthCertificate">Birth certificate (pdf):</label>
                    <input type="file" id="birthCertificate" name="birthCertificate" accept=".pdf" required>
                </div>

                <div class="form-group">
                    <label for="registrationReceipt">Registration fee receipt (pdf):</label>
                    <input type="file" id="registrationReceipt" name="registrationReceipt" accept=".pdf" required>
                </div>

                <div class="form-group">
                    <label for="sponsorLetter">Upload sponsor letter (pdf):</label>
                    <input type="file" id="sponsorLetter" name="sponsorLetter" accept=".pdf">
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="comments">Please provide suggestion or comment:</label>
                    <textarea id="comments" name="comments" rows="4"></textarea>
                </div>
            </div>

            <div class="form-buttons">
                <button type="reset" class="btn-clear">Clear form</button>
                <button type="submit" class="btn-register">Register</button>
            </div>
        </form>
    </div>
</body>
</html>

