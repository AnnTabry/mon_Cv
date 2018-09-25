<?php
$destinataire = 'annetabry@gmail.com';

$message_envoye = $message_non_envoye  = $message_erreur_formulaire = $message_formulaire_invalide = "";
$nom = $prenom = $email = $tel = $message = "";
//$firstnameError = $nameError = $emailError = $phoneError = $messageError = "";

    function isPhone($tel) 
    {
        return preg_match("/^[0-9 ]*$/",$tel);
    }


// on teste si le formulaire a été soumis
if (!isset($_POST['envoi'])) // formulaire non envoyé
{
	$message_erreur_formulaire = "Vous devez d'abord <a href=\"../index.html\">envoyer le formulaire</a>.";
}
else
{
	function Rec($text) // pour nettoyer et enregistrer du texte
	{
		$text = htmlspecialchars(trim($text), ENT_QUOTES);
		if (1 === get_magic_quotes_gpc())
		{
			$text = stripslashes($text);
		}

		$text = nl2br($text);
		return $text;
	};

	function IsEmail($email) // pour vérifier la syntaxe d'un email
	{
		$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
		return (($value === 0) || ($value === false)) ? false : true;
	}

	// formulaire envoyé, on récupère tous les champs.
  	$nom     = (isset($_POST['firstname']))? Rec($_POST['firstname'])     : '';
	$prenom  = (isset($_POST['name']))     ? Rec($_POST['name'])   : '';
    $email   = (isset($_POST['email']))    ? Rec($_POST['email'])   : '';
    $tel     = (isset($_POST['phone']))    ? Rec($_POST['phone'])   : '';
	$message = (isset($_POST['message']))  ? Rec($_POST['message']) : '';

	// On va vérifier les variables et l'email ...
	$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré

if (($nom != '') && ($prenom != '') && ($email != '') && ($message != ''))
	{
		// les 4 variables sont remplies, on génère puis envoie le mail
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
                    'Reply-To:'.$email. "\r\n" .
                    'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
                    'Content-Disposition: inline'. "\r\n" .
                    'Content-Transfer-Encoding: 7bit'." \r\n" .
                    'X-Mailer:PHP/'.phpversion();

		// Remplacement de certains caractères spéciaux
		$message = str_replace("&#039;","'",$message);
		$message = str_replace("&#8217;","'",$message);
		$message = str_replace("&quot;",'"',$message);
		$message = str_replace('<br>','',$message);
		$message = str_replace('<br />','',$message);
		$message = str_replace("&lt;","<",$message);
		$message = str_replace("&gt;",">",$message);
		$message = str_replace("&amp;","&",$message);

		// Envoi du mail
		$num_emails = 0;
		$tmp = explode(';', $destinataire);
		foreach($tmp as $email_destinataire)
		{
			if (mail($email_destinataire, $message, $headers))
                $num_emails++;
		}

		if (($num_emails == 2) ||  ($num_emails == 1))
		{
			$message_envoye= "Votre message nous est bien parvenu !";
		}
		else
		{
			$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
		};
	}
	else
	{
		// une des 3 variables (ou plus) est vide ...
		$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
	};
}; // fin du if (!isset($_POST['envoi']))

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="icon" href="https://image.flaticon.com/icons/svg/759/759711.svg" type="image/png">
    <!--     <link rel="icon" href="img/favicon.ico" type="image/x-icon"> -->
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Marcellus+SC" rel="stylesheet">
    <link rel="stylesheet" href="../css/cv.css">
    <title>Anne TABRY - CV </title>
    <meta name="google-site-verification" content="-IRFVkD25cH-boMjb1aBjFQNxjmRPkI0Cb9TAWxSrlg" />
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="50">
    <div class="container-fluid no-gutter p-0">
        <div id="background" class="no-gutter">
             <nav class="navbar navbar-expand-xl navbar-expand-lg nav navbar-dark bg-dark col-md-12 justify-content-around fixed-top"
                id="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header col-xl-3 col-lg-3 col-md-6 d-flex justify-content-between">
                        <h2 id="titre" class="col-md-9">
                            <a class="text-light textnoindent" href="#section1">Anne Tabry</a>
                        </h2>
                        <button class="navbar-toggler hidden-lg-up col-md-6" type="button" data-toggle="collapse"
                            data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse col-xl-6 col-lg-6 col-md-8 col-sm-7 justify-content-end" id="navbarToggleExternalContent">
                        <ul class="navbar-nav ">
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section1">Accueil</a>
                            </li>
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section2">Compétences web</a>
                            </li>
                            <!--
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section2bis">Projets</a>
                            </li>-->
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section3">Formation</a>
                            </li>
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section4">Expériences</a>
                            </li>
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#section5">Portfolio</a>
                            </li>
                            <li class="nav-item nav-link">
                                <a class="text-light btn m-0" href="#formulaire">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- ---------------------------------------------------------------------------------------- -->
            <section class="container text-center" id="section1">
                <br>
                <br>
                <br>
                <br>
                <br>
                <nav class="navbar navbar-expand-lg col-md-12 my-5 box">
                    <form class="form-inline my-2 my-lg-0 col-md-12 p-4">
                        <div class="col-md-3 text-center">
                            <img src="../img/myPhoto.jpg" alt="photo Anne TABRY" id="maphoto" class="rounded-circle mb-5 img-fluid img-thumbnail" />
                            <h1 class="marcellus">Anne Tabry</h1>
                            <p class="my-0 marcellus">34 ans</p>
                            <p class="my-0 marcellus">Cannes, Fr</p>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="typewriter">
                                <h2 class="text-center my-5 marcellus mx-auto">Développeuse web</h2>
                            </div>
                            <hr>
                            <br>
                            <p class="textindent intro text-justify text-left">
                                En formation intensive développement web full-stack avec <a href="https://simplon.co/referentiel/developpeur-web/"
                                    target="_blank" class="text-dark font-weight-bold">Simplon</a>, école labelisée
                                grande école du
                                numérique, je prépare actuellement ma certification RNCP Développeur Logiciel niveau
                                III.
                                <br>
                                Assidue, rigoureuse, motivée, je m'adapte très rapidement à tout type d'environnement.
                                <br>Je serai ravie de mettre à votre disposition mes compétences et qualités acquises
                                au cours de mon parcours afin de vous satisfaire au mieux.<br>N'hésitez pas à me <a
                                    href="#footer">contacter</a> pour davantage d'informations.</p>
                            </p>
                        </div>
                    </form>
                </nav>
            </section>
            <br>
            <br>
            <br>
            <br id="section2">
            <br>
           

            <div class="container text-center mt-5 mb-5  ">
                <section class="col-md-12 my-5 row mx-auto">
                    <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Compétences</h2>

                    <div class="col-md-12">
                        <div class="row">

                            <div class="card-group col-md-12">

                                <div class="card mr-3 rounded ">
                                    <div class="card-body">
                                        <h2 class="card-title">Compétences web</h2>
                                        <div class="col-md-12">
                                            <div class="progress my-3" style="height: 20px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success"
                                                    role="progressbar" style="width: 68%" aria-valuenow="10"
                                                    aria-valuemin="0" aria-valuemax="100">Html</div>
                                                </div>
                                            <div class="progress my-3" style="height: 20px;"">
                                                    <div class="
                                                progress-bar progress-bar-striped progress-bar-animated text-monospace
                                                bg-success" role="progressbar" style="width: 68%" aria-valuenow="10"
                                                aria-valuemin="0" aria-valuemax="100">Css</div>
                                            </div>
                                        <div class="progress my-3" style="height: 20px;"">
                                                <div class="
                                            progress-bar progress-bar-striped progress-bar-animated text-monospace
                                            bg-success" role="progressbar" style="width: 68%" aria-valuenow="10"
                                            aria-valuemin="0" aria-valuemax="100">Bootstrap</div>
                                        </div>
                                        <div class="progress my-3" style="height: 20px;"">
                                                    <div class="
                                        progress-bar progress-bar-striped progress-bar-animated text-monospace
                                        bg-success" role="progressbar" style="width: 65%" aria-valuenow="10"
                                        aria-valuemin="0" aria-valuemax="100">Responsive web design</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                    <div class="
                                    progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success"
                                    role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0"
                                    aria-valuemax="100">Javascript</div>
                            </div>
                            <div class="progress my-3" style="height: 20px;"">
                                                    <div class="
                                progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success" role="progressbar"
                                style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">jQuery</div>
                        </div>
                        <div class="progress my-3" style="height: 20px;"">
                                                    <div class="
                            progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success" role="progressbar"
                            style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Php</div>
                    </div>
                    <div class="progress my-3" style="height: 20px;"">
                        <div class="progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success" role="progressbar"
                        style="width: 65%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Sql</div>
            </div>
            <div class="progress my-3" style="height: 20px;"">
                <div class="progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success" role="progressbar"
                style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Base de données</div>
        </div>
        <div class="progress my-3" style="height: 20px;"">
            <div class="progress-bar progress-bar-striped progress-bar-animated text-monospace bg-success" role="progressbar" style="width: 50%"
            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Wordpress</div>
    </div>

    </div>
    </div>
                                </div>
                                <div class="card mx-3 rounded">
                                    <div class="card-body">
                                        <h2 class="card-title">En cours d'acquisition</h2>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                                progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                                style="width: 25%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">NodeJs</div>
                                        </div>
                                        <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                            progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                            style="width: 15%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Angular</div>
                                    </div>
                                    <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                        progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                        style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Symfony</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                    style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Java</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                    style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">C</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                    style="width: 15%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">C++</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated bg-warning text-monospace text-dark" role="progressbar"
                                    style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">C#</div>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="card ml-3 rounded">
                                    <div class="card-body">
                                        <h2 class="card-title">Compétences transverses</h2>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                                progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 60%"
                                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Linux</div>
                                        </div>
                                        <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                            progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 50%"
                                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Git</div>
                                    </div>
                                    <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                        progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 50%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Programmation orientée objet</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 60%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Architecture MVC</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 70%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Anglais (niveau B1)</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 80%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Travail en équipe</div>
                                </div>
                                <div class="progress my-3" style="height: 20px;"">
                                                                                <div class="
                                    progress-bar progress-bar-striped progress-bar-animated text-monospace" role="progressbar" style="width: 60%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Méthode Agile</div>
                                </div>
                                </div>

                                </div>
                                </div>
                                </div>

                            </div>

                        </div><!-- fin row -->
                    </div>
                </section>

<!--
  <br id="section2bis"><br>
        <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Mes projets</h2>
        <div class="container mt-5 mb-5 mx-auto bg-light textnoindent shadow rounded hideme">

        <table class="table table-hover table-borderless">
            <tbody>
                <tr>
                    <th scope="row">Projet GUIDER</th>
                    <td>Guider : Création d'une application de mise en relation entre touristes & guides : maquettage
                        de l'application, choix chartre graphique, shéma UML, choix des technologies, retro-planningn,
                        ... Langages utilisés : Html, Css, Bootstrap, JavaScript, jQuery, Php, base de doonées MySql,
                        Sql, API Google Map.</td>
                </tr>
                <tr>
                        <th scope="row">Boutique en ligne Wordpress</th>
                    <td>Réalisation d'un site e-commerce avec Wordpress, woo-commerce</td>
                </tr>
                <tr>
                        <th scope="row">Wordpress</th>
                    <td>Création d'un thème parent en Wordpress</td>
                </tr>
                <tr>
                        <th scope="row">Angular</th>
                    <td>Présentation interactive avec Angular 4, Css Grid, Javascript canvas</td>
                </tr>
                <tr>
                        <th scope="row">Boutique en ligne PHP</th>
                    <td>Réalisation d'un site e-commerce sans CMS avec Php : inscription / connexion client, espace
                        administrateur, CRUD pour la gestion des articles, panier.</td>
                </tr>
                <tr>
                    <th scope="row">OpenClassrooms</th>
                    <td>Blog en Php (commentaires et posts)</td>
                </tr>
            </tbody>
        </table>
  

    </div> -->

    <!-- ---------------------------------------------------------------------------------- -->
    <section class="col-lg-10 col-md-10 my-5 mx-auto" id="section3">
        <br>
        <br>
        <br>
        <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Formation</h2>
        <div class="card-deckd-flex col-md-12 row justify-content-around mx-auto">
            <div class="card mb-3 col-lg-5 col-md-10 col-sm-10 mr-2 mt-4">
                <img class="card-img-top form mx-auto mt-4 img-fluid" src="img/logos/simplon.png" alt="logo école simplon">
                <div class="card-body">
                    <h6 class="card-title text-center font-weight-bold marcellus">Formation Développeur.se web</h6>
                    <p class="text-center">
                        <small class="text-muted">De février à octobre 2018</small>
                    </p>
                    <p class="card-text">
                        <p>Formation professionnalisante de sept mois (dont un mois de stage en entreprise), ayant pour
                            but de développer une application client-serveur ainsi qu'une application web au travers
                            de différents projets, pédagogiques ou personnels.</p>
                        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Concevoir et administrer une base de données
                            <br />
                            <br /><img src="../img/round-done-button.png" alt="check" class="mr-2">Développer, tester et déployer un site web
                            <br />
                            <br /><img src="../img/round-done-button.png" alt="check" class="mr-2">Sécuriser un site web
                            <br>
                            <br />font partie des compétences visées de cette formation intensive.</p>
                        <br>
                        <br>
                        <p>Pour plus d'informations : </p>
                        <div class="d-flex justify-content-center">
                            <a href="https://simplon.co/referentiel/developpeur-web/" target="\_blank" title="Lien vers le détail ma formation">
                                <img src="../img/logos/logo-couleur.png" alt="logo simplon" class="logo" id="logosimplon" />
                            </a>
                        </div>
                    </p>
                </div>
            </div>
            <div class="card mb-3 col-lg-5 col-md-10 col-sm-10 mt-4">
                <img class="card-img-top form mx-auto mt-4 img-fluid" src="img/logos/OpenClassrooms.png" alt="logo OpenClassRooms">
                <div class="card-body">
                    <h6 class="card-title text-center font-weight-bold marcellus">Formations web en autodidacte</h6>
                    <p class="text-center">
                        <small class="text-muted">Depuis janvier 2018</small>
                    </p>
                    <p class="card-text">
                        <p class="font-weight-bold">Open ClassRooms :</p>
                        <p>Html5, Css3, Javascript, Php, MySql, Linux et Git font partie des cours que j'étudie
                            actuellement.
                            Certificats à l'appui pour la plupart des formations suivies (visibles sur
                            <a href="https://www.linkedin.com/in/anne-tabry-0a260939/" target="_blank">Linkedin</a>).</p>
                        <p class="font-weight-bold">Udemy :</p>
                        <p>Formation complète Développeur web. HTML, CSS, Javascript, jQuery, Bootstrap, PHP, MySQL,
                            WordPress tout y est pour appréhender le métier de développeur web.</p>
                        <p class="font-weight-bold">Codecacademy : </p>
                        <p>Formation aux langages Front-End au travers d'exercices de compréhension et d'application.</p>
                        <p class="font-weight-bold">SoloLearn :</p>
                        <p>Exercices d'initiation et de compréhension pour les langages front-end et back-end.</p>
                    </p>
                </div>
            </div>
            <div class="card col-lg-5 col-md-10 col-sm-10 mb-3">
                <img class="card-img-top form mx-auto mt-4 img-fluid" src="img/logos/université_Lille.jpg" alt="logo université lille">
                <div class="card-body">
                    <h6 class="card-title text-center font-weight-bold marcellus">Master 2 Sciences Humaines et
                        Sociales
                        <br>mention Information, Communication, Culture et Documentation,
                        <br>Spécialité Métiers de la Culture</h6>
                    <p class="text-center">
                        <small class="text-muted">De 2009 à 2011</small>
                    </p>
                    <p class="card-text">
                        <p>Parcours Production Artistique et Publics de la Culture, mention Assez Bien, Université
                            Lille3.</p>
                        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Participer à l'administration, la production et la diffusion de spectacles vivants</p>
                        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Coordonner des projets culturels et artistiques</p>
                        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Promouvoir des structures culturelles et entretenir des relations avec leurs publics</p>
                        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Organiser des événements culturels ou assurer le suivi administratif des projets
                            de développement des structures culturelles.</p>
                    </p>
                </div>
            </div>
            <div class="card col-lg-5 col-md-10 col-sm-10 mb-3">
                <img class="card-img-top form mx-auto mt-4 img-fluid" src="img/logos/université_Nancy.jpg" alt="logo université nancy">
                <div class="card-body">
                    <h6 class="card-title text-center font-weight-bold marcellus">Licence Lettres et Sciences Humaines,
                        <br>mention Culture Communication</h6>
                    <p class="text-center">
                        <small class="text-muted">De 2004 à 2007</small>
                    </p>
                    <p class="card-text">
                        <p>Option Cinéma Audiovisuel, Université Nancy2, mention Assez Bien, 2007.</p>
                        <br>
                        <br>
                        <h6 class="card-title text-center font-weight-bold marcellus">Licence Lettres et Sciences
                            Humaines,
                            <br> mention Arts du Spectacles</h6>
                        <p class="text-center">
                            <small class="text-muted">De 2004 à 2007</small>
                        </p>
                        <p>Option Arts de la Scène, Université Nancy2, mention Assez Bien, 2007.</p>
                    </p>
                </div>
            </div>
        </div>
    </section>
  
    <!-- -----------------------------------Expériences--------------------------- -->
    <section class="container-fluid col-lg-10 row mx-auto my-5" id="section4">
        <div>
            <br>
            <br>
            <br>
            <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Expériences</h2>
            <div class="card-deck">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="satisfy pt-2 card-title text-center">Stage création d'application</h4>
                        <p class="card-text">
                            <small class="text-muted">(Sictiam, Sophia Antipolis, Juin 2018)</small>
                        </p>
                        <p class="card-text">Conception et création d'une Progressive Web App, qui a pour but de mettre
                            en relation des
                            guides non-professionnels et des touristes afin de redynamiser l'arrière-pays. Ce projet
                            nous a valu (à mon équipe -de 3- et moi-même) le 3° prix au HOT (Hackathon fOr Tourism
                            organisé par la CCI Nice Côte d'Azur, avec la Telecom Valley et le Business Pôle).</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="satisfy pt-2 card-title text-center">Prix coup de coeur du jury Act'in Space</h4>
                        <p class="card-text">
                            <small class="text-muted">(Hackathon Act'in Space, Cannes, Mai 2018)</small>
                        </p>
                        <p class="card-text">Dans le cadre du Act'in Space (hackathon portant sur l’utilisation de
                            technologies du spatial
                            dans tous les domaines du quotidien, et organisé par le CNES, l’ESA et l’ESA BIC Sud
                            France) : Coup de coeur du jury pour notre application "Surv'Eye", projet éthique qui
                            permet via notre application de parrainer un animal en voie d'extinction et ainsi de
                            participer au balisage des animaux en utilisant la balise Argos, système sateliitaire
                            de localisation et de collecte de données utilisé pour la protection de l'environnement.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">Conception et réalisation d'une présentation
                            interactive</h4>
                        <p class="card-text">
                            <small class="text-muted">(Travail d'équipe pour un client, Mai 2018)</small>
                        </p>
                        <p class="card-text">Réalisation d'un site adapté aux besoins du client, qui permet de naviguer
                            aisément dans
                            la présentation du modèle économique du client. Langages utilisés : Html, Css et Angular.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">3° prix du "Hack fOr Tourism" </h4>
                        <p class="card-text">
                            <small class="text-muted">(Hackathon "Hack fOr Tourism", Sophia Antipolis, Avril 2018)</small>
                        </p>
                        <p class="card-text">Dans le cadre du HOT (Hackathon fOr Tourism), concours de création
                            d'applications numériques,
                            mon équipe et moi-même avons obtenu le 3° prix pour notre application "GUIDER", une
                            plateforme
                            de mise en relation entre touristes et guides, qui a pour objectif de redynamiser tout
                            l'arrière pays et d'en valoriser ses ressources.</p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card-deck">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">Chargée de communication</h4>
                        <p class="card-text">
                            <small class="text-muted">(Association Viza Ouf, Perpignan, de 2012 à 2013)</small>
                        </p>
                        <p class="card-text">Élaboration et mise à jour des supports et outils de communication (site
                            internet, communiqués,
                            dossiers de presse, prospection). Promotion sur les réseaux sociaux, développement de
                            partenariats locaux (presse, radio, mairie).</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">Stage au service production</h4>
                        <p class="card-text">
                            <small class="text-muted">(Centre Chorégraphique National de Roubaix, 2010)</small>
                        </p>
                        <p class="card-text">Assistante de production et de diffusion autour de la Cie Zahrbat, guest
                            compagnie du CCN
                            Roubaix, dirigé par Carolyn Carlson : établissement des contrats, DUE, demandes de
                            subventions,
                            suivi des plannings et des budgets, gestion secretariat classique (courriers, appels,
                            calendrier).</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">Directrice adjointe en centre de vacances</h4>
                        <p class="card-text">
                            <small class="text-muted">(Opcv, Fol, Pep68, de 2005 à 2007) </small>
                        </p>
                        <p class="card-text">Gestion d'une équipe d'animation, des activités, des sorties et du budget
                            pédagogique : établissement
                            de factures et suivi du budget, réservations, devis et logistique des sorties. Egalement
                            Animatrice de loisirs à de nombreuses reprises.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title satisfy pt-2 text-center">Aide Agricole en arboriculture</h4>
                        <p class="card-text">
                            <small class="text-muted">(Earl'pom Abricot, de 2014 à 2017)</small>
                        </p>
                        <p class="card-text">Entretien des vergers, retaille des vergers de pêchers et nectarines,
                            Taille en vert des
                            arbres, éclaircissage des vergers ainsi que récolte des fruits.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- --------------------------------------------------------------------- -->
    <section class="col-md-12 my-5 mx-auto " id="section5">
        <br>
        <br>
        <br>
        <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Portfolio</h2>
        <div class="container text-center">
            <div id="carouselExampleFade" class="carousel slide carousel-fade bg-dark " data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                    <li data-target="#demo" data-slide-to="3"></li>
                    <li data-target="#demo" data-slide-to="4"></li>
                    <li data-target="#demo" data-slide-to="5"></li>
                    <li data-target="#demo" data-slide-to="6"></li>
                </ul>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/cvAnneTab.png" alt="Cv en ligne">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Mon premier CV en ligne</h5>
                            <p class="p-3">Réalisé dans le cadre d'un cours Udemy</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/FireShotVoyages.png" alt="Site voyage">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Réalisation d'un site responsive</h5>
                            <p class="p-3">Mon premier travail d'équipe avec Simplon</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/guider.png" alt="application Guider">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Application web "Guider"</h5>
                            <p class="p-3">Plateforme de mise en relation touristes / guides, réalisée dans le cadre
                                d'un stage
                                à la SICTIAM.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/archi.png" alt="image présentation">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Réalisation d'un site interactif avec Angular</h5>
                            <p class="p-3">Travail d'équipe autour d'une problématique de navigation dans une
                                présentation de modèle
                                économique pour répondre aux besoins d'un client.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/simplon.png" alt="site simplon prairie">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Réalisation d'un site selon son cahier des charges</h5>
                            <p class="p-3">Projet en équipe sur la construction d'un site en respectant le cahier des
                                charges établi
                                par nos formateurs.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/Hackathon-for-Tourism.jpg.png"
                            alt="HoT 2018">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Hackathon fOr Tourism</h5>
                            <p class="p-3">Obtention du troisième prix lors de ce concours de création d'applications
                                numériques.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="card-img-top carousel img-fluid" src="../img/Portfolio/act-in-space-2018.jpg" alt="Act'in space 2018">
                        <div class="carousel-caption d-none d-md-block bgtranspacarousel">
                            <h5>Act'in Space 2018</h5>
                            <p class="p-3">Prix coup de coeur du jury lors du hackathon Act'in Space, qui porte sur
                                l’utilisation
                                de technologies du spatial dans tous les domaines du quotidien.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-control-prev bgtranspa" href="#carouselExampleFade" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </div>
                <div class="carousel-control-next bgtranspa" href="#carouselExampleFade" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </div>
            </div>
        </div>
    </section>
    
    <br><!--
    <section>
    <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Qualités acquises</h2>
    <div class="container mx-auto box textnoindent shadow rounded col-md-5">
<br>
        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Perséverance dans la recherche de solutions</p>
        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Goût du travail en équipe</p>
        <p><img src="img/round-done-button.png" alt="check" class="mr-2">Aptitude d'apprentissage et adaptabilité</p>
        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Bon relationnel</p>
        <p><img src="../img/round-done-button.png" alt="check" class="mr-2">Implication, rigueur et réactivité</p>

    </div>
</section>-->
<br id="formulaire">
    <!-- -------------FORMULAIRE ------------------------------------------------------------- -->
    <section class="col-md-12 my-5 row mx-auto">
        <h2 class="text-center my-5 titre box col-md-5 mx-auto p-3">Contactez-moi</h2>
        <!--  <div class="container text-center mt-5 mb-5  bg-dark textnoindent shadow rounded hideme">-->

        <div class="row">
            <div class="col-lg-8 col-lg-offset-1 mx-auto">
                <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                    <div class="row ">
                        <div class="col-md-6 ">
                            <label for="firstname">Prénom <span class="blue">*</span></label>
                            <input id="firstname" type="text" name="firstname" class="form-control" placeholder="Votre prénom">
                            <p class="comments"><?php 
                            //echo $firstnameError; ?></p>

                        </div>
                        <div class="col-md-6">
                            <label for="name">Nom <span class="blue">*</span></label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Votre Nom">
                            <p class="comments"><?php 
                            //echo $nameError; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email <span class="blue">*</span></label>
                            <input id="email" type="text" name="email" class="form-control" placeholder="Votre Email">
                            <p class="comments"><?php 
                            //echo $emailError; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Téléphone</label>
                            <input id="phone" type="tel" name="phone" class="form-control" placeholder="Votre Téléphone">
                            <p class="comments"><?php 
                            //echo $phoneError; ?></p>
                        </div>
                        <div class="col-md-12">
                            <label for="message">Message <span class="blue">*</span></label>
                            <textarea id="message" name="message" class="form-control" placeholder="Votre Message" style="height: 10vw;" rows="3"></textarea>
                            <p class="comments"><?php 
                            //echo $messageError; ?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="blue"><strong>* Ces informations sont requises.</strong></p>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success btn-lg btn-block" value="Envoyer" name="envoi">
                        </div>
                    </div>
              
                    <p class="font-weight-bold my-2" style="display:<?php 
                    if(($nom != '') && ($prenom != '') && ($email != '') && ($message != '')) echo 'block'; else echo 'none'; ?>">Votre message a bien été envoyé. Merci de m'avoir contacté <?php echo $_POST['firstname']; ?></p>
                    <p class="font-weight-bold my-2" style="display:<?php 
                    if($num_emails == 0) echo 'block'; else echo 'none'; ?>">Votre message n'a pas pu être envoyé, veuillez réessayer plus tard.</p>
                </form>
            </div>
        </div>

        <!--</div> -->
    </section>


    <!-- -------------------------------------------------------------------------- -->

    <footer class="bg-dark col-md-12" id="footer">
        <div class="d-flex justify-content-around row align-items-center">
            <div class="d-md-block align-items-center">
                <a href="tel:0679818738" title="Appelez-moi">
                    <img src="../img/logos/phone.png" alt="logo téléphone" class="logofooter mt-4 img-fluid" />
                    <br>
                    <p class="m-0 pt-2 text-light textno d-none d-lg-block d-sm-none d-md-none">06 79 81 87 38</p>
                </a>
            </div>
            <a href="mailto:annetabry@gmail.com" title="Me contacter par mail">
                <img src="../img/logos/gmail.png" alt="logo mail" class="mt-4 img-fluid logofooter" />
                <br>
                <p class="m-0 pt-1 text-light gmail d-none d-lg-block d-sm-none d-md-none">annetabry@gmail.com</p>
            </a>
            <a href="https://github.com/AnnTabry" target="_blank" title="">
                <img src="../img/logos/github.png" alt="logo github" class="img-fluid logofooter mt-4" />
                <br>
                <p class="m-0 pt-2 text-light github d-none d-lg-block d-sm-none d-md-none">GitHub</p>
            </a>
            <a href="https://www.linkedin.com/in/anne-tabry-0a260939/" target="_blank" title="Accéder à mon profil Linkedin">
                <img src="../img/logos/linkedin.png" alt="logo Linkedin" class="img-fluid logofooter mt-4" />
                <br>
                <p class="m-0 pt-2 text-light textno d-none d-lg-block d-sm-none d-md-none">Profil Linkedin</p>
            </a>
            <a href="documents/MonCvAnnTabry.pdf" target="_blank" title="Imprimer ce CV">
                <img src="../img/logos/pdf.png" alt="logo pdf" class="img-fluid logofooter mt-4" />
                <br>
                <p class="m-0 pt-2 text-light textno d-none d-lg-block d-sm-none d-md-none">Version pdf</p>
            </a>
        </div>
        <div class="text-center mb-0 mt-3 copyright">Copyright © Anne TABRY 2018.</div>
    </footer>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/cv.js"></script>
</body>

</html>