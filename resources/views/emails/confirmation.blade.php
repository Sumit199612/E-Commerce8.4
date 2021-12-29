<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register E-mail</title>
</head>
<body>
    <table>
    <tr><td>Dear {{ $name }}!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Please click on below given account confirmation link to activate your account.</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><a href="{{ url('confirm/'.$code) }}">Confirm Your Account</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td><h3>From</h3>,</td></tr>
        <tr><td><h1 style="color: #f59e42;">Keshri's Fashion</h1></td></tr>
    </table>
</body>
</html>
