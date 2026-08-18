<!DOCTYPE html>
<html>
<body>
    <h2>Your PDF is Ready</h2>

    <p>Hello {{ $ready->user->name }},</p>

    <p>Your PDF <strong>{{ $ready->set->name }}</strong> has been generated.</p>

    <p>Records: {{ $ready->records }}</p>

    <p>The PDF is attached to this email.</p>
</body>
</html>