@extends('layouts.default')
@section('content')
<div ng-controller="operatorControllerJs">
	<h2>Gestão de Operadores</h2>

	<div growl></div>
    
    <button type="button" class="btn btn-xs btn-success" ng-click="openModalOperator('md', 'add', 0)">
        Adicionar tipos de operadores
    </button>
    <br>
    <br>
    <table ng-table="tableParams" ng-init="getOperatorTable()" class="table table-condensed table-bordered table-hover" show-filter="true">
        <tr ng-repeat="operator in tableParams.data">
            <td title="'ID'" sortable="'id'" >[[ operator.id ]]</td>
            <td title="'Operator Type'" filter="{ operatorFilter: 'text'}" sortable="'operator_type'">[[ operator.operator_type ]]</td>
            
            <td title="'created_at'" sortable="'created_at'" width="90px">[[ operator.created_at ]]</td>
            <td title="'updated_at'" sortable="'updated_at'" width="90px">[[ operator.updated_at ]]</td>
            <td title="'Ação'">
                <button class="btn btn-default btn-xs btn-warning" ng-click="openModalOperator('md', 'edit', operator.id)">{{ trans("relationTypes/messages.BTNTABLE1") }}</button>
                <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(operator.id)" style="margin-top: 5px;">{{ trans("relationTypes/messages.THEADER11") }}</button>
            </td>
        </tr>
        <tr ng-if="tableParams.data.length == 0">
            <td colspan="9"> Não existe operadores </td>
        </tr>
    </table>
</div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/operator.js') ?>"></script>
@stop