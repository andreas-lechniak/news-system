<?php
	
	//Nie pokazuje denerwujących błędów i bugów
	error_reporting(E_ALL & ~E_NOTICE);
	
	//Połączenie z bazą danych...
	$link = mysqli_connect("localhost", "root", "", "testowa");
	
	//Pokaż wybraną wiadomość
	if(isset($_GET['pokaz']))
	{
		echo '<h3>Cała wiadomość</h3>';
		$id = $_GET['pokaz'];
		$result = mysqli_query($link,"SELECT * FROM newsy WHERE id='$id'");
		$row = mysqli_fetch_assoc($result);
		echo '<div>
			 Nr z bazy: '.$row['id'].'.<br />
			 Autor: '.$row['autor'].'.<br />
			 Adres email autora: '.$row['email'].'.<br />
			 Kategoria: '.$row['kategorie'].'.<br />
			 Treść POSTA: '.$row['tresc'].'<br />
			 </div>';
		echo '<br />Strona główna <a href="newsy.php">Newsów</a>';
	}

	//Wyślij wiadomość do autora postu
	if(isset($_GET['wyslij_list']))
	{
		$id = $_GET['wyslij_list'];
		$result = mysqli_query($link, "SELECT * FROM newsy WHERE id='$id'");
		$row = mysqli_fetch_assoc($result);
		$autor = $row['autor'];
		$email = $row['email'];
		
		//Wysyłanie przykładowego maila do zapisanego autora w serwisie newsów
		$tresc = "Imie: $imie. Oto wiadomość wysłana z naszego wewnętrznego systemu Newsów.";
		$header =  "From: A L \nContent-Type:".
				   ' text/plain;charset="UTF-8"'.
				  "\nContent-Transfer-Encoding: 8bit";
				
		mail($email, 'Kontakt ze strony www.newsy.pl', $tresc, $header);
		
		//Potwierdzenie wysłania maila
		echo 'Wiadomość odnośnie postu w serwisie Newsów. <br />';
		
		//Przekierowanie na stronę główną
		header('Refresh: 5; URL=newsy.php');
		echo 'Zaraz zostaniesz przekierowany na stronę główną seriwsu...';

	}
	
	//Zapisz post w bazie Newsów
	if(isset($_POST['zapisz']))
	{
		if(isset($_POST['autor']) && isset($_POST['email']) && isset($_POST['tytul']) && isset($_POST['tresc']) && isset($_POST['kategorie']))
		{
			$autor = $_POST['autor'];
			$email = $_POST['email'];
			$tytul = $_POST['tytul'];
			$tresc = $_POST['tresc'];
			$kategorie = $_POST['kategorie'];
			$data_dodania = $_POST['data_dodania'];
			$data_dodania = date('Y-m-d H:i:s');
				
			if(strlen($autor) < 3 || strlen($autor) > 25)
			{
				echo 'Nieprawidłowa długość w wartości <b>Autor</b>. <br />';
				
				//Przekierowanie na stronę główną
				header('Refresh: 3; URL=newsy.php');
				echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
			}
			else if(preg_match('/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]$/', $email))
			{
				echo 'Nieprawidłowa długość w wartości <b>Email</b>. Użyto niedozwolonych znaków. <br />';
				
				//Przekierowanie na stronę główną
				header('Refresh: 3; URL=newsy.php');
				echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
			}
			else if(strlen($tresc) < 3 || strlen($tresc) > 1000)
			{
				echo 'Nieprawidłowa długość w wartości <b>Treść</b>. <br />';
				
				//Przekierowanie na stronę główną
				header('Refresh: 3; URL=newsy.php');
				echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
			}
			else
			{
				
				$result = "INSERT INTO newsy (autor, email, tytul, tresc, kategorie, data_dodania) VALUES('$autor', '$email', '$tytul', '$tresc', '$kategorie', '$data_dodania')";
				if(mysqli_query($link,$result))
				{
					echo 'Zapisano rekord w bazie danych. <br /><br />';
					echo 'Zapisane dane: <br />
					  Autor newsa: <b>'.$autor.'</b><br />
					  Adres e-mail autora: <b>'.$email.'</b><br />
					  Tytuł newsa: <b>'.$tytul.'</b><br />
					  Treść newsa: <b>'.$tresc.'</b><br />
					  Kategorie newsa: <b>'.$kategorie.'</b><br />
					  Dane zapisano z datą: <b>'.$data_dodania.'</b><br />';
				
					//Przekierowanie na stronę główną
					header('Refresh: 5; URL=newsy.php');
					echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
				}
				else
				{
					echo "Błąd: " . $result . "<br>" . mysqli_error($link);
				}	
			}
		}
	}
	
	$autor = "";
	$email = "";
	$tytul = "";
	$tresc = "";
	$uid = 0;
	$edit_state = false;
	
	//Edytuj wybraną wiadomość
	if(isset($_POST['update']))
	{
		$id = mysqli_real_escape_string($link,$_POST['id']);
		$autor = mysqli_real_escape_string($link,$_POST['autor']);
		$email = mysqli_real_escape_string($link,$_POST['email']);
		$tresc = mysqli_real_escape_string($link,$_POST['tresc']);
		$tytul = mysqli_real_escape_string($link,$_POST['tytul']);
		$kategorie = mysqli_real_escape_string($link,$_POST['kategorie']);
		$data_edycji = mysqli_real_escape_string($link,$_POST['data_edycji']);
		
		$result = "UPDATE newsy SET autor='$autor', email='$email', tytul='$tytul', tresc='$tresc', kategorie='$kategorie', data_edycji='$data_edycji' WHERE id='$id'";
		if(mysqli_query($link,$result))
		{
			//Wysłanie listu do autora o zmianie jego POSTU
			$result = mysqli_query($link, "SELECT * FROM newsy WHERE id='$id'");
			$row = mysqli_fetch_assoc($result);
			$autor = $row['autor'];
			$email = $row['email'];
			$tytul = $row['tytul'];
			$data_dodania = $row['data_dodania'];
			$data_edycji = $row['data_edycji'];
			
			$tresc = "Imie: $imie. Post napisany przez ciebie w dniu - ".$data_dodania.", o tytule ".$tytul." został zmieniony w dn. ".$data_edycji;
			$header =  "From: A L \nContent-Type:".
					   ' text/plain;charset="UTF-8"'.
					  "\nContent-Transfer-Encoding: 8bit";
					
			mail($email, 'Kontakt ze strony www.newsy.pl', $tresc, $header);

			//Potwierdzenie edycji rekordu i wysłanie potwierdzenia edycji POSTU.
			echo 'Rekord został zmieniony. <br />
				  Wiadomość odnośnie postu w serwisie Newsów. <br />';
			
			//Przekierowanie na stronę główną
			header('Refresh: 5; URL=newsy.php');
			echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
		}
		else
		{
			echo "Błąd: " . $result . "<br>" . mysqli_error($link);
		}
	}
	
	//Usuń wybraną wiadomość
	if(isset($_GET['usun']))
	{
		$id = $_GET['usun'];
		mysqli_query($link, "DELETE FROM newsy WHERE id=$id");
		
		//Potwierdzenie usunięcia rekordu.
		echo 'Rekord został skasowany. <br /><br />';
		
		//Przekierowanie na stronę główną
		header('Refresh: 5; URL=newsy.php');
		echo 'Zaraz zostaniesz przekierowany na stronę główną serwisu...';
	}
	
?>
