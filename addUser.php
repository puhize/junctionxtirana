    <?php

    include_once('config.php'); 

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $surname = $_POST["surname"];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "INSERT INTO users (name, surname, email, password) VALUES (:name, :surname, :email, :password )";
        $insertSql = $conn->prepare($sql);

        $insertSql->bindParam(':name', $name);
        $insertSql->bindParam(':surname', $surname);
        $insertSql->bindParam(':email', $email);
        $insertSql->bindParam(':password', $password);

        $insertSql->execute();

        echo "Data saved successfully ...<br>";
        header("Location: index.php");
        exit(); 
    }

    ?>