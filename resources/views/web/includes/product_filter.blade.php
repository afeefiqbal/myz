
<form id="filter-form" method="post">
    <div class="accordion" id="accordionPanelsStayOpenExample">             
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    @php
                        $categoryCount = \App\Models\Category::count();
                        $colorCount = \App\Models\Color::count();
                        $shapeCount = \App\Models\Shape::count();
                        $tagCount = \App\Models\Tag::count();
                    @endphp
                <button class="accordion-button show @if ($categoryCount > 0) has_sub_category  @endif" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="" aria-controls="">
                    <div class="form-check title">
                        <label class="form-check-label label_bold" for="">
                        Category
                        </label>
                    </div>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse  show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                    @foreach($parentCategories as $parent)
                        @foreach($parent->activeChildren as $subCategory)
                        <?php if(isset($subCategory->title)){
                        $parent_ = true;
                        } ?>
                        @endforeach
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            
                                <button class="accordion-button
                                @if($parent->activeChildren->count() > 0)
                                has_sub_category
                                @endif
                                 collapsed   {{ ($loop->iteration == 2)?'':'test' }} {{ $parent->short_url == $typeValue?'selected':'' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $parent->short_url }}" aria-expanded="true" aria-controls="{{ $parent->short_url }}  "  id="parent_cat{{ $parent->id }}">
                                
                                    <div class="form-check">
                                        <input class="form-check-input filterItem categoryFilterItem"  type="checkbox" 
                                                   type="checkbox" name="category_id[]"
                                                   id="Category_{{$parent->id}}"
                                                   value="{{$parent->id}}"
                                                   data-field="category_id"
                                                   data-label="Category"
                                                   data-title="{{$parent->title}}" {{ $parent->short_url == $typeValue?'checked':'' }}
                                                   @if(@$urlType == $parent->short_url) checked @endif
                                                   >
                                        <label class="form-check-label" for="Category_{{ $parent->id }}">
                                        {{ $parent->title }}
                                        </label>
                                    </div>
                                </button>
                            </h2>
                            <div id="{{ $parent->short_url }}" class="accordion-collapse collapse   {{ ($loop->iteration ==1)?' ':'' }}" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <ul>  
                                        @foreach($parent->activeChildren as $subCategory)
                                            
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input filterItem" type="checkbox" value="{{$subCategory->id}}"  name="sub_category_id[]" data-parent = "{{ $subCategory->parent_id }}"
                                                        id="Category_{{$subCategory->id}}"
                                                        data-field="sub_category_id"
                                                        value="{{ $subCategory->id }}"
                                                        data-label="Category"
                                                    
                                                        @if(@$urlType == $subCategory->short_url) checked @endif
                                                        data-title="{{$subCategory->title}}">
                                                <label class="form-check-label" for="Category_{{$subCategory->id}}">
                                                {{ $subCategory->title }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button show @if ($colorCount > 0) has_sub_category  @endif" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                    <div class="form-check title">
                        <label class="form-check-label label_bold" for="flexCheckDefault">
                            Color
                        </label>
                    </div>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse  show" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <div class="colorWrapper">
                        @foreach($colors as $color)
                        {{-- {{ $color->title == $typeValue?'active':'dd' }} --}}
                            <a href="javascript:void(0)" class="colorItem colorItemFilterClick">
                                <input type="checkbox"  name="color_id[]" id="Color_{{$color->id}}" data-field="color_id" value="{{ $color->id }}" data-label="Color"  data-title="{{$color->title}}" {{ $color->title == $typeValue?'checked':'' }} class="form-check-input filterItem d-none">
                                <label for="Color_{{$color->id}}" class="colorBox" style="background:{{$color->code}}"> </label>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                <button class="accordion-button show @if ($shapeCount > 0) has_sub_category  @endif"  type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                    <div class="form-check title">
                        <label class="form-check-label label_bold" for="flexCheckDefault">
                            SHAPE
                        </label>
                    </div>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse  show" aria-labelledby="panelsStayOpen-headingFour">
                <div class="shapeArea">
                    @foreach($shapes as $shape)
                    <a href="javascript:void(0)" class="shapeFilterClick">
                        <label for="Shape_{{$shape->id}}"> 
                            {!! Helper::printImage($shape, 'image', 'image_webp', '', 'img-fluid') !!}
                            <h6>{{ @$shape->title }}</h6>
                        </label>
                        <input type="checkbox"  name="shape_id[]" id="Shape_{{$shape->id}}" data-field="shape_id" value="{{ $shape->id }}" data-label="Shape"   data-title="{{$shape->title}}"  {{ $shape->title == $typeValue?'checked':'' }} class="form-check-input filterItem d-none">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button show has_sub_category" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                    <div class="form-check title">
                        <label class="form-check-label label_bold" for="flexCheckDefault">
                            Price
                        </label>
                    </div>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse  show" aria-labelledby="panelsStayOpen-headingThree">
                <div class="priceRagerArea">
                    <div class="slider-range-wrap">
                        <div class="currencyBox">{{Helper::defaultCurrency()}}</div>
                            @php $dc = Helper::defaultCurrency(); @endphp
                            <div id="slider-range" class="range_bar_sort"></div>
                            <p class="range-value">
                                <input type="text" id="amount" name="my_range"  value="AED{{ Helper::getMinPrice() }}-AED{{ Helper::getMaxPrice() }}"data-min="{{ Helper::getMinPrice() }}"  data-max="{{ Helper::getMaxPrice() }}"  data-from="{{ Helper::getMinPrice() }}"  data-to="{{ Helper::getMaxPrice() }}">
                            </p>
    
                        </div>
                    </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                <button class="accordion-button show @if ($tagCount > 0) has_sub_category  @endif" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                    <div class="form-check title">
                        <label class="form-check-label label_bold" for="flexCheckDefault">
                            Product tags
                        </label>
                    </div>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse  show" aria-labelledby="panelsStayOpen-headingFive">
                <div class="productTagArea">
                    
                    @foreach($tags as $tag)
                    
                    <label for="tag_{{$tag->id}}"  class="tagFilterClick">
                        <label class="d-block" for="tag_{{$tag->id}}">{{ @$tag->title }}</label>
                        <input type="checkbox"  name="tag_id[]" id="tag_{{$tag->id}}" data-field="tag_id" value="{{ $tag->id }}" data-label="Tag"  data-title="{{$tag->title}}" {{ $color->short_url == $typeValue?'checked':'' }}  class="form-check-input filterItem d-none">
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" id="sort_value" name="sort_value"
    value="{{ $sort_value }}">
    <input type="hidden" id="input_field" name="input_field">
    <input type="hidden" name="pageType" id="type" value="{{$type}}">
    <input type="hidden" name="typeValue" id="typeValue" value="{{$typeValue}}">
    <input type="hidden" name="title" id="title" value="{{$title}}">
    
    <input type="hidden" id="loading_offset" name="loading_offset"
    value="{{$offset}}">
    <input type="hidden" id="loading_limit" name="loading_limit"
    value="{{$loading_limit}}">
    <input type="hidden" id="totalProducts" name="totalProducts" value="{{$totalProducts}}">
</form>

@push('scripts')

<script>
       $(function() {
           
           
    
           
           
           $( "#slider-range" ).slider({
        range: true,
        min: {{ Helper::getMinPrice() }},
        max: {{ Helper::getMaxPrice() }},
        values: [ {{ Helper::getMinPrice() }}, {{ Helper::getMaxPrice() }} ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "AED" + {{ Helper::getMinPrice() }} + " -AED" + {{ Helper::getMaxPrice() }} );
        }
    });
    $( "#amount" ).val( "AED" + $( "#slider-range" ).slider( "values", 0 ) +
    " -AED" + $( "#slider-range" ).slider( "values", 1 ) );
    
    
    
    
    
    // check any class is active or not

});
</script>
@endpush


<!-- <h4>Price Range</h4>
    <p>Range : {{Helper::defaultCurrency()}}
        {{ Helper::getMinPrice() }} - {{Helper::defaultCurrency()}}
        {{ Helper::getMaxPrice() }}</p>
        <div class="price-range-slider">
            <div id="slider-range" class="range-bar range_bar_sort"></div>
            <p class="range-value">
                <input type="text" id="amount" name="my_range"
                value="AED{{ Helper::getMinPrice() }}-AED{{ Helper::getMaxPrice() }}"
                data-min="{{ Helper::getMinPrice() }}"
                data-max="{{ Helper::getMaxPrice() }}"
                data-from="{{ Helper::getMinPrice() }}"
                data-to="{{ Helper::getMaxPrice() }}">
            </p>
        </div>
        //     var amount = $("#amount").val();
        //     alert(amount);
        
        
        
        // var substring = amount.replace("AED", "");
        
        // var substrings = substring.replace("AED", "");
        
        // var substringss = substrings.replace("-", ",");
        // values=substringss.split(',');
        
        //      var min = values[0];
        
        //      var max = values[1];
</div> -->