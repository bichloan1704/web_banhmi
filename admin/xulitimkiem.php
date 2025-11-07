<?php
include 'config.php';

if (isset($_POST['key-search'])) {
    $searchTerm = $_POST['key-search'];

    $query = "SELECT * FROM sanpham WHERE tensanpham LIKE '%$searchTerm%'";
    $result = $conn->query($query);

    $data = array(); 

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id' => $row['id'],
                'image' => $row['image'],
                'name' => $row["tensanpham"],
                'price' => $row["gia"]
            );
        }
    }
    echo json_encode($data);
}
?>
