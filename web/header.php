<?php
require '../PHP/db.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepared statement voor veiligheid
    $stmt = $conn->prepare("SELECT user_id, first_name, last_name, password_hash, role FROM users WHERE email = ?");
    if (!$stmt) {
        die("Fout in SQL voorbereiding: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {
            // Login succesvol, sessies instellen
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect naar dashboard of homepagina
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Ongeldig wachtwoord.";
        }
    } else {
        $error = "Geen account gevonden met dit e-mailadres.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #eee;
            font-family: "Poppins", sans-serif;
        }
        .login-card {
            background: #111;
            border: 1px solid #bfa046;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(191,160,70,0.2);
        }
        .form-label { color: #555; font-weight: 500; }
        .form-control {
              background-color: #555; /* lichte achtergrond */
              color: #000;            /* zwarte tekst */
              border: 1px solid #555;
              padding: 10px;
              caret-color: #bfa046;   /* goudkleurige cursor */
            }
   
    
        .form-control:focus {
            background-color: #222;
            border-color: #bfa046;
            box-shadow: 0 0 8px rgba(191,160,70,0.4);
            color: #000;               /* zwarte tekst tijdens focus */
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
        .btn-gold:hover { background: #d4b768; }
        h3 { color: #bfa046; font-weight: 600; }

    
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-card">
                <h3 class="text-center mb-4">Inloggen</h3>

                <?php if(!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- Dummy velden voor autofill -->
                <form action="login.php" method="POST" autocomplete="off">
                    <input type="text" name="fakeuser" style="display:none">
                    <input type="password" name="fakepass" style="display:none">

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" autocomplete="new-email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Wachtwoord</label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password" required>
                    </div>

                    <button type="submit" class="btn-gold">Inloggen</button>
                </form>

                <p class="text-center mt-3">
                    Nog geen account? <a href="register.php" style="color: #bfa046;">Registreer hier</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
