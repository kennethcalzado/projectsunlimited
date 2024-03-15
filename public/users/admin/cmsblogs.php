<?php
session_start();
$pageTitle = "CMS - Blogs";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../assets/input.css">

    <style>
        body,
        p {
            font-family: 'Karla', sans-serif;
            letter-spacing: -0.4px;
        }
    </style>
</head>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #F6E17A;
    }

    .btn {
        background-color: #F6E17A;
        color: #000;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #FFD700;
    }
</style>


<body>
    <div class="container">
        <!-- Content -->
        <h1 style="text-align:center; margin-top:20px;">Blog Posts</h1>
        <hr />
        <table id="blogTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Thumbnail</th>
                    <th>Description</th>
                    <th>Images</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>
                <?php
                include("../../../backend/conn.php");

                $sql = 'SELECT * FROM blogs ORDER BY date DESC';
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td><img src='../assets/blogs_img/{$row['thumbnail']}' width='100' height='100'></td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['images'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td><button onclick=\"editPost('" . $row['id'] . "')\" type='button' class='yellow-btn'>Edit</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
</body>

<?php
$content = ob_get_clean();
include("../../../public/master.php"); // Corrected path to master.php
include("../../../backend/conn.php"); // Corrected path to conn.php
?>