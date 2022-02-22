<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>PillPal</title>
  </head>
  <body>

  	<?php
            $servname = 'localhost';
            $dbname = 'pillpal';
            $user = 'root';
            $pass = '';
            
            try{
                $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "CREATE TABLE fiche(
                        Nom VARCHAR(30) NOT NULL,
                        Prenom VARCHAR(50) NOT NULL,
						Email VARCHAR(50) NOT NULL,
						Phone VARCHAR(50) NOT NULL,
                        Password VARCHAR(200) NOT NULL,
                        UNIQUE(Phone))";
                
                $dbco->exec($sql);
            }
            
            catch(PDOException $e){
              // echo "Erreur : " . $e->getMessage();
            }
    ?>

        <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form" method="POST">
            <h2 class="title">Log in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Numéro de téléphone" name="Phone" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Mot de passe" name="Password" />
            </div>
            <input type="submit" value="Se connecter" class="btn solid" />
            
          </form>
          <form action="#" class="sign-up-form" method="POST">

            <h2 class="title">Se connecter</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Nom du patient" name="Nom" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Prénom du patient" name="Prenom" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email du médecin" name="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="text" placeholder="Numéro de téléphone" name="Phone" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Mot de passe" name="Password" />
            </div>
            <input type="submit" class="btn" value="Créer un compte" />
          
          </form>
        </div>
    </div>
         <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Créer un compte</h3>
            <p><br></p>
            <button class="btn transparent" id="sign-up-btn">
             Sign up 
            </button>
          </div>
          <img src="img/doctor.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Vous avez déjà un compte ?</h3>
            <p><br></p>

            <button class="btn transparent" id="sign-in-btn" type="submit">
              Se connecter
            </button>
          </div>
          <img src="img/doc.png" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  
	<?php
	function test_input($par) {
	    $par = trim($par);
	    $par = stripslashes($par);
	    $par = htmlspecialchars($par);
	    return $par;
	}


		if ((!empty($_POST['Nom'])) && (!empty($_POST['Prenom'])) && (!empty($_POST['Email'])) && (!empty($_POST['Phone']))&& (!empty($_POST['Password'])))
		{
			$Nom=test_input($_POST['Nom']);
			$Prenom=test_input($_POST['Prenom']);
			$Email=test_input($_POST['Email']);
			$Phone=test_input($_POST['Phone']);
			$Password=test_input($_POST['Password']);
			

			$sq=new PDO ("mysql:host=localhost;dbname=pillpal",'root','');
			$sq->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


			if (!filter_var($Email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z-' ]*$/",$Nom) || !preg_match("/^[a-zA-Z-' ]*$/",$Prenom) || !preg_match("/^[0][0-9]{9}$/",$Phone)){
				echo " <aside>Le format des noms, numéro de téléphone ou email est invalide !<aside> ";
			}

			else{

					$table1 = $sq->prepare(" SELECT `Phone` FROM `fiche` ");
					$table1->execute();
					$pat1 = $table1->fetchAll();
					$d=0;
					foreach ( $pat1 as $i )
					{
						if ($Phone == $i['Phone'] )
						{
							$d=1;
							
						}
					}
					if ($d==1)
					{
							echo " <aside>Ce compte existe déjà </aside> ";
					}
					else
					{
						$statement1 = $sq->prepare("INSERT INTO fiche(Nom,Prenom,Email,Phone,Password) VALUES (?,?,?,?,?)");
						$statement1->execute(array($Nom,$Prenom,$Email,$Phone,$Password));

						echo " <aside>Vous êtes bien inscrit ! <aside> ";
					}
				
				
				
				}
			}	
		
	?>




	<?php

			$conn=new PDO ("mysql:host=localhost;dbname=pillpal",'root','');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if ((!empty($_POST['Phone'])) && (!empty($_POST['Password']))) 
		{
			$sign_mail_or_phone=htmlspecialchars($_POST['Phone']);
			$sign_passwd=htmlspecialchars($_POST['Password']);


				$tab1 = $conn->prepare(" SELECT `Nom`, `Prenom`, `Email`, `Phone`, `Password` FROM `fiche` ");
				$tab1->execute();
				$pat1 = $tab1->fetchAll();
				foreach ( $pat1 as $y )
				{
					if ( $sign_mail_or_phone == $y['Phone'] &&  $sign_passwd == $y['Password'] )
					{
						$_SESSION['Nom'] = $y['Nom'];
						$_SESSION['Prenom'] = $y['Prenom'];
						$_SESSION['Email']=$y['Email'];
						$_SESSION['Phone']=$y['Phone'];
						$_SESSION['Password']=$y['Password'];

						$link="<script> window.open('index.php','_self')</script>";
						echo $link;
					}
					else{
						
						echo "<aside>Identifiant ou mot de passe incorrets !<br> </aside>";
					}
				}
			
			
		}
	?>


<style>
	aside{
  position: absolute;
  bottom: 10px;
  right: 20px;
  color: #d2b9dd;
}
</style>

</body>
</html>


