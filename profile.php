<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php';
    if (!$_SESSION['unique_id']) {
        header("location: index.php");
    }
    ?>
    <title>profile - page</title>
</head>

<body>
    <div class="wrapper">
        <section class="profile">
            <header>
                <?php
                include_once './php/config.php';
                $unique_id = $_GET['unique_id'];
                $sql = "SELECT * FROM users WHERE unique_id = :unique_id";
                $statement = $pdo->prepare($sql);
                $statement->execute([":unique_id" => $unique_id]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="./users.php"><i class="fas fa-arrow-left"></i></a>
                <p>Profile</p>
            </header>
            <form method="post" enctype="application/x-www-form-urlencoded">
                <div class="avatar">
                    <div class="profile-pic">
                        <img src="./upload/<?php echo $user["profile_pic"] ?>" alt="profile-pic">
                        <input type="file" class="file" name="profile_pic" id="file-input" hidden>
                        <label class="label" for="file-input"><i class="fa-solid fa-camera"></i></label>
                    </div>
                </div>
                <div class="input-field">
                    <span><i class="fa-solid fa-at"></i></span>
                    <div>
                        <label>Email</label>
                        <input type="text" name="email" readonly value="<?php echo $user["email"] ?>">
                    </div>
                </div>
                <div class="input-field">
                    <span><i class="fa-solid fa-user"></i></span>
                    <div>
                        <label>Name</label>
                        <input type="text" name="name" readonly autocomplete="off"
                            value="<?php echo $user["fName"] . " " . $user["lName"] ?>">
                        <p>This is not your username. write your full name seperated by comma (,).</p>
                    </div>
                    <span class="icon"><i class="fa-solid fa-pen" title="name"></i></span>
                </div>
                <div class="input-field">
                    <span><i class="fa-solid fa-circle-info"></i></span>
                    <div>
                        <label>About</label>
                        <input type="text" name="about" autocomplete="off" readonly
                            value="<?php echo $user["about"] ?>">
                    </div>
                    <span class="icon"><i class="fa-solid fa-pen" title="about"></i></span>
                </div>
                <div class="update">
                    <button type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
            </form>
        </section>
    </div>
    <script>
    // set profile photo
    const file = document.querySelector('.file'),
        profile = document.querySelector('.profile form .profile-pic img');
    file.addEventListener('change', (e) => {
        profile.src = URL.createObjectURL(e.target.files[0]);
        document.querySelector(".profile form .update").style.visibility = "visible"
    })
    </script>
    <script src="./js/profile.js"></script>
</body>

</html>