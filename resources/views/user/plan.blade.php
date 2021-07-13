<div class="card mt-4">
    <div class="card-body">
        <ul class="list-unstyled user-details list-unstyled-border list-unstyled-noborder">
            @foreach($plans as $plan)
                <li class="media">
                    <img alt="" class="mr-3 rounded-circle" width="50" src="{{asset(Storage::url('plan')).'/'.$plan->image}}">
                    <div class="media-body">
                        <div class="media-title font-style">{{$plan->name}}</div>
                        <div class="text-job text-muted"> {{isset(\Auth::user()->planPrice()['stripe_currencys_symbol'])?\Auth::user()->planPrice()['stripe_currency_symbol'].$plan->price:''}} {{' / '. $plan->duration}}</div>
                    </div>
                    <div class="media-items">
                        <div class="media-item">
                            <div class="media-value">{{$plan->max_users}}</div>
                            <div class="media-label">{{__('Users')}}</div>
                        </div>
                        <div class="media-item">
                            <div class="media-value">{{$plan->max_customers}}</div>
                            <div class="media-label">{{__('Customers')}}</div>
                        </div>
                        <div class="media-item">
                            <div class="media-value">{{$plan->max_venders}}</div>
                            <div class="media-label">{{__('Venders')}}</div>
                        </div>
                        <div class="media-item">
                            @if($user->plan==$plan->id)
                                <div class="media-value"></div>
                                <div class="media-label text-success"><h6>{{__('Active')}}</h6></div>
                            @else
                                <div class="media-value">
                                    <a href="{{route('plan.active',[$user->id,$plan->id])}}" class="btn btn-primary" title="Click to Upgrade Plan"><i class="fas fa-cart-plus"></i></a>
                                </div>
                                <div class="media-label text-success"><h6></h6></div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
