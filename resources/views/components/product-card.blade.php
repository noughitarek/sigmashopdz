
<div class="pro">
    <a class="product-link" href="{{route('main_products_show', $product->slug)}}" alt="{{$product->name}}">
        <img src="{{asset('/img/products/'.explode(',', $product->photos)[0])}}" alt="{{$product->name}}">
        <div class="des">
            <span dir="ltr">- {{$product->Reduction()}}%</span>
            <h5>{{$product->name}}</h5>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h4>DZD {{$product->price}}</h4>
        </div>
        <i class="fas fa-shopping-cart cart"></i>
    </a>    
</div>