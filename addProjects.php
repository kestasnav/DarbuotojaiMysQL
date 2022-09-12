<?php
 include ("dblogin.php");
  if (isset($_POST['action']) && $_POST['action']=='insert'){   
   
    $sql="INSERT INTO employees_projects (projects_id, employees_id) VALUES (?, ?)";
    $stm=$pdo->prepare($sql);
    $stm->execute([ $_POST['projects_id'], $_GET['id']]);
   
    header("location:darbuotojai.php");
    die();
    
  }
  if (isset($_GET['id'])){

    $sql="SELECT * FROM projects";
    $stm=$pdo->prepare($sql);
    $stm->execute([]);
    $projects=$stm->fetchAll(PDO::FETCH_ASSOC);
  }else{
    header("location:darbuotojai.php");
    die();
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektų priskyrimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5 mb-5">
                    <div class="card-header">Priskirti darbuotojui projektą</div>
                    <div class="card-body">
                        <?php
                            if (isset($klaida)){
                                ?>
                                <div class="alert alert-danger"><?=$klaida?></div>
                                
                                <?php
                            }
                        ?>
                        <form action="" method="POST">
                        <input type="hidden" name="action" value="insert"> 
                           
                            <div class="mb-3">
                                <label for="" class="form-label">Projektai: </label>
                                <select name="projects_id" class="form-control mb-3">
                                    <?php foreach($projects as $project){ ?>
                                        
                                    <option value="<?=$project['id']?>" ><?=$project['name']?></option>
                                    <?php } ?>  
                                </select>
                            <button class="btn btn-success">Redaguoti</button>
                            <a href="darbuotojai.php" class="btn btn-info float-end">Atgal</a>


                        </form>

                        </div>
                </div>
            </div>
        </div>
    </div>