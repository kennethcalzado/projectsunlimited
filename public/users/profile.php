<?php
session_start();
$pageTitle = "Profile";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
</head>

<body class="bg-gray-100">
    <div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10 flex justify-center items-center h-screen">
        <div class="max-w-md w-full">
            <div class="bg-white shadow-md rounded-lg p-8">
                <div class="profile-image-container mb-6 flex justify-center items-center">
                    <img src="../../assets/image/projectslogo.png" alt="Profile Image" class="rounded-full w-32 h-32 object-cover">
                    <div class="edit-icon ml-2"><i class="fas fa-edit text-gray-500"></i></div> <!-- Edit icon -->
                </div>

                <form method="post" enctype="multipart/form-data">
                    <input id="file-upload" type="file" name="profile_img" accept="image/*" onchange="autoSaveImage(this)" hidden>
                    <input type="submit" id="submit_img" name="submit_img" value="Save" class="hidden">
                </form>

                <div class="container">
                    <div class="card-container">
                        <div class="card">
                            <h4 class="text-xl font-semibold mb-4">Update Password</h4>
                            <form method="post">
                                <label for="oldPass" class="block mb-2">Input Old Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="oldPass" required name="oldPass" type="password">
                                    <span toggle="#oldPass" class="toggle-old-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <label for="password" class="block mb-2">New Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="password" required name="password" type="password" minlength="8" oninput="checkPasswordStrength(this.value)">
                                    <span id="passwordStrengthIcon" class="absolute top-0 right-0 mr-3"></span>
                                    <span toggle="#passwordconfirm" class="toggle-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <!-- Password requirements -->
                                <div class="passreq mb-4" id="passwordRequirementsContainer">
                                    <p class="password-requirements-title"><b>Password Requirements:</b></p>
                                    <ul id="passwordRequirements" class="listreq pl-4">
                                        <li id="length">Minimum of 8 characters</li>
                                        <li id="specialChar">At least one special character/symbol</li>
                                        <li id="number">At least one number</li>
                                        <li id="capital">At least one capital letter</li>
                                    </ul>
                                </div>

                                <label for="passwordconfirm" class="block mb-2">Confirm New Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="passwordconfirm" required name="passwordconfirm" type="password" minlength="8" oninput="checkPasswordMatch(this.value)">
                                    <span id="confirmPasswordIcon" class="absolute top-0 right-0 mr-3"></span>
                                    <span toggle="#passwordconfirm" class="toggle-confirm-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="submit_info" class="btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>




<?php
$script = ob_get_clean();
include("../../public/master.php");
include("../../backend/conn.php");
?>