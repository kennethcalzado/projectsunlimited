<?php
$pageTitle = "Login";
ob_start();
?>
<div class="container mx-auto my-4">
    <!-- Outer Row -->
    <div class="flex justify-center">
        <div class="w-full lg:w-10/12 md:w-9/12">
            <div class="card bg-white shadow-lg my-5 ">
                <div class="card-body p-0  ">
                    <!-- Nested Row within Card Body -->
                    <div class="flex flex-wrap  ">
                        <div class="lg:w-6/12 bg-login-image lg:block hidden">
                            <img class="w-full h-full object-cover"
                                src="../assets/image/pexels-mentatdgt-1799790-1024x683.jpg" alt="Login Image">
                        </div>

                        <div class="w-full lg:w-6/12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="text-2xl text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="POST" action="../backend\login-authorization.php">
                                    <div class="mb-4">
                                        <label>Email</label>
                                        <input type="email"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address..." name="email">
                                    </div>
                                    <div class="mb-4">
                                        <label>Password</label>
                                        <input type="password"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                    </div>
                                    <div class="mb-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox text-blue-500">
                                            <span class="ml-2 text-gray-700">Remember Me</span>
                                        </label>
                                    </div>
                                    <button href="index.html" class="yellow-btn text-base">
                                        Login
                                    </button>
                                </form>
                                <hr class="my-4">
                                <div class="text-center">
                                    <a class="text-sm text-blue-500" href="forgot-password.html">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>