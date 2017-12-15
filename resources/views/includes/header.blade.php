
    <ul class="nav" id="side-menu">
        <li>
            <a href="/dashboardManage"><i class="fa fa-fw fa-dashboard"></i> {{trans("dashboard/messages.Page_Name")}} </a>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.PROC_MANAGE")}} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/processTypesManage">{{trans("header.PROCS_KINDS")}}</a>
                </li>
               {{-- <li>
                    <a href="/processesManage">Processes</a>
                </li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.TRANS_MANAGE")}} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/transactionTypesManage">{{trans("header.TRANS_KINDS")}}</a>
                </li>
                <li>
                    <a href="/tStatesManage">{{trans("header.TSTATE_MANAGE")}}</a>
                </li>
                {{--<li>
                    <a href="/transactionsManage">Transactions</a>
                </li>--}}
                <li>
                    <a href="/customFormManage">{{trans("header.CF_MANAGE")}}</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.ENTS_MANAGE")}} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/entityTypesManage">{{trans("header.ENTS_KINDS")}}</a>
                </li>
				<!-- <li>
                    <a href="/dynamicSearch">{{trans("header.DYN_SEARCH")}}</a>
                </li>
                <li>
                    <a href="/dynamicSearch/savedSearch">{{trans("header.SAVE_SEARCHES")}}</a>
                </li> -->
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Gestão de Pesquisas <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/dynamicSearch"> {{trans("header.DYN_SEARCH")}} </a>
                </li>
                <li>
                    <a href="/dynamicSearch/savedSearch">{{trans("header.SAVE_SEARCHES")}}</a>
                </li>
                <li>
                    <a href="/operator"> Operadores </a>
                </li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.PSD_MANAGE")}} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/CausalLinksManage">{{trans("header.CAUSAL_LINKS")}}</a>
                </li>
                <li>
                    <a href="/WaitingLinksManage">{{trans("header.WAIT_LINKS")}}</a>
                </li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.PROP_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/propertiesManageEnt">{{trans("header.ENT_PROP") }}</a>
                </li>
                <li>
                    <a href="/propertiesManageRel">{{trans("header.REL_PROP") }}</a>
                </li>
				<li>
					<a href="propAllowedValueManage">{{trans("header.ALLOWED_VALUES_MANAGE") }}</a>
				</li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.REL_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/relationTypesManage">{{trans("header.RELS_KINDS") }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.UNIT_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/propUnitTypeManage">{{trans("header.UNIT_KINDS") }} </a>
                </li>
                {{--<li>
                    <a href="/a">Units</a> <!--bug-->
                </li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.ACT_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/actorsManage">{{trans("header.ACTORS") }}</a>
                </li>
                {{--<li>--}}
                    {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.ROLS_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/rolesManage">{{trans("header.ROLS") }}</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.LANGS_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/languagesManage">{{trans("header.LANGS") }}</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("header.USERS_MANAGE") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/usersManage">{{trans("header.USERS") }}</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
    </ul>