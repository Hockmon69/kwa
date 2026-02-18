<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KWA DWAI MEDIA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('Database.php'); include('nav.php'); ?>

<div class="search-container" style="text-align: center; margin: 30px 0;">
    <form action="index.php" method="GET">
        <input type="text" name="search" placeholder="Search for a photo or event..." 
               style="padding: 10px; width: 300px; border-radius: 5px; border: 1px solid #444; background: #222; color: white;">
        <button type="submit" class="btn">Search</button>
    </form>
</div>

<section class="gallery-container">
    <h2 style="text-align:center; margin: 40px 0;">Portfolio Gallery</h2>
    <div class="gallery-grid">
        <?php
        // Search logic remains the same
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_word = $_GET['search'];
            $query = "SELECT * FROM gallery WHERE title LIKE '%$search_word%' ORDER BY upload_date DESC";
        } else {
            $query = "SELECT * FROM gallery ORDER BY upload_date DESC";
        }

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $img = $row['image_path'];
                $title = addslashes($row['title']);
                
                // CHANGE 1: Pull the description from the database row
                $desc = isset($row['description']) ? addslashes($row['description']) : "";
                
                // CHANGE 2: Pass $desc as the third argument in openLightbox
                echo '<div class="gallery-item" onclick="openLightbox(\''.$img.'\', \''.$title.'\', \''.$desc.'\')">';
                echo '    <img src="'.$img.'" alt="'.$title.'" style="cursor:pointer;">';
                echo '    <div class="image-info"><h3>'.$row['title'].'</h3></div>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align:center; width:100%;">No photos found matching that search.</p>';
        }
        ?>
    </div>
</section>

<div id="lightbox" onclick="closeLightbox()" style="display:none; position:fixed; z-index:999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); text-align:center;">
    <span style="position:absolute; top:20px; right:30px; color:white; font-size:40px; cursor:pointer;">&times;</span>
    <img id="lightbox-img" style="max-width:70%; max-height:60%; margin-top:5%; border: 3px solid white;">
    <h2 id="lightbox-caption" style="color:white; margin-top:20px;"></h2>
    <p id="lightbox-desc" style="color:white; margin-top:10px; font-style:italic;"></p>
</div>

<script>
// CHANGE 4: Add 'desc' to the function arguments
function openLightbox(src, title, desc) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').innerHTML = title;
    // CHANGE 5: Put the description text into the new <p> tag
    document.getElementById('lightbox-desc').innerHTML = desc;
    document.getElementById('lightbox').style.display = 'block';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}
</script>

<?php include('footer.html'); ?> 
</body>
</html>