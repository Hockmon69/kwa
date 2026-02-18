<?php
session_start();
include('Database.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // 1. Get the file path first so we can delete the actual file from the folder
    $res = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    unlink($row['image_path']); // This deletes the actual file

    // 2. Delete from database
    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");
    header("Location: admin.php");
}

// Handle the File Upload Logic
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description']; // Get the new description field
    
    $target_file = "uploads/" . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Add 'description' to the columns and '$description' to the values
        $sql = "INSERT INTO gallery (title, image_path, category,description) 
                VALUES ('$title', '$target_file', '$category', '$description')";
        mysqli_query($conn, $sql);
        $msg = "Photo uploaded with details!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Upload Photo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">ADMIN<span>PANEL</span></div>
        <ul>
            <li><a href="index.php">View Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div style="max-width: 600px; margin: 50px auto; background: #222; padding: 30px; border-radius: 10px;">
        <h1>Upload New Work</h1>
        <?php if(isset($msg)) { echo "<p style='color: #2ed573;'>$msg</p>"; } ?>
        
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <label>Photo Title:</label>
            <input type="text" name="title" required placeholder="e.g. Sunset in Rwanda">
            
            <label>Select Image:</label>
            <input type="file" name="image" accept="image/*" required style="border: none;">
            <label>Category:</label>
<select name="category" required style="width:100%; padding:10px; margin:10px 0; background:#333; color:white;">
    <option value="Events">Events</option>
    <option value="News">News</option>
    <option value="gallery">gallery</option>
</select>

<label>Photo Description:</label>
<textarea name="description" placeholder="Write the story behind this photo..." 
          style="width:100%; height:100px; padding:10px; margin:10px 0; background:#333; color:white; border:1px solid #444;"></textarea>
            
            <button type="submit" name="upload" class="btn" style="width: 100%;">Upload to Gallery</button>
        </form>
    </div>

    <div style="max-width: 800px; margin: 20px auto; color: white;">
    <h3>Manage Photos</h3>
    <table style="width: 100%; background: #222; margin-top: 10px; border-collapse: collapse;">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM gallery");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr style='border-bottom: 1px solid #444;'>";
            echo "<td style='padding:10px;'><img src='{$row['image_path']}' width='50'></td>";
            echo "<td>{$row['title']}</td>";
            echo "<td><a href='admin.php?delete={$row['id']}' style='color:red;' onclick='return confirm(\"Delete this photo?\")'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>