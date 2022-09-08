<?php
 include ("dblogin.php");
  if (isset($_POST['action']) && $_POST['action']=='update'){
    $sql="UPDATE employees SET name=?, surname=?, gender=?, phone=?, birthday=?, education=?, salary=? WHERE id=?";
    $stm=$pdo->prepare($sql);
    $stm->execute([ $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['phone'], $_POST['birthday'], $_POST['education'], $_POST['salary'],$_POST['id']]);
    header("location:darbuotojai.php");
    die();
  }
  $employee=[];
  if (isset($_GET['id'])){
    $sql="SELECT * FROM employees WHERE id=?";
    $stm=$pdo->prepare($sql);
    $stm->execute([$_GET['id']]);
    $employee=$stm->fetch(PDO::FETCH_ASSOC);
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
    <title>Darbuotojo duomenų redagavimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5 mb-5">
                    <div class="card-header">Redaguoti darbuotojo informaciją</div>
                    <div class="card-body">
                        <?php
                            if (isset($klaida)){
                                ?>
                                <div class="alert alert-danger"><?=$klaida?></div>
                                
                                <?php
                            }
                        ?>
                        <form action="" method="POST">
                        <input type="hidden" name="action" value="update"> 
                            <input type="hidden" name="id" value="<?=$employee['id']?>" >
                            <div class="mb-3">
                                <label for="" class="form-label">Vardas</label>
                                <input name="name" type="text" class="form-control" value="<?=$employee['name']?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Pavardė</label>
                                <input name="surname" type="text" class="form-control" value="<?=$employee['surname']?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lytis</label>
                                <br>
                                <select name="gender" id="file"  value="<?=$employee['gender']?>">
                                <option value="gender">Pasirinkite lytį</option>
                                <option value="Vyras">Vyras</option>
                                <option value="Moteris">Moteris</option>     
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Telefonas</label>
                                <input name="phone" type="text" class="form-control"  value="<?=$employee['phone']?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Gimimo data</label>
                                <input name="birthday" type="text" class="form-control"  value="<?=$employee['birthday']?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Išsilavinimas</label>
                                <input name="education" type="text" class="form-control"  value="<?=$employee['education']?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Atlyginimas</label>
                                <input name="salary" type="text" class="form-control"  value="<?=$employee['salary']?>">
                            </div>
                            <button class="btn btn-success">Redaguoti</button>
                            <a href="darbuotojai.php" class="btn btn-info float-end">Atgal</a>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>