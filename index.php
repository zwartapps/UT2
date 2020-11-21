<?php
//Arrancamos session con su nombre
session_name('Adivinar');
session_start();

//declaramos variables y el boton de empezar de nuevo
$numeros[] = "";
$numero = "";
$frase1 = "";
$frase2 = "";
$frase3 = "";
$ganado = false;
$resetButton = '<button class="btn btn-danger" type="submit" name="reset">Empezar de nuevo</button>';

//Creamos variables de session y el numero aleatorio
if (!isset($_SESSION['adivina'])) {
	$_SESSION['adivina'] = rand(1, 20);
} 

if (isset($_SESSION['adivina'])) {
	$adivina = $_SESSION['adivina'];
}

//Contador para los numeros de intentos
if (!isset($contador)) {
	$contador = 5;
}

if (!isset($_SESSION['counter'])) {
	$_SESSION['counter'] = 5;
}

if (!isset($_SESSION['numeros'])) {
	$_SESSION['numeros'] = array();
	$contador = "";
}

//Cuando puslamos Adivinar hacemos las comprobaciones
if (isset($_POST['numero'])) {
	$numero = $_POST['numero'];
	$_SESSION['counter'] -= 1;
	array_push($_SESSION['numeros'], $numero);
	$frase1 = "El número introducido es " . $numero;
	if ($numero < $adivina) {
		$frase2 = "El número es menor que el numero a adivinar";
	} else {
		$frase2 = "El número es mayor que el numero a adivinar ";
	}
	if ($numero == $adivina) {
		$frase3 = "¡Ha acertado el número!" . '<br>' .
			"El número a adivinar era el " . $adivina;
		$ganado = true;
	}
}

$contador = $_SESSION['counter'];

//Cuando se pulsa el boton para empezar de nuevo destruimos session y borramos los valores
if (isset($_POST['reset'])) {	
	unset($adivina);
	unset($_POST['numero']);
	session_destroy();
	header('index.php');
}

?>

<!DOCTYPE html>

<head>
	<?php include("lib/header.php") ?>
	<title>UT2_1</title>
</head>

<body>
	<div class="container">
		<h2>Adivinar numero</h2>
		<form class="form-horizontal" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
			<div class="form-group">
				<label for="numero" >Introduzca un numero (1 - 20):</label>
				<input type="number" id="numero" placeholder="1-20" name="numero" min="1" max="20" size="50">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="submit" <?php if ($ganado == true || $contador == 0) { ?> disabled <?php   } ?>>Adivinar</button>
		</div>
	</div>

	<div class="container">
		<?php

		if ($contador > 0) {
			if (isset($_POST['numero']) && $ganado == false) {
				echo $frase1 . '<br>';
				echo $frase2 . '<br>';
				echo "Le quedan " . $contador . ' intentos <br>';
			}
		} else {
			echo "Se le han agotado los intentos " . '<br>';
			echo "No ha acertado el número <br><br>";
			echo $resetButton;
		}

		if ($contador > 0 && $ganado == true) {
			echo $frase3 . '<br>' . '<br>';		
			echo $resetButton;
		}

		// Quitar el comentario para ver el numero a adivinar
		/*
		echo '<br>';
		if (isset($adivina)) {
			echo $adivina;
		};
		*/
		?>
	</div>
</body>

<footer class="footer">
	<!-- Incluimos el footer -->
	<?php include('footer.php'); ?>
</footer>
<html>