<p>Hello {{ $quotation->name_with_initial }},</p>

<p>Your quotation has been generated and is attached to this email.</p>

<h4>🟢 Portal Login Details:</h4>
<p><strong>Email:</strong> {{ $quotation->email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>You can now log in to the customer portal to view updates.</p>

<p>Thank you,<br>
Capitalboost</p>
