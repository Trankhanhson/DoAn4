<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
        <input type="text" id="sdt" placeholder="sdt">
        <button onclick="sendOtp()" id="XacMinh">submit</button>
    </form>

    <form action="">
        <input type="text" id="verificationcode">
        <button onclick="codeverity()">confirm</button>
    </form>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>

        function sendOtp(){
            event.preventDefault()
            const firebaseConfig = {
                apiKey: "AIzaSyB1FuGkBfcS7oHWqFGLtHSUxY3btvXiWaM",
                authDomain: "otpconfirm-de0b8.firebaseapp.com",
                projectId: "otpconfirm-de0b8",
                storageBucket: "otpconfirm-de0b8.appspot.com",
                messagingSenderId: "1551170791",
                appId: "1:1551170791:web:9cc9ae02118876e6f8b642",
                measurementId: "G-QV2VCK2XHB"
                };
            firebase.initializeApp(firebaseConfig);

            var a = document.getElementById('sdt').value;
            var b = "+84";
            var number = b + a.slice(-9);

            const appVerifier = new firebase.auth.RecaptchaVerifier('XacMinh', { size: 'invisible' });
            firebase.auth().signInWithPhoneNumber(number, appVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                appVerifier.reset();
            }).catch(function (error) {
                alert(error.message);
                appVerifier.reset();
            });
        }

        function codeverity() {
            event.preventDefault()
            var code = document.getElementById('verificationcode').value;
            coderesult.confirm(code).then(function () {
                alert("nhap ma dung")
            }).catch(function () {
                alert("nhap ma sai")
            })
        }
      </script>

</body>
</html>