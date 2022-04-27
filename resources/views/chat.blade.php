<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>

    <!-- Missive Live Chat -->


    <!-- /Missive Live Chat -->
</head>
<!-- Missive Live Chat -->

    <!-- Missive Chat -->

<script>
    (function(d, w) {
        w.MissiveChatConfig = {
            "id": "{{$user['id']}}",
            "user": {
                "name": "{{$user['name']}}",
                "email": "{{$user['email']}}",
                "digest": "{{$user['digest']}}"
            }
        };

        var s = d.createElement('script');
        s.async = true;
        s.src = 'https://webchat.missiveapp.com/' + w.MissiveChatConfig.id + '/missive.js';
        if (d.head) d.head.appendChild(s);
    })(document, window);
</script>
<!-- /Missive Live Chat -->
<!--Coded With Love By Mutiullah Samim-->
<body>

</body>
</html>
