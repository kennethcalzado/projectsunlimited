<?php
$pageTitle = "News & Projects";
ob_start();
include("../backend/conn.php");

$sql = 'SELECT * FROM blogs ORDER BY date DESC';
$result = mysqli_query($conn, $sql);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/input.css">
    <style>
        .card-group {
            width: 350px;
            height: 450px;
            margin: 1%;
            display: inline-block;
            background-color: #D9D9D9;
            vertical-align: top;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .placeholder {
            width: 310px;
            height: 320px;
            background-color: black;
            margin: auto;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* Title styling */
        .title {
            font-weight: bold;
            color: black;
            position: relative;
            font-size: x-large;
            text-align: left;
        }

        .title::after {
            content: "";
            background-image: url('../assets/image/arrowgold.png');
            background-size: contain;
            width: 40px;
            height: 40px;
            position: absolute;
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
            background-repeat: no-repeat;
            transition: background-image 0.3s ease;
        }

        .card-group:hover {
            background-color: #F6E381;
        }

        .card-group:hover .title::after {
            background-image: url('../assets/image/arrowblack.png');
        }

        .date {
            font-size: 22px;
            color: black;
            margin-bottom: 10px;
        }

        .thumbnail {
            max-width: auto;
            max-height: auto;
            position: absolute;
            z-index: 2;
            border: 15px solid black;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        @media (max-width: 768px) {
            .card {
                width: 48%;
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <section>
        <section>
            <div class="content">
                <div class="relative">
                    <img src="../assets/image/blogbanner.png" class="w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                        <p class="text-white font-bold text-4xl text-center">STAY UPDATED WITH <br> <span class="text-[#F6E381]">PROJECTS UNLIMITED</span></p>
                    </div>
                </div>
            </div>
        </section>

        <div style="width: 100%; text-align: center;">
            <h1 style="padding-top: 25px; font-size: 38px; font-weight: 800; margin: 0;">NEWS & PROJECTS</h1>
        </div>

        <section style="padding-top: 20px; padding-bottom: 90px;">
            <div class="container mx-auto flex flex-wrap justify-center">

                <?php
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
                            <div class="card-group">
                            <a href="' . $row['page'] . '" class="card-link">
                            <div class="date">' . $row['date'] . '</div>
                                <div class="placeholder">
                                    <img src="../assets/blogs_img/' . $row['thumbnail'] . '" alt="Thumbnail" class="thumbnail">
                                </div>
                                
                                <div class="title">' . $row['title'] . '</div>
                            </a>
                                </div>';
                    }
                } else {
                    echo "No blogs found.";
                }
                ?>

                <div class="clearfix"></div>
            </div>
        </section>

</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>