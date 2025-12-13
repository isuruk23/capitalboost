<p>Hello {{ $quotation->name_with_initial }},</p>

<p>Your quotation has been generated and is attached.</p>

<h4>🟢 Portal Login Details</h4>
<p><strong>Email:</strong> {{ $quotation->email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>
    <strong>Login URL:</strong><br>
    <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
</p>

<p>Please keep your login credentials secure.</p>

<p>Thank you,<br>
Your Company Name</p>
