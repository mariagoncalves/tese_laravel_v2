@extends('layouts.default')
@section('content')
    <h2>{{trans("properties/messages.Page_Name1")}}</h2>
    <div ng-controller="propertiesOfEntitiesManagmentControllerJs">
        <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsEnt('md', 'add', 0)">{{trans('properties/messages.ADD_PROPERTIES')}}</button>
        <br>
        <br>

        <table ng-table="tableParams" ng-init="getPropsOfEntities()" class="table table-condensed table-bordered table-hover" show-filter="true">
            <tr ng-repeat="entitiesProps in tableParams.data">
                <td title="'{{trans('properties/messages.THEADER2')}}'" filter ="{entityFilter: 'text'}" sortable="'entity_name'" >
                    [[entitiesProps.entity_name]]
                    <div>
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(entitiesProps.ent_id)"> {{trans('properties/messages.BTNTABLE3')}}</button>
                    </div>
                </td>
                <td title="'{{trans('properties/messages.THEADER1')}}'" sortable="'id'" > [[entitiesProps.id]] </td>
                <td title="'{{trans('properties/messages.THEADER3')}}'" filter ="{propertyFilter: 'text'}" sortable="'property_name'" > [[entitiesProps.property_name]] </td>
                <td title="'{{trans('properties/messages.THEADER4')}}'" sortable="'value_type'" > [[entitiesProps.value_type]] </td>
                <td title="'{{trans('properties/messages.THEADER5')}}'" sortable="'form_field_name'" > [[entitiesProps.form_field_name == null ? "-" : entitiesProps.form_field_name]] </td>
                <td title="'{{trans('properties/messages.THEADER6')}}'" sortable="'form_field_type'" > [[entitiesProps.form_field_type]] </td>
                <td title="'{{trans('properties/messages.THEADER7')}}'" sortable="'unit_name'" > [[ entitiesProps.unit_name == null ? "-" : entitiesProps.unit_name ]] </td>
                <td title="'{{trans('properties/messages.THEADER8')}}'" sortable="'form_field_size'" > [[entitiesProps.form_field_size]] </td>
                <td title="'{{trans('properties/messages.THEADER9')}}'" sortable="'mandatory'" > [[ entitiesProps.mandatory == "1" ? "Sim" : "Não"]]  </td>
                <td title="'{{trans('properties/messages.THEADER10')}}'" sortable="'state'" > [[ entitiesProps.state ]] </td>
                <td title="'{{trans('properties/messages.THEADER11')}}'" sortable="'created_at'" > [[ entitiesProps.created_at ]] </td>
                <td title="'{{trans('properties/messages.THEADER12')}}'" sortable="'updated_at'" > [[ entitiesProps.updated_at ]] </td>
                <td title="'{{trans('properties/messages.THEADER19')}}'">
                    <button class="btn btn-default btn-xs btn-warning" ng-click="openModalPropsEnt('md', 'edit', entitiesProps.id)">{{trans('properties/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(entitiesProps.id)">{{trans('properties/messages.BTNTABLE4')}}</button>
                </td>
            </tr> 
        </table>

        <!-- Popup para reordenar as propriedades -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.FORM_DRAG_DROP')}}</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('properties/messages.Page_Name')}}</h4>
                        <ul ui-sortable="sortableOptionsEnt" ng-model="propsEnt" class="list-group">
                            <li ng-repeat="prop in propsEnt" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
                        </ul>
                       <!-- <pre>[[propsEnt]]</pre> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propertiesOfEntities.js') ?>"></script>
@stop
