<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password E-mail</title>
</head>
<body>
    <table>
    <tr><td>Dear {{ $name }}!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your <strong>KESHRI FASHION</strong> account password has been successfully updated .<br>Your account information is as below :</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Email : {{ $email }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>New Password : {{ $password }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td><h3>From,</h3></td></tr>
        <tr><td><h1 style="color: #f59e42;">Keshri's Fashion</h1></td></tr>
    </table>
</body>
</html>
