<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "kosmetic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve filter values
$skin_type = isset($_POST['skin_type']) ? $_POST['skin_type'] : '';
$brand = isset($_POST['brand']) ? $_POST['brand'] : '';
$allergies = isset($_POST['allergies']) ? $_POST['allergies'] : '';

// Construct SQL query
$sql = "SELECT * FROM products WHERE 1=1";

if ($skin_type) {
    $sql .= " AND skin_type = '$skin_type'";
}

if ($brand) {
    $sql .= " AND brand LIKE '%$brand%'";
}

if ($allergies) {
    $sql .= " AND allergies LIKE '%$allergies%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Products - Kosmetic</title>
    <link rel="stylesheet" href="css(filter).css">
</head>
<body>
    <header>
        <h1>Filtered Products</h1>
    </header>

    <nav>
        <a href="index.html">Home</a>
        <a href="makeup.html">Makeup Products</a>
        <a href="skincare.html">Skincare</a>
        <a href="login.html">Login</a>
        <a href="contact.html">Contact Us</a>
    </nav>

    <section id="filters">
        <h2>Adjust Filters</h2>
        <form action="filter.php" method="POST">
            <label for="skin-type">Skin Type:</label>
            <select id="skin-type" name="skin_type">
                <option value="">Any</option>
                <option value="normal" <?php if ($skin_type == 'normal') echo 'selected'; ?>>Normal</option>
                <option value="oily" <?php if ($skin_type == 'oily') echo 'selected'; ?>>Oily</option>
                <option value="dry" <?php if ($skin_type == 'dry') echo 'selected'; ?>>Dry</option>
                <option value="combination" <?php if ($skin_type == 'combination') echo 'selected'; ?>>Combination</option>
            </select>
            <label for="brand">Favorite Brand:</label>
            <input type="text" id="brand" name="brand" placeholder="Enter favorite brand..." value="<?php echo $brand; ?>">
            <label for="allergies">Allergies:</label>
            <input type="text" id="allergies" name="allergies" placeholder="Enter allergies..." value="<?php echo $allergies; ?>">
            <input type="submit" value="Apply">
        </form>
    </section>

    <section id="filtered-products">
        <h2>Products</h2>
        <div class="product-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='karly-jones-W6sLRR4E9xs-unsplash.jpg" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>Brand: " . $row['brand'] . "</p>";
                    echo "<p>Skin Type: " . $row['skin_type'] . "</p>";
                    echo "<p>Allergies: " . $row['allergies'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found matching your criteria.</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Kosmetic. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
