@extends('layouts.default')
@section('content')
<div ng-controller="dynamicSearchControllerJs">
	<h2>{{trans("dynamicSearch/messages.TITLE2")}}</h2>

	<div ng-init = "getSavedQueries()">
	   
       <div ng-if="queries.length == 0"> <p>{{trans("dynamicSearch/messages.NO_SAVED_SEARCHES")}}</p> </div>

    	<table class="table table-condensed table-bordered table-hover" border = "1px" ng-if="queries.length > 0">
    		<thead>
                <th>{{trans("dynamicSearch/messages.THEADER11")}}</th>
                <th>{{trans("dynamicSearch/messages.THEADER7")}}</th>
                <th>{{trans("dynamicSearch/messages.THEADER8")}}</th>
                <th>{{trans("dynamicSearch/messages.THEADER9")}}</th>
                <th>{{trans("dynamicSearch/messages.THEADER10")}}</th>
            </thead>
            <tbody>
            	<tr ng-repeat-start="query in queries" ng-if="false" ng-init="innerIndex = $index"></tr>

            	<td rowspan="[[ query.conditions.length + 1 ]] "> [[ query.name ]] 
                    <br> <button class="btn btn-sm btn-primary" type = "button" ng-click = "showQueryResults(query.id, query.ent_type.id)" > {{trans("dynamicSearch/messages.BTN4FORM")}} </button>
                    <button class="btn btn-sm btn-primary" type = "button" ng-click = "showResult(query.id, query.ent_type.id)" > {{trans("dynamicSearch/messages.BTN1FORM")}} </button>
                </td>
            	<td rowspan="[[ query.conditions.length + 1 ]] "> [[ query.ent_type.language[0].pivot.name ]] </td>

                <tr ng-repeat="condition in  query.conditions" >
                	<td>[[ condition.property.language[0].pivot.name ]]</td>
                	<td>[[ condition.operator.operator_type ]]</td>
                	<td> [[ condition.value == "" ? "{{trans("dynamicSearch/messages.ANY_VALUE")}}" : condition.value ]] </td>
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