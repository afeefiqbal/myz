


            @if($blogs->isNotEmpty())

            @foreach( $blogs as $blog )
                <div class="col-lg-4 col-md-6 marginBottom">
                    <div class="blogCard">
                        <div class="blogImage">
                        {!! Helper::printImage($blog, 'image', 'image_webp', '', 'img-fluid') !!}
                        </div>
                        <div class="blogDetails">
                            <h6>
                                {{ $blog->title }}
                            </h6>
                            <div class="textArea">

                                {!! $blog->description !!}


                            </div>
                            <div class="btnDateWrapper">
                                <a class="primary_btn" href="{{ url('blog/'.$blog->short_url) }}">Read More</a>
                                <div class="date">
                                    {{ date('d-m-Y', strtotime($blog->posted_date)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($loop->last)
                <div class="appendHere_{{$offset}}"></div>
            @endif
                @endforeach
                @endif

            </div>
            <input type="hidden" id="totalBlogs" name="total_blogs" value="{{$totalBlog}}">
        <input type="hidden" id="blog_loading_offset" name="blog_loading_offset" value="{{$offset}}">
        <input type="hidden" id="blog_loading_limit" name="blog_loading_limit" value="{{$loading_limit}}">

            @if($totalBlog>$offset)
            <div class="row">
                <div class="col-12 text-center more-section-{{$offset}}">
                    <a class="primary_btn load-more-button">Load More</a>
                </div>
            </div>

            @endif


        </div>
