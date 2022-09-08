<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    }
    include("dblogin.php");
    
     //$name = $surname = $gender = $phone = $birthday = $education = $salary ="";
    $error = [];
    if (isset($_POST['action']) && $_POST['action'] == 'insert') { 
      $name = test_input($_POST["name"]);
      $surname = test_input($_POST["surname"]);
      $gender = test_input($_POST["gender"]);
      $phone = test_input($_POST["phone"]);
      $birthday = test_input($_POST["birthday"]);
      $education = test_input($_POST["education"]);
      $salary = test_input($_POST["salary"]);
    
      if(empty($name)) {
        $error['vardas'] = "Vardas privalomas";
      } else {
        if (strlen($name) < 3) {
            $error['vardas'] = "Vardas per trumpas";
      }
      }
      if(empty($surname)) {
        $error['pavarde'] = "Pavardė privaloma";
      } else {
        if (strlen($name) < 3) {
            $error['pavarde'] = "Pavardė per trumpa";
      }
      }
   
if(empty($error)){
        $sql="INSERT INTO employees (name, surname, gender, phone, birthday, education, salary) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stm=$pdo->prepare($sql);
        $stm->execute([ $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['phone'], $_POST['birthday'], $_POST['education'], $_POST['salary']]);
        header("location:darbuotojai.php");
        die();
    }
   
    }
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naujo darbuotojo sukūrimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5 mb-5">
                    <div class="card-header">Pridėti naują darbuotoją</div>
                    <div class="card-body">
                        
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert"> 
                            <div class="mb-3">
                                <label for="" class="form-label">Vardas</label>
                                <input name="name" type="text" class="form-control" >
                             
                          
                                <?php if (isset($error['vardas'])){ echo'<div class="alert alert-danger w-25 text-center">'. $error['vardas'].'</div>';}?>
                                
                        
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Pavardė</label>
                                <input name="surname" type="text" class="form-control" >
                                <?php if (isset($error['pavarde'])){ echo'<div class="alert alert-danger w-25 text-center">'. $error['pavarde'].'</div>';}?>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lytis</label>
                                <br>
                                <select name="gender">
                                <option value="gender">Pasirinkite lytį</option>
                                <option value="Vyras">Vyras</option>
                                <option value="Moteris">Moteris</option>     
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Telefonas</label>
                                <input name="phone" type="text" class="form-control"  >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Gimimo data</label>
                                <input name="birthday" type="text" class="form-control"  >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Išsilavinimas</label>
                                <input name="education" type="text" class="form-control"  >
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Atlyginimas</label>
                                <input name="salary" type="text" class="form-control" placeholder="Vesti sumą centais" >
                            </div>
                            <button class="btn btn-success">Pridėti</button>
                            <a href="darbuotojai.php" class="btn btn-info float-end">Atgal</a>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>