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
                <a href="./profile.php?unique_id=<?php echo $_SESSION["unique_id"] ?>" class="content">
                    <img src="./upload/<?php echo $user["profile_pic"] ?>" alt="<?php echo $user["fName"] ?>">
                    <div class="details">
                        <span><?php echo ucfirst($user["fName"]) . " " . ucfirst($user["lName"]) ?></span>
                        <p class="online"><?php echo $user["about"] ?></p>
                    </div>
                </a>
                <div class="options">
                    <a href="./php/logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                </div>
            </header>
            <div class="search">
                <span class="text">Select a user to start chat</span>
                <input type="text" name="searchBar" placeholder="Enter name to search...">
                <button class="active"><i class="fas fa-search"></i></button>
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