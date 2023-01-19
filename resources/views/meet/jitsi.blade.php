<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


    <script src="{{ mix('/js/app.js') }}"></script>
    
    <script src='https://meet.jit.si/external_api.js'></script>
    <script type="text/javascript">
        const codeAddress = () => {
            const domain = `meet.jit.si/${document.getElementById('info')}`;
            const options = {
                roomName: document.getElementById('roomName').value,
                width: 1910,
                height: 932,
                parentNode: document.querySelector('#meet').value,
                userInfo: {
                    email: document.getElementById('email').value,
                    displayName: document.getElementById('name').value
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);
        }
        window.onload = codeAddress;
    </script>
    
    <title>Meet</title>
</head>
<body>
    <input type="hidden" id="info" value="{{ $roomId }}">
    <input type="hidden" id="email" value="{{ $email }}">
    <input type="hidden" id="name" value="{{ $name }}">
    <input type="hidden" id="roomName" value="{{ $roomName }}">
    
    <div id="meet"></div>
</body>
</html>