@extends('layouts.default')
@section('content')
	<h2>{{ trans("relationTypes/messages.Page_Name") }}</h2>

    <div growl></div>
    
	<div ng-controller="RelationTypesManagmentControllerJs">
        <button type="button" class="btn btn-xs btn-success" ng-click="openModalRelTypes('md', 'add', 0)">
            {{ trans("relationTypes/messages.THEADER10") }}
        </button>
        <br>
        <br>
        <table ng-table="tableParams" ng-init="getRelationsTable()" class="table table-condensed table-bordered table-hover" show-filter="true">
            <tr ng-repeat="relType in tableParams.data">
                <td title="'{{ trans('relationTypes/messages.THEADER2') }}'" filter="{ relationFilter: 'text'}" sortable="'relation'" >[[ relType.relation ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER3') }} 1'" filter="{ entity1Filter: 'text'}" sortable="'entity1'">[[ relType.entity1 ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER3') }} 2'" filter="{ entity2Filter: 'text'}" sortable="'entity2'">[[ relType.entity2 ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER4') }}'" filter="{ transTypeFilter: 'text'}" sortable="'transaction_type'">[[ relType.transaction_type ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER6') }}'" filter="{ stateFilter: 'text'}" sortable="'state'" width="85px">[[ relType.state ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER7') }}'" sortable="'created_at'" width="90px">[[ relType.created_at ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER8') }}'" sortable="'updated_at'" width="90px">[[ relType.updated_at ]]</td>
                <td title="'{{ trans('relationTypes/messages.THEADER12') }}'">
                    <button class="btn btn-default btn-xs btn-warning" ng-click="openModalRelTypes('md', 'edit', relType.id)">{{ trans("relationTypes/messages.BTNTABLE1") }}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relType.id)" style="margin-top: 5px;">{{ trans("relationTypes/messages.THEADER11") }}</button>
                </td>
            </tr>
            <tr ng-if="tableParams.data.length == 0">
                <td colspan="9">{{ trans("relationTypes/messages.NO_RELATIONS") }}</td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/relTypes.js') ?>"></script>
@stop
