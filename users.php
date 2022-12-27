<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php';
    if (!$_SESSION['unique_id']) {
        header("location: index.php");
    }
    ?>
    <title>user - page</title>
</head>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                include_once './php/config.php';
                $sql = "SELECT * FROM users WHERE unique_id = :unique_id";
                $statement = $pdo->prepare($sql);
                $statement->execute([":unique_id" => $_SESSION["unique_id"]]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                ?>
                <div class="content">
                    <img src="./upload/<?php echo $user["profile_pic"] ?>" alt="<?php echo $user["fName"] ?>">
                    <div class="details">
                        <span><?php echo ucfirst($user["fName"]) . " " . ucfirst($user["lName"]) ?></span>
                        <p class="online"><?php echo ($user["status"]) ? "online" : "offline" ?></p>
                    </div>
                </div>
                <a href="./php/logout.php" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select a user to start chat</span>
                <input type="text" name="searchBar" class="active" placeholder="Enter name to search...">
                <button class="active"><i class="fas fa-search active"></i></button>
            </div>
            <div class="users-list">
            </div>
        </section>
    </div>
    <script>
    const searchBar = document.querySelector(".users .search input"),
        searchBtn = document.querySelector(".users .search button"),
        usersList = document.querySelector('.users .users-list');

    searchBtn.onclick = () => {
        searchBar.classList.toggle("active")
        searchBar.focus()
        document.querySelector(".users .search button i").classList.toggle("active")
    }

    searchBar.onblur = (e) => {
        usersList.classList.remove("active")
        e.target.value = ""
    }
    </script>
    <script src="./js/users.js"></script>
</body>

</html>