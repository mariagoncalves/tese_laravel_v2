@extends('layouts.default')
@section('content')

@if (isset($queryId))
	<input type="hidden" id="idQuery" value = "{{ $queryId }}" >
	@if (isset($pesquisa))
		<input type="hidden" id="idSearch" value = "{{ $pesquisa }}" >
	@endif
@endif

<div ng-controller="dynamicSearchControllerJs">
	<form id="dynamic-search" style = "display: {{ isset($pesquisa) && $pesquisa == 1 ? 'none' : 'block' }} ;">
		<div ng-init = "getEntitiesData({{$id}})">
			<div id = "checkET">
				<h3>{{trans("dynamicSearch/messages.TABLE_TITLE1")}} [[ents.language[0].pivot.name ]] </h3>
				<table id="table1" class="table table-condensed table-bordered table-hover" >
		            <thead>
		                <tr>
		                    <th>{{trans("dynamicSearch/messages.THEADER1")}}</th>
		                    <th>{{trans("dynamicSearch/messages.THEADER2")}}</th>
		                    <th><input type = "checkbox" name = "selectAlltable1" id = "selectAlltable1" ng-click = "checkUncheckAll('ET')"> {{trans("dynamicSearch/messages.THEADER3")}}</th>
		                    <th>{{trans("dynamicSearch/messages.THEADER4")}}</th>
		                </tr>
		            </thead>
			        <tbody>
		                <td ng-if="ents.properties.length == 0" colspan="4"> {{trans("dynamicSearch/messages.NO_DATA_TABLE1_P1")}} [[ents.language[0].pivot.name ]] {{trans("dynamicSearch/messages.NO_DATA_TABLE1_P2")}}  </td>

		                <div ng-if = "ents.properties.length > 0">
			                <tr ng-repeat="(key1, property) in ents.properties">
			                    <td>[[ property.id ]]</td>
			                    <td>[[ property.language[0].pivot.name ]]</td>
			                    <td> 
			                    	<input type ="hidden" id = "keyET[[ property.id ]]" value = "[[key1]]">
			                    	<input class = "checkstable1" type="checkbox" name = "checkET[[ key1 ]]" value = "[[ property.id ]]" ng-click = "clickTable1()">
			                    </td>
			                    <td>
			                    	<div ng-switch on="property.value_type">
								        <div ng-switch-when="text"> <input type="text" name="textET[[ key1 ]]"> </div>
								        <div ng-switch-when="bool"> 
								        	<input type="radio" name="radioET[[ key1 ]]" value="1">{{trans("dynamicSearch/messages.TRUE")}}
											<input type="radio" name="radioET[[ key1 ]]" value="0">{{trans("dynamicSearch/messages.FALSE")}}
										</div>
										<div ng-switch-when="enum">
											<select name = "selectET[[ key1 ]]">
												<option></option>
								        		<option ng-repeat = "propAllowedValue in property.prop_allowed_values" value="[[propAllowedValue.id ]]"> 
								        			[[ propAllowedValue.language[0].pivot.name]] 
								        		</option>
								        	</select>
										</div>
										<!-- <div ng-switch-when="ent_ref"> 
											<select name = "ent_refET[[ key1 ]]" ng-init = "getEntityInstances(ents.id, property.id)">
								        		<option></option>
								        		<option ng-repeat = "inst in fkEnt[property.id].fk_ent_type.entity" value = "[[ inst.id ]]"> [[ inst.language[0].pivot.name ]] </option>
								        	</select>
										</div> -->
								        <div ng-switch-when="int"> 
											<select name = "operatorsET[[ key1 ]]">
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="intET[[ key1 ]]">
										</div>
										<div ng-switch-when="double"> 
											<select name = "operatorsET[[ key1 ]]">
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="doubleET[[ key1 ]]">
										</div>
										<div ng-switch-when="file"> <input type="text" name="fileET[[ key1 ]]"> </div>
										<!-- Não sei se é para por o prop-ref -->
										<div ng-switch-when="prop_ref">
											<select name = "propRefET[[ key1 ]]">
												<option></option>
								        		<option ng-repeat = "value in property.fk_property.values" value = "[[value.id]]"> 
								        			[[ value.value ]] 
								        		</option>
								        	</select>
										</div>
										<div ng-switch-default> 								        	
										</div>
									</div>
			                    </td> 
			                </tr>
		            	</div>
	            	</tbody>
				</table>
			</div>

			<!-- Esta tabela mostra as propriedades das entidades que contenham pelo menos uma prop que seja ent_ref e que a ent referenciada seja a entidade selecionada anteriormente -->
			<!-- <div ng-init = "getEntRefs({{$id}})" id = "checkRL"> -->
			<div ng-init = "getPropRefs({{$id}})" id = "checkRL">
				<h3> {{trans("dynamicSearch/messages.TABLE_TITLE2")}} [[ents.language[0].pivot.name ]] </h3>

				<div ng-if = "entRefs.length == 0">
					<p> {{trans("dynamicSearch/messages.NO_DATA_TABLE2")}} [[ents.language[0].pivot.name ]] </p>
				</div>

				<div ng-if = "entRefs.length > 0">
					<div ng-repeat = "entRef in entRefs">
						<h4> {{trans("dynamicSearch/messages.TABLE_SUBTITLE2")}} [[ entRef.ent_type.language[0].pivot.name ]] </h4>

						<table id="table2" class="table table-condensed table-bordered table-hover">
				            <thead>
				                <tr>
				                    <th>{{trans("dynamicSearch/messages.THEADER1")}}</th>
				                    <th>{{trans("dynamicSearch/messages.THEADER2")}}</th>
				                    <th><input type = "checkbox" name = "selectAlltable2" id = "selectAlltable2" ng-click = "checkUncheckAll('VT')" disabled> {{trans("dynamicSearch/messages.THEADER3")}}</th>
				                    <th>{{trans("dynamicSearch/messages.THEADER4")}}</th>
				                </tr>
				            </thead>
					        <tbody>
				                <div>
				                	<td ng-if="entRef.properties.length == 0" colspan="4"> {{trans("dynamicSearch/messages.NO_DATA_SUBTABLE2")}} </td>

					                <tr ng-repeat="propOfEnt in entRef.properties" >
					                    <td>[[ propOfEnt.id ]]</td>
					                    <td>[[ propOfEnt.language[0].pivot.name ]]</td>
					                    <td>
					                    	<input type ="hidden" id = "keyVT[[ propOfEnt.id ]]" value = "[[propOfEnt.key]]">
					                    	<input class = "checkstable2" type="checkbox" name = "checkVT[[ propOfEnt.key ]]" value = "[[ propOfEnt.id ]]" ng-click = "clickTable2()" disabled> 
					                    </td>
					                    <td>
					                    	<div ng-switch on="propOfEnt.value_type">
										        <div ng-switch-when="text"> <input type="text" name="textVT[[ propOfEnt.key  ]]" disabled> </div>
										        <div ng-switch-when="bool"> 
										        	<input type="radio" name="radioVT[[ propOfEnt.key  ]]" value="1" disabled>{{trans("dynamicSearch/messages.TRUE")}}
													<input type="radio" name="radioVT[[ propOfEnt.key  ]]" value="0" disabled>{{trans("dynamicSearch/messages.FALSE")}}
												</div>
												<div ng-switch-when="enum">
													<select name = "selectVT[[ propOfEnt.key  ]]" disabled>
														<option></option>
										        		<option ng-repeat = "propAllowedValue in propOfEnt.prop_allowed_values" value="[[propAllowedValue.id ]]"> 
										        			[[ propAllowedValue.language[0].pivot.name ]] 
										        		</option>
										        	</select>
												</div>
										        <div ng-switch-when="int"> 
													<select name = "operatorsVT[[ propOfEnt.key  ]]" disabled>
										        		<option></option>
										        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
										        	</select>
										        	<input type="number" name="intVT[[ propOfEnt.key  ]]" disabled>
												</div>
												<div ng-switch-when="double"> 
													<select name = "operatorsVT[[ propOfEnt.key  ]]" disabled>
										        		<option></option>
										        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
										        	</select>
										        	<input type="number" name="doubleVT[[ propOfEnt.key ]]" disabled>
												</div>
												<div ng-switch-when="file"> 
													<input type="text" name="fileVT[[ propOfEnt.key ]]" disabled>
												</div>
												<div ng-switch-default> 
												</div>
											</div>
					                    </td>
				                	</tr>
				            	</div>
			            	</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- 3º tabela -->
			<div ng-init = "getRelsWithEnt({{$id}})">
				<h3> {{trans("dynamicSearch/messages.TABLE_TITLE3_P1")}} [[ents.language[0].pivot.name ]] {{trans("dynamicSearch/messages.TABLE_TITLE3_P2")}} </h3>

				<div ng-if = "relsWithEnt.length == 0">
					<p> {{trans("dynamicSearch/messages.NO_DATA_TABLE3_P1")}} [[ents.language[0].pivot.name ]] {{trans("dynamicSearch/messages.NO_DATA_TABLE3_P2")}}</p>
				</div>

				<div ng-if = "relsWithEnt.length != 0">
					<table class="table table-condensed table-bordered table-hover" id="table3">
	                    <thead>
	                        <th>{{trans("dynamicSearch/messages.THEADER5")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER6")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER3")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER4")}}</th>
	                    </thead>
	                    <tbody>
			                <tr ng-repeat-start="relWithEnt in relsWithEnt" ng-if="false" ng-init="innerIndex = $index"></tr>

			                <td rowspan="[[ relWithEnt.properties.length + 1 ]] ">
			                    [[ relWithEnt.language[0].pivot.name ]]
			                </td>

			                <td ng-if="relWithEnt.properties.length == 0" colspan="3"> {{trans("dynamicSearch/messages.NO_DATA_TABLE3")}} </td>

			                <tr ng-repeat="(key3, prop) in relWithEnt.properties" >
			                    <td>[[ prop.language[0].pivot.name ]]</td>
			                    <td> 
			                    	<input type ="hidden" id = "keyRL[[ prop.id ]]" value = "[[prop.key]]">
			                    	<input type="checkbox" name="checkRL[[ prop.key ]]" value="[[ prop.id ]]" ng-click = "clickTable3()" disabled> 
			                    </td>
			                    <td>
			                    	<div ng-switch on="prop.value_type">
								        <div ng-switch-when="text"> <input type="text" name="textRL[[ prop.key ]]" disabled> </div>
								        <div ng-switch-when="bool"> 
								        	<input type="radio" name="radioRL[[ prop.key ]]" value="1" disabled>{{trans("dynamicSearch/messages.TRUE")}}
											<input type="radio" name="radioRL[[ prop.key ]]" value="0" disabled>{{trans("dynamicSearch/messages.FALSE")}}
										</div>
										<div ng-switch-when="enum">
											<select name = "selectRL[[ prop.key ]]" disabled>
												<option></option>
								        		<option ng-repeat = "propAllowedValue in prop.prop_allowed_values" value="[[propAllowedValue.id ]]"> 
								        			[[ propAllowedValue.language[0].pivot.name ]] 
								        		</option>
								        	</select>
										</div>
										<!-- <div ng-switch-when="ent_ref"> 
											<select name = "ent_refRL[[ prop.key ]]" ng-init = "getEntityInstances(ents.id, prop.id)" disabled>
								        		<option></option>
								        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
								        	</select>
										</div> -->
								        <div ng-switch-when="int"> 
											<select name = "operatorsRL" disabled>
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="intRL[[ prop.key ]]" disabled>
										</div>
										<div ng-switch-when="double"> 
											<select name = "operatorsRL[[ prop.key ]]"  disabled>
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="doubleRL[[ prop.key ]]" disabled>
										</div>
										<div ng-switch-when="file"> 
											<input type="text" name="fileRL[[ prop.key ]]" disabled>
										</div>
										<div ng-switch-when="prop_ref"> 
											<select name = "propRefRL[[ prop.key ]]" disabled>
								        		<option></option>
								        		<option ng-repeat = "value in prop.fk_property.values" value = "[[value.id]]">
													[[value.value]]
								        		</option>
								        	</select>
										</div>
										<div ng-switch-default> 
								        	<input type="text" name="propRefRL[[ prop.key ]]" disabled>
										</div>
									</div>
			                    </td>
			                    <tr ng-repeat-end ng-if="false"></tr>
			                </tr>
	                    </tbody>
	                </table>
                </div>
			</div>

			<!-- 4º tabela -->
			<div ng-init = "getEntsRelated(relWithEnt.id, {{ $id }})">
				<h3> {{trans("dynamicSearch/messages.TABLE_TITLE4")}} [[ents.language[0].pivot.name ]] </h3>

				<div ng-if="relsWithEnt.length == 0" colspan="4"> {{trans("dynamicSearch/messages.NO_DATA_TABLE4")}} [[ents.language[0].pivot.name ]] </div>

				<div ng-if="relsWithEnt.length > 0"> 
					<table id="table4" class="table table-condensed table-bordered table-hover">
	                    <thead>
	                        <th>{{trans("dynamicSearch/messages.THEADER7")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER2")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER3")}}</th>
	                        <th>{{trans("dynamicSearch/messages.THEADER4")}}</th>
	                    </thead>
	                    <tbody>

	                    	<tr ng-repeat-start="(position, entRelated) in entsRelated" ng-if="false" ng-init="innerIndex = $index"></tr>

			                <td ng-if="entRelated.properties.length != 0 && entRelated.ent_type1_id == ents.id" rowspan="[[ entRelated.properties.length + 1 ]] ">
			                    [[ entRelated.ent2.language[0].pivot.name ]]
			                   <!-- <input type = "checkbox" name = "selectAllTable3" id = "selectAllTable3" ng-click = "checkUncheckAll('ER')"> -->
			                </td>

			                <td ng-if="entRelated.properties.length != 0 && entRelated.ent_type2_id == ents.id" rowspan="[[ entRelated.properties.length + 1 ]] ">
			                    [[ entRelated.ent1.language[0].pivot.name ]]
			                    <!-- <input type = "checkbox" name = "selectAllTable3" id = "selectAllTable3" ng-click = "checkUncheckAll('ER')"> -->
			                </td>

			                <td ng-if="entRelated.properties.length == 0 && position == 0" colspan="4"> {{trans("dynamicSearch/messages.NO_DATA_SUBTABLE2")}} </td>

			               	<tr ng-repeat="property in entRelated.properties" >
			               		<input type="hidden" name="idEntTypeER[[ property.key ]]" value = "[[ entRelated.ent_type1_id ]]" ng-if="entRelated.properties.length != 0 && entRelated.ent_type2_id == ents.id">
			               		<input type="hidden" name="idEntTypeER[[ property.key ]]" value = "[[ entRelated.ent_type2_id ]]" ng-if="entRelated.properties.length != 0 && entRelated.ent_type1_id == ents.id">
			                    <td>[[ property.language[0].pivot.name ]]</td>
			                    <td> 
			                    	<input type ="hidden" id = "keyER[[ property.id ]]" value = "[[property.key]]">
			                    	<input type="checkbox" name="checkER[[ property.key ]]" value="[[ property.id ]]" ng-click="clickTable4()" disabled> 
			                    </td>
			                    <td>	
			                    	<div ng-switch on="property.value_type">
								        <div ng-switch-when="text">
								        	<input type="text" name="textER[[ property.key ]]" disabled> 
								        </div>
								        <div ng-switch-when="bool"> 
								        	<input type="radio" name="radioER[[ property.key ]]" value="1" disabled>{{trans("dynamicSearch/messages.TRUE")}}
											<input type="radio" name="radioER[[ property.key ]]" value="0" disabled>{{trans("dynamicSearch/messages.FALSE")}}
										</div>
										<div ng-switch-when="enum">
											<select name = "selectER[[ property.key ]]" disabled>
												<option></option>
								        		<option ng-repeat = "propAllowedValue in property.prop_allowed_values" value="[[propAllowedValue.id ]]"> 
								        			[[ propAllowedValue.language[0].pivot.name ]] 
								        		</option>
								        	</select>
										</div>
										<!-- <div ng-switch-when="ent_ref"> 
											<select name = "ent_refER[[ property.key ]]" ng-init = "getEntityInstances(property.ent_type_id, property.id)" disabled>
								        		<option></option>
								        		<option ng-repeat = "inst in fkEnt[property.id].fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
								        	</select>
										</div> -->
								        <div ng-switch-when="int"> 
											<select name = "operatorsER[[ property.key ]]" disabled>
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="intER[[ property.key ]]" disabled>
										</div>
										<div ng-switch-when="double"> 
											<select name = "operatorsER[[ property.key ]]" disabled>
								        		<option></option>
								        		<option ng-repeat = "operator in operators" value = "[[operator.id]]"> [[ operator.operator_type ]] </option>
								        	</select>
								        	<input type="number" name="doubleER[[ property.key ]]" disabled>
										</div>
										<div ng-switch-when="file"> 
											<input type="text" name="fileER[[ property.key ]]" disabled>
										</div>

										<div ng-switch-when="prop_ref">
											<select name = "propRefER[[ property.key ]]" disabled>
												<option></option>
								        		<option ng-repeat = "value in property.fk_property.values" value = "[[value.id]]"> 
								        			[[ value.value ]] 
								        		</option>
								        	</select>
										</div>
										<div ng-switch-default> 
								        	<input type="text" name="propRefER[[ key3 ]]" disabled>
										</div>
									</div>
			                    </td>
			                    <tr ng-repeat-end ng-if="false"></tr>
			                </tr>
	                    </tbody> 
	                </table>
                </div>
            </div>
            <button id = "showResultButton" type="button" class="btn btn-md btn-primary" ng-click="search(ents.id)"> {{trans("dynamicSearch/messages.BTN1FORM")}} </button>
		</div>
	</form>

	<!-- Tabela com os resultados da pesquisa -->
	<div id="dynamic-search-presentation" style="display: none;">
		<p><b>{{trans("dynamicSearch/messages.INPUT1_NAME")}}</b></p>
		<input type="text" name="query_name" id = "query_name" ng-change = "blockUnblockSaveButton()" ng-model = "query_name">
		<button id = "save_button" class = "btn btn-sm btn-primary" type = "button" ng-click = "saveSearch(ents.id)" disabled> Save </button>
		<h3>{{trans("dynamicSearch/messages.TITLE1")}}</h3>
		<div id="false-de-pesquisa" style="padding: 15px 0px;">
			<dl>
			  <dt>[[ resultDynamincSearch.phrase[0] ]]:</dt>
			  <dd ng-repeat = "(key, phrase) in resultDynamincSearch.phrase" ng-if="key != 0">[[ phrase ]]</dd>
			  <dd ng-if="resultDynamincSearch.phrase.length == 1 ">- {{trans("dynamicSearch/messages.NO_SEARCH")}}</dd>	
			</dl>
		</div>

		<div>
			<div growl></div>
			<div ng-if="resultDynamincSearch.result.length == 0" >
				<label>{{trans("dynamicSearch/messages.NO_RESULTS")}}</label></br></br>
			</div>
			<table class="table table-condensed table-bordered table-hover" ng-if="resultDynamincSearch.result.length != 0">
	            <thead>
	            	<th ng-repeat="value in resultDynamincSearch.result[0]">[[value.property.language[0].pivot.name]]</th>
	            </thead>
	            <tbody>
	                <tr ng-repeat="entity in resultDynamincSearch.result">
                		<td ng-repeat="value in entity">
                			[[ value.value == '' ? '{{trans("dynamicSearch/messages.NO_VALUES")}}' : value.value ]]
                		</td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<button type="button" class="btn btn-md btn-primary" ng-click="voltar()"> {{trans("dynamicSearch/messages.BTN3FORM")}} </button>
	</div>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop