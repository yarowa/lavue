@extends('layouts.app')

@section('content')
    <div class="container">
        <Question-page :question="{{ $question }}"></Question-page>
    </div>
@endsection

