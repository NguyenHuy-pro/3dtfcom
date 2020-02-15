<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/14/2016
 * Time: 2:34 PM
 */

$modelHelpDetail = new \App\Models\Manage\Content\Help\Detail\TfHelpDetail();

$dataHelpDetail = $modelHelpDetail->infoOfObjectAndAction($dataHelpObjectAccess->object_id, $dataHelpActionAccess->action_id)
?>
<div class="row">
    @if(count($dataHelpDetail) > 0)
        @foreach($dataHelpDetail as $detail)
            <?php
            $dataHelpContent = $modelHelpDetail->helpContentInfo($detail->detail_id);
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default tf-margin-padding-none tf-border-none">
                    <div class="panel-heading tf-bg-none">
                        <h4>{!! $detail->name !!}</h4>
                    </div>
                    <div class="panel-body tf-overflow-prevent">
                        {!! $detail->description !!}

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @if(count($dataHelpContent)> 0 )
                    @foreach($dataHelpContent as $content)
                        @include('help.content.content')
                    @endforeach
                @endif
            </div>
        @endforeach
    @endif
</div>
