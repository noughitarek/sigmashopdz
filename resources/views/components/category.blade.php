<section id="product1" class="section-p1">
    <h2>{{$category->name}}</h2>
    <p>{{$category->description}}</p>
    <div class="pro-container">
        @foreach($category->Products() as $product)
        @include('components.product-card')
        @endforeach
    </div>
</section>