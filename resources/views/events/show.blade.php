<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'événement</title>
</head>
<body>
<h1>Détails de l'événement</h1>
<p>Nom : {{ $event->title }}</p>
<p>Début : {{ $event->start }}</p>
<p>Fin : {{ $event->end }}</p>
<p>Lieu : {{ $event->location }}</p>
<!-- Ajoutez d'autres détails de l'événement ici selon vos besoins -->
</body>
</html>
