@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div style="max-width: 500px; margin: 2rem auto; text-align: center;">
    <h2>Verify Your Email</h2>
    <p>Thanks for registering! Before you can log in, please verify your email address by clicking the link we sent to <strong>{{ auth()->user()->email }}</strong>.</p>
    <p>If you didn't receive the email, click below to resend.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
    @if(session('status') === 'verification-link-sent')
        <p class="alert alert-success" style="margin-top: 1rem;">A new verification link has been sent to your email.</p>
    @endif
</div>
@endsection
