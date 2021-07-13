@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>
        var SalesChart = (function () {
            var $chart = $('#cash-flow');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'line',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                                ticks: {}
                            }]
                        }
                    },
                    data: {
                        labels: {!! json_encode($incExpLineChartData['day']) !!},
                        datasets: {!! json_encode($incExpLineChartData['incExpArr']) !!}

                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        var SalesChart = (function () {
            var $chart = $('#incExpBarChart');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'bar',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                                ticks: {}
                            }]
                        }
                    },
                    data: {
                        labels: {!! json_encode($incExpBarChartData['month']) !!},
                        datasets: {!! json_encode($incExpBarChartData['incExpArr']) !!}
                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();

        var DoughnutChart = (function () {
            var $chart = $('#chart-doughnut-income');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };
                var doughnutChart = new Chart($this, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: {!! json_encode($incomeCatAmount) !!},
                            backgroundColor: {!! json_encode($incomeCategoryColor) !!},
                        }],
                        labels: {!! json_encode($incomeCategory) !!},
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
                $this.data('chart', doughnutChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        var DoughnutChart = (function () {
            var $chart = $('#chart-doughnut-expense');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };
                var doughnutChart = new Chart($this, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: {!! json_encode($expenseCatAmount) !!},
                            backgroundColor: {!! json_encode($expenseCategoryColor) !!},
                        }],
                        labels: {!! json_encode($expenseCategory) !!},
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
                $this.data('chart', doughnutChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();

    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Dashboard')}}</h1>
        </div>
        @if(\Auth::user()->type=='company')
            <div class="row">
                @if($constant['taxes']<=0)
                    <div class="col-3">
                        <div class="alert alert-danger">
                            {{__('Please add constant taxes. ')}}<a href="{{route('taxes.index')}}"><b>{{__('click here')}}</b></a>
                        </div>
                    </div>
                @endif
                @if($constant['category']<=0)
                    <div class="col-3">
                        <div class="alert alert-danger">
                            {{__('Please add constant category. ')}}<a href="{{route('product-category.index')}}"><b>{{__('click here')}}</b></a>
                        </div>
                    </div>
                @endif
                @if($constant['units']<=0)
                    <div class="col-3">
                        <div class="alert alert-danger">
                            {{__('Please add constant unit. ')}}<a href="{{route('product-unit.index')}}"><b>{{__('click here')}}</b></a>
                        </div>
                    </div>
                @endif
                @if($constant['paymentMethod']<=0)
                    <div class="col-3">
                        <div class="alert alert-danger">
                            {{__('Please add constant payment method. ')}}<a href="{{route('payment-method.index')}}"><b>{{__('click here')}}</b></a>
                        </div>
                    </div>
                @endif
                @if($constant['bankAccount']<=0)
                    <div class="col-3">
                        <div class="alert alert-danger">
                            {{__('Please create bank account. ')}}<a href="{{route('bank-account.index')}}"><b>{{__('click here')}}</b></a>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('TOTAL CUSTOMERS')}}</h4>
                        </div>
                        <div class="card-body">
                            {{\Auth::user()->countCustomers()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('TOTAL VENDORS')}}</h4>
                        </div>
                        <div class="card-body">
                            {{\Auth::user()->countVenders()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-money-bill-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('TOTAL INVOICES')}}</h4>
                        </div>
                        <div class="card-body">
                            {{\Auth::user()->countInvoices()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-money-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{__('TOTAL BILLS')}}</h4>
                        </div>
                        <div class="card-body">
                            {{\Auth::user()->countBills()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Income Vs Expense')}}</h4>

                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right">{{\Auth::user()->priceFormat(\Auth::user()->todayIncome())}}</div>
                                    <div class="media-title"><a href="#">{{__('Income Today')}}</a></div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right">{{\Auth::user()->priceFormat(\Auth::user()->todayExpense())}}</div>
                                    <div class="media-title"><a href="#">{{__('Expense Today')}}</a></div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right">{{\Auth::user()->priceFormat(\Auth::user()->incomeCurrentMonth())}}</div>
                                    <div class="media-title"><a href="#">{{__('Income This Month')}}</a></div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right">{{\Auth::user()->priceFormat(\Auth::user()->expenseCurrentMonth())}}</div>
                                    <div class="media-title"><a href="#">{{__('Expense This Month')}}</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Cashflow')}}</h4>
                        <div class="card-header-action">
                            <h4>{{__('Last 15 days')}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="cash-flow" class="chartjs-render-monitor" height="210"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Income & Expense')}}</h4>
                        <div class="card-header-action">
                            <h4>{{__('Current year').' - '.$currentYear}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="incExpBarChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Income By Category')}}</h4>
                                <div class="card-header-action">
                                    <h4>{{__('Current year').' - '.$currentYear}}</h4>
                                </div>
                            </div>
                            <div class="col-12">
                                @forelse($incomeCategory as $key=>$category)
                                    <div class="text-right mt-10">
                                        <span class="graph-label" style="background-color: {{$incomeCategoryColor[$key]}}">{{$category}}</span>
                                        <span>{{\Auth::user()->priceFormat($incomeCatAmount[$key])}}</span>
                                    </div>
                                @empty
                                    <div class="text-center">
                                        <h6>{{__('there is no income by category')}}</h6>
                                    </div>
                                @endforelse
                            </div>
                            <div class="card-body">
                                <canvas id="chart-doughnut-income" height="182"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Expense By Category')}}</h4>
                                <div class="card-header-action">
                                    <h4>{{__('Current year').' - '.$currentYear}}</h4>
                                </div>
                            </div>
                            <div class="col-12">
                                @forelse($expenseCategory as $key=>$category)
                                    <div class="text-right mt-10">
                                        <span class="graph-label" style="background-color: {{$expenseCategoryColor[$key]}}">{{$category}}</span>
                                        <span>{{\Auth::user()->priceFormat($expenseCatAmount[$key])}}</span>
                                    </div>
                                @empty
                                    <div class="text-center">
                                        <h6>{{__('there is no expense by category')}}</h6>
                                    </div>
                                @endforelse
                            </div>
                            <div class="card-body">
                                <canvas id="chart-doughnut-expense" height="182"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Latest Income')}}</h4>
                        <div class="card-header-action">
                            <a href="{{route('revenue.index')}}" class="btn btn-primary">{{__('View All')}}</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Customer')}}</th>
                                    <th>{{__('Amount Due')}}</th>
                                    <th>{{__('Description')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($latestIncome as $income)
                                    <tr class="font-style">
                                        <td>{{\Auth::user()->dateFormat($income->date)}}</td>
                                        <td>{{!empty($income->customer)?$income->customer->name:''}}</td>
                                        <td>{{\Auth::user()->priceFormat($income->amount)}}</td>
                                        <td>{{$income->description}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center">
                                                <h6>{{__('there is no latest income')}}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Latest Expense')}}</h4>
                        <div class="card-header-action">
                            <a href="{{route('payment.index')}}" class="btn btn-primary">{{__('View All')}}</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Vendor')}}</th>
                                    <th>{{__('Amount Due')}}</th>
                                    <th>{{__('Description')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($latestExpense as $expense)
                                    <tr class="font-style">
                                        <td>{{\Auth::user()->dateFormat($expense->date)}}</td>
                                        <td>{{!empty($expense->vender)?$expense->vender->name:''}}</td>
                                        <td>{{\Auth::user()->priceFormat($expense->amount)}}</td>
                                        <td>{{$expense->description}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center">
                                                <h6>{{__('there is no latest expense')}}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Account Balance')}}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('Bank')}}</th>
                                    <th>{{__('Holder Name')}}</th>
                                    <th>{{__('Balance')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($bankAccountDetail as $bankAccount)
                                    <tr class="font-style">
                                        <td>{{$bankAccount->bank_name}}</td>
                                        <td>{{$bankAccount->holder_name}}</td>
                                        <td>{{\Auth::user()->priceFormat($bankAccount->opening_balance)}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center">
                                                <h6>{{__('there is no account balance')}}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Invoices')}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-header">
                                <h6><b>{{__('Weekly Statistics')}}</b></h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyInvoice['invoiceTotal'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Invoice Generated')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyInvoice['invoicePaid'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Paid')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyInvoice['invoiceDue'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Due')}}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-header">
                                <h6><b>{{__('Monthly Statistics')}}</b></h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyInvoice['invoiceTotal'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Invoice Generated')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyInvoice['invoicePaid'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Paid')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyInvoice['invoiceDue'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Due')}}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <h6><b>{{__('Recent Invoices')}}</b></h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('Customer')}}</th>
                                    <th>{{__('Issue Date')}}</th>
                                    <th>{{__('Due Date')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($recentInvoice as $invoice)
                                    <tr class="font-style">
                                        <td>{{\Auth::user()->invoiceNumberFormat($invoice->invoice_id)}}</td>
                                        <td>{{!empty($invoice->customer)? $invoice->customer->name:'' }} </td>
                                        <td>{{ Auth::user()->dateFormat($invoice->issue_date) }}</td>
                                        <td>{{ Auth::user()->dateFormat($invoice->due_date) }}</td>
                                        <td>{{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                        <td>
                                            @if($invoice->status == 0)
                                                <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 1)
                                                <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 2)
                                                <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 3)
                                                <span class="badge badge-info">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 4)
                                                <span class="badge badge-success">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center">
                                                <h6>{{__('there is no recent invoice')}}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Bills')}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-header">
                                <h6><b>{{__('Weekly Statistics')}}</b></h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyBill['billTotal'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Bill Generated')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyBill['billPaid'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Paid')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($weeklyBill['billDue'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Due')}}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-header">
                                <h6><b>{{__('Monthly Statistics')}}</b></h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyBill['billTotal'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Bill Generated')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyBill['billPaid'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Paid')}}</a></div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right">{{\Auth::user()->priceFormat($monthlyBill['billDue'])}}</div>
                                            <div class="media-title"><a href="#">{{__('Total Due')}}</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <h6><b>{{__('Recent Bills')}}</b></h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('Vendor')}}</th>
                                    <th>{{__('Bill Date')}}</th>
                                    <th>{{__('Due Date')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($recentBill as $bill)
                                    <tr class="font-style">
                                        <td>{{\Auth::user()->billNumberFormat($bill->bill_id)}}</td>
                                        <td>{{!empty($bill->vender)? $bill->vender->name:'' }} </td>
                                        <td>{{ Auth::user()->dateFormat($bill->bill_date) }}</td>
                                        <td>{{ Auth::user()->dateFormat($bill->due_date) }}</td>
                                        <td>{{\Auth::user()->priceFormat($bill->getTotal())}}</td>
                                        <td>
                                            @if($bill->status == 0)
                                                <span class="badge badge-primary">{{ __(\App\Bill::$statues[$bill->status]) }}</span>
                                            @elseif($bill->status == 1)
                                                <span class="badge badge-warning">{{ __(\App\Bill::$statues[$bill->status]) }}</span>
                                            @elseif($bill->status == 2)
                                                <span class="badge badge-danger">{{ __(\App\Bill::$statues[$bill->status]) }}</span>
                                            @elseif($bill->status == 3)
                                                <span class="badge badge-info">{{ __(\App\Bill::$statues[$bill->status]) }}</span>
                                            @elseif($bill->status == 4)
                                                <span class="badge badge-success">{{ __(\App\Bill::$statues[$bill->status]) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center">
                                                <h6>{{__('there is no recent bill')}}</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Goal')}}</h4>
                    </div>
                    <div class="card-body">
                        @forelse($goals as $goal)
                            @php
                                $total= $goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['total'];
                            $percentage=$goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'];
                            @endphp
                            <div class="col-12">
                                <div class="card card-statistic-1 card-statistic-2">
                                    <div class="card-wrap">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="card-header">
                                                    <h4>{{__('Name')}}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{$goal->name}}
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="card-header">
                                                    <h4>{{__('Type')}}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ __(\App\Goal::$goalType[$goal->type]) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="card-header">
                                                    <h4>{{__('Duration')}}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{$goal->from .' To '.$goal->to}}
                                                </div>
                                            </div>

                                            <div class="col-5">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            {{\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)}}
                                                        </div>
                                                        <div class="col-auto">
                                                            {{ number_format($percentage, 2, '.', '')}}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width:{{number_format($goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'], 2, '.', '')}}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center">
                                        <h6>{{__('there is no goal')}}</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


