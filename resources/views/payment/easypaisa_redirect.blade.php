<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to EasyPaisa...</title>
</head>
<body onload="document.getElementById('easypaisa_form').submit()">
    <p>Redirecting to EasyPaisa...</p>
    <form id="easypaisa_form" action="{{ $paymentUrl }}" method="POST">
        @foreach($postData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>
</html>
