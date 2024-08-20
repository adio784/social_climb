<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Account</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
        style="background-color: #ffffff; margin: 20px auto; max-width: 600px;">
        <tr>
            <td style="padding: 20px; text-align: center;">
                <img src="{{ asset('images/SOCIAL_CLIMB_WHITEBG.png') }}" alt="Logo"
                    style="width: 150px; height: auto;">
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; background-color: #ffffff;">
                <h1 style="font-size: 24px; color: #333333;">Hello, {{ $user->last_name . ' ' . $user->first_name }}!
                </h1>
                <p style="font-size: 16px; color: #555555;">
                    Welcome to Social Climb! Please use the verification code below to verify your account:
                </p>
                <div style="text-align: center; margin: 30px 0;">
                    <span style="font-size: 22px; font-weight: bold; color: #333333;">{{ $token }}</span>
                </div>
                <p style="font-size: 16px; color: #555555;">
                    If you did not create an account, no further action is required.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #f4f4f4;">
                <p style="font-size: 14px; color: #888888;">&copy; {{ date('Y') }} Social Climb. All rights
                    reserved.</p>
            </td>
        </tr>
    </table>
</body>

</html>
