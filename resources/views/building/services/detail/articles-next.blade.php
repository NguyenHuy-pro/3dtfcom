<?php
/*
 *
 *
 * modelUser
 * dataBuildingArticles
 *
 *
 */
$hFunction = new Hfunction();
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();

$nextArticles = $dataBuildingArticles->infoRelationOfArticles($dataBuildingArticles->articlesId(), 5);
?>
@if(count($nextArticles) > 0)
    <div class="row">
        <div class="tf-building-service-article-detail-next col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tf-title col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {!! trans('frontend_building.service_article_detail_next_title_label') !!}
            </div>
            @foreach($nextArticles as $dataBuildingArticlesNext)
                <?php
                $buildingArticlesNextAlias = $dataBuildingArticlesNext->alias();
                ?>
                <div class="tf-articles-content col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(!empty($dataBuildingArticlesNext->avatar()))
                        <div class="media">
                            <a class="pull-left"
                               href="{!! route('tf.building.services.article.detail.get',$buildingArticlesNextAlias) !!}">
                                <img class="media-object" src="{!! $dataBuildingArticlesNext->pathSmallImage() !!}"
                                     alt="{!! $dataBuildingArticlesNext->alias() !!}">
                            </a>

                            <div class="media-body">
                                <h5 class="media-heading">
                                    <a class="tf-link tf-font-size-16 tf-border-none"
                                       href="{!! route('tf.building.services.article.detail.get',$buildingArticlesNextAlias) !!}">
                                        {!! $dataBuildingArticlesNext->name() !!}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @else
                        <table class="table">
                            <tr>
                                <td class="tf-short-description">
                                    {!! $hFunction->cutString($dataBuildingArticlesNext->shortDescription(),70,'...') !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="tf-name">
                                    <h5>
                                        <a class="tf-link tf-font-size-16"
                                           href="{!! route('tf.building.services.article.detail.get',$buildingArticlesNextAlias) !!}">
                                            {!! $dataBuildingArticlesNext->name() !!}
                                        </a>
                                    </h5>
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif