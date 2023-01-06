<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>user - signup</title>
</head>

<body>
    <div class="wrapper">
        <section class="form signup">
            <header>
                WEchat
            </header>
            <form action="#" enctype="application/x-www-form-urlencoded">
                <div class="avatar">
                    <div class="profile-pic">
                        <img src="" alt="img">
                        <input type="file" class="file" name="profile_pic" id="file-input" hidden>
                        <label class="label" for="file-input"><i class="fa-solid fa-plus"></i></label>
                    </div>
                </div>
                <div class="name-details">
                    <div class="field input">
                        <label for="">first name</label>
                        <input type="text" name="fName" autocomplete="off">
                    </div>
                    <div class="field input">
                        <label for="">last name</label>
                        <input type="text" name="lName" autocomplete="off">
                    </div>
                </div>
                <div class="field input">
                    <label for="">email address</label>
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
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
    <script>
    // set profile photo
    const file = document.querySelector('.file'),
        profile = document.querySelector('.form form .profile-pic img');
    file.addEventListener('change', (e) => {
        profile.src = URL.createObjectURL(e.target.files[0]);
    })
    </script>
    <script src="./js//signup.js"></script>
    <script src="./js/hide_show_password.js"></script>
</body>

</html>