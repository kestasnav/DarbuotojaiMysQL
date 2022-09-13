<?php

include("dblogin.php");


 

if (isset($_GET['action']) && $_GET['action']=='delete'){
    $sql="SELECT * FROM employees WHERE id=?";
    $stm=$pdo->prepare($sql);
    $stm->execute([$_GET['id']]);
    $employee=$stm->fetch(PDO::FETCH_ASSOC);

    $sql="DELETE FROM employees WHERE id=?";
    $pstm=$pdo->prepare($sql);
    $pstm->execute([$_GET['id']]);
}

$workers="SELECT * FROM employees ORDER BY salary DESC";

$positions="SELECT *, employees.positions_id, positions.id as emID, positions.name as posName, count(employees.positions_id) as kiekis FROM positions LEFT JOIN employees ON positions_id=positions.id GROUP BY employees.positions_id";

$result=$pdo->query($workers);
$positionsResult=$pdo->query($positions);

$workersAvg=$pdo->query("SELECT *,  count(*) as darbSK, min(salary) as minSal, avg(salary) as avgSal, max(salary) as maxSal FROM employees")->fetchAll(PDO::FETCH_ASSOC);
$gendersM=$pdo->query("SELECT gender, avg(salary) as mot, count(gender) as motKiek FROM employees GROUP BY gender HAVING gender='Moteris'")->fetchAll(PDO::FETCH_ASSOC);
$gendersV=$pdo->query("SELECT gender,  avg(salary) as vyr, count(gender) as vyrKiek FROM employees GROUP BY gender HAVING gender='Vyras'")->fetchAll(PDO::FETCH_ASSOC);
$projektai=$pdo->query("SELECT projects.name as name, projects.id as projID, count(employees_id) as kiekis FROM employees_projects 
LEFT JOIN projects ON projects.id=employees_projects.projects_id GROUP BY projects.name ORDER BY kiekis DESC")->fetchAll(PDO::FETCH_ASSOC);
$tustiprojektai=$pdo->query("SELECT employees.name as vardas, employees.surname as pavarde, positions.name as pareigos FROM employees LEFT JOIN positions ON employees.positions_id=positions.id WHERE employees.id NOT IN (SELECT employees_id FROM employees_projects)")->fetchAll(PDO::FETCH_ASSOC);

$employees=$result->fetchAll(PDO::FETCH_ASSOC);
$positions=$positionsResult->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbuotojai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header"><b>Darbuotojų sąrašas</b></div>
                    <div class="card-body">
                    <a href="create.php" class="btn  btn-primary float-end mb-3">Pridėti naują darbuotoją</a>
                        <table class="table">
                            <thead>
                                <tr class="bg bg-info">
                                <th>Vardas</th>
                                <th>Pavardė</th>
                                <th>Gimimo data</th>
                                <th>Atlyginimas</th>
                                <th></th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employees as $employee){ ?>
                                <tr class="bg bg-light">
                                    <td><?=$employee['name']?></td>
                                    <td><?=$employee['surname']?></td>
                                    <td><?=$employee['birthday']?></td>
                                    <td><?=$employee['salary']/100?> EU</td>
                                    <td><a class="btn btn-success" href="darbuotojas.php?id=<?=$employee['id']?>">Detaliau</a>
                                    </td>
                                    <td>
                                        <a href="addProjects.php?id=<?=$employee['id']?>" class="btn btn-warning">Priskirti projektą</a>
                                        <a href="update.php?id=<?=$employee['id']?>" class="btn btn-info">Redaguoti</a>
                                        <a href="darbuotojai.php?action=delete&id=<?=$employee['id']?>" class="btn btn-danger">Ištrinti</a>

                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-3 mb-3">
                    <div class="card-header"><b>Pareigų sąrašas</b></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Darbuotojų pareigos</th>
                                    <th class="text-center">Baziniai atlyginimai</th>
                                    <th class="text-center">Darbuotojų skaičius</th>
                                    <th></th>                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($positions as $position){ 
                                
                                $bazineAlga = $position['base_salary']/100;
                                ?>
                               
                                <tr>
                                    <td class="text-center"><?=$position['posName']?></td>
                                    <td class="text-center"><?=$bazineAlga?> EU</td>
                                    
                                     <td class="text-center"><?=$position['kiekis']?></td>
                                    
                                    <td><a class="btn btn-success" href="darbuotojuPareigos.php?id=<?=$position['emID']?>">Rodyti darbuotojus</a></td>
                                    </tr>
                                <?php }  ?>
                              
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        
        
            <div class="col-md-6">
                <div class="card mt-3 mb-3">
                    <div class="card-header"><b>Įmonės statistika</b></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                    <?php foreach($workersAvg as $wrkAvg) { ?>
                                        <?php } ?>  
                                        <?php foreach($gendersM as $genM) { ?>
                                        <?php } ?>
                                        <?php foreach($gendersV as $genV) { ?>
                                        <?php } ?>  
                                <tr>Įmonėje dirbančių darbuotojų skaičius: </tr> <b><span><?=$wrkAvg['darbSK']?></span></b><hr>
                                <tr>Įmonėje dirbančių moterų skaičius: </tr> <b><span><?=$genM['motKiek']?></span></b><hr>
                                <tr>Įmonėje dirbančių vyrų skaičius: </tr> <b><span><?=$genV['vyrKiek']?></span></b><hr>
                                <tr>Vidutinis darbo užmokestis: </tr> <b><span><?=(round($wrkAvg['avgSal']/100,2))?> EU</span></b><hr>
                                <tr>Mažiausias darbo užmokestis: </tr> <b><span><?=$wrkAvg['minSal']/100?> EU</span></b><hr>
                                <tr>Didžiausias darbo užmokestis: </tr> <b><span><?=$wrkAvg['maxSal']/100?> EU</span></b><hr>
                                <tr>Moterų atlyginimo vidurkis: </tr> <b><span><?=(round($genM['mot']/100,2))?> EU</span></b><hr>
                                <tr>Vyrų atlyginimų vidurkis: </tr> <b><span><?=(round($genV['vyr']/100,2))?> EU</span></b><hr>
                                 
                            </thead>                            
                        </table>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
                <div class="card mt-3 mb-3">
                    <div class="card-header"><b>Projektų sąrašas</b></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                 <th class="text-center">Projekto pavadinimas</th>
                                 <th class="text-center">Dirbančių darbotuojų skaičius</th>
                                 <th></th>                                
                                </tr>
                            </thead>   
                            <tbody>
                                <tr>
                                <?php foreach($projektai as $projektas){ ?>
                               <td class="text-center"><?=$projektas['name']?></td>
                               <td class="text-center"><?=$projektas['kiekis']?></td>
                               <td><a class="btn btn-success" href="projektai.php?id=<?=$projektas['projID']?>">Rodyti darbuotojus</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>                         
                        </table>
                        </div>
                </div>
            </div>
        
        <div class="col-md-6">
                <div class="card mt-3 mb-3">
                    <div class="card-header"><b>Darbuotojai kurie nedirba prie jokių projektų</b></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                 <th class="text-center">Vardas</th>
                                 <th class="text-center">Pavardė</th>
                                 <th class="text-center">Pareigos</th>
                                 <th></th>                                
                                </tr>
                            </thead>   
                            <tbody>
                                <tr>
                                <?php foreach($tustiprojektai as $tusti){ ?>
                               <td class="text-center"><?=$tusti['vardas']?></td>
                               <td class="text-center"><?=$tusti['pavarde']?></td>
                               <td class="text-center"><?=$tusti['pareigos']?></td>
                               </tr>
                                <?php } ?>
                            </tbody>                         
                        </table>
                        </div>
                </div>
            </div>
        </div>
     </div>
    </div>
    
</body>
</html>