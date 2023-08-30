<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="output.css">
</head>
<body>

    <div class="w-1/2 h-auto border border-gray-400 rounded-sm mx-auto mt-32 p-3">
        <div class="text-2xl text-sky-700">Change Password</div><hr>
        <br>
        <form action="resetcode.php" method="post" class="flex flex-col space-y-4">
            <input type="hidden" name="password_token"value="<?php if(isset($_GET['token'])){echo $_GET['token']; } ?>">
            <label for="">Email Address</label>
            <input type="email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email']; } ?>" placeholder="Enter Email Address" class="p-2 border border-gray-400 rounded-md">
            <label for="">New Password</label>
            <input type="password" name="newpassword" placeholder="Enter New Password" class="p-2 border border-gray-400 rounded-md">
            <label for="">Confirm Password</label>
            <input type="password" placeholder="Enter Confirm Password" name="confirmpassword" class="p-2 border border-gray-400 rounded-md">
            <button type="submit" name="updatepass" class="w-full p-3 mx-auto rounded-lg bg-sky-500 text-white font-light mb-5 hover:bg-sky-300">Update Password</button>
        </form>
    </div>
</body>
</html>


<?php




?>