@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Players</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div style="padding-top: 30px">
                            <span>Total: </span>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Total Wins</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">{{Auth::user()->name }}</th>
                                    <td>{{ Auth::user()->email }}</td>
                                    <td>{{ DB::table('wins')->count() }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <p>
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
