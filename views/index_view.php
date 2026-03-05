<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>Spoify</title>
    <link rel="icon" href="images/logo.png">
<body>
<header>
    <div class="title-container">
        <div class="logo"></div>
        <div class="title">SPOIFY</div>
    </div>

    <div id="search" class="searchbar-container mobile">
        <div class="searchbar">
            <div class="icon"></div>
            <input class="text" placeholder="What song would you like to play?" oninput="search(this.value)">
            <!-- Searchbar moet werken naar de songs in de database-->
        </div>
    </div>

    <div id="account" class="account-container mobile">
        <div class="icon" onclick="<?php if (isset($_SESSION['Username'])) { ?> window.location = 'account.php' <?php } else { ?> document.getElementById('popup').style.display = 'block' <?php } ?>"></div>
        <div id="popup">
            <div class="title">login</div>
            <div class="cross" onclick="this.parentElement.style.display = 'none'"></div>
                        <br>
                    <div class="form">
                        <form class="form" action="inlog_verwerk.php" method="post" id="loginform">
                        <div>
                            <label>Username:</label>
                            <input type="text" name="username" max-length="30" required/>
                        </div>
                        <div>
                            <label>Password:</label>
                            <input type="password" name="password" min-length="8" required/>
                        </div>
                        <input type="submit" value="Login"/>
                            <button onclick="document.getElementById('signinform').style.display = 'block'; this.parentElement.style.display = 'none'" type="button">Signin Page</button>
                        </form>

                        <form class="form" action="register_verwerk.php" method="post" id="signinform" style="display: none;">
                            <div>
                                <label>Username:</label>
                                <input type="text" name="username" max-length="30" required/>
                            </div>
                            <div>
                                <label>Password:</label>
                                <input type="password" name="password" min-length="8" required/>
                            </div>
                            <div>
                                <label>Repeat Password:</label>
                                <input type="password" name="confirmpassword" min-length="8" required/>
                            </div>
                            <p>Are you a musical artist?<input type="checkbox" name="isArtist" value="Yes"/></p>
                            <input type="submit" value="Make"/>
                            <button onclick="document.getElementById('loginform').style.display = 'block'; this.parentElement.style.display = 'none'" type="button">Login Page</button>
                        </form>
                    </div>
        </div>
    </div>
</header>

<div id="list" class="list-container mobile">
    <div class="list-songs-container">
        <div class="songs-grid">
            <?php foreach ($sonkz as $song) { ?>
                <div class="song-card" onclick="playsong('<?= $song['Song_name'] ?>', '<?= $song['Username'] ?>', '<?= $song['Audio_file'] ?>', '<?= $song['Cover'] ?>', '<?= $song['Song_ID'] ?>')">
                    <div class="cover" style="background-image: url('<?= $song['Cover'] ?>')"></div>
                    <div class="info">
                        <div class="song-name">
                            <?= $song['Song_name'] ?>
                        </div>
                        <div class="pink-line"></div>
                        <div class="artist-name">
                            <?= $song['Username'] ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    </div>
</div>

<div class="misc-container">
    <div class="now-playing" id="now-playing">
        <div class="cover"></div>
        <div class="song">Heartbreak, heartbreak</div>

        <div class="sound-container">
            Volume: 
            <input class="volume" type="range" min="0" max="100" value="100" onchange="player.volume(this.value)"><br>

            <button onclick="player.toggleplay()">PlayPause</button><br>

            Timeline: 
            <input class="timeline" type="range" min="0" max="0" value="0" id="timeline" onchange="player.settime(this.value)"><br>
        </div>

    </div>

    <div class="artist-container">
        <div class="icon" style="filter: brightness(100)" onclick="fave()" id="favefavefave"></div>
        <div class="artist">Shihoko Hirata</div>
    </div>
</div>


<div id="faves" class="faves-container no-select mobile">
    <div class="resize-handle"></div>
    <div class="title">Favorites</div>
    <div id="shrink" class="icon"></div>
    <div class="faves-song-container" id="skibidifaves">
        <div class="faves-song">
            <div class="icon"></div>
            <div class="text-wrap"></div>
        </div>
    </div>
</div>

<div id="searchmenu">

    <!--
        Yo twin dit is je song object, zorg ervoor dat hij hier ook werkt ipv alleen in faves-song-container
        Als je dat lukt werkt de search function ook meteen :)
        xx sophie
     -->

</div><style>
    #searchmenu {
        /* Yo je kan alles hier weghalen dit is een test <style> */
        width: 300px;
        height: 100px;
        position: fixed;
        top: 100px;
        left: 200px;

        display: none; /* Deze display none is VERPLICHT toegevoegd te worden aan de main style, de rest niet */
    }
</style>

<div class="bar">
    <div onclick="menu('list')" style="background-image: url('images/home.png');"></div>
    <div onclick="menu('search')" style="background-image: url('images/search.png');"></div>
    <div onclick="menu('faves')" style="background-image: url('images/heart.png'); filter: brightness(999)"></div>
    <div onclick="menu('account')" style="background-image: url('images/account-placeholder.png');"></div>
</div>

<script src="js/player.js"></script>
<script src="js/index.js"></script>
<script src="js/resize-faves.js"></script>
</body>
</html>

<script defer>
    playsong('<?= $sonkz[0]['Song_name'] ?>', '<?= $sonkz[0]['Username'] ?>', '<?= $sonkz[0]['Audio_file'] ?>', '<?= $sonkz[0]['Cover'] ?>', '<?= $sonkz[0]['Song_ID'] ?>')
    player.stop()
</script>