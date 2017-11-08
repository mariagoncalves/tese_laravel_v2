<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{trans('properties/messages.ADD_PROPERTIES')}}</h4>
    </div>
    <div class="modal-body">
        <form id="formProperty" name="frmProp" class="form-horizontal" novalidate="">
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('properties/messages.THEADER2')}}:</label>
                <div class="col-sm-9" ng-init="getEntities()">
                    <select id = "entity_type" class="form-control" name="entity_type" ng-model="entity_type" >
                        <option value=""></option>
                        <option ng-repeat="entity in entities" value="[[ entity.id ]]" ng-selected="entity.id == property.ent_type_id">[[ entity.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.entity_type" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group">
                <label for="property_name" class="col-sm-3 control-label">{{trans('properties/messages.THEADER3')}}:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_name" name="property_name" ng-value="property.language[0].pivot.name" >
                    <ul ng-repeat="error in errors.property_name" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getStates()">
                <label for="property_state" class="col-sm-3 control-label">{{trans('properties/messages.THEADER10')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline state" ng-repeat="state in states">
                        <input type="radio" name="property_state" value="[[ state ]]" ng-checked="state == property.state">[[ state ]]
                    </label>
                    <ul ng-repeat="error in errors.property_state" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getValueTypes()">
                <label class="col-sm-3 control-label">{{trans('properties/messages.THEADER4')}}:</label>
                <div class="col-sm-9">
                    <select class="form-control" id="property_valueType" name="property_valueType" ng-model="property_valueType" ng-change = "changes()">
                        <option value=""></option>
                        <option ng-repeat="valueType in valueTypes" value="[[ valueType ]]" ng-selected="valueType == property.value_type">[[ valueType ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.property_valueType" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
                <br>
            </div>

            <div class="form-group" ng-init="getFieldTypes()">
                <label for="Gender" class="col-sm-3 control-label">{{trans('properties/messages.THEADER6')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline fieldType" ng-repeat="fieldType in fieldTypes">
                        <input type="radio" name="property_fieldType" value="[[ fieldType ]]" ng-checked="fieldType == property.form_field_type">[[ fieldType ]]
                    </label>
                    <ul ng-repeat="error in errors.property_fieldType" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group" ng-init="getUnits()">
                <label for="unitType" class="col-sm-3 control-label">{{trans('properties/messages.THEADER7')}}:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="unites_names">
                        <option value=""></option>
                        <option ng-repeat="unit in units" ng-value="unit.id" ng-selected="unit.id == property.unit_type_id">[[ unit.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.unites_names" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

           <div class="form-group">
                <label for="property_fieldSize" class="col-sm-3 control-label">{{trans('properties/messages.THEADER8')}}:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="property_fieldSize" name="property_fieldSize"  ng-value="property.form_field_size">
                    <ul ng-repeat="error in errors.property_fieldSize" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="property_mandatory" class="col-sm-3 control-label">{{trans('properties/messages.THEADER9')}}:</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline mandatory">
                        <input type="radio" name="property_mandatory" value="1" ng-checked="1 == property.mandatory" required>{{trans('properties/messages.YES')}}
                    </label>
                    <label for="" class="radio-inline mandatory">
                        <input type="radio" name="property_mandatory" value="0" ng-checked="0 == property.mandatory" required>{{trans('properties/messages.NO')}}
                    </label>
                    <ul ng-repeat="error in errors.property_mandatory" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <!-- Aqui é só um select para selecionar apenas uma entidade -->
            <div class="form-group">
                <label for="reference_entity" class="col-sm-3 control-label"> {{trans('properties/messages.THEADER14')}}:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="reference_entity" ng-disabled="true" ng-model = "reference_entity" ng-change = "getPropsByEnt()">
                        <option value=""></option>
                        <option ng-repeat="entity in entities" ng-value="entity.id" ng-selected="entity.id == property.fk_ent_type_id">[[ entity.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.reference_entity" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <!-- Aqui é só um select para selecionar apenas uma propriedade -->
            <div class="form-group">
                <label for="fk_property" class="col-sm-3 control-label"> {{trans('properties/messages.THEADER15')}}:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="fk_property" ng-disabled="true">
                        <option value=""></option>
                        <option ng-repeat="prop in propEntity.properties" ng-value="prop.id" ng-selected = "prop.id == property.fk_property_id">[[ prop.language[0].pivot.name ]]</option>
                    </select>
                    <ul ng-repeat="error in errors.fk_property" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>
            <!-- Multiselect de entidades -->
            <div class="form-group">
                <label for="ent_types_select" class="col-sm-3 control-label">{{trans('properties/messages.THEADER16')}}:</label>
                <div class="col-sm-9">
                    <select class="entselecting" style="width: 100%" multiple="multiple" id="ent_types_select" name="ent_types_select" ng-model="ent_types_select" ng-change = "blockUnblockOutputType()">
                    </select>

                    <ul ng-repeat="error in errors.ent_types_select" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <!-- Multiselect de propriedades -->
            <div class="form-group">
                <label for="propselect" class="col-sm-3 control-label">{{trans('properties/messages.THEADER17')}}:</label>
                <div class="col-sm-9">
                    <select class="propselecting" style="width: 100%" multiple="multiple" id="propselect" name="propselect" ng-model="propselect" ng-change = "blockUnblockOutputType()">
                    </select>
                    <ul ng-repeat="error in errors.propselect" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

            <!-- Só deve aparecer caso escolha propriedades de entidades -->
            <div class="form-group" ng-init="getOutputTypes()">
                <label for="property_outputType" class="col-sm-3 control-label">{{trans('properties/messages.THEADER18')}}:</label>
                <div class="col-sm-9">
                    <label class="radio-inline outputType" ng-repeat="outputType in outputTypes">
                        <input type="radio" id = "property_outputType" name="property_outputType" value="[[ outputType ]]" ng-checked="((outputType == property.property_can_read_property[0].pivot.output_type) || (outputType == property.reading_ent_types[0].pivot.output_type))" ng-disabled="true">[[ outputType ]]
                    </label>
                    <ul ng-repeat="error in errors.property_outputType" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmProp.$invalid">{{trans('properties/messages.BTN1FORM')}}</button>
    </div>
</div>