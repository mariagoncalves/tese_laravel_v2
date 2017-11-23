/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('dashboardController', function($scope, $q, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout, FileUploader) {
    $scope.oneAtATime = true;

    $scope.groups = [
        {
            title: 'Dynamic Group Header - 1',
            content: 'Dynamic Group Body - 1'
        },
        {
            title: 'Dynamic Group Header - 2',
            content: 'Dynamic Group Body - 2'
        }
    ];

    $scope.items = ['Item 1', 'Item 2', 'Item 3'];

    $scope.status = {
        isCustomHeaderOpen: false,
        isFirstOpen: true,
        isFirstDisabled: false
    };

    $scope.dynamicPopover = {
        content: 'Hello, World!',
        templateUrl: 'popover',
        title: 'Title'
    };

    $scope.openModalDialog = function (size, id, min, max, transtypename) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var deferred = $q.defer();

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalDialog',
            controller: 'ModalInstanceCtrlDialog',
            backdrop: 'static',
            keyboard: false,
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                trans_id: function() {
                    return id
                },
                trans_min: function() {
                    return min
                },
                trans_max: function() {
                    return max
                },
                trans_type_name: function() {
                    return transtypename
                }
            }
        });

        modalInstance.result.then(function (response) {
            ArrModalDialogOpened.pop();
            deferred.resolve(response);
            //alert('Modal success at:' + new Date());
        }, function (response) {
            deferred.reject(response);
            //alert('Modal dismissed at: ' + new Date());
        });

        modalInstance.opened.then(function (response) {
                if (min == 1 && max == 1) {
                    $scope.modalDialog = {};
                    //alert("entrou");
                    $scope.modalDialog.number = 1;
                    $scope.modalDialog.id = id;
                    modalInstance.close($scope.modalDialog);
                }
            }
        );

        return deferred.promise;
    };

    var ArrModalDialogOpened = [];
    $scope.ModalInstanceCtrlDialog = function ($scope, $uibModalInstance, $timeout, trans_id, trans_min, trans_max, trans_type_name) {
        ArrModalDialogOpened.push($uibModalInstance);

        $scope.transTypeName = trans_type_name;
        $scope.transTypeMin = trans_min;
        $scope.transTypeMax = trans_max;

        $scope.cancel = function ($modalDialogForm) {
            if (trans_max == '*')
            {
                if ($modalDialogForm.number < trans_min) 
                {
                    alert("valores fora dos limites de min");
                    return;
                }
            }
            else
            {
                if (($modalDialogForm.number > trans_max) || ($modalDialogForm.number < trans_min)) 
                {
                    alert("valores fora dos limites de max e min");
                    return;
                }
            }
             
            $modalDialogForm.id = trans_id;
            $uibModalInstance.close($modalDialogForm);
        };
    };


    $scope.modal = [];
    $scope.modal_formTab = {};
    //https://stackoverflow.com/questions/36844064/dismiss-uibmodal-from-within
    $scope.openModalTask = function (size, id, flag, proc_type_id) {
        /*var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalTask',
            controller: 'ModalInstanceCtrl',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                trans_id: function() {
                    return id
                },
                flag_inic_process: function() {
                    return flag
                },
                process_type_id: function() {
                    return proc_type_id
                }
            }
        }).result.then(function(result) {
            //Get triggers when modal is closed
            //alert(reason);
            $scope.modal = [];
            //$scope.modal_processTab = [];
            //$scope.modal_formTab = [];
            uploader.clearQueue();
            $scope.modal_formTab.length = 0;
            if ($scope.modal_processTab !== undefined)
                $scope.modal_processTab.length = 0;
            $scope.getAllInicExecTrans();
            alert("entrou closed");
        }, function(reason){
            //gets triggers when modal is dismissed.
            uploader.clearQueue();
            $scope.modal_formTab.length = 0;
            if ($scope.modal_processTab !== undefined)
                $scope.modal_processTab.length = 0;
            alert("entrou dismissed");
        });
    };

    $scope.modalsArrData = [];
    $scope.ModalInstanceCtrl = function ($scope, $uibModalInstance, $timeout, trans_id, flag_inic_process, process_type_id) {
        $scope.modal_formTab = {};
        console.log($scope.modal_formTab);
        $scope.modalInstance = $uibModalInstance;
        var index_m = 0;
        var indexTabLocal = 0;

        $scope.index = index_m;

        $scope.modal_processTab = [];
        /*$scope.modal_formTab.push({ tab :[], causalinks :[]});
        $scope.modal_formTab[index_m].relTypeExist = false;*/
        $scope.modal_formTab.relTypeExist = false;
        $scope.modal_formTab.tab = [];
        $scope.modal_formTab.causalinks = [];

        $scope.updateValue = function(choice, i, indexTab){
            console.log($scope.modal_formTab);
            console.log(choice);
            console.log(i);
            var index = $scope.modal_formTab.tab[indexTab].propsform[i].fields[choice];
            console.log(index);
            if (index === false)
            {
                delete $scope.modal_formTab.tab[indexTab].propsform[i].fields[choice];
            }

            if (isEmpty($scope.modal_formTab.tab[indexTab].propsform[i].fields))
            {
                delete $scope.modal_formTab.tab[indexTab].propsform[i].fields;
            }

            //console.log($scope.modal_formTab.tab[indexTab].propsform[i].fields);
        };

        function isEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        $scope.processes = function() {
            $http.get(API_URL + "/dashboard/get_processes_of_tr/" + trans_id, {
                ignoreLoadingBar: false
            })
                .then(function (response) {
                    $scope.process = response.data;
                });
        };

        $scope.verParEntType = function ($id, $indexTab) {
            $scope.showMessage = false;
            $scope.formChild($id, $indexTab);
        };
        $scope.formChild = function($id, $indexTab) {
            if ($id == null)
            {

            }
            else
            {
                $http.get(API_URL + "/dashboard/get_props_form_child/" + $id, {
                    ignoreLoadingBar: false
                })
                    .then(function (response) {
                        /*$scope.showMessage = true;
                        $scope.modal_formTab.relTypeExist = false;
                        $scope.modal_formTab.propsform = response.data;
                        $scope.myPropsform_ = $scope.modal_formTab.propsform;
                        $scope.myRelTypeExist_ = $scope.modal_formTab.relTypeExist;*/

                        $scope.modal_formTab[index_m].tab[$indexTab].showMessage = true;
                        $scope.modal_formTab[index_m].tab[$indexTab].relTypeExist_ = false;
                        $scope.modal_formTab[index_m].tab[$indexTab].propsform_ = response.data;
                        $scope.modal_formTab[index_m].tab[$indexTab].showBtnType_ = true;

                        console.log($scope.modal_formTab[index_m].tab[$indexTab]);

                    }, function errorCalback(response) {
                        $scope.modal_formTab[index_m].tab[$indexTab].showMessage = false;
                        $scope.modal_formTab[index_m].tab[$indexTab].relTypeExist_ = null;
                        $scope.modal_formTab[index_m].tab[$indexTab].propsform_ = null;
                        $scope.modal_formTab[index_m].tab[$indexTab].showBtnType_ = null;
                    }).finally(function () {
                    // called no matter success or failure
                });
            }
        };

        var data;
        $scope.isUserInicExecOfTrans = function ($trans_id, $counter) {
            var deferred = $q.defer();

            if ($counter == 0)
            {
                $http.get(API_URL + "/dashboard/is_User_InicAndExec_trans/" + $trans_id, {
                    ignoreLoadingBar: false
                })
                    .then(function (response) {
                        data = response;
                        deferred.resolve(response);
                    }, function errorCalback(response) {
                        data = response;
                        deferred.reject(response);
                    }).finally(function () {
                    // called no matter success or failure
                });
            }
            else
            {
                deferred.resolve(data);
            }

            counter++;

            return deferred.promise;
        };

        $scope.getTransTypeName = function ($trans_type_id) {
            var deferred = $q.defer();

            $http({
                method: 'GET',
                url: API_URL + "/transaction_types/get_trans_type_name/" + $trans_type_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                ignoreLoadingBar: false
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        var type = 1;
        var counter = 0;
        var counterTStatesCan = 0;
        $scope.showMessage = false;
        $scope.templatePath = 'tabChildFormTask';

        var fileExist = false;

        $scope.process_id=0;
        $scope.changeTabBoot = function ($title, $templateurl, $tabnumber, $type, $process_id) {
            $scope.modal_formTab.process = $process_id; //se não for selecionado nenhum valor na selectbox o valor vem undefined, se selecionado vem null
            $scope.modal_formTab.transaction_type_id = trans_id;
            $scope.modal_formTab.process_type_id = process_type_id;
            //console.log($process_id.id);
            //alert("$id=" + $id);
            //debugger;
            if ($tabnumber == 1) {
                counterTStatesCan = 0;
                counter = 0;
            }

            $scope.myTabNumber = $tabnumber + 1;

            //guarda da recursividade
            if ($type == 6) {
                $type = 1;
                return;
            }

            $scope.tabs.splice($scope.activeTabIndex + 1);

            $scope.modal.transaction_type_id = trans_id;

            $scope.isTrAndStWaitingForAnotherTr(trans_id, $type, $process_id != null ? $process_id.id : null).then(function (data) {
                $scope.isUserInicExecOfTrans(trans_id, counter).then(function (data) {
                        //se o valor devolvido for true então o utilizador é iniciador e executor desse tipo de transacção
                        /*if (data.data === true) {
                            counterTStatesCan = 0; //logo guardamos um valor para controlar o número de vezes que iremos
                        }*/

                        /*if (counterTStatesCan === 0) {
                            counterTStatesCan++;*/
                        if (data.data === true) //se o valor devolvido for true então o utilizador é iniciador e executor desse tipo de transacção
                        {

                            $scope.propsForm(trans_id, $type).then(function (response) {
                                    //emptyRelTypeProp se for false entao existem propriedades para aquele tipo de relação ou
                                    //é do tipo reltype entao é necessario carregar as selectboxes das instancias das entidades
                                    if (response.data.emptyRelTypeProp === false)
                                    {
                                        //$scope.modal_formTab.relTypeExist = true;
                                        reltype = true;
                                        //carregar as duas selectboxes
                                        var id = response.data.rel_type_id;
                                        $scope.loadEntities1(id);
                                        $scope.loadEntities2(id);
                                    }
                                    else
                                    {
                                        reltype = false;
                                        //$scope.modal_formTab.relTypeExist = false;
                                    }

                                    if (response.data.emptyEntTypeProp)
                                    {
                                        enttype = false;
                                    }
                                    else
                                    {
                                        enttype = true;
                                    }

                                    //File verification
                                    for (var i=0; i < response.data.data.length; i++)
                                    {
                                        if (response.data.data[i].value_type === "file")
                                        {
                                            fileExist = true;
                                            break;
                                        }
                                        else
                                        {
                                            fileExist = false;
                                        }
                                    }

                                    $scope.modal_formTab.tab.push({
                                        entTypeExist: enttype,
                                        relTypeExist: reltype,
                                        propsform: response.data.data,
                                        showBtnType: true,
                                        fileExist: fileExist,
                                        type:$type
                                    });

                                    if (response.data.par_prop_type_val !== null)
                                    {
                                        $scope.verParEntType(response.data.par_prop_type_val, indexTabLocal);
                                    }

                                    growl.success('Loading done successfully.', {title: 'Success!', referenceId: index_m});
                                    //$scope.showBtnType = true;
                                    $scope.types.push($type);
                                    $scope.mytype = ++$type; //tem de ser ++type senao nao coloca o valor incrementado na variable $scope.mytype
                                    $scope.myindexTab = indexTabLocal++;

                                    //console.log($scope.modal_formTab);

                                    $scope.addTab($title, $templateurl);

                                    $timeout(function () {
                                        $scope.changeTabBoot($title, $templateurl, ++$tabnumber, $scope.mytype, $process_id);
                                    }, 100);
                                }
                            ).catch(function (response) {
                                //debugger;
                                $scope.modal_formTab.tab.push({
                                    entTypeExist: response.data.emptyEntType !== true,
                                    relTypeExist: response.data.emptyRelType !== true,
                                    propsform: null,
                                    showBtnType: null,
                                    type:$type
                                });

                                if (response.status === 400) {
                                    indexTabLocal++;
                                    counterTStatesCan = 0;
                                    $scope.types.push($type);
                                    $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                                    //$scope.addTab($title + " " + $type, "tabError");
                                    $timeout(function () {
                                        $scope.changeTabBoot($title, $templateurl, ++$tabnumber, ++$type, $process_id); //nao pode ser $tabnumber++
                                    },100);
                                }
                                else if (response.status === 401)
                                {
                                    growl.error('There is no properties linked to Ent Type or Rel Type!', {
                                        title: 'Erro!',
                                        referenceId: 80
                                    });

                                    $uibModalInstance.close();
                                }
                            });

                            //$scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber, ++$type);
                        }
                        else {
                            growl.error('Can´t advance to the next transaction state.', {
                                title: 'Erro!',
                                referenceId: index_m
                            });
                        }
                    }
                ).catch(function (response) {
                    if (response.status === 400) {

                    }
                });
                //}
            }).catch(function (response) {
                //debugger;
                if (response.status === 400) {
                    growl.error('Can´t advance to the next transaction state, there are some transactions needeed to do it first.', {
                        title: 'Erro!',
                        referenceId: index_m
                    });
                }
            });
        };

        $scope.all = function ($title, $templateurl, $tabnumber, $process_id) {
            $scope.modal_formTab.process = $process_id; //se não for selecionado nenhum valor na selectbox o valor vem undefined, se selecionado vem null
            $scope.modal_formTab.transaction_type_id = trans_id;
            $scope.modal_formTab.process_type_id = process_type_id;

            $scope.tabs.splice($scope.activeTabIndex + 1);
            indexTabLocal = 0;

            $scope.getTodo($process_id != null ? $process_id.id : null).then(function (response) {
                console.log(response.data);
                //emptyRelTypeProp se for false entao existem propriedades para aquele tipo de relação ou
                //é do tipo reltype entao é necessario carregar as selectboxes das instancias das entidades
                //var promise = $timeout();
                var promiseStack = [];
                angular.forEach(response.data, function(value, key) {
                    //promise = promise.then(function() {
                    var deferred = $q.defer();
                    var promise = deferred.promise;
                    if (key === 0)
                    {
                        deferred.resolve();
                    }
                    else
                    {
                        promiseStack.push(deferred);
                    }
                    promise.then(function() {
                        if (value.emptyRelTypeProp === false) {
                            //$scope.modal_formTab.relTypeExist = true;
                            reltype = true;
                            //carregar as duas selectboxes
                            var id = value.rel_type_id;
                            $scope.loadEntities1(id);
                            $scope.loadEntities2(id);
                        }
                        else {
                            reltype = false;
                            //$scope.modal_formTab.relTypeExist = false;
                        }

                        if (value.emptyEntTypeProp) {
                            enttype = false;
                        }
                        else {
                            enttype = true;
                        }

                        //File verification
                        if (value.data !== null)
                        {
                            for (var i = 0; i < value.data.length; i++) {
                                if (value.data[i].value_type === "file") {
                                    fileExist = true;
                                    break;
                                }
                                else {
                                    fileExist = false;
                                }
                            }
                        }

                        $scope.modal_formTab.tab.push({
                            entTypeExist: enttype,
                            relTypeExist: reltype,
                            propsform: value.data,
                            showBtnType: true,
                            fileExist: fileExist,
                            type: key + 1
                        });

                        if (value.par_prop_type_val !== null) {
                            $scope.verParEntType(value.par_prop_type_val, indexTabLocal);
                        }

                        growl.success('Loading done successfully.', {title: 'Success!', referenceId: index_m});
                        //$scope.showBtnType = true;
                        $scope.mytype = key + 1; //tem de ser ++type senao nao coloca o valor incrementado na variable $scope.mytype
                        $scope.myindexTab = indexTabLocal++;

                        $scope.myPromise = promiseStack[key];

                        //console.log($scope.modal_formTab);

                        if (value.data !== null)
                        {
                            $scope.addTab($title, $templateurl);
                        }
                        else
                        {
                            if ((response.data.length - 1) !== key)
                                promiseStack[key].resolve();
                        }
                        /*else
                            return $timeout();

                        return $timeout(500);*/
                    });
                });
            });
        };

        $scope.log = function(m){
            //console.log(m);
            try {
                m.resolve();
            }
            catch(err)
            {

            }
        };

        $scope.getTodo = function($proc_id)
        {
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: API_URL + "dashboard/get_todo",
                data: $.param({ 'process_id': $proc_id,
                        'trans_type_id':trans_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                ignoreLoadingBar: false
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        //inicializar o array das tabs
        $scope.tabs = [];
        //verificar se o tipo de transacção inicia um novo processo
        if (flag_inic_process === 1) //se sim então não aparece a tab para escolher um processo já existente
        {
            //$scope.changeTabBoot('Task', 'tabFormTask', 1, 1, null);
            $scope.all('Task', 'tabFormTask', 1, null);
        }
        else //se não então aparece a tab para escolher um processo já existente
        {
            $scope.tabs = [{
                title: 'Process',
                templateUrl: 'tabProcess',
                disabled: false
            }];

            $scope.processes(); //carregar a dropdownlist com os processos existentes
        }


        $scope.taberror = [];

        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl,
                disabled: false
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        $scope.verifCanUseProc = function($proc_id)
        {
            $http({
                method: 'POST',
                url: API_URL + "dashboard/verify_can_use_proc/",
                data: $.param({ 'process_id': $proc_id,
                        'transaction_type_id':trans_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                if (response.data === false)
                {
                    $scope.cantAdvance = true;
                    growl.error('It is not possible to use this process because the requirements are already met!!! Choose another process', {
                        title: 'Erro!',
                        referenceId: index_m
                    });
                }
                else
                {
                    $scope.cantAdvance = false;
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    $scope.save = function ($form_Tab, $modalInstance) {
        var types = [];
        var typesOnFormTabs = $form_Tab.tab;

        console.log($form_Tab);
        typesOnFormTabs.forEach(function (item, i) {
            types.push(item.type);
        });
        //trans_id
        $scope.getCausalLinksOfTr($form_Tab.transaction_type_id, types).then(function (response) {
            var causallinks = response.data;
            causallinks.forEach(function (item, i) {
                $scope.openModalDialog('sm', causallinks[i].caused_t, causallinks[i].min, causallinks[i].max, item.caused_transaction.language[0].pivot.t_name).then(function (data) {
                    $form_Tab.causalinks.push({
                        transaction_type_id: causallinks[i].caused_t,
                        t_state_id: 1,
                        numberofTrs: data.number
                    });

                    if (ArrModalDialogOpened.length === 0)
                    {
                        $scope.sendData($form_Tab).then(function (response){
                            $modalInstance.close('save');
                        });
                    }
                });
            });
        }).catch(function (response) {
            if (response.status === 400) {
                $scope.sendData($form_Tab).then(function (response){
                    $modalInstance.close('save');
                });
            }
        });
        console.log($form_Tab);
    };

    $scope.getCausalLinksOfTr = function ($trans_type_id, $arr_t_states_id) {
        var deferred = $q.defer();

        $http({
            method: 'POST',
            url: API_URL + "/dashboard/get_causal_links_tr",
            data: $.param({ 't_states_id' : $arr_t_states_id,
                    'transaction_type_id':$trans_type_id
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            ignoreLoadingBar: false
        }).then(function (response) {
            deferred.resolve(response);
        }, function errorCalback(response) {
            deferred.reject(response);
        }).finally(function () {
            // called no matter success or failure
        });

        return deferred.promise;
    };

    $scope.sendData = function ($data) {
        var deferred = $q.defer();

        var data = [];
        data.push($data);

        $http({
            method: 'POST',
            url: API_URL + "/dashboard/send_data",
            data: data,
            headers: {'Content-Type': 'application/json'},
            ignoreLoadingBar: false
        }).then(function (response) {
            deferred.resolve(response);
        }, function errorCalback(response) {
            deferred.reject(response);
        }).finally(function () {
            // called no matter success or failure
        });

        return deferred.promise;
    };

    $scope.modal.transaction_type_id = null;

    var reltype = false;
    var enttype = false;
    $scope.propsForm = function($id, $type)
    {
        var deferred = $q.defer();
        //$scope.modal_formTab = [];
        //$scope.modal_formTab.loading = true;
        $http.get(API_URL + "/dashboard/get_props_form/" + $id + "/" + $type)
            .then(function (response) {
                    deferred.resolve(response);
                }, function errorCalback(response)
                {
                    deferred.reject(response);
                }
            ).finally(function() {
            // called no matter success or failure
            //$scope.modal_formTab.loading = false;
        });

        return deferred.promise;
    };

    $scope.isTrAndStWaitingForAnotherTr = function ($trans_type_id, $t_state_id, $process_id) {
        var deferred = $q.defer();

        $http({
            method: 'POST',
            url: API_URL + "/dashboard/isTrAndStWaitingForAnotherTr",
            data: $.param({ 't_state_id' : $t_state_id,
                    'transaction_type_id': $trans_type_id,
                    'process_id' : $process_id
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            ignoreLoadingBar: false
        }).then(function (response) {
            deferred.resolve(response);
        }, function errorCalback(response) {
            deferred.reject(response);
        }).finally(function () {
            // called no matter success or failure
        });

        return deferred.promise;
    };

    $scope.loadEntities1 = function($id) {
        $http.get(API_URL + "/dashboard/get_entities1_for_relType/" + $id)
            .then(function (response) {
                $scope.entities1 = response.data;
            });
    };

    $scope.loadEntities2 = function($id) {
        $http.get(API_URL + "/dashboard/get_entities2_for_relType/" + $id)
            .then(function (response) {
                $scope.entities2 = response.data;
            });
    };

    $scope.openModalProcess = function (size, parentSelector) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalProcess',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            alert("modal closed");
        });

        /*modalInstance.result.then(function () {
            alert('Modal success at:' + new Date());
        }, function () {
            //alert('Modal dismissed at: ' + new Date());
            //$scope.modal = null;
        });*/
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

    $scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };

    $scope.transacsTypesUserCanInit = function($id) {
        $http.get(API_URL + "/dashboard/get_transtypeusercaninit/" + $id)
            .then(function (response) {
                $scope.transactiontypes = response.data;
            });
    };

    $scope.transacsTypesUserCanInit_ = function() {
        $http.get(API_URL + "/dashboard/get_transtypeusercaninit_")
            .then(function (response) {
                $scope.transactiontypes_ = response.data;
            });
    };
    $scope.transacsTypesUserCanInit_();

    $scope.customFormUserCanInit_ = function() {
        $http.get(API_URL + "/dashboard/get_customformusercaninit_")
            .then(function (response) {
                $scope.customforms_ = response.data;
            });
    };
    $scope.customFormUserCanInit_();


    $scope.getAllInicExecTrans = function() {
        $http.get('/dashboard/get_all_inic_exec_trans', [{cache : true}]).then(function(response) {
            $scope.tableParamsInicTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data.InicTrans
            });

            $scope.tableParamsExecTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data.ExecTrans
            });
        });
    };
    $scope.getAllInicExecTrans();





    $scope.openModalTransactionState = function (size, id, actorCan, processid, trans_type_id) {
        //parentSelector,
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalTransactionState',
            controller: 'ModalInstanceCtrl_trans_state',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                trans_id: function() {
                    return id
                },
                actor_Can: function() {
                    return actorCan
                },
                process_id: function() {
                    return processid
                },
                transaction_type_id: function() {
                    return trans_type_id
                }
            }
        }).result.then(function(result) {
            //Get triggers when modal is closed
            //alert(reason);
            $scope.modal = [];
            //$scope.modal_processTab = [];
            //$scope.modal_formTab = [];
            uploader.clearQueue();

            $scope.modal_formTab.length = 0;
            $scope.getAllInicExecTrans();
            alert("entrou closed");
        }, function(reason){
            //gets triggers when modal is dismissed.
            uploader.clearQueue();
            $scope.modal_formTab.length = 0;
            alert("entrou dismissed");
        });

        /*modalInstance.result.then(function () {
         alert('Modal success at:' + new Date());
         }, function () {
         //alert('Modal dismissed at: ' + new Date());
         //$scope.modal = null;
         });*/
    };

    $scope.ModalInstanceCtrl_trans_state = function ($scope, $uibModalInstance, trans_id, actor_Can, process_id, transaction_type_id) {
        $scope.modal_formTab = {};
        $scope.modalInstance = $uibModalInstance;
        var indexTabLocal = 0;
        var index_m = 0;
        //$scope.modal_formTab.push({ tab :[], causalinks :[], types : []});
        $scope.modal_formTab.relTypeExist = false;
        $scope.modal_formTab.tab = [];
        $scope.modal_formTab.causalinks = [];

        var proc = {id:process_id};
        $scope.modal_formTab.process = proc; //se não for selecionado nenhum valor na selectbox o valor vem undefined, se selecionado vem null
        $scope.modal_formTab.transaction_type_id = transaction_type_id;
        $scope.modal_formTab.transaction_id = trans_id;
        //$scope.modal_formTab.process_type_id = process_type_id;


        $scope.myindex = index_m;

        $scope.updateValue = function(choice, i, indexTab){
            console.log($scope.modal_formTab);
            console.log(choice);
            console.log(i);
            var index = $scope.modal_formTab.tab[indexTab].propsform[i].fields[choice];
            console.log(index);
            if (index === false)
            {
                delete $scope.modal_formTab.tab[indexTab].propsform[i].fields[choice];
            }

            if (isEmpty($scope.modal_formTab.tab[indexTab].propsform[i].fields))
            {
                delete $scope.modal_formTab.tab[indexTab].propsform[i].fields;
            }

            //console.log($scope.modal_formTab.tab[indexTab].propsform[i].fields);
        };

        function isEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        $scope.tabs = [{
            title: 'Transaction State',
            templateUrl: 'tabTransactionState'
        }];

        $scope.actorCan = actor_Can;
        $scope.myTransID = trans_id;

        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        $scope.verifyCanDoNextTransState = function($id, $t_state_id, $actorCan, $trans_type_id) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: API_URL + "/dashboard/verify_can_do_next_trans_state/" + $id,
                data: $.param({ 't_state_id' : $t_state_id,
                        'actorCan': $actorCan,
                        'transaction_type_id' : $trans_type_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                deferred.resolve(response);
            }).catch(function(response){
                deferred.reject(response);
            });

            return deferred.promise;
        };

        $scope.changeTabBoot = function ($title, $templateurl, $tabnumber, $type) {
            alert("Current transaction state is: " + $type);
            $scope.tabs.splice(($scope.activeTabIndex + 1), ($scope.tabs.length - 1));
            //alert($scope.activeTabIndex);
            if ($scope.activeTabIndex === 0)
                $scope.modal_formTab.tab.splice(0, ($scope.modal_formTab.tab.length - 1));
            else
                $scope.modal_formTab.tab.splice(($scope.activeTabIndex + 1), ($scope.tabs.length - 1));
            /*if ($tabnumber === 1)
            {
                indexTabLocal = 1;
            }*/

            $scope.verifyCanDoNextTransState(trans_id, $type, actor_Can, transaction_type_id).then(function (response) {
                var type = parseInt(response.data.nextState);

                //alert("The next transaction state is: " + type);

                    //a guarda da recursividade
                    if (type > 5)
                    {
                        return;
                    }

                    alert("The next transaction state is: " + type);
                    //$t_state++;
                $scope.isTrAndStWaitingForAnotherTr(transaction_type_id, type, process_id).then(function (data) {
                                $scope.propsForm(transaction_type_id, type).then(function (response) {
                                        //emptyRelTypeProp se for false entao existem propriedades para aquele tipo de relação ou
                                        //é do tipo reltype entao é necessario carregar as selectboxes das instancias das entidades
                                        if (response.data.emptyRelTypeProp === false)
                                        {
                                            //$scope.modal_formTab.relTypeExist = true;
                                            reltype = true;
                                            //carregar as duas selectboxes
                                            var id = response.data.rel_type_id;
                                            $scope.loadEntities1(id);
                                            $scope.loadEntities2(id);
                                        }
                                        else
                                        {
                                            reltype = false;
                                            //$scope.modal_formTab.relTypeExist = false;
                                        }

                                        if (response.data.emptyEntTypeProp === false)
                                        {
                                            enttype = true;
                                        }
                                        else
                                        {
                                            enttype = false;
                                        }

                                        //File verification
                                        for (var i=0; i < response.data.data.length; i++)
                                        {
                                            if (response.data.data[i].value_type === "file")
                                            {
                                                fileExist = true;
                                                break;
                                            }
                                            else
                                            {
                                                fileExist = false;
                                            }
                                        }

                                        $scope.modal_formTab.tab.push({
                                            entTypeExist: enttype,
                                            relTypeExist: reltype,
                                            propsform: response.data.data,
                                            showBtnType: false,
                                            fileExist: fileExist,
                                            type:type
                                        });

                                        growl.success('Loading done successfully.', {title: 'Success!', referenceId: index_m});
                                        $scope.showBtnType = false;
                                        $scope.mytype = (type === 1 ? type + 1 : type); //tem de ser ++type senao nao coloca o valor incrementado na variable $scope.mytype
                                        //$scope.myindexTab = indexTabLocal++;
                                        $scope.myindexTab = ++$tabnumber;

                                        //console.log($scope.modal_formTab);

                                        $scope.addTab($title, $templateurl);
                                    }
                                ).catch(function (response) {
                                    //debugger;
                                    $scope.modal_formTab.tab.push({
                                        entTypeExist: response.data.emptyEntTypeProp != true,
                                        relTypeExist: response.data.emptyRelTypeProp != true,
                                        propsform: null,
                                        showBtnType: null,
                                        type:type
                                    });

                                    if (response.status == 400) {
                                        //indexTabLocal++;
                                        ++$tabnumber;
                                        counterTStatesCan = 0;

                                        $scope.myMessage = "There is no form associated to transaction state " + type;

                                        $scope.addTab("Info", 'tabError');
                                        $timeout(function () {
                                            //$scope.verifyCanDoNextTransState(trans_id, type, actor_Can, transaction_type_id);
                                            //$scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber, ++$type, $process_id); //nao pode ser $tabnumber++
                                            $scope.changeTabBoot($title, $templateurl, $tabnumber, type);
                                        },100);
                                    }
                                    else if (response.status == 401)
                                    {
                                        growl.error('There is no properties linked to Ent Type or Rel Type!', {
                                            title: 'Erro!',
                                            referenceId: 80
                                        });

                                        $uibModalInstance.close();
                                    }
                                });
                        }).catch(function (response) {
                            //debugger;
                            if (response.status == 400) {
                                growl.error('Can´t advance to the next transaction state, there are some transactions needeed to do it first.' + + response.data.dataTransactionsLacking, {
                                    title: 'Erro!',
                                    referenceId: index_m,
                                    ttl: -1
                                });
                            }
                });
            }).catch(function (response) {
                    if (response.status === 400)
                    {
                        alert("Não pode seguir para o proximo passo");
                    }
                    console.log(response);
                });
        };

        $scope.trans_states = function($id) {
            $http.get(API_URL + "/dashboard/get_states_from_transaction/" + $id)
                .then(function (response) {
                    $scope.transactionstates = response.data.data;
                    //$scope.t_state_id = response.data.t_state_id;
                });
        };
        $scope.trans_states(trans_id);

        $scope.trans_ack = function($lastTransactionState) {
            if ((actor_Can === 'Iniciator' && ($lastTransactionState.t_state_id === 2 || $lastTransactionState.t_state_id === 3 || $lastTransactionState.t_state_id === 4))
            || (actor_Can === 'Executer' && ($lastTransactionState.t_state_id === 1 || $lastTransactionState.t_state_id === 5)))
            {
                //verifica e insere na base de dados
                $scope.insertTransactionAck($lastTransactionState.id).then(function (response) {
                    alert("sucesso");
                    $scope.trans_states(trans_id);

                }).catch(function (response) {
                    if (response.status === 400)
                    {
                        alert("Ocorreu um erro");
                    }
                    else if (response.status === 401)
                    {
                        alert("O acknowledge da transacção já existe");
                    }
                });
            }
        };

        $scope.insertTransactionAck = function($trans_state_id) {
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: API_URL + "dashboard/trans_ack/",
                data: $.param({
                        'trans_state_id' : $trans_state_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                deferred.resolve(response);
            }).catch(function (response) {
                deferred.reject(response);
            });

            return deferred.promise;
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };





    $scope.openModalProcessTransactions = function (size, parentSelector) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalProcessTransactions',
            controller: 'ModalInstanceCtrl_procs_trans_state',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            //alert("modal closed");
        });

        /*modalInstance.result.then(function () {
         alert('Modal success at:' + new Date());
         }, function () {
         //alert('Modal dismissed at: ' + new Date());
         //$scope.modal = null;
         });*/
    };

    $scope.ModalInstanceCtrl_procs_trans_state = function ($scope, $uibModalInstance) {
        $scope.tabs = [{
            title: 'Transactions',
            templateUrl: 'tabTransactions'
        }];

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };


    //Inicio - Guilherme
    //Modal CustomForm
    //Verificar se é custoForm para gestão do file
    var customFormfileUpload = false;

    $scope.modal_formTab1 = [];

    $scope.openModalCustomFormTask = function (size, customformid, customforminitproc) {

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalTaskCustomForm',
            controller: 'ModalInstanceCtrlCustomForm',
            scope: $scope,
            size: size,
            resolve: {
                custom_form_id: function() {
                    return customformid
                },
                custom_form_init_proc: function() {
                    return customforminitproc
                }
            }
        }).result.then(function(reason) {
            //Get triggers when modal is closed
            uploader.clearQueue();
            $scope.files = [];
            $scope.process = null;
            $scope.tabs = null;
            $scope.modal_processTab = null;
            $scope.modal_formTab1 = [];
            var index_m = 0;
            var indexTabLocal = 0;
            customFormfileUpload = false;

            $scope.getAllInicExecTrans();

        }, function(){
            //Get triggers when modal is dimissed
            uploader.clearQueue();
            $scope.files = [];
            $scope.process = null;
            $scope.tabs = null;
            $scope.modal_processTab = null;
            $scope.modal_formTab1 = [];
            var index_m = 0;
            var indexTabLocal = 0;
            customFormfileUpload = false;
        });
    };

    $scope.ModalInstanceCtrlCustomForm = function ($scope, $uibModalInstance, $timeout, custom_form_id, custom_form_init_proc) {

        var custom_form_id = custom_form_id;
        customFormfileUpload = true;
        $scope.fileExist = false;
        $scope.process = [];
        $scope.tabs = [];
        $scope.modal_processTab = [];
        $scope.modal_formTab1.push({ tab :[]});
        var index_m = 0;
        var indexTabLocal = 0;

        $scope.modal_formTab1[index_m].custom_form_id = custom_form_id;

        //Mudar a Tab
        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl,
                disabled: false
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        //Buscar os Processos
        $scope.processesCustomForm = function() {
            $http.get(API_URL + '/dashboard/get_process_custom_form/' + custom_form_id)
                .then(function (response) {
                    $scope.process = response.data;
                });
        };

        //Buscar o custom Form
        $scope.getCustomForm = function (){

            $http.get(API_URL + '/dashboard/get_custom_form/' + custom_form_id)
                .then(function (response) {

                    //$scope.modal_formTab1.push({ tab :[], causalinks :[]}); se forem varios modais é preciso fazer assim
                    $scope.modal_formTab1[index_m].tab.push({
                        propsform: response.data
                    });

                    //defenir o Process_type_id
                    //Assumindo que todas os tipos de transações pertencem ao mesmo tipo de processo. Buscar id do tipo de processo pela  primeira Tipo de trasanção
                    $scope.modal_formTab1[index_m].process_type_id = response.data.transaction_types[0].process_type_id;

                    if(response.data.transaction_types !== undefined)
                    {
                        //File verification
                        for (var i=0; i < response.data.transaction_types.length; i++)
                        {
                            for(var j=0; j < response.data.transaction_types[i].ent_type[0].properties.length; j++)

                                if (response.data.transaction_types[i].ent_type[0].properties[j].value_type === "file")
                                {
                                    $scope.fileExist = true;
                                    break;
                                }
                        }
                    }
                });
        };

        //Mudar a Tab
        $scope.all = function ($title, $templateurl, $tabnumber, $process_id) {

            //Verificar se selecionou um processo
            if($process_id === undefined || $process_id === null)
            {
                growl.error('Selecione um Processo; ', {title: 'Erro!'});
            }
            else
            {
                var process_id = $process_id.id;
                $scope.modal_formTab1[index_m].process_id = process_id;

                //Fazer o reset das tabs
                $scope.tabs.splice(($scope.activeTabIndex + 1));

                if (custom_form_id !== undefined) {
                    switch ($tabnumber) {
                        case 1:
                            //Verificar se pode avançar (causal e waiting)
                            $scope.isUserInicExecOfCustomForm(custom_form_id, process_id).then(function (data) {

                                //Caso pode avançar
                                //Buscar os Tipos de Transações
                                $scope.getCustomForm();
                                //Adicionar a tab
                                $scope.myindexTab = indexTabLocal++;
                                $scope.myindex = index_m;
                                $scope.addTab("Custom Form", "tabFormCustomForm");

                            }).catch(function (response) {
                                //Apagar as messagens de Growls antigas
                                //debugger;
                                if(!response.data.Causal)
                                    growl.error('Já existe transações realizadas do Custom Form, neste processo; ' + '<br>' + response.data.dataError.CausalTransaction.join( '<br>' ), {title: 'Erro!'});

                                if(!response.data.Waiting)
                                    growl.error('Precisa de realizar transações, para poder efectuar este Custom Form; ' + '<br>' + response.data.dataError.WaitingTransaction.join( '<br>' ), {title: 'Erro!'});

                            });

                            break;
                        default:
                    }
                }
            }
        };

        //Verificar as Tabs
        //inicializar o array das tabs
        //verificar se o tipo de transacção inicia um novo processo
        if (custom_form_init_proc === 1) //se sim então não aparece a tab para escolher um processo já existente
        {

            $scope.modal_formTab1[index_m].process_id = null;

            //Buscar o Custom Form
            $scope.getCustomForm();

            $scope.myindexTab = indexTabLocal++;
            $scope.myindex = index_m;
            $scope.addTab("Custom Form", "tabFormCustomForm");

        }
        else //se não então aparece a tab para escolher um processo já existente
        {
            $scope.tabs = [{
                title: 'Process',
                templateUrl: 'tabProcess',
                disabled: false
            }];

            $scope.processesCustomForm(); //carregar a dropdownlist com os processos existentes
        }

        //save new record / update existing record
        $scope.save = function() {

            var url = API_URL + "dashboard/savecustomform";

            $http({
                method: 'POST',
                url: url,
                data: $scope.modal_formTab1,
                headers: {'Content-Type': 'application/json'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                growl.success('Insert with Sucess.',{title: 'Success!', referenceId: 80});
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
            });
        };

        //Verificar se pode avançar
        $scope.isUserInicExecOfCustomForm = function ($custom_form_id, $process_id) {
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: API_URL + '/dashboard/verify_custom_form',
                data: $.param({
                        'custom_form_id' :  $custom_form_id,
                        'process_id' :  $process_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                ignoreLoadingBar: true
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        //Close Modal
        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };


    $scope.values = {};

    //FileUploader Functions
    var uploader = $scope.uploader = new FileUploader({
        url: 'fileUpload'
    });

    // CALLBACKS
    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
    };
    uploader.onAfterAddingFile = function(fileItem) {
        var namePath = fileItem.file.name;
        //debugger;
        var arrayKeys = Object.keys($scope.files);
        console.log('arrayKeys',arrayKeys);
        var lastItem = arrayKeys[arrayKeys.length-1];
        console.log('lastItem', lastItem);
        var fileName = lastItem;
        var fileExtension = '.' + fileItem.file.name.split('.').pop();
        var fileNameOriginal = fileItem.file.name;
        fileItem.file.name = fileName + fileExtension;

        //Colocar o File como data64
        var reader = new FileReader();
        reader.readAsDataURL(fileItem._file);
        reader.onload = function (event) {
            var base64 = event.target.result;
            fileItem.file['data'] = base64;
            fileItem.file['fileName'] = fileNameOriginal;
        };

        if(customFormfileUpload)
        {
            angular.forEach($scope.modal_formTab1[0].tab[0].propsform.transaction_types, function(value, key1) {
                angular.forEach(value.ent_type[0].properties, function(value, key) {
                    if (value.language[0].pivot.form_field_name === fileName)
                    {
                        var obj = {};
                        obj[fileName] = fileItem.file;
                        value['fields'] = obj;
                    }
                });
            });
        }
        else
        {
            angular.forEach($scope.modal_formTab.tab, function(value, key1) {
                angular.forEach(value.propsform, function(value, key) {
                    if (value.language[0].pivot.form_field_name === fileName)
                    {
                        var obj = {};
                        obj[fileName] = fileItem.file;
                        value['fields'] = obj;
                    }
                });
            });
        }

        //console.log('modaformtab', $scope.modal_formTab);
        //console.log('onAfterAddingFile', fileItem);
    };
    $scope.files = [];
    uploader.onAfterRemovingFile = function(fileItem) {
        var fileName = fileItem.file.name.split('.').shift();
        //$scope.files[0][fileName] = null;
        delete $scope.files[fileName];

        var fileName = fileItem.file.name.replace(/\.\w+/, "");

        if(customFormfileUpload)
        {
            angular.forEach($scope.modal_formTab1[0].tab[0].transaction_types, function(value, key1) {
                angular.forEach(value.ent_type[0].properties, function(value, key) {
                    if (value.language[0].pivot.form_field_name === fileName)
                    {
                        delete value['fields'];
                    }
                });
            });
        }
        else
        {
            angular.forEach($scope.modal_formTab.tab, function(value, key1) {
                angular.forEach(value.propsform, function(value, key) {
                    if (value.language[0].pivot.form_field_name === fileName)
                    {
                        delete value['fields'];
                    }
                });
            });
        }

        //console.info('onAfterRemovingFile', fileItem);
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function(item) {
        console.info('onBeforeUploadItem', item);
    };
    uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
    };
}).directive('validFile', function () {
    return {
        require: "ngModel",
        restrict: 'A',
        link: function ($scope, el, attrs, ngModel) {
            el.bind('change', function (event) {
                ngModel.$setViewValue(event.target.files[0]);
                $scope.$apply();
            });

            $scope.$watch(function () {
                return ngModel.$viewValue;
            }, function (value) {
                if (!value) {
                    el.val("");
                }
            });
        }
    };
});