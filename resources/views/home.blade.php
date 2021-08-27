@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Available features on your panel</h3>
                    <p>Use & Enjoy!</p>

                    <ul>
                        <li><a href="/running-server-processes">List of password types</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
