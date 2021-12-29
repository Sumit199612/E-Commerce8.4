@extends('layouts.frontLayout.front_design')
@section('content')

    <section>
        <style>
            * {
                box-sizing: border-box;
            }

            .img-magnifier-container {
                position: relative;
            }

            .img-magnifier-glass {
                position: absolute;
                border: 3px solid #000;
                border-radius: 50%;
                cursor: none;
                /*Set the size of the magnifier glass:*/
                width: 100px;
                height: 100px;
            }

        </style>

        <div class="container">
            <div class="row">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="col-sm-3">
                    @include('layouts.frontLayout.front_sidebar')
                </div>
                <div class="col-sm-9 padding-right">
                    <div class="product-details">
                        <!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <div class="img-magnifier-container">
                                    <!--<a class="mainImage" href="{{ asset('images/backend_images/products/large/' . $productDetails->product_image) }}">-->
                                    <img width="300" height="300" id="myimage" class="mainImage"
                                        src="{{ asset('images/backend_images/products/large/' . $productDetails->product_image) }}"
                                        alt="" />
                                    <!--</a>-->
                                </div>
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                        @foreach ($productAltImages as $altimage)
                                            <!--      <a href="{{ asset('images/backend_images/products/large/' . $productDetails->product_image) }}" data-standard="{{ asset('images/backend_images/products/small/' . $productDetails->product_image) }}">-->
                                            <img class="changeImage"
                                                src="{{ asset('/images/backend_images/products/large/' . $altimage->product_image) }}"
                                                style="width:80px;  cursor:pointer;" alt="Product alternate image">
                                            <!-- </a>-->
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Controls -->
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <form name="addtocartForm" id="addtocartForm" action="{{ url('add-cart') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                                <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                                <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                                <input type="hidden" name="product_price" id="price"
                                    value="{{ $productDetails->product_price }}">
                                <div class="product-information">
                                    <!--/product-information-->
                                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                                    <h2>{{ $productDetails->product_name }}</h2>
                                    <p>Code: {{ $productDetails->product_code }}</p>
                                    <p>

                                        <!-- <button id="clickME" onclick="clickME()"> HI</button> -->
                                        <select id="selSize" name="Size" style="width:150px;">
                                            <option value="">Select Size</Option>
                                            @foreach ($productDetails->attributes as $sizes)
                                                <option value="{{ $productDetails->id }}-{{ $sizes->size }}">
                                                    {{ $sizes->size }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                    <img src="images/product-details/rating.png" alt="" />
                                    <span>
                                        <span id="getPrice">INR {{ $productDetails->product_price }}</span>
                                        <label>Quantity:</label>
                                        <input type="text" name="quantity" value="1" />
                                        @if ($total_stock > 0)
                                            <button type="submit" class="btn btn-fefault cart" id="cartButton">
                                                <i class="fa fa-shopping-cart"></i>
                                                Add to cart
                                            </button>
                                        @endif
                                    </span>
                                    <p><b>Availability:</b> <span id="Availability">@if ($total_stock > 0) In Stock @else Out of Stock @endif</p></span>
                                    <p><b>Condition:</b> New</p>
                                    <p><b>Brand:</b> E-SHOPPER</p>
                                    <a href=""><img src="images/product-details/share.png" class="share img-responsive"
                                            alt="" /></a>
                                </div>
                                <!--/product-information-->
                            </form>
                        </div>
                    </div>
                    <!--/product-details-->

                    <div class="category-tab shop-details-tab">
                        <!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#care" data-toggle="tab">Material & Care</a></li>
                                <li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active in" id="description">
                                <div class="col-sm-12">
                                    <p>{{ $productDetails->product_description }}</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="care">
                                <div class="col-sm-12">
                                    <p>{{ $productDetails->care }}</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="delivery">
                                <div class="col-sm-12">
                                    <p>100% Original Product <br>
                                        Cash On Delivery
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/category-tab-->

                    <div class="recommended_items">
                        <!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>

                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php $count = 1; ?>
                                @foreach ($relatedProducts->chunk(3) as $chunk)
                                    <div <?php if ($count == 1) {?> class="item active" <?php } else {?>
                                        class="item" <?php }?>>
                                        @foreach ($chunk as $item)
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img style="width:230px;"
                                                                src="{{ asset('/images/backend_images/products/large/' . $item->product_image) }}"
                                                                alt="Recommended Product Image" />
                                                            <h2>INR {{ $item->product_price }}</h2>
                                                            <p>{{ $item->product_name }}</p>
                                                            <a href="{{ url('product/' . $item->id) }}"><button
                                                                    type="button" class="btn btn-default add-to-cart"><i
                                                                        class="fa fa-shopping-cart"></i>Add to
                                                                    cart</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <?php $count++; ?>
                                @endforeach
                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!--/recommended_items-->

                </div>
            </div>
        </div>
        <script>
            function magnify(imgID, zoom) {
                var img, glass, w, h, bw;
                img = document.getElementById(imgID);

                /* Create magnifier glass: */
                glass = document.createElement("DIV");
                glass.setAttribute("class", "img-magnifier-glass");

                /* Insert magnifier glass: */
                img.parentElement.insertBefore(glass, img);

                /* Set background properties for the magnifier glass: */
                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
                bw = 3;
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;

                /* Execute a function when someone moves the magnifier glass over the image: */
                glass.addEventListener("mousemove", moveMagnifier);
                img.addEventListener("mousemove", moveMagnifier);

                /*and also for touch screens:*/
                glass.addEventListener("touchmove", moveMagnifier);
                img.addEventListener("touchmove", moveMagnifier);

                function moveMagnifier(e) {
                    var pos, x, y;
                    /* Prevent any other actions that may occur when moving over the image */
                    e.preventDefault();
                    /* Get the cursor's x and y positions: */
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;
                    /* Prevent the magnifier glass from being positioned outside the image: */
                    if (x > img.width - (w / zoom)) {
                        x = img.width - (w / zoom);
                    }
                    if (x < w / zoom) {
                        x = w / zoom;
                    }
                    if (y > img.height - (h / zoom)) {
                        y = img.height - (h / zoom);
                    }
                    if (y < h / zoom) {
                        y = h / zoom;
                    }
                    /* Set the position of the magnifier glass: */
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";
                    /* Display what the magnifier glass "sees": */
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
                }

                function getCursorPos(e) {
                    var a, x = 0,
                        y = 0;
                    e = e || window.event;
                    /* Get the x and y positions of the image: */
                    a = img.getBoundingClientRect();
                    /* Calculate the cursor's x and y coordinates, relative to the image: */
                    x = e.pageX - a.left;
                    y = e.pageY - a.top;
                    /* Consider any page scrolling: */
                    x = x - window.pageXOffset;
                    y = y - window.pageYOffset;
                    return {
                        x: x,
                        y: y
                    };
                }
            }

            /* Execute the magnify function: */
            magnify("myimage", 3);
            /* Specify the id of the image, and the strength of the magnifier glass: */
        </script>

    </section>



@endsection
