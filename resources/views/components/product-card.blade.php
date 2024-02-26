
<div class="pro">
    <a class="product-link" href="{{route('main_products_show', $product->slug)}}" alt="{{$product->name}}">
        <img src="{{asset('/img/products/'.explode(',', $product->photos)[0])}}" alt="{{$product->name}}">
        <div class="des">
            <h5>{{$product->name}}</h5>
            <span dir="ltr">
                <del style="color: red;">{{$product->old_price}} DZD</del>
                -{{$product->Reduction()}}%
                <h4 dir="ltr">{{$product->price}} DZD</h4>
            </span>
        </div>
        <i class="fas fa-shopping-cart cart"></i>
    </a>    
</div>