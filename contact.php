<?php


$errors = [];
$missing = [];
$required = ['name', 'email', 'subject', 'message'];
$submitted = false;

// Check if any required elements are empty in the POST array
foreach ($_POST as $key => $value) {
    foreach ($required as $field) {
        if ($key == $field && !$value) {
            $missing[] = $field;
        }
    }
}

// Check if there are any errors in the submitted fields
if (isset($_POST['email'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'email';
    }
}
if (isset($_POST['mobile'])) {
    $mobPattern = "/^04\d{8}/";
    if (!preg_match($mobPattern, $_POST['mobile'])) {
        $errors[] = 'mobile';
    }
}

// Check that there are no missing or eroneous fields before saving submission to file
if ($_POST && !$missing && !$errors) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $file = fopen("mail.txt", "a");
    if (flock($file, LOCK_EX)) {
        fputcsv($file, $_POST);
    }
    fclose($file);

    // Save user details if the 'Remember Me' box is checked on successful submission
    if (isset($_POST['rememberMe'])) {
        echo '<script>
        localStorage.setItem("name", "' . $_POST['name'] . '");
        localStorage.setItem("email", "' . $_POST['email'] . '");
        localStorage.setItem("mobile", "' . $_POST['mobile'] . '");
        </script>';

    }

    $submitted = true;
}

?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <?php include('includes/head.php') ?>
    <meta name="description" content="Send an email to the content curators to get in touch about a topic of interest regarding Douglas Baker">
    <title>ANZAC Douglas Raymond Baker - Contact</title>
</head>

<body>

    <header>
        <?php include('includes/header.php'); ?>

    </header>

    <nav>
        <?php include('includes/menu.php'); ?>

    </nav>

    <main>

        <div class="contact-container">
            <?php if (!$submitted) : ?>
                <p>Submit your details if you would like more information or to get in touch! </p>
            <?php else : ?>
                <p>Thanks for submitting! We'll get back to you as soon as possible!</p>
            <?php endif; ?>
            <?php if ($errors || $missing) : ?>
                <span class="form-error">Please fix the errors and submit again!</span>
            <?php endif; ?>
            <div class="contact-form-box" <?php if ($submitted) {
                                                echo 'style="display:none"';
                                            } ?>>

                <form method="POST" class="contact-form" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name"<?php if ($errors || $missing) {
                                                                                            echo ' value="' . $_POST['name'] . '">';
                                                                                        } else {
                                                                                            echo '><script>storageIsSet("name");</script>';
                                                                                        } ?> 
                    <?php if ($missing && in_array('name', $missing)) : ?>
                        <span class="form-error">Please enter your name</span>
                    <?php endif; ?>

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="your@email.com"<?php if ($errors || $missing) {
                                                                                                echo ' value="' . $_POST['email'] . '">';
                                                                                            } else {
                                                                                                echo '><script>storageIsSet("email");</script>';
                                                                                            } ?> 
                    <?php if ($missing && in_array('email', $missing)) : ?>
                        <span class="form-error">Please enter your email</span>
                    <?php elseif ($errors && in_array('email', $errors)) : ?>
                        <span class="form-error">Please use correct email format: <em>your@email.com</em></span>
                    <?php endif; ?>

                    <label for="mobile">Mobile</label>
                    <input type="number" id="mobile" name="mobile" placeholder="04XXXXXXXX"<?php if ($errors || $missing) {
                                                                                                echo ' value="' . $_POST['mobile'] . '">';
                                                                                            } else {
                                                                                                echo '><script>storageIsSet("mobile");</script>';
                                                                                            } ?> 
                    <?php if ($errors && in_array('mobile', $errors)) : ?>
                        <span class="form-error">Please use correct mobile format: <em>04XXXXXXXX</em></span>
                    <?php endif; ?>

                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Subject of Interest"<?php if ($errors || $missing) {
                                                                                                            echo ' value="' . $_POST['subject'] . '"';
                                                                                                        } ?>>
                    <?php if ($missing && in_array('subject', $missing)) : ?>
                        <span class="form-error">Please enter the subject</span>
                    <?php endif; ?>

                    <label for="message">Message</label>
                    <textarea type="text" id="message" name="message" rows="4" placeholder="Your Message"><?php if ($errors || $missing) {
                                                                                                                echo $_POST['message'];
                                                                                                            } ?></textarea>
                    <?php if ($missing && in_array('message', $missing)) : ?>
                        <span class="form-error">Please enter your message</span>
                    <?php endif; ?>

                    <label for="rememberMe">Remember Me</label>
                    <input type="checkbox" name="rememberMe" id="rememberMe" onclick="toggleStorage()">
                    <script>rememberCheck()</script>

                    <input type="submit" name="submit" value="submit">
                </form>

            </div>

        </div>

    </main>

    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>

</body>

</html>