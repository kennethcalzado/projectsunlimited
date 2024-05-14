<?php
session_start();
$pageTitle = "Audit Logs";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="../../../assets/input.css">

    <style>
        td.message {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td img {
            display: block;
            margin: 0 auto;
            max-width: 100px;
            max-height: 100px;
        }

        .action-btns button {
            width: auto;
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 10px;
        }

        td {
            padding: 2%;
        }

        tr {
            border-bottom: 1px solid #e5e7eb;
            /* Light Gray */
            vertical-align: center;
        }

        tr:hover {
            background-color: #f5f4f4;
            /* Gray */
        }

        tr.dark:hover {
            background-color: #f5f4f4;
            /* Off White */
        }
    </style>

</head>

<body>
    <!-- FILTER SCRIPTS -->
    <script>
        // FILTER SCRIPTS
        $(document).ready(function() {
            // Event listener for category and sort filters
            $('#sortFilter').change(function() {
                // Get the selected category and sort option
                var sortOption = $('#sortFilter').val();

                // Reset search input
                $('#searchInput').val('');

                // Call the function to fetch data based on the selected category and sort option
                fetchData(sortOption);
            });

            // Event listener for search input
            $('#searchInput').on('input', function() {
                // Get the search query
                var query = $(this).val();

                // Get the selected category and sort option
                var sortOption = $('#sortFilter').val();

                // Call the function to fetch data based on the selected sort option, and search query
                fetchData(sortOption, query);
            });

            // Function to fetch data based on category, sort option, and search query
            function fetchData(sortOption, query = '', page = 1) {
                var limit = 10; // Number of records per page
                $.ajax({
                    url: '../../../backend/fetch_logs.php',
                    method: 'POST',
                    data: {
                        sortOption: sortOption,
                        query: query, // Include search query in the AJAX request
                        page: page, // Include page parameter for pagination
                        limit: limit // Include limit parameter for pagination
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateTable(response.data); // Update table with fetched data
                        updatePagination(response.total, page, limit); // Update pagination controls
                    }
                });
            }

            function updateTable(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        html += '<tr>';
                        html += '<td>' + item.user_id + '</td>';
                        html += '<td>' + item.fname + ' ' + item.lname + '</td>';
                        html += '<td>' + item.role_name + '</td>';
                        html += '<td>' + item.action + '</td>';
                        html += '<td>' + item.date + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="4">No records found</td></tr>';
                }
                $('#blogTable tbody').html(html);
                $('#blogTable .message').text(function(i, text) {
                    return text.length > 50 ? text.substr(0, 50) + '...' : text;
                });
            }


            // Function to update pagination controls
            function updatePagination(totalCount, currentPage, limit) {
                var totalPages = Math.ceil(totalCount / limit); // Calculate total pages
                var pagination = $('#pagination');
                pagination.empty(); // Clear previous pagination buttons

                var startItem = currentPage === 1 ? 1 : (currentPage - 1) * limit + 1;
                var endItem = Math.min(currentPage * limit, totalCount);

                // Adjust endItem if it exceeds totalCount
                if (endItem > totalCount) {
                    endItem = totalCount;
                }

                // Create Page buttons
                for (var i = 1; i <= totalPages; i++) {
                    var pageBtn = $('<button>').text(i).addClass('pagination-btn mx-1 py-1 px-3 rounded-lg');
                    if (i === currentPage) {
                        pageBtn.addClass('bg-yellow-200 text-black font-bold transition');
                    } else {
                        pageBtn.addClass('bg-gray-200 text-gray-700 hover:bg-gray-300 hover:underline transition');
                    }
                    pageBtn.click(function(page) {
                        return function() {
                            fetchData($('#sortFilter').val(), $('#searchInput').val(), page);
                        };
                    }(i));
                    pagination.append(pageBtn);
                }
                pagination.addClass('flex justify-end');
                pagination.show(); // Show pagination if there are multiple pages

                $('#itemCount').text(`Showing ${startItem}-${endItem} of ${totalCount} items`);
            }

            // Fetch initial data
            fetchData('new');
        });
    </script>

    <div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20">
        <div style="padding-top: 15px;">
            <!-- Content -->
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h1 class="text-4xl font-bold mt-8">Audit Logs</h1>
            </div>
            <div class="border-b border-black flex-grow border-4 mt-2 mb-2"></div>
            <div class="flex flex-col sm:flex-row items-center justify-center">
                <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <label for="sortFilter" class="mr-2">Sort</label>
                    <select id="sortFilter" class="border rounded-md px-2 py-1">
                        <optgroup label="Sort By:">
                            <option value="new">Newest to Oldest</option>
                            <option value="old">Oldest to Newest</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <div class="relative mb-1 mt-1 sm:mb-0 sm:mr-2">
                        <!-- Search input -->
                        <div class="relative text-gray-600">
                            <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
                            <button type="button" id="searchButton" class="absolute right-0 top-0 mt-3 mr-4">
                                <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="blogTable" class="display">
                <thead>
                    <th scope="col" class="px-6 py-3 w-1/12">User ID</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Name</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Role</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Action</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Date</th>
                </thead>

                <tbody>
                    <?php
                    include("../../../backend/conn.php");

                    $sql = 'SELECT auditlogs.*, roles.role_name
                    FROM auditlogs
                    LEFT JOIN roles ON auditlogs.role_id = roles.role_id
                    ORDER BY auditlogs.date DESC';

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['fname'], ' ', $row['lname']; ?></td>
                                <td><?php echo $row['role_name']; ?></td>
                                <td><?php echo $row['action']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
            <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0 mb-9">
                <div id="itemCount" class="text-center text-gray-500"></div>
                <div id="pagination" class="justify-center mt-4"></div>
            </div>
        </div>
</body>

<?php
$content = ob_get_clean();

include("../../../public/master.php");
include("../../../backend/conn.php");
?>