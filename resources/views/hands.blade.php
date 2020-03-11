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
                            Welcome, {{ Auth::user()->name }}. Please, select here to play!
                            <div style="padding-top: 30px">
                                @if($round->count() > 0)
                                    <a href="{{route('round')}}" class="btn btn-outline-primary">Play all rounds</a>
                                @else
                                <form
                                    enctype="multipart/form-data"
                                    method="POST"
                                    action="{{ route('hands') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file"
                                               id="hands" name="hands"
                                               accept="text/plain">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-primary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                                @endif

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
