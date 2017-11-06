@extends('layouts.default')
@section('content')
<div ng-controller="dynamicSearchControllerJs">
	<h2>Pesquisas guardadas</h2>

	<div ng-init = "getSavedQueries()">
		<!-- <ul>
			<li ng-repeat = "query in queries"> [[query.name]] </li>
		</ul> -->
	   
       <div ng-if="queries.length == 0"> <p> Não existe pesquisas gravadas</p> </div>

    	<table class="table table-condensed table-bordered table-hover" border = "1px" ng-if="queries.length > 0">
    		<thead>
                <th>Nome da Query </th>
                <th>Entidade</th>
                <th>Propriedade</th>
                <th>Operador</th>
                <th>Valor</th>
            </thead>
            <tbody>
            	<tr ng-repeat-start="query in queries" ng-if="false" ng-init="innerIndex = $index"></tr>

            	<td rowspan="[[ query.conditions.length + 1 ]] "> [[ query.name ]] 
                    <br> <button class="btn btn-sm btn-primary" type = "button" ng-click = "showQueryResults(query.id, query.ent_type.id)" > Abrir/Editar Pesquisa </button>
                    <button class="btn btn-sm btn-primary" type = "button" ng-click = "showResult(query.id, query.ent_type.id)" > Pesquisar </button>
                </td>
            	<td rowspan="[[ query.conditions.length + 1 ]] "> [[ query.ent_type.language[0].pivot.name ]] </td>

                <tr ng-repeat="condition in  query.conditions" >
                	<td>[[ condition.property.language[0].pivot.name ]]</td>
                	<td>[[ condition.operator.operator_type ]]</td>
                	<td> [[ condition.value == "" ? "Qualquer" : condition.value ]] </td>
                	<tr ng-repeat-end ng-if="false"></tr>
                </tr>
            </tbody>
    	</table>
    </div>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop