@extends('layouts.default')
@section('content')
    <h2>{{trans('properties/messages.Page_Name2')}}</h2>
    <div ng-controller="propertiesOfRelationsManagmentControllerJs">
        <div growl></div>

        <button type="button" class="btn btn-xs btn-success" ng-click="openModalPropsRel('md', 'add', 0)">{{trans('properties/messages.ADD_PROPERTIES')}}</button>
        <br>
        <br>
        <table ng-table="tableParams" ng-init="getPropsOfRelation()" class="table table-condensed table-bordered table-hover" show-filter="true">
            <tr ng-repeat="relationProps in tableParams.data">
                <td title="'{{trans('properties/messages.THEADER13')}}'" filter ="{relationFilter: 'text'}" sortable="'relation_name'">
                    [[relationProps.relation_name]]
                    <div>
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindow(relationProps.rel_id)"> {{trans('properties/messages.BTNTABLE3')}} </button>
                    </div>
                </td>
                <td title="'{{trans('properties/messages.THEADER1')}}'" sortable="'id'" > [[relationProps.id]] </td>
                <td title="'{{trans('properties/messages.THEADER3')}}'" filter ="{propertyFilter: 'text'}" sortable="'property_name'" > [[relationProps.property_name]] </td>
                <td title="'{{trans('properties/messages.THEADER4')}}'" sortable="'value_type'" > [[relationProps.value_type]] </td>
                <td title="'{{trans('properties/messages.THEADER5')}}'" sortable="'form_field_name'" > [[relationProps.form_field_name]] </td>
                <td title="'{{trans('properties/messages.THEADER6')}}'" sortable="'form_field_type'" > [[relationProps.form_field_type]] </td>
                <td title="'{{trans('properties/messages.THEADER7')}}'" sortable="'unit_type'" > [[relationProps.unit_name]] </td>
                <td title="'{{trans('properties/messages.THEADER8')}}'" sortable="'form_field_size'" > [[relationProps.form_field_size]] </td>
                <td title="'{{trans('properties/messages.THEADER9')}}'" sortable="'mandatory'" > [[ relationProps.mandatory ]] </td>
                <td title="'{{trans('properties/messages.THEADER10')}}'" sortable="'state'" > [[ relationProps.state ]] </td>
                <td title="'{{trans('properties/messages.THEADER11')}}'" sortable="'created_at'" > [[ relationProps.created_at ]] </td>
                <td title="'{{trans('properties/messages.THEADER12')}}'" sortable="'updated_at'" > [[ relationProps.updated_at ]] </td>
                <td title="'{{trans('properties/messages.THEADER19')}}'">
                    <button class="btn btn-default btn-xs btn-warning" ng-click="openModalPropsRel('md', 'edit', relationProps.id)">{{trans('properties/messages.BTNTABLE1')}}</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(relationProps.id)">{{trans('properties/messages.BTNTABLE4')}}</button>
                </td>
            </tr> 
        </table>

        <!-- Popup para reordenar propriedades-->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.FORM_DRAG_DROP')}}</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('properties/messages.Page_Name')}}</h4>
                        <ul ui-sortable="sortableOptions" ng-model="propsRel" class="list-group">
                            <li ng-repeat="prop in propsRel" class="list-group-item" data-id="[[ prop.id ]]">[[prop.language[0].pivot.name]]</li>
                        </ul>
                       <!-- <pre>[[propsRel]]</pre> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propertiesOfRelations.js') ?>"></script>
@stop
