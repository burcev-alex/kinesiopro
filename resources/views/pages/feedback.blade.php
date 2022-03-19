@extends('layouts.app')

@section('metaLabels')
    @parent
    @include('meta::manager', [
    'title' => "Feedback",
    'keywords' => "",
    'description' => ""
    ])
@stop

@section('content')
<form action="/feedback/" method="POST" id="feedbackForm" class="feedbackForm form-send">
    @csrf
    <label>
        <p>ФИО*</p>
        <input type="text" name="name">
    </label>
    <label>
        <p>Email*</p>
        <div class="inputs-wrapper">
            <input type="text" name="email">
        </div>
    </label>
    <label>
        <p>Phone*</p>
        <div class="inputs-wrapper">
            <input type="text" name="phone">
        </div>
    </label>
    <label>
        <p>Comments</p>
        <textarea name="comment"></textarea>
    </label>
    <input type="submit">
</form>
@endsection