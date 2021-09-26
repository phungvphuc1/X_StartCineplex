@extends('layouts._layout')

@section('title', $cate->Name)

@section('content')

        <div class="search-wrapper" style="margin-top: 56px;">
            <div class="container container--add" style="padding-top: 15px">
                <form id="search-form" method="post" class="search" action="/phim/tim-kiem">
                    {{ csrf_field() }}
                    <input type="text" class="search__field" placeholder="Search" name="keyword" id="txtKeyword" required>
                    <button type="submit" class="btn btn-md btn--danger search__button">Movie Search</button>
                </form>
            </div>
        </div>
        <!-- Main content -->
        <section class="container">

            <div class="clearfix"></div>

            <h2 id='target' class="page-heading heading--outcontainer">Thể loại phim: {{ $cate->Name }}</h2>

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8 col-md-9">
                        @foreach ($film as $item)

                            <div class="movie movie--test movie--test--dark movie--test--left">
                                <div style="display: none;">{{ $url = '/phim/' . $item->Metatitle . "/" . $item->ID }}</div>
                                <div class="movie__images">
                                    <a href="{{ $url }}" class="movie-beta__link">
                                        <img alt='' src="{{ asset('assets/images/film/'. $item->Image) }}" style="width: 212px; height: 212px">
                                    </a>
                                </div>

                                <div class="movie__info">
                                    <a href='{{ $url }}' class="movie__title">{{ $item->Name }}  </a>

                                    <p class="movie__time">{{ $item->Time }}</p>
                                    <p class="movie__option">
                                    @foreach($lstCate as $jtem)
                                        @if($item->ID == $jtem->Film_ID)
                                            <a href="#">{{ $jtem->Name }}</a> |
                                        @endif
                                        
                                    @endforeach
                                        
                                    </p>
                                    
                                    <div class="movie__rate">
                                        {{-- <div class="score"></div> --}}
                                        <span class="movie__rating">{{ $item->Vote }}</span>
                                    </div>               
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    
                    <aside class="col-sm-4 col-md-3">
                        <div class="sitebar first-banner--left">
                            <div class="banner-wrap first-banner--left">
                                <img alt='banner' style="width: 249px; height: 249px" src="{{asset('assets/images/cinema/hollywood.jpeg')}}">
                            </div>

                             <div class="banner-wrap">
                                <img alt='banner' style="width: 249px; height: 249px" src="{{asset('assets/images/cinema/iron-man.jpg')}}">
                            </div>

                             <div class="banner-wrap banner-wrap--last">
                                <img alt='banner' style="width: 249px; height: 249px" src="{{asset('assets/images/cinema/mavel.jpg')}}">
                            </div>
    
                        </div>
                    </aside>
                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                {{ $film->render() }}
            </div>
        </section>

@endsection

@section('jsSection')
    <script>
        var token = $("meta[name='csrf-token']").attr("content");
        var common = {
            init: function () {
                common.registerEvent();
            },
            registerEvent: function () {

                $("#txtKeyword").autocomplete({
                    minLength: 0,
                    source: function (request, response) {
                        $.ajax({
                            url: "/phim/" + request.term,//Link lấy dữ liệu gợi ý
                            dataType: "json",
                            type: 'get',
                            data: {},
                            success: function (data) {
                                response(data);
                                //response($.map(data, function (item) {
                                //    return {
                                //        value: item.Product_Name,
                                //        label: item.Image
                                //    }
                                //}));
                            }
                        });
                    },
                    focus: function (event, ui) {
                        $("#txtKeyword").val(ui.item.label);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#txtKeyword").val(ui.item.label);
                        //$("#project-id").val(ui.item.value);
                        //$("#project-description").html(ui.item.desc);
                        //$("#project-icon").attr("src", "images/" + ui.item.icon);

                        return false;
                    }
                })
                .autocomplete("instance")._renderItem = function (ul, item) {
                    return $("<li>")
                            //.append("<div>" + item.value + "<br>" + item.label + "</div>")
                            .append("<div> <img alt='' src='http://localhost:8000/assets/images/film/'" + $item.value + "' style='width: 110px'>" + item.label + "</div>")
                            .appendTo(ul);
                        };
                    }
                }
                common.init();
    </script>
@endsection