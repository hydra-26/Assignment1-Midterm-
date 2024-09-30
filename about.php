<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">ABOUT</h2>
    <table class="table table-bordered mt-4" style="border-color: black;">
    <style>
                th {
                    background-color: #f8f9fa !important;
                    color: black;
                    width: 130px;
                    text-align: center;
                }
            </style>
        <tbody>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($_SESSION['name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($_SESSION['email']); ?></td>
            </tr>
            <tr>
                <th>Facebook URL</th>
                <td><?php echo htmlspecialchars($_SESSION['facebook_url']); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo htmlspecialchars($_SESSION['phone']); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($_SESSION['gender']); ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?php echo htmlspecialchars($_SESSION['country']); ?></td>
            </tr>
            <tr>
                <th>Skills</th>
                <td><?php echo htmlspecialchars($_SESSION['skills']); ?></td>
            </tr>
            <tr>
                <th>Biography</th>
                <td><?php echo htmlspecialchars($_SESSION['biography']); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
