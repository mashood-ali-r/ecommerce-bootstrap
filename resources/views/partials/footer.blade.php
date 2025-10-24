<!-- resources/views/partials/footer.blade.php -->
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5>Store</h5>
                <p>Your one-stop shop for amazing products. Stay connected for latest deals!</p>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white text-decoration-none">Products</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Follow Us</h6>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white fs-5"><i class="bi bi-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <hr class="bg-white">
        <p class="text-center mb-0">&copy; {{ date('Y') }} Store. All rights reserved.</p>
    </div>
</footer>
