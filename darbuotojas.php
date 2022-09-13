<?php

include("dblogin.php");
$sql="SELECT employees.*,positions.name as positions_name FROM employees 
LEFT JOIN positions ON employees.positions_id=positions.id 
WHERE employees.id=?";
$sql2="SELECT projects.name as projektas FROM employees 
LEFT JOIN positions ON employees.positions_id=positions.id 
LEFT JOIN employees_projects ON employees.id=employees_id
LEFT JOIN projects ON projects.id=projects_id
WHERE employees.id=?";
//$sql="SELECT * FROM employees WHERE id=?";
$result=$pdo->prepare($sql);
$result->execute([$_GET['id']]);
$employees=$result->fetchAll(PDO::FETCH_ASSOC);

$result=$pdo->prepare($sql2);
$result->execute([$_GET['id']]);

$employees2=$result->fetchAll(PDO::FETCH_ASSOC);
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
		<div class="row">
	
				<div class="card mt-3">
				
				<div class="card-header">
                <?php foreach($employees as $employee){ 
                    $alga = $employee['salary']/100;
                    ?>
                    
					<h1><?=$employee['name']?> <?=$employee['surname']?> / <?=$employee['gender']?></h1>
				</div>
				<div class="card-body">
				<div class="col-md-6 d-flex flex-row">
				
			<div class="col-md-8 ">
				
				<p>
					<b>Išsilavinimas: </b> <br /> <?=$employee['education']?>
				</p>
				<p class="text-center">
					<b>Pareigos: </b> <br /> <?=$employee['positions_name']?>
				</p>
				
				<p>
					<b>Mėnesinė alga: </b> <br /><?=$alga?> EUR
				</p>
				</div>
			
			<div class="col-md-6">
					<div>
				<p>
					<b>Telefonas: </b> <br /> <?=$employee['phone']?>
				</p>
				</div>
                <?php } ?>
				<h4>Projektų sąrašas:</h4>
				<?php foreach($employees2 as $employee1){ 
					
					?>
				<span><?=($employee1['projektas'] > 0)? $employee1['projektas'] :'Nėra priskirtų projektų'?></span><br>                    
					<?php } ?>
			</div>
				</div>
			</div>
		</div>
			</div>
					<div class="row">
			<div class="card mt-5 mb-5">
			

				<div class="card-body">
				<div class="col-md-4">
					<div class="card-header">Mokesčiai</div>

					<table class="table  table-hover">
                    <?php foreach($employees as $employee){ ?>
						<tr>
							<td>Priskaičiuotas atlyginimas „ant popieriaus“:</td>
							<td class="curr"><?=$alga?></td>


						</tr>
						<tr>
							<td>Pritaikytas NPD</td>
							<td class="curr">
                            <?php if($alga<=1704) {
                             $NPD=  540 - 0.34 *($alga - 730); 
                            } else {
                              $NPD=  400 - 0.18 * ($alga - 642);
                            }
                            echo $NPD;
                                ?>
                            </td>


						</tr>
						<tr>
							<td>Gyventojų pajamų mokestis 20 %:</td>
							<td class="curr"><?=$GPM = ($alga - $NPD) * 0.2?></td>


						</tr>
						<tr>
							<td>Sveikatos draudimas 6.98 %:</td>
							<td class="curr"><?=$PSD = $alga *0.0698?></td>


						</tr>
						<tr>
							<td>Soc. draudimas 12.52 %:</td>
							<td class="curr"><?=$VSD = $alga *0.1252?></td>


						</tr>

						<tr class="info">
							<td>Išmokamas atlyginimas „į rankas“:</td>
							<td class="curr"><b><?=$rankos = $alga - $GPM - $PSD - $VSD?></b></td>
						</tr>

						<tr>
							<td colspan="2"><b>Darbo vietos kaina</b></td>
						</tr>

						<tr>
							<td>Sodra 1.77 %:</td>
							<td class="curr"><?=$darbdavioSodra = $alga * 0.0177?></td>
						</tr>

						<tr>
							<td>Garantinis fondas 0.16 %:</td>
							<td class="curr"><?=$darbdavioGarFondas = $alga * 0.0016?></td>

						</tr>
						<tr class="info">
							<td>Visa darbo vietos kaina :</td>
							<td class="curr"><b><?=$alga + $darbdavioSodra?></b></td>
                            <?php } ?>
						</tr>
					</table>
				</div>
			</div>

			</div>
			
		</div>
</div>
	</div>
    
</body>
</html>