<h2>Welcome {{ $customer->name_with_initial }}</h2>

<h3>Your Plans</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>Plan</th>
        <th>Sub Plan</th>
        <th>Payment Term</th>
        <th>Status</th>
    </tr>

    @foreach($quotations as $q)
        <tr>
            <td>{{ $q->plan->plan ?? '-' }}</td>
            <td>{{ $q->subplan->plan ?? '-' }}</td>
            <td>{{ $q->paying_term }}</td>
            <td>Active</td>
        </tr>
    @endforeach
</table>

<form method="POST" action="{{ route('customer.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
