@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Contact Us</h1>

    <div class="row">
        <div class="col-md-6">
            <form class="bg-light p-4 rounded shadow-sm">
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
        <div class="col-md-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h4>Get in touch</h4>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    1234 Main St, Anytown, USA
                </p>
                <p>
                    <i class="fas fa-phone"></i>
                    (123) 456-7890
                </p>
                <p>
                    <i class="fas fa-envelope"></i>
                    contact@example.com
                </p>
            </div>
            <div class="mt-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.678901234567!2d-122.084!3d37.421999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQ5JzM0LjAiTiAxMjLCsDQ5JzAyLjAiVw!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
