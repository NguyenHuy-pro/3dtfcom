<div id="tf_building_service_article_detail_share" class="tf-display-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="tf-article-detail-share-content col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <table class="table tf-margin-bot-none">
                <tr>
                    <td>
                        <a class="tf_articles_embed tf-link-bold"
                           data-href="{!! route('tf.building.services.article.detail.embed.share',$dataBuildingArticles->articlesId()) !!}">
                            <i class="tf-font-size-18 tf-font-bold fa fa-code"></i>
                        </a><br/>
                        {!! trans('frontend_building.service_article_detail_share_code_label') !!}
                    </td>
                    <td>
                        <div class="fb-share-button" data-layout="button_count"
                             style="margin-top: 0;"
                             data-href="#"
                             data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank"
                               href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F3dtf.com%2Fbuilding%2Fabout&amp;src=sdkpreparse">
                                Share
                            </a>
                        </div>
                        <br/>
                        <span>{!! trans('frontend_building.service_article_detail_share_facebook_label') !!}</span>
                    </td>
                    <td>
                        <script type="text/javascript"
                                src="https://apis.google.com/js/plusone.js"></script>
                        <g:plusone size="medium"></g:plusone>
                        <br/>
                        <span>{!! trans('frontend_building.service_article_detail_share_google_label') !!}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="input-group input-group-sm">
                                    <input class="tf_link_copy form-control" type="text" readonly
                                           value="{!! route('tf.building.services.article.detail.get',$dataBuildingArticles->alias()) !!}">
                                          <span class="input-group-btn">
                                            <button class="tf_get_link btn btn-default" type="button">
                                                {!! trans('frontend_building.service_article_detail_share_get_link_label') !!}
                                            </button>
                                          </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span class="tf-link-red" onclick="tf_main.tf_hide('#tf_building_service_article_detail_share');">
                            {!! trans('frontend_building.service_article_detail_share_close_label') !!}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>