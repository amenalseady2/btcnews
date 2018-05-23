<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body id="body">
    登陆成功
    <script type="text/javascript">
    var twitterId = '{{ $user->id }}';
    onemena.authSuccess(twitterId);
    </script>

</body>
</html>