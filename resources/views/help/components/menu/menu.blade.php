<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/14/2016
 * Time: 1:27 PM
 */
$modelHelpObject = new \App\Models\Manage\Content\Help\Object\TfHelpObject();
$modelHelpAction = new \App\Models\Manage\Content\Help\Action\TfHelpAction();

$dataHelpObject = $modelHelpObject->getInfo();
?>
<ul class="tf_help_menu_wrap list-group">
    @if(count($dataHelpObject) > 0)
        @foreach($dataHelpObject as $object)
            <?php
            $helpObjectId = $object->object_id;
            $objectAlias = $object->alias;
            $dataHelpAction = $modelHelpObject->helpActionInfo($helpObjectId);
            $statusObjectAccess = ($dataHelpObjectAccess->object_id == $helpObjectId) ? true : false;
            ?>
            <li class="tf_help_menu_object list-group-item tf-border-none @if($statusObjectAccess) tf-bg-whitesmoke  @endif">
                <span class="glyphicon @if($statusObjectAccess) glyphicon-minus @else glyphicon-plus  @endif  tf-font-size-10 tf-color"></span>
                <a class="tf-link"> {!! $object->name !!}</a>
                <ul class="tf_help_menu_action list-group tf-help-menu-action @if(!$statusObjectAccess) tf-display-none @endif ">
                    @if(count($dataHelpAction) > 0)
                        @foreach($dataHelpAction as $action)
                            <?php
                            $helpActionId = $action->action_id;
                            $actionAlias = $action->alias;
                            $statusActionAccess = ($dataHelpActionAccess->action_id == $helpActionId) ? true : false;
                            ?>
                            <li class="list-group-item @if($statusObjectAccess) tf-bg-whitesmoke  @endif tf-border-none tf-padding-top-5 tf-padding-bot-5">
                                <a class="@if($statusActionAccess && $statusObjectAccess ) tf-link-red-bold tf-text-under @else tf-link @endif"
                                   href="{!! route('tf.help',"$objectAlias/$actionAlias") !!}">{!! $action->name !!}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        @endforeach
    @endif
</ul>