<?php
session_start();

$todoList = array();

if (isset($_SESSION["todoList"])) {
    $todoList = $_SESSION["todoList"];
}

function appendData($data) {
    return $data;
}

function deleteData($toDelete, $todoList) {
    foreach ($todoList as $index => $taskName) {
        if ($taskName === $toDelete) {
            unset($todoList[$index]);
        }
    }
    return array_values($todoList); // Reindex the array
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["task"])) {
        echo '<script>alert("Error: there is no data to add in array")</script>';
        exit;
    }
    array_push($todoList, appendData($_POST["task"]));
    $_SESSION["todoList"] = $todoList;
}

if (isset($_GET['task'])) {
    $taskToDelete = urldecode($_GET['task']);
    $todoList = deleteData($taskToDelete, $todoList);
    $_SESSION["todoList"] = $todoList;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #ffe6e6;
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            color: #333333; /* Dark text color */
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #333333; /* Dark border for each box */
        }
        .card-header {
            background-color: #add8e6;
            color: white;
            border-bottom: 2px solid #333333; /* Dark border */
        }
        .card-body {
            background-color: #ffffff;
        }
        .list-group-item {
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #333333; /* Dark border for list items */
        }
        .btn-primary {
            background-color: #add8e6;
            border-color: #333333; /* Dark border */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-danger {
            background-color: #f5c6cb;
            border-color: #333333; /* Dark border */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">To-Do List Application</h1>
        <div class="card">
            <div class="card-header">Add a New Task</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="task" placeholder="Enter your task here">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Tasks</div>
            <ul class="list-group list-group-flush">
                <?php
                foreach ($todoList as $task) {
                    echo '<li class="list-group-item">' . htmlspecialchars($task) . '<a href="?task=' . urlencode($task) . '" class="btn btn-danger btn-sm">Delete</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
