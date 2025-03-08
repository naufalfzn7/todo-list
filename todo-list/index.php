<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="todo-container">
        <h1>To-Do List</h1>
        <form class="todo-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <input type="text" name="task" id="task" placeholder="Tambahkan tugas baru ...">
            <button name="add" type="submit">Tambah</button>
        </form>
        <?php
        //MEMULAI SESSION
        session_start();
        // inisialiasi array untuk daftar todos jika belum ada
        if (!isset($_SESSION['tasks'])) {
            $_SESSION['tasks'] = [];
        }
        //jika ada form yg disubmit akan menambahkan task ke daftar tasks
        if (isset($_POST["add"])) {
            $task = trim($_POST["task"]);
            if (!empty($_POST["task"])) {
                //menambahkan task ke session array todos
                $_SESSION['tasks'][] = $task;
            }
            //redirect untuk menghindara resubmission saat redirect
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
            exit();
        }

        // jika ada request untuk menghapus task/todo

        if (isset($_POST['delete'])) {
            $index_to_delete = $_POST['delete'];
            if (isset($_SESSION['tasks'])) {
                unset($_SESSION['tasks'][$index_to_delete]);
                //reset indeks array setelah penghapusan
                $_SESSION['tasks'] = array_values($_SESSION['tasks']);
            }
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
            exit();
        }

        ?>

        <ul class="todo-list">
            <?php
            foreach ($_SESSION['tasks'] as $index => $task): ?>

                <li>
                    <?= htmlspecialchars($task) ?>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="display: inline;">
                        <input type="hidden" name="delete" value="<?= $index ?>">
                        <button type="submit" class="delete-btn">Hapus</button>
                    </form>
                </li>

            <?php endforeach; ?>



        </ul>

    </div>
</body>

</html>