<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/translations/{lang}/{part}.json', function($lang,$part) {
    return File::get(public_path() . '/app/translations/' . $lang . '/' . $part .'.json');
});

//TIPOS DE PROCESSO
Route::get('/modalProcessTypes', function () {
    return view('processTypes/modalProcessTypes');
});
Route::get('/processTypesManage', 'ProcessTypes@index');
Route::get('/proc_types/get_proc/{id?}', 'ProcessTypes@getAll');
Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/Process_Type', 'ProcessTypes@insert');
Route::post('/Process_Type/{id}', 'ProcessTypes@update');
Route::post('/Process_Type_del/{id}', 'ProcessTypes@delete');
//FIM

//INSERIR PROCESSOS
Route::get('/processesManage', 'Processes@index');
Route::get('/procs/get_procs/{id?}','Processes@getAll');
Route::post('/Process', 'Processes@insert');
Route::get('/proc_types/get_procs_types', 'Processes@getAllProcsTypes');
//FIM

//TIPOS DE TRANSACÇÕES
Route::get('/modalTransactionTypes', function () {
    return view('transactionTypes/modalTransactionTypes');
});
Route::get('/transactionTypesManage', 'TransactionTypes@index');
Route::get('/transacs_types/get_transacs_types/{id?}','TransactionTypes@getAll');
Route::post('/Transaction_Type', 'TransactionTypes@insert');
Route::post('/Transaction_Type/{id}', 'TransactionTypes@update');
Route::post('/Transaction_Type_del/{id}', 'TransactionTypes@delete');
Route::get('/exec/get_executers', 'TransactionTypes@getAllExecuters');
//FIM

//INSERIR TRANSACÇÕES
Route::get('/transactionsManage', 'Transactions@index');
Route::get('/transacs/get_transacs/{id?}','Transactions@getAll');
Route::post('/Transaction', 'Transactions@insert');
Route::get('/processes/get_processes', 'Transactions@getAllProcesses');
Route::get('/processes/get_transacs_types', 'Transactions@getAllTransactionsTypes');


//TIPOS DE ENTIDADES
Route::get('/modalEntTypes', function () {
    return view('entTypes/modalEntTypes');
});
Route::get('/entityTypesManage', 'EntTypes@index');
Route::get('/ents_types/get_ents_types/{id?}','EntTypes@getAll');
Route::post('/Entity_Type', 'EntTypes@insert');
Route::post('/Entity_Type/{id}', 'EntTypes@update');
Route::post('/Entity_Type_del/{id}', 'EntTypes@delete');
Route::get('/ents_types/get_enttypes', 'EntTypes@getAllEntTypes');
Route::get('/ents_types/get_transacs_types', 'EntTypes@getAllTransactionTypes');
Route::get('/ents_types/get_tstates', 'EntTypes@getAllTStates');
Route::get('/ents_types/get_prop_allowed_values', 'EntTypes@getAllPropAllowedValues');

Route::get('/ents_types/get_all_http', 'EntTypes@getAllHttp');


//CASUAL LINKS
Route::get('/modalCausalLinks', function () {
    return view('causalLinks/modalCausalLinks');
});
Route::get('/CausalLinksManage', 'CausalLinksController@index');
Route::get('/causal_links/get_causal_links/{id?}','CausalLinksController@getAll');
Route::post('/Causal_Link', 'CausalLinksController@insert');
Route::post('/Causal_Link/{id}', 'CausalLinksController@update');
Route::post('/Causal_Link_del/{id}', 'CausalLinksController@delete');


//WAITING LINKS
Route::get('/modalWaitingLinks', function () {
    return view('waitingLinks/modalWaitingLinks');
});
Route::get('/WaitingLinksManage', 'WaitingLinksController@index');
Route::get('/waiting_links/get_waiting_links/{id?}','WaitingLinksController@getAll');
Route::post('/Waiting_Link', 'WaitingLinksController@insert');
Route::post('/Waiting_Link/{id}', 'WaitingLinksController@update');
Route::post('/Waiting_Link_del/{id}', 'WaitingLinksController@delete');


//T STATE
Route::get('/tStatesManage', 'TStatesController@index');
Route::get('/t_states/get_t_state/{id?}', 'TStatesController@getAll');
Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/T_State', 'TStatesController@insert');
Route::post('/T_State/{id}', 'TStatesController@update');
Route::post('/T_State_del/{id}', 'TStatesController@delete');

//Dashboard
Route::post('/dashboard/get_todo', 'DashboardController@all');


Route::get('/transaction_types/get_trans_type_name/{id}', 'DashboardController@getTransTypeName');

Route::get('/dashboardManage', 'DashboardController@index');

Route::get('/dashboard/get_transtypeusercaninit_', 'DashboardController@getTransTypeUserCanInit');

Route::get('/dashboard/get_props_form/{id}/{id1}/{id2}', 'DashboardController@getProps');
Route::get('/dashboard/get_props_form_child/{id}', 'DashboardController@getPropsfromChild');

Route::get('/dashboard/get_processes_of_tr/{id}', 'DashboardController@getAllProcessOfTr');

Route::get('/dashboard/get_entities1_for_relType/{id}', 'DashboardController@getEntites1RelType');
Route::get('/dashboard/get_entities2_for_relType/{id}', 'DashboardController@getEntites2RelType');

/*Route::get('/dashboard/get_all_inic_trans', 'DashboardController@getAllInicTrans');
Route::get('/dashboard/get_all_exec_trans', 'DashboardController@getAllExecTrans');*/
Route::get('/dashboard/get_all_inic_exec_trans', 'DashboardController@getAllInicExecTrans');

Route::get('/dashboard/is_User_InicAndExec_trans/{id}', 'DashboardController@isUserInicAndExecOfTrans');

Route::post('/dashboard/verify_can_use_proc/', 'DashboardController@verifCanUseProc');

Route::post('/dashboard/isTrAndStWaitingForAnotherTr', 'DashboardController@isTrAndStWaitingForAnotherTr');
Route::post('/dashboard/get_causal_links_tr', 'DashboardController@getCausalLinksOfTr');

Route::get('/tabError', function () {
    return view('dashboard/tabError');
});

Route::get('/tabProcess', function () {
    return view('dashboard/tabProcess');
});

Route::get('/modalDialog', function () {
    return view('dashboard/modalDialog');
});

Route::get('/modalTask', function () {
    return view('dashboard/modalTask');
});
Route::get('/modalProcess', function () {
    return view('dashboard/modalProcess');
});
Route::get('/tabTask', function () {
    return view('dashboard/tabTask');
});
Route::get('/tabFormTask', function () {
    return view('dashboard/tabFormTask');
});
Route::get('/tabChildFormTask', function () {
    return view('dashboard/tabChildFormTask');
});


Route::get('/popover', function () {
    return view('dashboard/popover');
});


Route::get('/modalTransactionState', function () {
    return view('dashboard/modalTransactionState');
});
Route::get('/tabTransactionState', function () {
    return view('dashboard/tabTransactionsState');
});
Route::get('/dashboard/get_states_from_transaction/{id}', 'DashboardController@getStatesFromTransaction');

Route::post('/dashboard/verify_can_do_next_trans_state/{id}', 'DashboardController@verifyIfCanDoNextTransactionState');

Route::get('/modalProcessTransactions', function () {
    return view('dashboard/modalProcess_Transactions');
});
Route::get('/tabProcessTransactions', function () {
    return view('dashboard/tabProcessTransactions');
});

Route::post('/dashboard/send_data', 'DashboardController@insertData');

Route::post('/dashboard/trans_ack', 'DashboardController@transactionAckAll');


Route::get('/proc_types/get_langs', 'ProcessTypes@getAllLanguage');
Route::post('/Process_Type', 'ProcessTypes@insert');
Route::post('/Process_Type/{id}', 'ProcessTypes@update');
Route::post('/Process_Type_del/{id}', 'ProcessTypes@delete');

//***********************************MARIA****************************//
// Rotas da gestão de Relações

Route::get('/relationTypesManage/', 'RelationManagement@index');
//Route::get('/relTypes/get_relations', 'RelationManagement@getAllRels');
Route::get('/getAllEntities', 'RelationManagement@getEntities');
Route::get('/getAllTransactionTypes', 'RelationManagement@getTransactionTypes');
Route::get('/getAllTransactionStates', 'RelationManagement@getTransactionStates');
Route::post('/Relation', 'RelationManagement@insertRelations');
Route::post('/Relation/{id?}', 'RelationManagement@updateRelationType');
Route::get('/getRelationsTypes/{id?}', 'RelationManagement@getRelations');
Route::post('/Relation_Type_remove/{id}', 'RelationManagement@remove');
Route::get('/modalrelType', function () {
    return view('reltype/modalRelType');
});

Route::get('/relTypes/get_relation_types1/{id?}','RelationManagement@getAll_test');

//Novas rotas com entidades separadas das relações
//----------------------------------Propriedades da Entidade----------------------------------------------------

Route::get('/propertiesManageEnt', 'PropertiesOfEntitiesController@getAllPropertiesOfEntities');
Route::get('/properties/get_props_ents', 'PropertiesOfEntitiesController@getAllEnt');

Route::post('/PropertyEnt', 'PropertiesOfEntitiesController@insertPropsEnt');
Route::post('/PropertyEnt/{id?}', 'PropertiesOfEntitiesController@updatePropsEnt');
Route::get('/properties/getPropsEntity', 'PropertiesOfEntitiesController@getAllPropsEntities');
Route::get('/properties/getPropsEntity/{id?}', 'PropertiesOfEntitiesController@getPropsEntities');
Route::post('/updateOrderEnt', 'PropertiesOfEntitiesController@updateOrderPropsEnt');
Route::get('/modalPropsEnt', function () {
    return view('properties/modalPropsEnt');
});

Route::get('/modalDragDropPropsEnt', function () {
    return view('properties/modalDragDropPropsEnt');
});

Route::post('/PropertyOfEntities_remove/{id}', 'PropertiesOfEntitiesController@remove');

Route::get('/modalConfirm', function () {
    return view('properties/modalConfirm');
});


Route::get('/properties/outputTypes', 'PropertiesOfEntitiesController@getOutputTypes');
Route::get('/PropertyEnt/get_props_ent/{id?}','PropertiesOfEntitiesController@getAll_test');

Route::get('/propertiesOfEntities/get_propsOfEnt/{id?}','PropertiesOfEntitiesController@getAll_test');

Route::get('/properties/getAllEntities','PropertiesOfEntitiesController@getEntities');

//----------------------------------Propriedades da Relação----------------------------------------------------

Route::get('/propertiesManageRel', 'PropertiesOfRelationsController@getAllPropertiesOfRelations');
Route::get('/properties/get_props_rel', 'PropertiesOfRelationsController@getAllRel');
Route::post('/PropertyRel', 'PropertiesOfRelationsController@insertPropsRel');
Route::post('/PropertyRel/{id?}', 'PropertiesOfRelationsController@updatePropsRel');
Route::get('/properties/getPropsRelation/{id?}', 'PropertiesOfRelationsController@getPropsRelations');
Route::post('/updateOrder', 'PropertiesManagment@updateOrderProps');

Route::get('/modalPropsRel', function () {
    return view('properties/modalPropsRel');
});

Route::get('/propertiesOfRelation/get_propsOfRel1/{id?}','PropertiesOfRelationsController@getAll_test');

Route::get('/properties/getAllRelations','PropertiesOfRelationsController@getRelations');

Route::post('/propertiesOfRelation/remove/{id}', 'PropertiesOfRelationsController@remove');

//--------------------------Métodos comuns as entidades e as relações---------------------------

Route::get('/properties/states', 'PropertiesController@getStates');
Route::get('/properties/valueTypes', 'PropertiesController@getValueTypes');
Route::get('/properties/fieldTypes', 'PropertiesController@getFieldTypes');
Route::get('/properties/units', 'PropertiesController@getUnits');
Route::get('/properties/get_property/{id?}', 'PropertiesController@getProperty');



Route::get('/properties/getTransactionsStates', 'PropertiesController@getTransactionsStates');
//----------------------------------Pesquisa Dinâmica----------------------------------------------------

Route::get('/dynamicSearch', 'DynamicSearchController@index');
Route::get('/dynamicSearch/entities', 'DynamicSearchController@getEntities');
Route::get('/dynamicSearch/entity/{id?}', 'DynamicSearchController@getEntitiesData');
Route::get('/dynamicSearch/entityDetails/{id?}', 'DynamicSearchController@getEntitiesDetails');
Route::get('/dynamicSearch/getOperators', 'DynamicSearchController@getOperators');
Route::get('/dynamicSearch/getEnumValues/{id?}', 'DynamicSearchController@getEnumValues');
Route::get('/dynamicSearch/getEntityInstances/{entityId?}/{propId?}', 'DynamicSearchController@getEntityInstances');
Route::get('/dynamicSearch/getEntRefs/{id?}', 'DynamicSearchController@getEntRefs');
Route::get('/dynamicSearch/getPropRefs/{id?}', 'DynamicSearchController@getPropRefs');
Route::get('/dynamicSearch/getPropsOfEnts/{id?}', 'DynamicSearchController@getPropsOfEnts');
Route::get('/dynamicSearch/getRelsWithEnt/{id?}', 'DynamicSearchController@getRelsWithEnt');
Route::get('/dynamicSearch/getEntsRelated/{idRelType?}/{idEntType}', 'DynamicSearchController@getEntsRelated');
Route::get('/dynamicSearch/getPropsEntRelated/{id?}', 'DynamicSearchController@getPropsEntRelated');


Route::post('/dynamicSearch/search/{id?}', 'DynamicSearchController@search');


Route::post('/dynamicSearch/inactiveActive/{id?}', 'DynamicSearchController@inactiveActive');


// Rotas para o saved searches
Route::get('/dynamicSearch/savedSearch', 'DynamicSearchController@showSavedSearches');


Route::post('/dynamicSearch/saveSearch/{id?}', 'DynamicSearchController@saveSearch');
Route::get('/dynamicSearch/getSavedQueries', 'DynamicSearchController@getSavedQueries');


//testes
Route::get('/dynamicSearch/getPropertiesQuery/{idQuery?}/{tableType?}', 'DynamicSearchController@getPropertiesQuery');


//Teste ng table saved query
Route::get('/dynamicSearch/getSavedQuery/{id?}','DynamicSearchController@getAllSavedsQueries');


//-------------------------------------------Rotas referentes aos operadores--------------------------------------

Route::get('/operator', 'OperatorController@index');
Route::get('/operator/get_operator_types/{id?}','OperatorController@getAll');
Route::get('/modalOperator', function () {
    return view('operator/modalOperator');
});
Route::post('/Operator', 'OperatorController@insertOperator');


//******************************************Duarte***********************************************//
//Users
Route::get('/usersManage', 'UsersController@index');
Route::get('/get_users', 'UsersController@getAll');
Route::get('/get_users/{id?}', 'UsersController@getAll');
Route::post('/users', 'UsersController@insert');
Route::post('/users/{id?}', 'UsersController@update');
Route::post('/users/remove/{id?}', 'UsersController@remove');
Route::get('/users/get_langs', 'UsersController@getLangs');
Route::get('/users/get_entities', 'UsersController@getEntities');

Route::get('/users/get_roles', 'UsersController@getRoles');
Route::get('/users/get_selroles/{id}', 'UsersController@getSelRoles');
Route::get('/users/get_onlyroles/{id}', 'UsersController@getOnlyRoles');
Route::post('/users/update_roles/{id}', 'UsersController@updateRoles');
Route::get('/users/view_roles', 'UsersController@viewRoles');
Route::post('/remove_user_role/', 'UsersController@removeRole');

//Languages
Route::get('/languagesManage', 'LanguageController@index');
Route::get('/get_languages', 'LanguageController@getAll');
Route::get('/get_languages/{id?}', 'LanguageController@getAll');
Route::post('/languages', 'LanguageController@insert');
Route::post('/languages/{id?}', 'LanguageController@update');
Route::post('/languages/remove/{id?}', 'LanguageController@remove');

//Actors
Route::get('/actorsManage', 'ActorController@index');
Route::get('/get_actors', 'ActorController@getAll');
Route::get('/get_actors/{id?}', 'ActorController@getAll');
Route::post('/actors', 'ActorController@insert');
Route::post('/actors/{id?}', 'ActorController@update');
Route::post('/actors/remove/{id?}', 'ActorController@remove');

Route::get('/actors/get_roles', 'ActorController@getRoles');
Route::get('/actors/get_selroles/{id}', 'ActorController@getSelRoles');
Route::get('/actors/get_onlyroles/{id}', 'ActorController@getOnlyRoles');
Route::post('/actors/update_roles/{id}', 'ActorController@updateRoles');
Route::get('/actors/view_roles', 'ActorController@viewRoles');
Route::post('/remove_actor_role/', 'ActorController@removeRole');

//Roles
Route::get('/rolesManage', 'RoleController@index');
Route::get('/get_roles', 'RoleController@getAll');
Route::get('/get_roles/{id?}', 'RoleController@getAll');
Route::post('/roles', 'RoleController@insert');
Route::post('/roles/{id?}', 'RoleController@update');
Route::post('/roles/remove/{id?}', 'RoleController@remove');

Route::get('/roles/get_actors', 'RoleController@getActors');
Route::get('/roles/get_selactors/{id}', 'RoleController@getSelActors');
Route::get('/roles/get_onlyactors/{id}', 'RoleController@getOnlyActors');
Route::post('/roles/update_actors/{id}', 'RoleController@updateActors');
Route::get('/roles/view_actors', 'RoleController@viewActors');
Route::post('/remove_actor_role/', 'RoleController@removeActors');

Route::get('/roles/get_users', 'RoleController@getUsers');
Route::get('/roles/get_selusers/{id}', 'RoleController@getSelUsers');
Route::get('/roles/get_onlyusers/{id}', 'RoleController@getOnlyUsers');
Route::post('/roles/update_users/{id}', 'RoleController@updateUsers');
Route::get('/roles/view_users', 'RoleController@viewUsers');
Route::post('/remove_user_role/', 'RoleController@removeUsers');

//*********************************************Guilherme*************************************************//
//Prop_unit_type
Route::get('/propUnitTypeManage/', 'PropUnitTypes@index');
Route::get('/prop_unit_types/get_unit', 'PropUnitTypes@getAll');
Route::get('/prop_unit_types/get_unit/{id?}', 'PropUnitTypes@getAll');
Route::post('/Prop_Unit_Type', 'PropUnitTypes@insert');
Route::post('/Prop_Unit_Type/{id?}', 'PropUnitTypes@update');
Route::get('/modalPropUnitTypes', function () {
    return view('PropUnitTypes/modalPropUnitTypes');
});
Route::post('/prop_unit_types/remove', 'PropUnitTypes@remove');
//FIM

//Prop_allowed_value
Route::get('/propAllowedValueManage/', 'PropAllowedValueController@index');
Route::get('/prop_allowed_value/get_unit', 'PropAllowedValueController@getAll');
Route::get('/prop_allowed_value/get_unit/{id?}', 'PropAllowedValueController@getAll');
Route::get('/prop_allowed_value/get_properties', 'PropAllowedValueController@getProp');
Route::post('/Prop_Allowed_Value', 'PropAllowedValueController@insert');
Route::post('/Prop_Allowed_Value/{id?}', 'PropAllowedValueController@update');
Route::get('/modalPropAllowedValues', function () {
    return view('propAllowedValues/modalPropAllowedValues');
});

Route::post('/prop_allowed_value/remove', 'PropAllowedValueController@remove');
//FIM

//CostumForm_Has_Ent_Type
Route::get('/customFormManage/', 'CustomFormManageController@index');
Route::get('/custom_form/get_custom_form', 'CustomFormManageController@getAll');
Route::get('/custom_form/get_custom_form/{id?}', 'CustomFormManageController@getAll');
Route::get('/custom_form/get_t_states/', 'CustomFormManageController@getAllTSate');

Route::post('/custom_form/updateOrderTransactionType', 'CustomFormManageController@updateOrderTransactionType');
Route::get('/custom_form/get_transaction_types', 'CustomFormManageController@getTransactionTypes');
Route::get('/custom_form/get_sel_transaction_types/{id?}', 'CustomFormManageController@getSelTransactionTypes');
Route::post('/Custom_Form/update_transaction_types/{id}', 'CustomFormManageController@updateTransactionTypes');
Route::post('/Custom_Form/update_mandatory', 'CustomFormManageController@updateMandatory');

Route::post('/Custom_Form/', 'CustomFormManageController@insert');
Route::post('/Custom_Form/{id?}', 'CustomFormManageController@update');
Route::post('/remove_transaction_types', 'CustomFormManageController@removeTransactionTypes');
Route::get('/modalCustomForms_CostumForm', function () {
    return view('customForms/modalCustomForm_CostumForm');
});
Route::get('/modalCustomForms_AddTransactionTypes', function () {
    return view('customForms/modalCustomForm_AddTransactionTypes');
});
Route::get('/modalCustomForms_DragDrop', function () {
    return view('customForms/modalCustomForm_DragDrop');
});
Route::get('/modalCustomForms_ViewTransactionTypes', function () {
    return view('customForms/modalCustomForm_ViewTransactionTypes');
});

Route::get('/custom_form/add_transaction_types/{id?}', 'CustomFormManageController@addTransactioType');
Route::get('/custom_form/get_transaction_types_by_process/{id?}', 'CustomFormManageController@getTransactionTypesByProcessType');
Route::post('/custom_form/remove', 'CustomFormManageController@remove');

//FIM

//Transation_Type - ActorIniciatesT
Route::get('/modalActorIniciatesT', function () {
    return view('transactionTypes/modalActorIniciatesT');
});
Route::get('/modalViewActorIniciatesT', function () {
    return view('transactionTypes/modalViewActorIniciatesT');
});
Route::get('/Transaction_Type/get_actor_iniciates_t/{id?}', 'TransactionTypes@getActorsIniciatesT');
Route::post('/Transaction_Type/update_actors/{id?}', 'TransactionTypes@updateActorsIniciatesT');
Route::post('/remove_actor_iniciates_t/', 'TransactionTypes@removeActorIniciatesT');

//FIM
//FileUploader
Route::post('/fileUpload', 'FileUploaderController@upload');
Route::post('/InsertValues', 'FileUploaderController@insert');
//FIM

//FIM
//Dashboard
Route::get('/dashboard/get_customformusercaninit_/', 'DashboardController@customFormUserCanInit_');
Route::post('/dashboard/savecustomform', 'DashboardController@insertCustomForm');
Route::get('/dashboard/get_process_custom_form/{id?}', 'DashboardController@getProcessCustomForm');
Route::post('/dashboard/verify_custom_form/', 'DashboardController@customFormNotInitProcess');


Route::get('/modalTaskCustomForm', function () {
    return view('dashboard/modalTaskCustomForm');
});

Route::get('/tabFormCustomForm', function () {
    return view('dashboard/tabFormCustomForm');
});

Route::get('/dashboard/get_custom_form/{id?}', 'DashboardController@getCustomFormProperties');

Route::get('/accordition', function () {
    return view('dashboard/accordion');
});

//FIM

