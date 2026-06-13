<?php include('admin-login.php') ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link rel="stylesheet" href="demo.css">
    <link rel="stylesheet" href="form-login.css">
</head>

<body>
    <div class="main-content">
        <!-- You only need this form and the form-login.css -->
        <form class="form-login" method="post" action="admin-login.php">
            <div class="form-log-in-with-email">
                <div class="form-white-background">
                    <div class="form-title-row">
                        <h1>Admin Log in</h1>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="form-row">
                            <p style="color: red;"><?php echo $error; ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <label>
                            <span>Email</span>
                            <input type="email" name="email" required>
                        </label>
                    </div>
                    <div class="form-row">
                        <label>
                            <span>Password</span>
                            <input type="password" name="password" required>
                        </label>
                    </div>
                    <div class="form-row">
                        <button type="submit">Log in</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>