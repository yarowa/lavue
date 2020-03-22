@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h2>{{ $question->title }}</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-secondary">Back to All Questions</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        {!! $question->bodyHtml !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

