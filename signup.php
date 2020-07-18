<?php
require "header.php";
?>

<main>
  <div class="wrapper-main">
    <section class="section-default">
      <?php
          if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyfields') {
              echo '<p class="signuperror">Töltsd ki az összes mezőt!</p>';
            }
            else if ($_GET['error'] == 'invalidmail'){
              echo '<p class="signuperror">Hibás emailcím</p>';
            }
            else if ($_GET['error'] == 'invaliduid'){
              echo '<p class="signuperror">Hibás felhasználónév</p>';
            }
            else if ($_GET['error'] == 'passwordcheck'){
              echo '<p class="signuperror">A jelszavak nem egyeznek</p>';
            }
            else if ($_GET['error'] == 'usertaken'){
              echo '<p class="signuperror">Foglalt felhasználónév</p>';
            }
          }
          else if ($_GET['signup'] == 'success'){
            echo '<p class="signupsucces">Sikeres dolgzófelvétel</p>';
          }

       ?>
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Felhasználónév">
        <input type="text" name="mail" placeholder="E-mail cím">
        <input type="password" name="pwd" placeholder="Jelszó">
        <input type="password" name="pwd-repeat" placeholder="Jelszó megerősítése">
        <button type="submit" name="signup-submit">Signup</button>

      </form>
    </section>

  </div>
</main>

<?php
require "footer.php";
?>
