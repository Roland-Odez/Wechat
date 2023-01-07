<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php';
    if (!$_SESSION['unique_id']) {
        header("location: index.php");
    }
    ?>
    <title>chat - page</title>
</head>

<body>
    <div class="wrapper">
        <section class="chat-area">
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
                <div class="content">
                    <div class="details">
                        <span><?php echo ucfirst($user["fName"]) . " " . ucfirst($user["lName"]) ?></span>
                        <p></p>
                    </div>
                </div>
            </header>
            <div class="chat-box">
            </div>
            <p class="down"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                </svg>
            </p>
            <form action="#" method="POST" class="typing-area">
                <input type="hidden" name="incoming_id" value="<?php echo $user['unique_id'] ?>">
                <input type="hidden" name="outgoing_id" value="<?php echo $_SESSION['unique_id'] ?>">
                <input type="text" name="message" placeholder="type a message here..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
        <script src="./js/chat.js"></script>
</body>

</html>