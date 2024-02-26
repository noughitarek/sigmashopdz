<section id="product1" class="section-p1">
    @if($data["show_custom_category_name"])
    <h2>{{$data["show_custom_category_name"]}}</h2>
    @else
    <h2>{{$category->name}}</h2>
    @endif
    <p>{{$category->description}}</p>
    <div class="pro-container">
        @foreach($category->Products() as $product)
        @include('components.product-card')
        @endforeach
    </div>
</section>