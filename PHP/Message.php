<?php
session_start();
include('dbConn.php');

if (isset($_SESSION['nom']) == null || isset($_SESSION['ID']) == null || isset($_SESSION['email']) == null || isset($_SESSION['role']) == null) {
    header("location: login.php");
    exit;
}

$id = $_SESSION['ID'];
$nom = $_SESSION['nom'];
$expediteurEmail = $_SESSION['email'];

if (isset($_POST['btnMessage'])) {
    $texte = $_POST['txttexte'];
    $destinataireEmail = $_POST['txtemail'];

    // Vérifier si le destinataire existe
    $queryExist = "SELECT * FROM user WHERE email = '$destinataireEmail'";
    $resultExist = mysqli_query($connection, $queryExist);
    $count = mysqli_num_rows($resultExist);

    if ($count > 0) {
        echo "Le destinataire existe.";

        // Enregistrer le message dans la base de données
        $query = "INSERT INTO messages (expediteur_email, destinataire_email, contexte, date_envoi) VALUES ('$expediteurEmail', '$destinataireEmail', '$texte', NOW())";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "Envoi réussi.";
        } else {
            echo "Échec de l'envoi.";
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
    <link rel="stylesheet" href="message.css">
</head>

<body>

    <div class="container">
        <div class="conversation-list">
            <h2>Conversations</h2>
            <?php
            // Récupérer les utilisateurs distincts
            $queryUsers = "SELECT DISTINCT destinataire_email FROM messages WHERE expediteur_email = '$expediteurEmail' OR destinataire_email = '$expediteurEmail'";
            $resultUsers = mysqli_query($connection, $queryUsers);

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
                $queryMessages = "SELECT * FROM messages WHERE (expediteur_email = '$expediteurEmail' AND destinataire_email = '$destinataireEmail') OR (expediteur_email = '$destinataireEmail' AND destinataire_email = '$expediteurEmail')";
                $resultMessages = mysqli_query($connection, $queryMessages);
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

                <h2>Envoyer un message</h2>
                <form action='' method='post'>
                    Destinataire : <input type='text' name='txtemail' value="<?php echo $destinataireEmail; ?>" required><br>
                    Texte : <input type='text' name='txttexte' required><br>
                    <input type='submit' name='btnMessage' value='Envoyer'>
                    <input type='reset' name='btnReset' value='Reset'>
                </form>
                
            <?php } 
            else {
            ?>
            <h2>Envoyer un message</h2>
                <form action='' method='post'>
                    Destinataire : <input type='text' name='txtemail' value="" required><br>
                    Texte : <input type='text' name='txttexte' required><br>
                    <input type='submit' name='btnMessage' value='Envoyer'>
                    <input type='reset' name='btnReset' value='Reset'>
                </form>
            <?php } ?>
            
        </div>
    </div>

</body>

</html>
