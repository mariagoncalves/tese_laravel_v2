@extends('layouts.default')
@section('content')
    <div ng-controller="processTypesController" ng-cloak>
        <h2>{{trans("processTypes/messages.Page_Name")}}</h2>
        <div growl></div>
        <br><br>
        <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm('md', 0, 'add')">{{trans("processTypes/messages.THEADER7")}}</button>
        <br><br>
        <div class="alert alert-danger" ng-show="tableParams==null">
            {{trans("processTypes/messages.EMPTY_TABLE")}} {{trans("processTypes/messages.Page_Name")}}
        </div>
        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams!=null">
            <tr ng-repeat="processtype in $data">
                <td sortable="'id'" filter="{id: 'number'}" data-title="'{{trans("processTypes/messages.THEADER1")}}'"> <!--ID-->
                    [[::processtype.id]]
                </td>

                <td sortable="'name'" filter="{name: 'text'}" data-title="'{{trans("processTypes/messages.THEADER2")}}'"> <!--Name-->
                    [[::processtype.name]]
                </td>

                <td sortable="'state'" data-title="'{{trans("processTypes/messages.THEADER3")}}'"> <!--State-->
                    [[::processtype.state]]
                </td>

                <td sortable="'created_at'" data-title="'{{trans("processTypes/messages.THEADER4")}}'"> <!--Created_at-->
                    [[ ::processtype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'{{trans("processTypes/messages.THEADER5")}}'"> <!--Updated_at-->
                    [[ ::processtype.updated_at ]]
                </td>

                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm('md', processtype.id, 'edit')">{{trans("processTypes/messages.BTNTABLE1")}}</button>
                    {{--<button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>--}}
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(processtype.id)">{{trans("processTypes/messages.BTNTABLE3")}}</button>
                </td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
<script src="<?= asset('app/controllers/processtypes.js') ?>"></script>
@stop