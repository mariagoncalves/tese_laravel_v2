app.controller('customformController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, $uibModal, $q) {

    //Translate Functions
    /*$translatePartialLoader.addPart('customForm');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };*/

    //Arrays initialization
    $scope.customForms = [];

    $scope.getCustomForms = function() {
        $http.get('/custom_form/get_custom_form', [{cache : true}]).then(function(response) {
            $scope.tableParams = new NgTableParams({
                count: 25,
                sorting: { id: "asc" },
                group: "custom_form_name"
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 4,
                dataset: response.data
            });
        });
    };
    $scope.getCustomForms();

    //Actualizar o valor do mandatory da transaction_type de um determinado custom_form
    $scope.updateMandatory = function (customformid, transactiontypeid) {
        var url = API_URL + "Custom_Form/update_mandatory";
        $http({
            method: 'POST',
            url: url,
            data: $.param({
                'custom_form_id' : customformid,
                'transaction_type_id' : transactiontypeid
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!', ttl: 1000});
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

    //MODAL FUNCTIONS
    //Modal - ADD - EDIT
    $scope.openModalForm_CostumForm =  function (size, id, type) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_CostumForm',
            controller: 'ModalInstanceCtrl_CostumForm',
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

    $scope.ModalInstanceCtrl_CostumForm = function ($scope, $uibModalInstance, $timeout, custom_form_id, modal_state) {

        var modalstate = modal_state;
        var id = custom_form_id;
        $scope.custom_Form = [];

        //Buscar todos TStates
        $scope.getAllTStates();

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;

            case 'edit':
                console.log("Entrou");
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

            $http({
                method: 'POST',
                url: url,
                data: $.param({'name' : $scope.custom_Form.language[0].pivot.name,
                    'state' : $scope.custom_Form.state,
                    't_state_id' : $scope.custom_Form.t_state_id
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
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
    $scope.openModalForm_AddTransactionTypes =  function (size, id, type) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_AddTransactionTypes',
            controller: 'ModalInstanceCtrl_AddTransactionTypes',
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

    $scope.ModalInstanceCtrl_AddTransactionTypes = function ($scope, $uibModalInstance, $timeout, custom_form_id, modal_state) {

        var modalstate = modal_state;
        var id = custom_form_id;
        $scope.checkProcessType = true;

        $scope.custom_Form = [];
        $scope.seltransactiontypes = [];
        $scope.seltransactiontypes.sel = [];

        $scope.form_title = "ADD_FORM_ENT_TYPE";

        //Buscar a informação para construção do modal
        $scope.getCustomFormInfo = function () {
            var deferred = $q.defer();

            $http.get(API_URL + 'custom_form/add_transaction_types/' + id)
                .then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });
            return deferred.promise;
        };

        //Preencher as informações ao abrir o Modal
        $scope.getCustomFormInfo().then(function (data) {


            $scope.process_types = data.data.process_types;
            $scope.customForm = data.data.custom_form;
            $scope.seltransactiontypes.sel = data.data.transaction_types_sel;
            $scope.process_type_id = data.data.process_type_id;


            //Caso não exista nenhum processo associado e nenhum tipo de transação neste custom form
            if($scope.process_type_id !== null &&  $scope.seltransactiontypes.sel !== null)
            {
                //Desactivar o select para escolher os tipos de transações
                $scope.checkProcessType = false;
                //Não mostrar nenhum tipo de transção para ser escolhida
                $scope.transaction_types = [];
            }

        }).catch(function (response) {

        });


        $scope.updateTransactionTypes = function (inic) {
            //Buscar todos os transações de acordo com o tipo de processo
            $http.get(API_URL + 'custom_form/get_transaction_types_by_process/' + $scope.process_type_id)
                .then(function(response) {
                    $scope.transaction_types = response.data
                });

            //Actualizar o Input Select
            if($scope.process_type_id !== undefined)
                $scope.checkProcessType = false;
            else
                $scope.checkProcessType = true;

            //Limpar os tipos de transações escolhidos
            if(inic === 0)
                $scope.seltransactiontypes.sel = [];
        };

        //save new record / update existing record
        $scope.saveEnt = function() {
            var url = API_URL + "Custom_Form/update_transaction_types/"+ id;

            $http({
                method: 'POST',
                url: url,
                data: $.param({
                    'selectedTransactionTypes' :  $scope.seltransactiontypes.sel,
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});;
                $scope.getCustomForms();
                $scope.cancel();
            },  function errorCallback(response) {

                if (response.status == 400)
                {
                    if(!response.data.sameActor)
                        growl.error('Transaction Types with different Iniciators or Executers.',{title: 'error!'});

                    if(!response.data.sameProcess)
                        growl.error('Transaction Types with different Process type.',{title: 'error!'});
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
                $scope.transactiontypes = response.data.transaction_types;
            });
        $scope.openModalForm_DragDrop('md', $scope.customformid);
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.ModalInstanceCtrl_DragDrop = function ($scope, $uibModalInstance, $timeout, custom_form_id) {

        var customForm_id = custom_form_id;

        // set up sortable options
        $scope.sortableOptionsTransactionType = {
            stop: function(e, ui) {
                //console.log($(".list-group").find('.list-group-item').data('id'));
                var content = [];
                $(".list-group").find('.list-group-item').each(function( index ) {
                    content.push($(this).data('id'));
                });

                content.push($scope.customformid);
                var formData = JSON.parse(JSON.stringify(content));

                var url      = API_URL + "/custom_form/updateOrderTransactionType";

                $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                }).then(function(response) {
                    console.log('Success!');
                    $scope.getCustomForms();
                    growl.success('Order updated successfully.',{title: 'Success!'});
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
    $scope.openModalForm_ViewTransactionTypes =  function (size, id) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalCustomForms_ViewTransactionTypes',
            controller: 'ModalInstanceCtrl_ViewTransactionTypes',
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

    $scope.ModalInstanceCtrl_ViewTransactionTypes = function ($scope, $uibModalInstance, $timeout, custom_form_id) {

        var customForm_id = custom_form_id;
        $scope.customForm_id = customForm_id;
        $scope.form_title = "VIEW_ENT_TYPE";

        //Buscar o Custom Form = id
        $scope.getCustomForm(custom_form_id);

        //Remover Tipos de Entidade associado ao Custom form com ID = customformid
        $scope.removeTransactionType = function(customformid, transactiontypeid) {
            var url = API_URL + "remove_transaction_types";
            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'custom_form_id' : customformid,
                        'transaction_type_id' : transactiontypeid,
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

    //SoftDelete da Prop Allowed Value
    $scope.remove = function (prop_allowed_value_id)
    {
        var url = API_URL + "custom_form/remove";
        $http({
            method: 'POST',
            url: url,
            data: $.param({'id' : prop_allowed_value_id,
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            growl.success('Delete Success');
            $scope.getCustomForms();
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

    //Funções Uteis
    $scope.getCustomForm = function (customForm_id) {
        $http.get(API_URL + 'custom_form/get_custom_form/' + customForm_id)
            .then(function(response) {
                $scope.customForm = response.data;
            });
    };

    $scope.getAllTStates= function() {
        $http.get(API_URL + '/custom_form/get_t_states')
            .then(function(response) {
                $scope.tStates = response.data;
            });
    };
});
