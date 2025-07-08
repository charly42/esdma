<?php
// Destinataire
$to = "contact@esdma.fr";

// Sécurisation basique des données
$nom     = htmlspecialchars(trim($_POST["nom"] ?? ""));
$prenom  = htmlspecialchars(trim($_POST["prenom"] ?? ""));
$email   = htmlspecialchars(trim($_POST["email"] ?? ""));
$objet   = htmlspecialchars(trim($_POST["objet"] ?? ""));
$contenu = htmlspecialchars(trim($_POST["contenu"] ?? ""));

// Validation basique
if (empty($nom) || empty($prenom) || empty($email) || empty($objet) || empty($contenu) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Données invalides.";
    exit;
}

// Sujet de l’email
$sujet = "Message depuis le formulaire ESDMA : $objet";

// Corps de l’email
$message = "
Vous avez reçu un nouveau message depuis le site ESDMA.

Nom : $nom
Prénom : $prenom
Email : $email

Objet : $objet

Message :
$contenu
";

// En-têtes
$headers = "From: $prenom $nom <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

// Envoi de l’e-mail
if (mail($to, $sujet, $message, $headers)) {
    echo "Message envoyé avec succès.";
} else {
    http_response_code(500);
    echo "Échec de l'envoi du message.";
}
?>
