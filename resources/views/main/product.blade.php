@extends('layouts.main')
@section('content')
<section id="productdetails" class="section-p1">
    <div class="single-pro-image">
        <img src="{{asset('/img/products/'.explode(',', $data['product']->photos)[0])}}" width="100%" id="MainImg" alt="{{$data['product']->name}}">
        <div class="small-image-group">
            @foreach(explode(',', $data['product']->photos) as $photo)
            <div class="small-img-col">
                <img src="{{asset('/img/products/'.$photo)}}" width="100%" class="small-img" alt="{{$data['product']->name}}">
            </div>
            @endforeach
        </div>
    </div>
    <div class="single-pro-details">
        <h5 id="product_navigation" >
            الصفحة الرئيسية /
            {{$data['product']->Category()->name}} /
            {{$data['product']->name}}
        </h5>
        <h4 id="product_name">{{$data['product']->name}}</h4>
        <center dir="ltr">
            <h4>
                <del style="color: red;">{{$data['product']->old_price}} DZD</del>
                <span>{{$data['product']->price}} DZD</span>
            </h4>
            
			<div class="container">
				<h4 class="text-content">
                    متبقي للعرض
                    <div style="color: red;" id="timer">00:00:00</div>
                </h4>
			</div>
        </center>
        <section id="form-details">
			<form id="orderForm" action="{{route('main_products_order', $data['product']->slug)}}" method="POST">
                @csrf
                
			    <center><h2 id="order">للطلب</h2></center>
                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="name" dir="rtl">الإسم الكامل <span style="color: red;ba">*</span></label>
                        <label for="name" dir="ltr">Nom complet <span style="color: red;">*</span></label>
                    </div>
                    <input type="text" id="name" name="name" required>
                    <span id="nameErr" style="color: red;font-size: 15px;">يرجى إدخال الإسم بالشكل الصحيح</span>
                </div>

                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="phone" dir="rtl">رقم الهاتف <span style="color: red;ba">*</span></label>
                        <label for="phone" dir="ltr">Num de téléphone <span style="color: red;">*</span></label>
                    </div>
                    <input type="text" id="phone" name="phone" required>
                    <span id="phoneErr" style="color: red;font-size: 15px;">يرجى إدخال رقم الهاتف بالشكل الصحيح</span>
                </div>
                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="phone2" dir="rtl">رقم الهاتف أخر</label>
                        <label for="phone2" dir="ltr">Autre numéro</label>
                    </div>
                    <input type="text" id="phone2" name="phone2">
                    <span style="color: red;font-size: 15px;"> &nbsp; </span>
                </div>
                @foreach($data['product']->Attributes() as $attribute)
                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="attributes" dir="rtl">{{$attribute->title_ar}} <span style="color: red;">*</span></label>
                        <label for="attributes" dir="ltr">{{$attribute->title}} <span style="color: red;">*</span></label>
                    </div>
                    <select dir="ltr" id="attributes" name="attributes[{{$attribute->id}}]" required>
                        @php
                            $i=0
                        @endphp
                        @while(true)
                            @if(isset(explode(",", $attribute->values)[$i]))
                            <option value="{{explode(',', $attribute->values)[$i]}}">
                                {{explode(",", $attribute->values)[$i]}}
                                @if(isset(explode(",", $attribute->values_ar)[$i]) && explode(",", $attribute->values_ar)[$i] != "")
                                    &nbsp;-&nbsp;
                                    {{explode(",", $attribute->values_ar)[$i]}}
                                @endif
                            </option>
                            @elseif(isset(explode(",", $attribute->values_ar)[$i]))
                            <option value="{{explode(',', $attribute->values_ar)[$i]}}">
                                @if(isset(explode(",", $attribute->values)[$i]) && explode(",", $attribute->values)[$i] != "")
                                    {{explode(",", $attribute->values)[$i]}}&nbsp;-&nbsp;
                                @endif
                                {{explode(",", $attribute->values_ar)[$i]}}
                            </option>
                            @else
                                @break
                            @endif
                            @php
                                $i++;
                            @endphp
                        @endwhile
                    </select>
                </div>
                @endforeach

                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="wilaya" dir="rtl">ولاية <span style="color: red;">*</span></label>
                        <label for="wilaya" dir="ltr">Wilaya <span style="color: red;">*</span></label>
                    </div>
                    <select dir="ltr" id="wilaya" name="wilaya" required>
						<option value="0" selected disabled>اختر الولاية</option>
                        @foreach($data['wilayas'] as $wilaya)
                            @if($wilaya->shown_price == null)
                                @continue
                            @endif
                            <option value="{{$wilaya->id}}">{{$wilaya->id}}. {{$wilaya->name}}&nbsp;-&nbsp;{{$wilaya->name_ar}}</option>
                        @endforeach
                    </select>
                    <span id="wilayaErr" style="color: red;font-size: 15px;">يرجى إدخال الولاية بالشكل الصحيح</span>
                </div>
                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="commune" dir="rtl">البلدية <span style="color: red;ba">*</span></label>
                        <label for="commune" dir="ltr">Commune <span style="color: red;">*</span></label>
                    </div>
                    <select dir="ltr" id="commune" name="commune" required>
						<option value="0" selected disabled>اختر البلدية</option>
                    </select>
                    <span id="communeErr" style="color: red;font-size: 15px;">يرجى إدخال البلدية بالشكل الصحيح</span>
                </div>

                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="address" dir="rtl">العنوان <span style="color: red;ba">*</span></label>
                        <label for="address" dir="ltr">Adresse <span style="color: red;">*</span></label>
                    </div>
                    <input type="text" id="address" name="address" required>
                    <span id="addressErr" style="color: red;font-size: 15px;">يرجى إدخال العنوان بالشكل الصحيح</span>
                </div>

                <div class="container" style="width: 100%;">
                    <div class="label-container">
                        <label for="quantity" dir="rtl">الكمية <span style="color: red;ba">*</span></label>
                        <label for="quantity" dir="ltr">Quantité <span style="color: red;">*</span></label>
                    </div>
                    <select dir="rtl" id="quantity" name="quantity" required>
                        @for($i=1;$i<=10;$i++)
						<option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>


				<div>
					<label for="productPrice">سعر المنتوج:</label>
					<h2 style="color: green; text-align: center;" id="productPrice">{{$data["product"]->price}} دج</h2>
					<input type="hidden" name="clean_price" id="productPriceInput" class="form-control" value="{{$data['product']->price}}" readonly>
				</div>
				<div>
					<label for="deliveryPrice">السعر التوصيل (باب المنزل):</label>
					<h2 style="color: green; text-align: center;" id="deliveryPrice">يرجى إدخال الولاية و البلدية</h2>
					<input type="hidden" name="delivery_price" class="form-control" id="deliveryPriceInput" value="0" readonly>
				</div>
				<div>
					<label for="totalPrice">السعر الإجمالي:</label>
					<h2 style="color: green; text-align: center;" id="totalPrice">يرجى إدخال الولاية و البلدية</h2>
					<input type="hidden" name="total_price" class="form-control" id="totalPriceInput" value="0" readonly>
				</div><br>
                <center>
                    <button id="submitButton" type="submit" class="normal" ><b>أرسل الطلب</b></button><br>
                    <span id="errorMessage" style="color: red;font-size: 15px;">يرجى إدخال معلوماتك بالشكل الصحيح لتقديم الطلب</span>
                </center>
            </form>
        </section>
        <div id="product_description">
            {!!$data['product']->description!!}
        </div>
    </div>
</section>

@endsection
@section("scripts")
<script>
    var mainImg = document.getElementById("MainImg");
    var smallImgs = document.querySelectorAll(".small-img");
    smallImgs.forEach((smallImg)=>{
        smallImg.onclick = function() {
            mainImg.src = smallImg.src;
        }
    })
	var timerElement = document.getElementById("timer");
	var countdown = getInitialCountdown();
	function getInitialCountdown() {
	var now = new Date();
	var secondsSinceMidnight = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
	console.log(secondsSinceMidnight)
	var remainingSeconds = (24 * 60 * 60) - secondsSinceMidnight;
	while(remainingSeconds<0)
	{
		remainingSeconds = remainingSeconds + (24 * 60 * 60)
	}
	return remainingSeconds<3600?remainingSeconds+3600:remainingSeconds;
	}
	function startTimer() {
	var hours, minutes, seconds;
	var interval = setInterval(function() {
		hours = parseInt(countdown / 3600, 10);
		minutes = parseInt((countdown % 3600) / 60, 10);
		seconds = parseInt(countdown % 60, 10);
		hours = hours < 10 ? "0" + hours : hours;
		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;
		if (--countdown < 0) {
			countdown = countdown+3600;
		}
		
		timerElement.textContent = hours + ":" + minutes + ":" + seconds;
	}, 1000);
	}
	startTimer();

</script>
<script>
    const communes_names = {@foreach ($data['communes'] as $commune)"{{$commune->id}}":{'name': "{!!$commune->name!!}", 'name_ar': "{!!$commune->name_ar!!}", 'wilaya': "{{$commune->Wilaya()->id}}"}, @endforeach}
    const deliveryPrices = {@foreach ($data['wilayas'] as $wilaya){{$wilaya->id}}:{{$wilaya->shown_price ?? '-1'}}, @endforeach}

	const submitButton = document.getElementById("submitButton");
	const orderForm = document.getElementById("orderForm");
	const name = document.getElementById("name");
	const phone = document.getElementById("phone");
	const address = document.getElementById("address");
	const wilaya = document.getElementById("wilaya");
	const commune = document.getElementById("commune");
    const quantity = document.getElementById("quantity");
    const errorMessage = document.getElementById("errorMessage");
    const nameErr = document.getElementById("nameErr");
    const phoneErr = document.getElementById("phoneErr");
    const addressErr = document.getElementById("addressErr");
    const wilayaErr = document.getElementById("wilayaErr");
    const communeErr = document.getElementById("communeErr");
    
    quantity.addEventListener("change", updatePrices);
    wilaya.addEventListener("change", updatePrices);
	wilaya.addEventListener("change", updateCommune);   

	commune.addEventListener("change", updateSubmitButtonState);    
	wilaya.addEventListener("change", updateSubmitButtonState);    
	name.addEventListener("input", updateSubmitButtonState);
	phone.addEventListener("input", updateSubmitButtonState);
	address.addEventListener("input", updateSubmitButtonState);

	submitButton.addEventListener("mouseover", function() {
        if (this.disabled) {
            this.style.cursor = "not-allowed";
        } else {
            this.style.cursor = "pointer";
        }
    });

    submitButton.addEventListener("mouseout", function() {
        this.style.cursor = "auto";
    });
    submitButton.addEventListener("click", function(){
        submitButton.disabled = true;
        submitButton.innerHTML = "يرجى الإنتظار ..";
        fbq('track', 'Purchase', {
            value: {{$data['product']->price}},
            currency: 'DZD'
        });
        orderForm.submit();
    });
    deliveryPrice = 0
    updateSubmitButtonState()
    function updatePrices()
    {
        deliveryPrice = deliveryPrices[document.getElementById("wilaya").value]
        productPrice = {{$data['product']->price}} * quantity.value

        totalPrice = deliveryPrice+productPrice
        productPriceInput.value = productPrice
        document.getElementById("productPrice").innerHTML = productPrice+ " دج"
        deliveryPriceInput.value = deliveryPrice
        if(document.getElementById("wilaya").value != 0)
        {
            if(deliveryPrice==0)
            {
                document.getElementById("deliveryPrice").innerHTML = "مجاني"
            }
            else
            {
                document.getElementById("deliveryPrice").innerHTML = deliveryPrice+ " دج"
            }
            totalPriceInput.value = totalPrice
            document.getElementById("totalPrice").innerHTML = totalPrice+ " دج"
        }
        else
        {
            document.getElementById("deliveryPrice").innerHTML = "يرجى إدخال الولاية و البلدية"
            document.getElementById("totalPrice").innerHTML = "يرجى إدخال الولاية و البلدية"
        }
    }
    function updateCommune()
    {
		commune.innerHTML = "";
		var selectedWilaya = wilaya.value;
		var pleaseSelectOption = new Option("اختر البلدية", 0);
		commune.appendChild(pleaseSelectOption);
		for (var communeId in communes_names)
		{
			if(communes_names[communeId].wilaya == selectedWilaya)
			{
				var option = new Option(communes_names[communeId].name+" - "+communes_names[communeId].name_ar, communeId);
				commune.appendChild(option);
			}
		}
    }
    
	function updateSubmitButtonState()
	{
		const phoneRegex = /^(0|213)[5-7]\d{8}$/;
		submitButton.disabled = false;
		errorMessage.style.display = "none"
		nameErr.style.display = "none"
		phoneErr.style.display = "none"
		addressErr.style.display = "none"
		wilayaErr.style.display = "none"
		communeErr.style.display = "none"

		if (name.value.trim() === "")
		{
			submitButton.disabled = true;
			errorMessage.style.display = "block"
			nameErr.style.display = "block"
		}
		if (address.value.trim() === "")
		{
			submitButton.disabled = true;
			errorMessage.style.display = "block"
			addressErr.style.display = "block"
		}
		if (wilaya.value<1 || wilaya.value>58)
		{
			submitButton.disabled = true;
			errorMessage.style.display = "block"
			wilayaErr.style.display = "block"
		}
		if (commune.value==0)
		{
			submitButton.disabled = true;
			errorMessage.style.display = "block"
			communeErr.style.display = "block"
		}
		if(!phoneRegex.test(phone.value.replace(/\D/g, '')))
		{
			submitButton.disabled = true;
			errorMessage.style.display = "block"
			phoneErr.style.display = "block"
		}
	}
</script>
@endsection