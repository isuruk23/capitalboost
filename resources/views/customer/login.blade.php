<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
</head>
<body>

<h2>Customer Login</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('customer.login.submit') }}">
    @csrf

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
