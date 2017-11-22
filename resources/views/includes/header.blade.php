
    <ul class="nav" id="side-menu">
        <li>
            <a href="/dashboardManage"><i class="fa fa-fw fa-dashboard"></i> Menu</a>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Process Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/processTypesManage">Process Kinds</a>
                </li>
                <li>
                    <a href="/processesManage">Processes</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Transaction Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/transactionTypesManage">Transaction Kinds</a>
                </li>
                <li>
                    <a href="/tStatesManage">T State</a>
                </li>
                <li>
                    <a href="/transactionsManage">Transactions</a>
                </li>
                <li>
                    <a href="/customFormManage">Custom Form</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Entities Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/entityTypesManage">Entity Kinds</a>
                </li>
				<li>
                    <a href="/dynamicSearch">Dynamic Search</a>
                </li>
                <li>
                    <a href="/dynamicSearch/savedSearch">Saved Searches</a>
                </li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Process Structure Diagram <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/CausalLinksManage">Causal Links</a>
                </li>
                <li>
                    <a href="/WaitingLinksManage">Waiting Links</a>
                </li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("messages.manageProperties") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/propertiesManageEnt">Entity</a>
                </li>
                <li>
                    <a href="/propertiesManageRel">Relation</a>
                </li>
				<li>
					<a href="propAllowedValueManage">Allowed Values</a>
				</li>
            </ul>
        </li>
		<li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("messages.relationManagment") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/relationTypesManage">{{trans("messages.relationTypes") }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Units Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/propUnitTypeManage">Unit Kinds</a>
                </li>
                <li>
                    <a href="/a">Units</a> <!--bug-->
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Actor Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/actorsManage">Actors</a>
                </li>
                {{--<li>--}}
                    {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Roles Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/rolesManage">Roles</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Languages Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/languagesManage">Languages</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Users Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="/usersManage">Users</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
    </ul>