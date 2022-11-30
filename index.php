<?php
    $a=0;
    $kontrol=false;
    $task_is_empty=true;
    try{
        $db=new PDO("mysql:host=localhost;dbname=to_do_list; charset=utf8", "root");
        $kontrol=true;
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
    if($kontrol)
    {
        if(isset($_POST['submit']))
        {
            try {
                $task = $_POST['task'];
                if($task) {
                    $SQL = "INSERT INTO tasks (Task) VALUES(:task_)";
                    $ekle = $db->prepare($SQL);
                    $islem = $ekle->execute(
                        array(
                            "task_" => $task
                        )
                    );
                    $task_is_empty=false;
                }
                    //SOR: mysqli_query($db,"SELECT * from tasks") yaptığımızdaki karşılık PDO'DA ne?
            }
            catch(PDOException $e)
            {
                echo "<pre>";
                echo "255 karakterden uzun bir metin yazdınız.";
                echo "</pre>";
                header('Refresh:2;index.php');
            }




        }
        if(isset($_GET['del_task']))
        {
            $id=$_GET['del_task'];
            $SQL="DELETE FROM tasks WHERE ID=$id";
            $silme=$db->prepare($SQL);
            $silme->execute();
            header('Refresh:2;index.php');
        }
        $SQL="SELECT * FROM tasks WHERE 1";
        $sorgu=$db->prepare($SQL);
        $sorgu->execute();
    }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="heading">
        <h2>My To-do list</h2>
    </div>
    <form method="POST" action="index.php" class="add_form">
        <?php if($task_is_empty) {?>
        <p><?php echo "Task can't be empty.";}?></p>

        <input type="text" name="task" class="task_input">
        <button type="submit" class="add_btn" name="submit">Add Task</button>
    </form>
    <table>
        <thead>
        <tr>
            <th>N</th>
            <th>Task</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($sorgu as $row)
        {?>
            <tr>
            <td><?php echo $a+1; ?></td>
            <td class="task"><?php echo $row['Task']?></td>
            <td class="delete">
                <a href="index.php?del_task=<?php echo $row['ID'] ;?>">X</a>
            </td>
            </tr>
            <?php
            $a++;
        }
        ?>
        </tbody>
    </table>
</body>
</html>