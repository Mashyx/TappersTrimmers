<?php
require '../PHP/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $conn->real_escape_string($_POST["first_name"]);
    $last_name  = $conn->real_escape_string($_POST["last_name"]);
    $email      = $conn->real_escape_string($_POST["email"]);
    $password   = $_POST["password"];

    // Wachtwoord hashen
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Standaard rol instellen
    $role = "user";

    $sql = "INSERT INTO users (first_name, last_name, email, password_hash, role)
            VALUES ('$first_name', '$last_name', '$email', '$password_hash', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registratie succesvol!";
    } else {
        echo "Er is een fout opgetreden: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            font-family: "Poppins", sans-serif;
            color: #eee;
        }

        .register-card {
            background: #111;
            border: 1px solid #bfa046;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(191,160,70,0.2);
        }

        .form-label {
            color: #ddd;
            font-weight: 500;
        }

        .form-control {
            background-color: #222;
            border: 1px solid #555;
            color: #fff;
            padding: 10px;
            caret-color: #bfa046;
        }

        .form-control:focus {
            background-color: #222;
            border-color: #bfa046;
            box-shadow: 0 0 8px rgba(191,160,70,0.4);
            color: #fff;
            outline: none;
        }

        .btn-gold {
            background: #bfa046;
            color: #111;
            font-weight: 600;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            transition: .3s;
            width: 100%;
        }

        .btn-gold:hover {
            background: #d4b768;
        }

        h3 {
            color: #bfa046;
            font-weight: 600;
        }

        /* Autofill fix */
        /* Chrome autofill fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #222 inset !important; /* achtergrond donker */
            -webkit-text-fill-color: #fff !important;                /* tekst wit */
            caret-color: #bfa046;                                    /* cursor goud */
        }


    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="register-card">
                <h3 class="text-center mb-4">Account Aanmaken</h3>

                <!-- Dummy velden voor autofill -->
                <form action="register.php" method="POST" autocomplete="off">
                    <input type="text" name="fakeusernameremembered" style="display:none">
                    <input type="password" name="fakepasswordremembered" style="display:none">

                    <div class="mb-3">
                        <label class="form-label">Voornaam</label>
                        <input type="text" name="first_name" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Achternaam</label>
                        <input type="text" name="last_name" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" autocomplete="new-email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password" required>
                    </div>

                    <button type="submit" class="btn-gold">Registreren</button>
                    <p class="text-center mt-3">
                        Heb je al een account? <a href="login.php" style="color: #bfa046;">Log hier in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
