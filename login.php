<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>user - login</title>
</head>

<body>
    <div class="wrapper">
        <section class="form login">
            <header>
                WeChat
            </header>
            <form style="margin-top: 20px;" action="POST">
                <div class="field input">
                    <label for="">email</label>
                    <input type="email" name="email" autocomplete="off">
                </div>
                <div class="field input">
                    <label for="">password</label>
                    <input type="password" name="password" class="password" autocomplete="off">
                    <i class="fas fa-eye hide-password"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Continue to chat">
                </div>
                <div class="error-txt">This is an error messsage</div>
            </form>
            <div class="link">Don't have an accout? <a href="index.php">Signup</a></div>
        </section>
    </div>
    <script src="./js/login.js"></script>
    <script src="./js/hide_show_password.js"></script>
</body>

</html>