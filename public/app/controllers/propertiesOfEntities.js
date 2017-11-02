app.controller('propertiesOfEntitiesManagmentControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {

    $translatePartialLoader.addPart('properties');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

	$scope.entities = [];
    $scope.states   = [];
    $scope.valueTypes = [];
    $scope.fieldTypes = [];
    $scope.units = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.errors = [];
    $scope.propsEnt = [];
    $scope.propEntity = [];
    //$scope.select2PropEntity = [];
    $scope.props = [];

    $scope.getEntities = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        $http.get('/properties/get_props_ents?page='+pageNumber).then(function(response) {
            console.log(response);
            $scope.entities = response.data.data;

            $scope.totalPages = response.data.last_page;
            $scope.currentPage = response.data.current_page;

            // Pagination Range
            var pages = [];

            for (var i = 1; i <= response.data.last_page; i++) {
                pages.push(i);
            }

            $scope.range = pages;

        });
    };

    $scope.showDragDropWindowEnt = function(id) {

        $scope.id = id;
        console.log(id);
        $scope.form_title = "Drag and Drop Properties";
        $http.get(API_URL + '/properties/getPropsEntity/' + id)
                    .then(function(response) {
                        $scope.propsEnt = response.data.properties;
                        console.log($scope.propsEnt);
                    });
        $('#myModal2').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.sortableOptionsEnt = {
        stop: function(e, ui) {
            console.log("DAR A AÇÃO PARA GUARDAR A ORDEM NA BASE DE DADOS.");

            console.log($(".list-group").find('.list-group-item').data('id'));

            var content = [];
            $(".list-group").find('.list-group-item').each(function( index ) {
                //content.push($(this).data('id'));
                content.push($(this).data('id'));
            });
            console.log(content);
            console.log("Chegou até aqui");
            var formData = JSON.parse(JSON.stringify(content));
            var url      = API_URL + "updateOrderEnt";

            $http({
                method: 'POST',
                url: url,
                data: formData,
            }).then(function(response) {
                console.log('Success!');
                $scope.getEntities();
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {
                    growl.error('Error.', {title: 'error!'});
                }
            });
        }
    };

    $scope.getStates = function() {
        //Estado das propriedades
        $http.get('/properties/states').then(function(response) {
            $scope.states = response.data;
            console.log($scope.states);
        });
    };

    $scope.getValueTypes = function() {
        //Buscar value types
        $http.get('/properties/valueTypes').then(function(response) {
            $scope.valueTypes = response.data;
            console.log($scope.valueTypes);
        });
    };

    $scope.getFieldTypes = function() {
        //Buscar fields types
        $http.get('/properties/fieldTypes').then(function(response) {
            $scope.fieldTypes = response.data;
            console.log($scope.fieldTypes);
        });
    };

    $scope.getUnits = function() {

        $http.get('/properties/units').then(function(response) {
            $scope.units = response.data;
            console.log($scope.units);

        });
    };

    $scope.getOutputTypes = function () {

        $http.get('/properties/outputTypes').then(function(response) {
            $scope.outputTypes = response.data;
            console.log($scope.outputTypes);
        });

    }

    $scope.openModalPropsEnt = function (size, modalstate, id, parentSelector) {

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalPropsEnt',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            resolve: {}
        }).rendered.then(function() {
            $scope.property = null;
            $scope.modalstate = modalstate;

            switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Add New Property";
                $scope.selectsProperty([], []);
                break;
            case 'edit':
                $scope.form_title = "Edit Property";
                $scope.id = id;
                console.log("ID" + id);

                $http.get(API_URL + '/properties/get_property/' + id)
                    .then(function(response) {
                        $scope.property = response.data;
                        console.log("DADOS DA PROPRIEDADE: ");
                        console.log(response.data);

                        $scope.changes();
                        $("[name=entity_type]").prop('disabled', 'disabled');

                        if ($scope.property.fk_property_id && $scope.property.fk_property_id != '') {
                            //dados = {properties: [$scope.property.fk_property]};
                            //$scope.propEntity = dados;
                            $scope.propEntity = {properties: [$scope.property.fk_property]};
                        }

                        //Adicionar a select2 as entidades associadas a propriedade
                        var entidades      = $scope.property.reading_ent_types,
                            lenght         = entidades.length,
                            selectEntities = [];

                        for (var i = 0; i < lenght; i++) {
                            if (entidades[i].pivot.deleted_at == null) {
                                selectEntities.push(entidades[i].pivot.providing_ent_type);
                            }
                        }

                        // Adicionar a select2 as propriedades associadas a propriedade
                        var props            = $scope.property.properties_reading,
                            lenght           = props.length,
                            selectProperties = [];

                        for (var i = 0; i < lenght; i++) {
                            if(props[i].pivot.deleted_at == null) {
                                selectProperties.push(props[i].pivot.providing_property);
                            }
                        }
                        $scope.selectsProperty(selectEntities, selectProperties);

                    });
                break;
            default:
                break;
        }


        });

    };

    $scope.selectsProperty = function(selectEntities, selectProperties) {
        console.log("TESTE SELECTS2: ");
        console.log(selectProperties);
        console.log(selectEntities);

        $http.get('/properties/getPropsEntity').then(function(response) {
            var entidades = response.data,
                lenght    = entidades.length,
                entTypes  = [],
                allEntType = [];

            for (var i = 0; i < lenght; i++) {
                var props = [];

                var propriedades = entidades[i].properties,
                    lenghtProp   = propriedades.length;

                for (var j = 0; j < lenghtProp; j++) {
                    if(jQuery.inArray(propriedades[j].id, selectProperties) !== -1) {
                        props.push({'id': propriedades[j].id, 'text': propriedades[j].language[0].pivot.name, 'selected': true});
                    } else {
                        props.push({'id': propriedades[j].id, 'text': propriedades[j].language[0].pivot.name});
                    }
                }

                if (props.length != 0) {
                    entTypes.push({'text': entidades[i].language[0].pivot.name, 'children': props});
                }

                if(jQuery.inArray(entidades[i].id, selectEntities) !== -1) {
                    allEntType.push({'id': entidades[i].id, 'text': entidades[i].language[0].pivot.name, 'selected': true});
                } else {
                    allEntType.push({'id': entidades[i].id, 'text': entidades[i].language[0].pivot.name});
                }
            }

            $("#propselect").select2({
                placeholder: "Properties",
                allowClear: true,
                closeOnSelect: false,
                data: entTypes
            });

            $("#ent_types_select").select2({
                placeholder: "Entities Type",
                allowClear: true,
                closeOnSelect: false,
                data: allEntType
            });
        });
    }

    $scope.changes = function() {

        var valueType = $("[name=property_valueType]").val();
        console.log("Valor do valueType:");
        console.log(valueType);

        if (valueType == "") {
            valueType = $scope.property.value_type;
        }

        if (valueType == 'ent_ref') {

            $("[name=reference_entity]").removeAttr("disabled");
            $("[name=fk_property]").prop('disabled', 'disabled');

        } else if (valueType == 'prop_ref') {
           
            $("[name=fk_property]").removeAttr("disabled");
            $("[name=reference_entity]").removeAttr("disabled");

        } else {

            $("[name=fk_property]").prop('disabled', 'disabled');
            $("[name=reference_entity]").prop('disabled', 'disabled');
        }
        
    };

    $scope.blockUnblockOutputType = function () {

        var val = $("#ent_types_select").val();
        var props = $("#propselect").val();

        if ((typeof val == undefined || val == null) && (typeof props == undefined || props == null)) {
            $("[name=property_outputType]").prop('disabled', 'disabled');
        } else {
            $("[name=property_outputType]").removeAttr("disabled");
        }
    }

    $scope.getPropsByEnt = function () {

        var value = $("[name=reference_entity]").val();
        value = value.split(":")[1];
        console.log(value);

        $http.get('/properties/getPropsEntity/' + value).then(function(response) {
            $scope.propEntity = [];
            console.log(response.data);
            $scope.propEntity = response.data;
        });
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {

            var url      = API_URL + "PropertyEnt";

            console.log(jQuery('#formProperty').serializeArray());

            var formData = JSON.parse(JSON.stringify(jQuery('#formProperty').serializeArray()));

            //Para passar todos os valores escolhidos nos multiselect
            formData.push({'name': 'propselect', 'value': $("#propselect").val()});
            formData.push({'name' : 'ent_types_select', 'value': $("#ent_types_select").val()});

            console.log(formData);
            console.log($("#propselect").val());

            if (modalstate === 'edit') {
                url += "/" + id ;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param(formData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(response) {
                //First function handles success
                $scope.errors = [];
                $scope.getEntities();
                $scope.cancel();

                if(modalstate == "add") {
                    growl.success('SAVE_SUCCESS_MESSAGE',{title: 'SUCCESS'});
                } else {
                    growl.success('EDIT_SUCCESS_MESSAGE',{title: 'SUCCESS'});
                }
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {

                    $scope.cancel();

                    growl.error(response.data.error, {title: 'error!'});
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

    $scope.remove = function(id) {
        var url = API_URL + "PropertyOfEntities_remove/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            console.log("lalal 11");
            console.log(response);
            growl.success('This is success message.',{title: 'Success!'});
            $scope.getEntities();
        }, function errorCallback(response) {
            console.log("lalal");
            console.log(response);
            if (response.status == 400 || response.status == 500)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
        });
    };

    
}).directive('pagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getEntities(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getEntities(currentPage-1)">&lsaquo; [[ "BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getEntities(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getEntities(currentPage+1)">[[ "BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getEntities(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});;

