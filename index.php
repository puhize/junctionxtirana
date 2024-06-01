<!DOCTYPE html>
<html lang="en">

<head>
  <link href="assets/css/login.css" rel="stylesheet" />
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <?php if (!empty($errorMsg)) : ?>
        <div style="color: red;"><?php echo $errorMsg; ?></div>
      <?php endif; ?>
      <form action="registerlogic.php" method="post">
        <h1>Create Account</h1>
        <input id="inputFirstName" name="name" type="text" placeholder="Enter your first name" required />
        <input id="inputLastName" name="surname" type="text" placeholder="Enter your last name" required />
        <input id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
        <input id="inputPassword" name="password" type="password" placeholder="Create a password" required />

        <input class="button" type="submit" name="submit" value="Create Account">
      </form>

    </div>

    <!--LOG IN-->
    <div class="form-container sign-in-container">
      <form action="login-logic.php" method="POST">
        <h1>Log in</h1>
        <input type="email" name="email" id="loginEmail" placeholder="name@example.com" required>
        <br>
        <input type="password" name="password" id="loginPassword" placeholder="Password" required>
        <br>
        <input class="button" type="submit" name="submit" value="Log in">
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">LOG In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start your journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/login.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="assets/js/scripts.js"></script>
</body>

</html>