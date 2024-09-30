<?php
session_start();

$errors = [];
$fields = ['name', 'email', 'password', 'confirm_password', 'phone', 'gender', 'country', 'biography', 'facebook_url'];

foreach ($fields as $field) {
    $$field = '';
}

$skills = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    foreach ($fields as $field) {
        $$field = htmlspecialchars($_POST[$field]);
    }

    if(empty($name)){
        $errors['name'] = "Error: This field is required.";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors['name'] = "Error: Letter and spaces only";
    }

    if(empty($email)){
        $errors['email'] = "Error: This field is required.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Error: Invalid email!";
    }

    if(empty($facebook_url)){
        $errors['facebook_url'] = "Error: This field is required.";
    }
    elseif (!filter_var($facebook_url, FILTER_VALIDATE_URL)) {
        $errors['facebook_url'] = "Error: Invalid URL";
    }
    elseif (strpos($facebook_url, 'facebook.com') === false) {
        $errors['facebook_url'] = "Error: Not a Facebook URL";
    }

    if(empty($password)){
        $errors['password'] = "Error: This field is required.";
    }
    elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $errors['password'] = "Password must be at least 8 characters, include a number and an uppercase letter";
    }

    if ($confirm_password !== $password) {
        $errors['confirm_password'] = "Error: Passwords do not match";
    }

    if(empty($phone)){
        $errors['phone'] = "Error: This field is required.";
    }
    if (!preg_match("/^[0-9]+$/", $phone)) {
        $errors['phone'] = "Error: Invalid phone number. Must be numeric";
    }
    
    if (empty($gender)) {
        $errors['gender'] = "Error: This field is required.";
    }

    if (empty($country)) {
        $errors['country'] = "Error: This field is required.";
    }

    if (!empty($_POST['skills'])) {
        $skills = implode(", ", $_POST['skills']);
    } else {
        $errors['skills'] = "Error: Select at least one skill";
    }

    if (empty($biography)) {
        $errors['biography'] = "Error: This field is required";
    }
    elseif(strlen($biography) > 200){
        $errors['biography'] = "Error: Maximum length is 200 characters";
    }

    
    if (empty($errors)) {
        $_SESSION = compact('name', 'email', 'phone', 'gender', 'country', 'skills', 'biography', 'facebook_url');
        header("Location: about.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center"><strong>Registration Form</strong></h2>
    <form method="post" action="" class="row g-4  mt-3">
       
        <div class="mb-3">
            <label for="name" class="form-label"><strong>NAME</strong></label>
            <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= $name; ?>" style="max-width: 300px;">
            <div class="invalid-feedback"><?= $errors['name']?></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label"><strong>EMAIL</strong></label>
            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= $email; ?>" style="max-width: 300px;">
            <small class="text-danger"><?= $errors['email'] ?? ''; ?></small>
        </div>
        
        <div class="mb-3">
            <label for="facebook_url" class="form-label"><strong>FACEBOOK URL</strong></label>
            <input type="url" class="form-control <?= isset($errors['facebook_url']) ? 'is-invalid' : ''; ?>" id="facebook_url" name="facebook_url" value="<?= $facebook_url; ?>" style="max-width: 300px;" placeholder="https://www.facebook.com/yourprofile">
            <small class="text-danger"><?= $errors['facebook_url'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label"><strong>PASSWORD</strong></label>
            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" style="max-width: 300px;">
            <small class="text-danger"><?= $errors['password'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label"><strong>CONFIRM PASSWORD</strong></label>
            <input type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" style="max-width: 300px;">
            <small class="text-danger"><?= $errors['confirm_password'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label"><strong>PHONE NUMBER</strong></label>
            <input type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?= $phone; ?>" style="max-width: 300px;">
            <small class="text-danger"><?= $errors['phone'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>GENDER</strong></label>
            <div>
                <input class="form-check-input <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>" type="radio" name="gender" value="Male" <?= $gender == 'Male' ? 'checked' : ''; ?>>
                <label class="form-check-label">Male</label>
            </div>
            <div>
                <input class="form-check-input <?= isset($errors['gender']) ? 'is-invalid' : ''; ?>" type="radio" name="gender" value="Female" <?= $gender == 'Female' ? 'checked' : ''; ?>>
                <label class="form-check-label">Female</label>
            </div>
            <small class="text-danger"><?= $errors['gender'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label"><strong>Country</strong></label>
            <select id="country" class="form-select <?= isset($errors['country']) ? 'is-invalid' : ''; ?>" name="country" style="max-width: 300px;">
                <option value=""disabled selected>Select a country</option>
                <option value="Australia">Australia</option>
                <option value="Brazil">Brazil</option>
                <option value="China">China</option>
                <option value="Denmark">Denmark</option>
                <option value="England">England</option>
                <option value="Finland">Finland</option>
                <option value="Greece">Greece</option>
                <option value="Hawaii">Hawaii</option>
                <option value="India">India</option>
                <option value="Japan">Japan</option>
                <option value="Philippines">Philippines</option>
                <option value="Taiwan">USA</option>
                <option value="Russia">Russia</option>
            </select>
            <small class="text-danger"><?= $errors['country'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Skills</strong></label>
            <?php
            $allSkills = ['Cybersecurity', 'Project Management', 'Programming Knowledge', 'Networking', 'Troubleshooting', 'Data Analytics'];
            foreach ($allSkills as $skill) {
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" name="skills[]" value="' . $skill . '" ' . (in_array($skill, explode(", ", $skills)) ? 'checked' : '') . '>';
                echo '<label class="form-check-label">' . $skill . '</label>';
                echo '</div>';
            }
            ?>
            <small class="text-danger"><?= $errors['skills'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <label for="biography" class="form-label"><strong>Biography</strong></label>
            <textarea class="form-control <?= isset($errors['biography']) ? 'is-invalid' : ''; ?>" id="biography" name="biography" rows="3" style="max-width: 600px;"><?= $biography; ?></textarea>
            <small class="text-danger"><?= $errors['biography'] ?? ''; ?></small>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>

        </div>
    </form>
</div>
</body>
</html>


