<div class="col-md-2">
    <div class="card">
        <div class="card-header">Navigation</div>
        <ul class="list-group">
            <!-- <li class="list-group-item bg-primary">Navigation</li> -->
            <li class="list-group-item">
                <a href="{{ route('add.account') }}">Add Bank Account</a>
            </li>

            <li class="list-group-item">
                @if($account)
                    <a href="{{ route('initiate.currency.change') }}">Convert Currency</a>
                @else
                    <a href="#">Convert Currency</a>
                @endif
            </li>

            <li class="list-group-item">
                <a href="{{ route('customer.transactions') }}">My Transactions</a>
            </li>
        </ul>
    </div>
</div>