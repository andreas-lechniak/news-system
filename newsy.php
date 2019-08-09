<?php 
	
	//Połączenie z serwerem - zapleczem operacyjnym niniejszej strony
	include('newsy-serwer.php');
	
	//Funkcja - przytnij w opisie
	function przytnij($txt, $limit)
	{
	  if (strlen($txt)<=$limit)
	  {
		return $txt;
	  } 
	  else 
	  {
		$txt = trim(preg_replace("/^(.+)\b.+/", "$1", substr($txt, 0, $limit)));
		return $txt."...";
	  }
	}
	
	//Wyświetlanie edytowanego POSTU na bieżącej stronie
	if(isset($_GET['edycja']))
	{
		$id = $_GET['edycja'];
		$update = true;
		$record = mysqli_query($link, "SELECT * FROM newsy WHERE id='$id'");
		if (@count($record) == 1)
		{
			$n = mysqli_fetch_array($record);
			$id = $n['id'];
			$autor = $n['autor'];
			$email = $n['email'];
			$tytul = $n['tytul'];
			$tresc = $n['tresc'];
			$kategorie = $n['kategorie'];
		}
	}
	
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<meta name="keyword" content="System newsów" />
		<meta name="description" content="System newsów" />
		<title>System newsów</title>
	</head>
	<body>
		<div>
			<form action="newsy-serwer.php" method="POST">
				<h3>Dodaj newsa</h3>
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				News zostanie zapisany / edytowany z dzisiejszą datą: <b><?php echo date("Y-m-d"); ?></b> <br /><br />
				Autor [Imię i nazwisko]: <input type="text" name="autor" value="<?php echo $autor; ?>" placeholder="Imię i nazwisko autora"><br /><br />
				Adres e-mail autora: <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Adres e-mail autora"><br /><br />
				Tytuł newsa: <input type="text" name="tytul" value="<?php echo $tytul; ?>" placeholder="Tytuł newsa"><br /><br />
				Treść newsa: 
				<textarea rows="6" cols="30" name="tresc" value="" placeholder="Wpisz treść newsa"><?php echo $tresc; ?></textarea><br /><br />
				Wybierz kategorię: 
				<select name="kategorie" value="<?php echo $kategorie; ?>">
					<option>Bez kategorii</option>
					<option>Sprawy bieżące</option>
					<option>Sport</option>
					<option>Informatyka</option>
				</select><br />
				<input type="hidden" name="data_dodania"><br />
				<?php if ($update == true): ?>
				<p>Edycja rekordu o nr ID: <b><?php echo $id; ?></b> i bieżącej kategorii <b><?php echo $kategorie; ?></b></p>
				<input type="hidden" name="data_edycji" value="<?php echo(date('Y-m-d H:i:s')); ?>"><br />
				<input type="submit" name="update" value="Uaktualnij">
				<?php else: ?>
				<input type="submit" name="zapisz" value="Zapisz"> <input type="reset" value="Wyczyść">
				<?php endif ?>
			</form>
		</div>
		
		<br /><br />
		
		<div>
			<h3>Zapisane Newsy</h3>
			<?php
				$results = mysqli_query($link,"SELECT * FROM newsy");
				echo '<table>
						<tr>
						<th>ID</th>
						<th>Autor</th>
						<th>Adres e-mail</th>
						<th>Tytuł newsa</th>
						<th>Skrót treści</th>
						<th>Kategoria</th>
						<th>Data dodania</th>
						<th>Data edycji</th>
						<th>Działania rekordu</th>
						</tr>';
				while($row = mysqli_fetch_array($results))
				{
					echo '<tr>
							<td>'.$row['id'].'</td>
							<td>'.$row['autor'].'</td>
							<td>'.$row['email'].'</td>
							<td>'.$row['tytul'].'</td>
							<td>'.przytnij($row['tresc'],100).'</td>
							<td>'.$row['kategorie'].'</td>
							<td>'.$row['data_dodania'].'</td>
							<td>'.$row['data_edycji'].'</td>
							<td>
								<a href="newsy-serwer.php?wyslij_list='.$row['id'].'" title="Wyślij email do autora o edycji postu">Wiadomość</a> | 
								<a href="newsy-serwer.php?pokaz='.$row['id'].'" title="Pokaż całą wiadomość">Pokaż</a> | 
								<a href="newsy.php?edycja='.$row['id'].'" title="Edytuj newsa">Edycja</a> | 
								<a href="newsy-serwer.php?usun='.$row['id'].'" OnClick="return confirm(\'Czy na pewno chcesz skasować POST?\');" title="Usuń newsa z bazy">Usuń</a>
							</td>
						  </tr>';
				}
					echo '</table>';
			?>
		</div>
		
		<div>		
			<?php
			
				//Wyświetlanie ilości wszystkich NEWSÓW w serwisie
				$results = mysqli_query($link, "SELECT count(id) AS ilosc FROM newsy");
				$row = mysqli_fetch_array($results);
				$ile_newsow = $row['ilosc'];
				echo '<p>Wszystkich newsów w bazie jest: <b>'.$ile_newsow.'</b>';
			?>
		</div>
		
		<div>
			<?php
			
				//Wyświetlanie ilości wszystkich NEWSÓW bez przypisanej jednej, konkretnej kategorii
				$results = mysqli_query($link, "SELECT count(id) AS ilosc FROM newsy WHERE kategorie='Bez kategorii'");
				$row = mysqli_fetch_array($results);
				$ile_bez_kategorii = $row['ilosc'];
				echo '<p>Newsów w bazie <b>bez przypisanej kategorii</b> jest: <b>'.$ile_bez_kategorii.'</b>';
			?>
		</div>
		
	</body>
</html>