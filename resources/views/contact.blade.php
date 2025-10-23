@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Contact Us</h1>

    <form class="col-md-6 mx-auto bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" placeholder="Your name">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="you@example.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea class="form-control" rows="4" placeholder="Write your message..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Send Message</button>
    </form>
</div>
@endsection
