

<?php
	try {

		// localhost
		// $pdoConnect = new PDO("mysql:host=localhost;dbname=pabids", "root", "");

		// Live
		$pdoConnect = new PDO("mysql:host=localhost;dbname=u297724503_pabids", "u297724503_pabids", "Pabids_2023$");
		$pdoConnect->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

	}
	catch (PDOException $exc){
		echo $exc -> getMessage();
	}
    catch (PDOException $exc){
        echo $exc -> getMessage();
    exit();
    }
?>