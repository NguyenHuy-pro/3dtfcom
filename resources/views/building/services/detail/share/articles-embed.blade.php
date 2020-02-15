<?php
/*
 * modelUser
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');
$hFunction = new Hfunction();
$mobileDetect = new Mobile_Detect();
//articles info
$articleId = $dataBuildingArticles->articlesId();
$articlesName = $dataBuildingArticles->name();
$articlesAlias = $dataBuildingArticles->alias();
$articlesKeyword = $dataBuildingArticles->keyword();
$articlesShortDescription = $dataBuildingArticles->shortDescription();
$articlesAvatar = $dataBuildingArticles->avatar();
$articlesContent = $dataBuildingArticles->content();

#building info
$dataBuilding = $dataBuildingArticles->building;
$dataUserBuilding = $dataBuilding->userInfo();
$userBuildingId = $dataUserBuilding->userId();
$buildingId = $dataBuilding->buildingId();
$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$buildingAlias = $dataBuilding->alias();
$buildingName = $dataBuilding->name();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();
#get banner is using
if (!empty($articlesAvatar)) {
    $imgShareSrc = $dataBuildingArticles->pathSmallImage();
} else {
    $dataBuildingBanner = $dataBuilding->bannerInfoUsing();
    if (count($dataBuildingBanner) > 0) {
        $imgShareSrc = $dataBuildingBanner->pathFullImage();

    } else {
        $imgShareSrc = $dataBuilding->pathBannerImageDefault();
    }
}
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article">
<head>

    {{--google adsense--}}

    @include('components.google.adsense.adsense')


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="REFRESH" content="1800"/>

    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="author" content="3dtf.com">
    <meta name="copyright" content="3dtf.com"/>
    <meta name="keywords" content="{!! $articlesKeyword !!}"/>
    <meta name="description" content="{!! $shortDescription !!}"/>

    {{--extend meta object--}}
    @yield('extendMetaPage')

    {{--title page--}}
    <title>
        {!! $articlesName !!}
    </title>


    <link rel="shortcut icon" href="{!! $imgShareSrc !!}"/>
    {{--Bootstrap Core CSS--}}
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">

    {{--css all pages--}}
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">

    {{--include css per page--}}
    @yield('tf_master_page_css')
    <link href="{{ url('public/building/css/building.css')}}" rel="stylesheet">

    {{--offline--}}
    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>

    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    {{--drag on mobile--}}
    <script type="text/javascript" src="{{ url('public/main/js/touch-ui.js')}}"></script>

    {{--3dtf js--}}
    <script src="{{ url('public/main/js/main.js')}}"></script>

    {{--include js per page on top--}}
    @yield('tf_master_page_js_header')
    <script src="{{ url('public/building/js/building-service.js')}}"></script>

    {{--ckeditor/ckfinder --}}
    <script type="text/javascript">
        //baseURL - config ckeditor
        baseURL = "{!! url('/') !!}";
    </script>

    <script type="text/javascript">
        windowHeight = window.innerHeight;
        windowWidth = window.innerWidth;

        $(document).ready(function () {
            tf_main.tf_hide('#tf_main_loading_status');
        });
    </script>
</head>

<body style="background-color: white">
{{--google analytics--}}
@include('components.google.analytics.analyticstracking')

<div class="tf_building_service_article_embed tf-building-service-article-embed tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12"
     data-articles="{!! $articleId !!}">
    <div class="row">
        <div class="tf-title text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="tf-link" title="To 3dtf.com" target="_blank" href="{!! route('tf.building.services.article.detail.get',$articlesAlias) !!}">
                3dtf.com
            </a>
        </div>
    </div>
    {{--statistic and action--}}
    <div class="row">
        @if(!empty($dataBuildingArticles->avatar()))
            <div class="tf-padding-top-10 tf-padding-bot-10 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img style="max-height: 200px;" src="{!! $dataBuildingArticles->pathSmallImage() !!}" alt="...">
            </div>
        @endif

        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2>{!! $dataBuildingArticles->name() !!}</h2>
        </div>
        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="tf-articles-statistic col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table tf-margin-bot-none">
                        <tr>
                            <td class="col-md-6 col-lg-6">
                                <i class="glyphicon glyphicon-thumbs-up"></i>
                                <span>{!! $dataBuildingArticles->totalLove() !!}</span>
                            </td>
                            <td class=" col-md-6 col-lg-6">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                <span>{!! $dataBuildingArticles->totalVisit() !!}</span>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="tf-articles-building col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="media">
                <a class="pull-left" href="{!! route('tf.building', $buildingAlias) !!}">
                    <img class="media-object" src="{!! $dataBuilding->buildingSample->pathImage() !!}"
                         alt="{!! $buildingAlias !!}">
                </a>

                <div class="media-body">
                    <h4 class="media-heading">
                        <a class="tf-link-bold tf-font-size-16 tf-border-none"
                           href="{!! route('tf.building', $buildingAlias) !!}">{!! $buildingName !!}</a>
                    </h4>
                    <span class="tf-color-grey">Published</span>
                    <span class="tf-color-grey">{!! $hFunction->dateFormatDMY($dataBuildingArticles->createdAt(),'-') !!}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>{!! $articlesShortDescription !!}</h4>
        </div>
    </div>
    <div class="row">
        <div class="tf-content col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {!! $articlesContent !!}
        </div>
    </div>
</div>

{{-- ================= bootstrap ============== --}}
{{--Bootstrap Core JavaScript--}}
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

{{--Custom Theme JavaScript--}}
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>

{{--DataTables JavaScript--}}
<script src="{{ url('public/main/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

</body>

</html>
