<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to JazzCash...</title>
</head>
<body onload="document.getElementById('jazzcash_form').submit()">
    <p>Redirecting to JazzCash...</p>
    <form id="jazzcash_form" action="{{ $paymentUrl }}" method="POST">
        @foreach($postData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>
</html>
