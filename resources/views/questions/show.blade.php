@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-item-center">
                                <h2>{{ $question->title }}</h2>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-secondary">Back to All Questions</a>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="media">
                            {{--@include('shared._votes', [
                               'model' => $question,
                            ])--}}
                            <Vote :model="{{ $question }}" name="question"></Vote>
                            <div class="media-body">
                                {!! $question->bodyHtml !!}
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>

                                        {{--@include('shared._author', [
                                            'model' => $question,
                                            'label' => 'asked'
                                        ])--}}
                                    <user-info :model="{{ $question }}" label="Asked"></user-info>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('answers._answers', [
            'answers' => $question->answers,
            'answerCount' => $question->answers_count,
        ])
        @include('answers._create')
    </div>
@endsection

