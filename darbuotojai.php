<?php

include("dblogin.php");

$workers="SELECT * FROM employees";
$positions="SELECT * FROM positions";
$result=$pdo->query($workers);
$positionsResult=$pdo->query($positions);


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
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Vardas</th>
                                <th>Pavardė</th>
                                <th>Gimimo data</th>
                                <th>Atlyginimas</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employees as $employee){ ?>
                                <tr>
                                    <td><?=$employee['name']?></td>
                                    <td><?=$employee['surname']?></td>
                                    <td><?=$employee['birthday']?> M</td>
                                    <td><?=$employee['salary']/100?> EU</td>
                                    <td><a class="btn btn-success" href="darbuotojas.php?id=<?=$employee['id']?>">Detaliau</a>
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
                                    <th>Darbuotojų pareigos</th>
                                    <th>Baziniai atlyginimai</th>
                                    <th></th>                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($positions as $position){ 
                                $bazineAlga = $position['base_salary']/100;
                                ?>
                                <tr>
                                    <td><?=$position['name']?></td>
                                    <td><?=$bazineAlga?> EU</td>
                                    <td><a href="#" class="btn btn-primary">Rodyti darbuotojus</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>