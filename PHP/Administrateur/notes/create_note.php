<?php
include('../../dbConn.php');
session_start();
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

$id = $_GET['id_etudiant'];

$queryformation = "SELECT *FROM user WHERE role = 'etudiant' AND ID = '$id'";
$resultformation = mysqli_query($connection, $queryformation);
$rowformation = mysqli_fetch_assoc($resultformation);
$formation = $rowformation['formation'];



// Récupérer la liste des cours depuis la base de données
$queryCours = "SELECT ID, nom_cours FROM cours WHERE nom_formation = '$formation' ";
$resultCours = mysqli_query($connection, $queryCours);

// Récupérer la liste des étudiants depuis la base de données
$queryEtudiants = "SELECT ID, prenom FROM user WHERE role = 'etudiant' AND ID = '$id'";
$resultEtudiants = mysqli_query($connection, $queryEtudiants);

// Vérifier si le formulaire a été soumis
if (isset($_POST['btnAjouterNote'])) {
    // Récupérer les valeurs du formulaire
    $id_etudiant = $_POST['ddlEtudiant'];
    $id_cours = $_POST['ddlCours'];
    $note = $_POST['txtNote'];

    // Vérifier si une note existe déjà pour ce cours et cet étudiant
    $queryCheckNote = "SELECT * FROM notes WHERE id_cours = $id_cours AND id_etudiant = $id_etudiant";
    $resultCheckNote = mysqli_query($connection, $queryCheckNote);
    $row = mysqli_fetch_assoc($resultCheckNote);
    $id_note = $row['ID'];
    // Vérifier le nombre de lignes retournées
    if (mysqli_num_rows($resultCheckNote) > 0) {
        echo "La note a été mise à jour.";
        // Mettre à jour la note
        $updateQuery = "UPDATE notes SET note = '$note' WHERE ID = $id_note";
        $resultQuery = mysqli_query($connection, $updateQuery);
        header ("Location: list_formation.php");

    } else {
        // Requête d'insertion de la note dans la table "notes"
        $query = "INSERT INTO notes (note, id_cours, id_etudiant) VALUES ('$note', '$id_cours', '$id_etudiant')";

        // Exécution de la requête
        if (mysqli_query($connection, $query)) {
            echo "La note a été ajoutée avec succès.";
            header ("Location: list_formation.php");
        } else {
            echo "Erreur lors de l'ajout de la note : " . mysqli_error($connection);
        }
    }

    // Fermer la connexion à la base de données
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/notes/create_note.css">
    <title>Gestion des notes - Administrateur</title>
</head>
<body>
<header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
    <h1>EFREI - Administrateur</h1>
        <nav>
            <ul>
            <li><a href="../../Administrateur/Home_Admin.php">Accueil</a></li>
            <li><a href="../../Administrateur/notes/list_formation.php">Notes</a></li>
            <li><a href="../../Administrateur/cours/list_formation.php">Cours</a></li>
            <li><a href="../../Administrateur/formations/list_formation.php">Formations</a></li>
            <li><a href="../../Administrateur/document/list_formation.php">document</a></li>
            <li><a href="../../Administrateur/plannings/list_formation.php">Planning</a></li>
            <li><a href="../../Administrateur/user/list_user.php">Utilisateurs</a></li>
            <li><a href="../../Administrateur/user/list_register.php">Inscription</a></li>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
            </ul>
        </nav>

<h2>Ajouter une note</h2>
<a href="list_etudiant_note.php">Liste des notes</a>

<form action="create_note.php" method="POST">
    <label for="ddlCours">Cours:</label>
    <select name="ddlCours">
        <?php while($row = mysqli_fetch_assoc($resultCours)): ?>
            <option value="<?php echo $row['ID']; ?>"><?php echo $row['nom_cours']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="ddlEtudiant">Etudiant:</label>
    <select name="ddlEtudiant">
        <?php while($row = mysqli_fetch_assoc($resultEtudiants)): ?>
            <option value="<?php echo $row['ID']; ?>"><?php echo $row['prenom']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="txtNote">Note :</label>
<input type="text" name="txtNote" required pattern="^(0|[1-9]|1[0-9]|20)$">
<span class="error">La note doit être comprise entre 0 et 20.</span>
<br>


    <input type="submit" name="btnAjouterNote" value="Ajouter la note">
</form>
</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>
