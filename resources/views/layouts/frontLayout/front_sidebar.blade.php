<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        <div class="panel panel-default">
            <?php //echo $categories_menu; ?>
            @foreach($categories as $cate)
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#{{ $cate->id }}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{ $cate->name }}
                        </a>
                    </h4>
                </div>
                <div id="{{ $cate->id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($cate->categories as $subcate)
                                <li><a href="{{ asset('/products/'.$subcate->url) }}">{{ $subcate->name }} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div><!--/category-products-->
</div>