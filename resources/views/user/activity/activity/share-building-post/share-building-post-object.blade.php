<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/13/2017
 * Time: 12:16 PM
 */
/*
 * modelUser
 * dataBuildingPost
 */

$hFunction = new Hfunction();
#content posts
?>
<div class="row">
    <div class="panel panel-default tf-margin-bot-none"
         data-posts="" data-date="">
        <div class="panel-heading tf-bg-none tf-border-none">
            <div class="row">
                <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object tf-border tf-icon-50 tf-border-radius-4" alt="keyword-seo"
                                 src="{!! asset('public\main\icons\icon_people_1.jpeg') !!}">
                        </a>

                        <div class="media-body">
                            <a class="tf-link-bold media-heading" href="#" target="_blank">
                                user name
                            </a>
                            <span class="tf-color-grey">shared an post on </span>
                            <a class="tf-link-bold">
                                Building name
                            </a>
                            <br/>
                            <span>10/01/2017</span>
                        </div>
                    </div>

                </div>

                {{--grant post--}}
                <div class="text-right col-xs-2 col-sm-4 col-md-4 col-lg-4">
                    <i class="fa fa-chevron-down dropdown-toggle tf-link-grey tf-font-size-14"
                       data-toggle="dropdown"></i>
                    <ul class="tf_posts_object_menu dropdown-menu dropdown-menu-right tf-padding-none tf-font-size-12">
                        <li>
                            <a class="tf_report tf-bg-hover"
                               data-href="#">
                                {!! trans('frontend_building.post_menu_bad_info') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_delete tf-bg-hover"
                               data-href="#">
                                {!! trans('frontend_building.post_menu_delete') !!}
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{--text post--}}
        <div class="panel-body">
            {{--content--}}
            <div class="row">
                <div class="tf-padding-bot-10 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    share content
                    <br/>
                    <a class="pull-left" href="#">
                        <img class="media-object tf-border-radius-4" alt="keyword-seo"
                             style="max-width: 100%; border: 1px solid #d7d7d7;"
                             src="{!! asset('public\imgsample\bannerDefault.jpg') !!}">
                    </a>

                    <div class="tf-padding-top-10 col-xs-12 col-sm-12 col-md-12  col-lg-12">
                        <span class="tf-color-grey">
                            Post content - Post content  - Post content - Post content - Post content - Post content
                            <br/>
                            - Post content - Post content - Post content - Post content - Post content - Post content
                        </span>
                    </div>
                </div>
            </div>

            {{--building statistic--}}
            <div class="tf-user-activity-object-statistic text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{--comment--}}
                <i class="glyphicon glyphicon-comment"></i>
                <span>689</span>
                <a class="tf-link" href="#">Comment</a>
                &nbsp;
                {{--love--}}
                <i class="glyphicon glyphicon-thumbs-up"></i>
                <span> 568 </span>
                <span class="tf-link">Love</span>

                &nbsp;
                {{--Share--}}
                <i class="glyphicon glyphicon-random"></i>
                <span> 12 </span>
                <span class="tf-link">Share</span>

            </div>

            {{--comment--}}
            @include('user.activity.activity.share-building-post.comments.comment-list')
        </div>

    </div>
</div>