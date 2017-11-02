app.controller('customformController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, $uibModal) {

    //Translate Functions
    $translatePartialLoader.addPart('customForm');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    //Arrays initialization
    $scope.customForms = [];

    //Custom Form Functions
    $scope.getCustomForms = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        $http.get('/custom_form/get_custom_form?page='+pageNumber).then(function(response) {
            console.log(response);
            $scope.customForms = response.data.data;

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

    //MODAL FUNCTIONS
    //Modal - ADD - EDIT
    $scope.openModalForm_PropAllowedValue =  function (size, id, type) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_PropAllowedValue',
            controller: 'ModalInstanceCtrl_PropAllowedValue',
            size: size,
            scope: $scope,
            resolve: {
                custom_form_id: function() {
                    return id
                },
                modal_state: function() {
                    return type
                }
            }
        }).result.then(function(reason) {

        }, function(){

        });
    };

    $scope.ModalInstanceCtrl_PropAllowedValue = function ($scope, $uibModalInstance, $timeout, custom_form_id, modal_state) {

        var modalstate = modal_state;
        var id = custom_form_id;
        $scope.custom_Form = [];

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;

            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                $http.get(API_URL + 'custom_form/get_custom_form/' + id)
                    .then(function(response) {
                        $scope.custom_Form = response.data;
                    });
                break;
        }

        //save new record / update existing record
        $scope.save = function() {
            var url = API_URL + "Custom_Form";

            //append employee id to the URL if the form is in edit mode
            if (modalstate === 'edit') {
                url += "/" + id ;
            }

            if(modalstate === 'add_ent_types') {

                url += "/update_ent_types/" + id;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param({'name' : $scope.custom_Form.language[0].pivot.name,
                    'state' : $scope.custom_Form.state,
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                if (modalstate === 'edit')
                    growl.success('EDIT_SUCCESS_MESSAGE');
                else
                    growl.success('SAVE_SUCCESS_MESSAGE');
                $scope.getCustomForms();
                $scope.cancel();
            },  function errorCallback(response) {
                if (response.status == 400)
                {
                    growl.error('This is error message.',{title: 'error!'});
                }
                else
                {
                    $scope.errors = response.data;
                }
                //alert('This is embarassing. An error has occured. Please check the log for details');
            });
        };

        //Close Modal
        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };


    //Modal - add_ent_types
    $scope.openModalForm_AddEntTypes =  function (size, id, type) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_AddEntTypes',
            controller: 'ModalInstanceCtrl_AddEntTypes',
            size: size,
            scope: $scope,
            resolve: {
                custom_form_id: function() {
                    return id
                },
                modal_state: function() {
                    return type
                }
            }
        }).result.then(function(reason) {

        }, function(){

        });
    };

    $scope.ModalInstanceCtrl_AddEntTypes = function ($scope, $uibModalInstance, $timeout, custom_form_id, modal_state) {

        var modalstate = modal_state;
        var id = custom_form_id;

        $scope.custom_Form = [];
        $scope.selenttypes = [];
        $scope.selenttypes.sel = [];

        $scope.form_title = "ADD_FORM_ENT_TYPE";
        $http.get(API_URL + 'custom_form/get_custom_form/' + id)
            .then(function(response) {
                $scope.customForm = response.data;
            });
        $http.get(API_URL + 'custom_form/get_ent_types/')
            .then(function(response) {
                $scope.ent_types = response.data;
            });
        $http.get(API_URL + '/custom_form/get_sel_ent_types/' + id)
            .then(function(response) {
                $scope.selenttypes.sel = response.data;
            });

        //save new record / update existing record
        $scope.saveEnt = function() {
            var url = API_URL + "Custom_Form/update_ent_types/"+ id;

            $http({
                method: 'POST',
                url: url,
                data: $.param({
                    'selectedEntTypes' :  $scope.selenttypes.sel,
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                if (modalstate === 'edit')
                    growl.success('EDIT_SUCCESS_MESSAGE');
                else
                    growl.success('SAVE_SUCCESS_MESSAGE');
                $scope.getCustomForms();
                $scope.cancel();
            },  function errorCallback(response) {
                if (response.status == 400)
                {
                    growl.error('This is error message.',{title: 'error!'});
                }
                else
                {
                    $scope.errors = response.data;
                }
            });
        };

        //Close Modal
        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    //Modal - Drag and Drop
    $scope.openModalForm_DragDrop =  function (size, id) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_DragDrop',
            controller: 'ModalInstanceCtrl_DragDrop',
            size: size,
            scope: $scope,
            resolve: {
                custom_form_id: function() {
                    return id
                }
            }
        }).result.then(function(reason) {

        }, function(){

        });
    };

    //DRAG AND DROP FUNCTIONS
    $scope.showDragDropWindowEnt = function(customForm_id) {
        $scope.customformid = customForm_id;
        $scope.form_title = "FORM_DRAG_DROP";
        $http.get(API_URL + 'custom_form/get_custom_form/' + customForm_id)
            .then(function(response) {
                $scope.enttypes = response.data.ent_types;
            });
        $scope.openModalForm_DragDrop('md', $scope.customformid);
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.ModalInstanceCtrl_DragDrop = function ($scope, $uibModalInstance, $timeout, custom_form_id) {

        var customForm_id = custom_form_id;

        // set up sortable options
        $scope.sortableOptionsEntType = {
            stop: function(e, ui) {
                //console.log($(".list-group").find('.list-group-item').data('id'));
                var content = [];
                $(".list-group").find('.list-group-item').each(function( index ) {
                    content.push($(this).data('id'));
                });

                content.push($scope.customformid);
                var formData = JSON.parse(JSON.stringify(content));

                var url      = API_URL + "/custom_form/updateOrderEntType";

                $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                }).then(function(response) {
                    console.log('Success!');
                    $scope.getCustomForms();
                    //growl.success('Order updated successfully.',{title: 'Success!'});
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

        //Close Modal
        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    //Modal - view ent_types
    $scope.openModalForm_ViewEntTypes =  function (size, id) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_ViewEntTypes',
            controller: 'ModalInstanceCtrl_ViewEntTypes',
            size: size,
            scope: $scope,
            resolve: {
                custom_form_id: function() {
                    return id
                }
            }
        }).result.then(function(reason) {

        }, function(){

        });
    };

    $scope.ModalInstanceCtrl_ViewEntTypes = function ($scope, $uibModalInstance, $timeout, custom_form_id) {

        var customForm_id = custom_form_id;
        $scope.customForm_id = customForm_id;
        $scope.form_title = "VIEW_ENT_TYPE";

        $scope.getCustomForm(custom_form_id);

        //Remover Tipos de Entidade associado ao Custom form com ID = customformid
        $scope.removeEntType = function(customformid, entitytypeid) {
            var url = API_URL + "remove_entity_types";
            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'custom_form_id' : customformid,
                        'ent_type_id' : entitytypeid,
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

                $scope.getCustomForm(custom_form_id);
                $scope.getCustomForms();
            }, function errorCallback(response) {
                if (response.status == 400)
                {
                    growl.error('This is error message.',{title: 'error!'});
                }
                else
                {
                    $scope.errors = response.data;
                }
            });
        };

        //Close Modal
        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    //Funções Uteis
    $scope.getCustomForm = function (customForm_id) {
        $http.get(API_URL + 'custom_form/get_custom_form/' + customForm_id)
            .then(function(response) {
                $scope.customForm = response.data;
            });
    };
});
