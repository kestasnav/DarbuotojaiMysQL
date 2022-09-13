
<?php

include("dblogin.php");
$sql="SELECT *, employees.name as vardas, employees.surname as pavarde, positions.name as pareigos FROM employees 
LEFT JOIN positions ON positions.id=employees.positions_id WHERE positions.id=?";
//$sql="SELECT * from positions where id=?";
$result=$pdo->prepare($sql);
$result->execute([$_GET['id']]);

$employees=$result->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbuotojo kortelė</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style type="text/css">
.curr {
	text-align: right;
}
</style>
</head>
<body>
<div class="container" id="content" tabindex="-1">
	<a class="btn btn-primary mt-3" href="darbuotojai.php">Grįžti į darbuotojų sąrašą</a>
	<div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vardas</th>
                                    <th>Pavardė</th>
                                    <th>Pareigos</th>
                                    <th></th>                                   
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <?php foreach($employees as $employee){ 
                   
                   ?>               <td><?=$employee['vardas']?></td>
                                    <td><?=$employee['pavarde']?></td>
                                    <td><?=$employee['pareigos']?></td>                                    
                                    </tr>
                                <?php }  ?>
                              
                            </tbody>
                        </table>
                        </div>
                </div>
                            </div>
    
</body>
</html>

