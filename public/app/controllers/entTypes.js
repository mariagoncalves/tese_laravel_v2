/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('entityTypesController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal) {
    $scope.translationData = {
        field: "Name"
    };

    $translatePartialLoader.addPart('entTypes');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.openModalForm = function (size, id, type) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalEntTypes',
            controller: 'ModalInstanceCtrl',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                ent_type_id: function() {
                    return id
                },
                modal_state: function() {
                    return type
                }
            }
        }).result.then(function(reason) {
            //Get triggers when modal is closed
            //alert(reason);
            /*$scope.modal = [];
            $scope.modal_processTab = [];
            $scope.modal_formTab = [];
            modal_i = 0;
            index1 = 0;*/
        }, function(){
            //gets triggers when modal is dismissed.
        });
    };

    $scope.ModalInstanceCtrl = function ($scope, $uibModalInstance, $timeout, ent_type_id, modal_state) {
        var modalstate = modal_state;
        var id = ent_type_id;
        $scope.entitytype = [];

        switch (modalstate) {
            case 'add':
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $http.get(API_URL + 'ents_types/get_ents_types/' + id)
                    .then(function(response) {
                        $scope.entitytype = response.data;
                    });
                break;
            default:
                break;
        }

        //save new record / update existing record
        $scope.save = function() {
            var url = API_URL + "Entity_Type";

            //append employee id to the URL if the form is in edit mode
            if (modalstate === 'edit') {
                url += "/" + id;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param({ 'language_id' : $scope.entitytype.language[0].id,
                        'name': $scope.entitytype.language[0].pivot.name,
                        'state': $scope.entitytype.state,
                        'transaction_type_id': $scope.entitytype.transaction_type_id,
                        'par_ent_type_id': $scope.entitytype.par_ent_type_id,
                        'par_prop_type_val': $scope.entitytype.par_prop_type_val,
                        't_state_id' : $scope.entitytype.t_state_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('This is success message.',{title: 'Success!'});
                $scope.getEntityTypes();
                $scope.cancel();
            }, function errorCallback(response) {
                if (response.status == 400)
                {
                    growl.error('This is error message.',{title: 'error!'});
                }
                else
                {
                    $scope.errors = response.data;
                }
                //console.log(response);
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    /*$scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };*/

    $scope.getall = function() {
        $http.get(API_URL + "/ents_types/get_all_http")
            .then(function (response) {
                $scope.transactiontypes = response.data.tr;
                $scope.tstates = response.data.ts;
                $scope.enttypes = response.data.et;
                $scope.propallowedvals = response.data.av;
                $scope.langs = response.data.langs;
            });
    };

    /*$scope.transacstypes = function() {
        $http.get(API_URL + "/ents_types/get_transacs_types")
            .then(function (response) {
                $scope.transactiontypes = response.data;
            });
    };

    $scope.tstates = function() {
        $http.get(API_URL + "/ents_types/get_tstates")
            .then(function (response) {
                $scope.tstates = response.data;
            });
    };

    $scope.enttypes = function() {
        $http.get(API_URL + "/ents_types/get_enttypes")
            .then(function (response) {
                $scope.enttypes = response.data;
            });
    };

    $scope.propallowedva = function() {
        $http.get(API_URL + "/ents_types/get_prop_allowed_values")
            .then(function (response) {
                $scope.propallowedvals = response.data;
            });
    };*/

    $scope.getEntityTypes = function() {
        $http.get('/ents_types/get_ents_types', [{cache : true}]).then(function(response) {
            $scope.tableParams = new NgTableParams({
                count: 2,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data
            });
        });
    };
    $scope.getEntityTypes();

    $scope.getall();
    //$scope.transacstypes();
    //$scope.langs();
    /*$scope.tstates();
    $scope.enttypes();*/

    $scope.delete = function(id) {
        var url = API_URL + "Entity_Type_del/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getEntityTypes();
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
});