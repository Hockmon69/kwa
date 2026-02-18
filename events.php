<?php include('Database.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Events Gallery | PhotoStudio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('nav.php'); ?>

    <header class="hero" style="height: 40vh;">
        <h1>Event Photography</h1>
        <p>Capturing the energy of live moments.</p>
    </header>

    <section class="gallery-container">
        <div class="gallery-grid">
            <?php
            // The magic happens here: we added "WHERE category = 'Events'"
            $query = "SELECT * FROM gallery WHERE category = 'Events' ORDER BY upload_date DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="gallery-item" onclick="openLightbox(\''.$row['image_path'].'\', \''.$row['title'].'\')">';
                    echo '    <img src="'.$row['image_path'].'" alt="'.$row['title'].'">';
                    echo '    <div class="image-info"><h3>'.$row['title'].'</h3></div>';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align:center; width:100%;">No event photos uploaded yet.</p>';
            }
            ?>
        </div>
    </section>

    <?php include('footer.html'); ?>
    
    <div id="lightbox" onclick="closeLightbox()" style="display:none; position:fixed; z-index:999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); text-align:center;">
    <span style="position:absolute; top:20px; right:30px; color:white; font-size:40px; cursor:pointer;">&times;</span>
    <img id="lightbox-img" style="max-width:90%; max-height:80%; margin-top:5%; border: 3px solid white;">
    <h2 id="lightbox-caption" style="color:white; margin-top:20px;"></h2>
</div>
<script>
function openLightbox(src, title) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').innerHTML = title;
    document.getElementById('lightbox').style.display = 'block';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}
</script>
</body>
</html>