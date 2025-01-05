<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gaphq";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all clients
$sql = "SELECT * FROM client";
$result = $conn->query($sql);
?>

<h1>Client List</h1>
<table border="1">
    <tr>
        <th>Client Name</th>
        <th>Company</th>
        <th>Action</th>
    </tr>
    <?php while ($client = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $client['clientname']; ?></td>
            <td><?php echo $client['companyName']; ?></td>
            <td>
                <a href="update_form.php?clientID=<?php echo $client['id']; ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php $conn->close(); ?>