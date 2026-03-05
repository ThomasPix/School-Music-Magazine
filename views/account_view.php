<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spoify - <?= $user ?></title>
    <link rel="icon" href="images/logo.png">
<body>
    <h1>
        Welkom "<?= $user ?>"
    </h1>
    <a href="./index.php">back</a>
    <form action="account.php" method="POST">
        <h3>Account Gegevens</h3>
        <p>
            Username: <input type="text" name="user" value="<?= $user ?>">
        </p>
        <p>
            Wachtwoord: <input type="password" name="pass">
        </p>
        <button type="submit" name="action" value="update">Aanpassen</button>
        <button type="submit" name="action" value="logout">Uitloggen</button>
        <button type="submit" name="action" value="delete">Account Verwijderen</button>
    </form>

    <?php if ($depresoespreso['IsArtist'] == 'Yes') { ?>
        <form action="account.php" method="POST" enctype="multipart/form-data">
            <h3>Nummer Uploaden</h3>
            <p>
                Naam: <input type="text" name="name">
            </p>
            <p>
                Audio Bestamd: <input type="file" name="song" accept="audio/*"> (2MEGABYTES MAXIMAAL DOOR DE KUT LIMITATIONS VAN ONZE SCHOOL SERVER)
            </p>
            <p>
                Cover: <input type="file" name="cover" accept="image/*">
            </p>
            <button type="submit" name="action" value="upload">Uploaden</button>
        </form>
    <?php } ?>
</body>
</html>