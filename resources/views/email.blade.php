<!DOCTYPE html>
<html>

<head>
    <title>Quotation #{{ $quotation->id }}</title>
</head>

<body>
    <h1>Quotation #{{ $quotation->id }}</h1>
    <h3>Dear {{ $quotation->client->name }},</h3>
    <p>Please find attached your quotation Invoice</p>
    <p>Thank you!</p>

</body>

</html>