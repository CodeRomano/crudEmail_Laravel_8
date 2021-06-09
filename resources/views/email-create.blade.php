@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header text-bolder">{{ __('labels.email_create') }}</div>
        <div class="card-body">
            @if (\Session::has('error'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ route('email.send') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="subject">{!! __('labels.subject') !!}</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="{!! __('labels.subject') !!}" value="{{ old('subject') }}" required>
                    
                    @error('subject')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recipient">{!! __('labels.recipient') !!}</label>
                    <input type="text" class="form-control  @error('recipient') is-invalid @enderror" id="recipient" name="recipient" placeholder="{!! __('labels.recipient') !!}" value="{{ old('recipient') }}" required>
                    
                    @error('recipient')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message">{!! __('labels.message') !!}</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                </div>

                @error('recipient')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

                <button class="btn btn-primary" type="submit">{!! __('labels.send_message') !!}</button>
                <a class="btn btn-default" href="{{ route('email.index') }}" type="button">{!! __('labels.send_cancel') !!}</a>
            </form>
        </div>
    </div>
</div>
@endsection