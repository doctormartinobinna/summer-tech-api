@extends('layouts.frontend')

@section('title', 'Single Product - Blade API Consumption')

@section('content')
    <p><a href="{{ route('blade.products.index') }}">← Back to Products</a></p>
    <h1>Product Details</h1>
    <div id="feedback" class="message loading">Loading product details...</div>

    <div id="product-card" style="display: none;">
        <img id="product-image" class="product-image" style="width: 180px; height: 130px;" alt="Product image">
        <h2 id="product-name"></h2>
        <p><strong>Category:</strong> <span id="product-category"></span></p>
        <p><strong>Price:</strong> <span id="product-price"></span></p>
        <p><strong>Status:</strong> <span id="product-status"></span></p>
        <p><strong>Description:</strong></p>
        <p id="product-description"></p>
    </div>

    <script>
        const productId = @json(request()->route('id'));
        const productEndpoint = "{{ url('/api/products') }}/" + productId;

        function formatMoney(value) {
            return new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            }).format(Number(value || 0));
        }

        function getProductFromPayload(payload) {
            return payload.data ?? payload;
        }

        async function loadProduct() {
            const feedback = document.getElementById('feedback');
            const card = document.getElementById('product-card');

            try {
                const response = await fetch(productEndpoint, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Request failed with status ' + response.status);

                const payload = await response.json();
                const product = getProductFromPayload(payload);

                document.getElementById('product-name').textContent = product.name ?? 'No product name';
                document.getElementById('product-category').textContent = product.category?.name ?? 'No category';
                document.getElementById('product-price').textContent = formatMoney(product.price);
                document.getElementById('product-status').textContent = (product.isActive ?? product.is_active) ? 'Active' : 'Inactive';
                document.getElementById('product-description').textContent = product.description ?? 'No description available.';

                const image = document.getElementById('product-image');
                if (product.image) {
                    image.src = product.image;
                    image.style.display = 'block';
                } else {
                    image.style.display = 'none';
                }

                feedback.style.display = 'none';
                card.style.display = 'block';
            } catch (error) {
                feedback.className = 'message error';
                feedback.textContent = 'Unable to load product. ' + error.message;
            }
        }

        loadProduct();
    </script>
@endsection