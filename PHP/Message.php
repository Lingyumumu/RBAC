<?php
session_start();
include('dbConn.php');

// Vérifier si les variables de session sont définies
if ($_SESSION['nom'] == null || $_SESSION['ID'] == null || $_SESSION['email'] == null || $_SESSION['role'] == null) {
    header("location: login.php");
    exit;
}

$id = $_SESSION['ID'];
$nom = $_SESSION['nom'];
$expediteurEmail = $_SESSION['email'];

// Vérifier si le formulaire de message a été soumis
if (isset($_POST['btnMessage'])) {
    $texte = $_POST['txttexte'];
    $destinataireEmail = $_POST['txtemail'];

    // Vérifier si le destinataire existe
    $queryExist = "SELECT * FROM user WHERE email = ?";
    $stmtExist = mysqli_prepare($connection, $queryExist);
    mysqli_stmt_bind_param($stmtExist, "s", $destinataireEmail);
    mysqli_stmt_execute($stmtExist);
    $resultExist = mysqli_stmt_get_result($stmtExist);
    $count = mysqli_num_rows($resultExist);

    if ($count > 0) {
        echo "Le destinataire existe.";

        // Enregistrer le message dans la base de données
        $query = "INSERT INTO messages (expediteur_email, destinataire_email, contexte, date_envoi) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sss", $expediteurEmail, $destinataireEmail, $texte);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Envoi réussi.";
        } else {
            echo "Échec de l'envoi : " . mysqli_error($connection);
        }
    } else {
        echo "Le destinataire n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="Message.css">
</head>
<header>
<h1>Système de Gestion de l'EFREI</h1>
</header>
<body>
    <nav>
        <ul>
            <?php if ($_SESSION['role'] == 'etudiant') { ?>
                <li><a href="Etudiant/Home_Etudiant.php">Accueil</a></li>
                <li><a href="Etudiant/plannings/list_planning.php">Mon emploi-du-temps</a></li>
                <li><a href="Etudiant/cours_inscrit.php">Cours</a></li>
                <li><a href="Etudiant/notes/list_note.php">Mes notes</a></li>
                <li><a href="Etudiant/mes_absences.php?ID=<?php echo $id; ?>">Mes Absences</a></li>
            <?php } elseif ($_SESSION['role'] == 'professeur') { ?>
                <li><a href="Professeur/Home_Professeur.php">Accueil</a></li>
                <li><a href="Professeur/plannings/list_planning.php">Mon emploi-du-temps</a></li>
                <li><a href="Professeur/cours/list_cours.php">Cours</a></li>
                <li><a href="Professeur/notes/list_note.php">Mes notes</a></li>
                <li><a href="Professeur/absences/list_absence.php">Mes absences</a></li>
            <?php } elseif ($_SESSION['role'] == 'administrateur') { ?>
                <li><a href="Administrateur/Home_Admin.php">Accueil</a></li>
                <li><a href="Administrateur/notes/list_formation.php">Notes</a></li>
                <li><a href="Administrateur/cours/list_formation.php">Cours</a></li>
                <li><a href="Administrateur/formations/list_formation.php">Formations</a></li>
                <li><a href="Administrateur/document/list_formation.php">Document</a></li>
                <li><a href="Administrateur/plannings/list_formation.php">Planning</a></li>
                <li><a href="Administrateur/user/list_user.php">Utilisateurs</a></li>
                <li><a href="Administrateur/user/list_register.php">Inscription</a></li>
            <?php } elseif ($_SESSION['role'] == 'personnel') { ?>
                <li><a href="Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="Personnel/cours/list_formation.php">Cours</a></li>
                <li><a href="Personnel/plannings/list_formation.php">Planning</a></li>
                <li><a href="Personnel/notes/list_formation.php">Notes</a></li>
                <li><a href="Personnel/user/list_register.php">Utilisateurs</a></li>
            <?php } ?>
            <li><a href="Message.php">Message</a></li>
            <li><a href="logout.php">Deconnexion</a></li>
        </ul>
   </nav>
    <div class="container">
        <div class="conversation-list">
            <h2>Conversations</h2>
            <?php
            // Récupérer les utilisateurs distincts
            $queryUsers = "SELECT DISTINCT destinataire_email FROM messages WHERE expediteur_email = ? OR destinataire_email = ?";
            $stmtUsers = mysqli_prepare($connection, $queryUsers);
            mysqli_stmt_bind_param($stmtUsers, "ss", $expediteurEmail, $expediteurEmail);
            mysqli_stmt_execute($stmtUsers);
            $resultUsers = mysqli_stmt_get_result($stmtUsers);

            while ($rowUser = mysqli_fetch_assoc($resultUsers)) {
                $destinataireEmail = $rowUser['destinataire_email'];
                $activeClass = (isset($_GET['destinataire']) && $_GET['destinataire'] == $destinataireEmail) ? 'active' : '';

                echo '<div class="conversation ' . $activeClass . '">';
                echo '<a href="?destinataire=' . $destinataireEmail . '">' . $destinataireEmail . '</a>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="message-box">
            <h2>Conversation avec <?php echo isset($_GET['destinataire']) ? $_GET['destinataire'] : ''; ?></h2>
            <?php
            if (isset($_GET['destinataire'])) {
                $destinataireEmail = $_GET['destinataire'];

                // Afficher les messages pour la conversation sélectionnée
                $queryMessages = "SELECT * FROM messages WHERE (expediteur_email = ? AND destinataire_email = ?) OR (expediteur_email = ? AND destinataire_email = ?)";
                $stmtMessages = mysqli_prepare($connection, $queryMessages);
                mysqli_stmt_bind_param($stmtMessages, "ssss", $expediteurEmail, $destinataireEmail, $destinataireEmail, $expediteurEmail);
                mysqli_stmt_execute($stmtMessages);
                $resultMessages = mysqli_stmt_get_result($stmtMessages);
                ?>

                <div class="message-list">
                    <?php
                    while ($rowMessage = mysqli_fetch_assoc($resultMessages)) {
                        $expediteur = $rowMessage['expediteur_email'];
                        $message = $rowMessage['contexte'];
                        $dateEnvoi = $rowMessage['date_envoi'];

                        $messageClass = ($expediteur == $expediteurEmail) ? 'sent' : 'received';

                        echo '<div class="message-item ' . $messageClass . '">';
                        echo '<strong>' . $expediteur . '</strong><br>';
                        echo $message . '<br>';
                        echo '<small>' . $dateEnvoi . '</small>';
                        echo '</div>';
                    }
                    ?>
                </div>

            <?php } ?>
            <h2>Envoyer un message</h2>
            <form action='' method='post'>
                Destinataire : <input type='text' name='txtemail' value="<?php echo isset($_GET['destinataire']) ? $_GET['destinataire'] : ''; ?>" required><br>
                Texte : <input type='text' name='txttexte' required><br>
                <input type='submit' name='btnMessage' value='Envoyer'>
                <input type='reset' name='btnReset' value='Reset'>
            </form>
        </div>
    </div>
</body>
</html>
