<div id="lrgawidget_wrap" class="wrap"><!-- /.wrap -->
    <div class="lrga_bs" ><!-- /.class -->
        <div class="lrga_bs lrgawidget"><!-- /.id -->
            <div class="box box-primary" id="lrgawidget">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Indicadores do seu negócio</h3>
                    <div class="box-tools pull-right">
                        <span id="lrgawidget_loading"></span>
                        <span id="lrgawidget_mode" class="label label-success"></span>
                        <!--<button type="button" class="btn btn-box-tool" id="lrgawidget_daterange_label">
                            <i class="fa fa-calendar"></i> 
                        </button>-->
                    </div>
                </div>
                <div id="lrgawidget_body" class="box-body">
                    <div class="nav-tabs-custom" id="lrgawidget_main">
                        <ul class="nav nav-tabs">
                            <?php
                            if (in_array("lrgawidget_perm_admin", $globalWidgetPermissions)) {
                                if (current_user_can('administrator')) {
                                    ?>
                                    <li><a data-toggle="tab" data-target="#lrgawidget_settings_tab" href="#lrgawidget_settings_tab"><i class="fa fa-cog fa-fw"></i><span class="hidden-xs hidden-sm"> Settings</span></a></li>

                                    <?php
                                }
                            } if (in_array("lrgawidget_perm_sessions", $globalWidgetPermissions)) {
                                if (current_user_can('administrator')) {
                                    $actLrgaTabs[] = "lrgawidget_sessions_tab";
                                    ?>
                                    <li><a data-toggle="tab" data-target="#lrgawidget_sessions_tab" href="#lrgawidget_sessions_tab"><i class="fa fa-users fa-fw"></i><span class="hidden-xs hidden-sm"> Sessões</span></a></li>

                                    <?php
                                }
                            } if (in_array("lrgawidget_perm_pages", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_pages_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_pages_tab" href="#lrgawidget_pages_tab"><i class="fa fa-file-o fa-fw"></i><span class="hidden-xs hidden-sm"> Páginas</span></a></li>			

                                <?php
                            } if (in_array("lrgawidget_perm_browsers", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_browsers_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_browsers_tab" href="#lrgawidget_browsers_tab"><i class="fa fa-list-alt fa-fw"></i><span class="hidden-xs hidden-sm"> Navegadores</span></a></li>

                                <?php
                            } if (in_array("lrgawidget_perm_languages", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_languages_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_languages_tab" href="#lrgawidget_languages_tab"><i class="fa fa-font fa-fw"></i><span class="hidden-xs hidden-sm"> Lingua</span></a></li>

                                <?php
                            } if (in_array("lrgawidget_perm_os", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_os_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_os_tab" href="#lrgawidget_os_tab"><i class="fa fa-desktop fa-fw"></i><span class="hidden-xs hidden-sm"> Sistemas Operacionais</span></a></li>

                                <?php
                            } if (in_array("lrgawidget_perm_devices", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_devices_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_devices_tab" href="#lrgawidget_devices_tab"><i class="fa fa-tablet fa-fw"></i><span class="hidden-xs hidden-sm"> Dispositivos</span></a></li>

                                <?php
                            } if (in_array("lrgawidget_perm_screenres", $globalWidgetPermissions)) {
                                $actLrgaTabs[] = "lrgawidget_screenres_tab";
                                ?>
                                <li><a data-toggle="tab" data-target="#lrgawidget_screenres_tab" href="#lrgawidget_screenres_tab"><i class="fa fa-arrows-alt fa-fw"></i><span class="hidden-xs hidden-sm"> Resolução de tela</span></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <div class="alert alert-danger hidden" id="lrgawidget_error"></div>
                            <?php if (in_array("lrgawidget_perm_admin", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane " id="lrgawidget_settings_tab">
                                    <div class="fuelux">
                                        <div class="wizard" data-initialize="wizard" id="lrga-wizard" style="background-color: #FFF;">
                                            <div class="steps-container">
                                                <ul class="steps">
                                                    <li class="active" data-name="lrga-createApp" data-step="1"><span class="badge">1</span>Create Google APP <span class="chevron"></span></li>
                                                    <li data-step="2" data-name="lrga-getCode"><span class="badge">2</span>Authorize APP <span class="chevron"></span></li>
                                                    <li data-step="3" data-name="lrga-profile"><span class="badge">3</span>Select Analytics Profile <span class="chevron"></span></li>
                                                </ul>
                                            </div>


                                            <div class="actions">
                                                <button type="button" class="btn btn-danger" data-lrgawidget-reset="reset" style="display: none;">
                                                    <i class="fa fa-refresh fa-fw"></i> Reset all data and start over
                                                </button>
                                                <button type="button" class="btn btn-primary" data-reload="lrgawidget_go_express" style="display: none;">
                                                    <i class="fa fa-arrow-circle-o-left fa-fw"></i> <i class="fa fa-magic fa-fw"></i> Go Back to Express Setup
                                                </button>
                                            </div>						

                                            <div class="step-content">
                                                <div class="step-pane active sample-pane bg-info alert" data-step="1">
                                                    <div class="row">
                                                        <div id="lrgawidget_express_setup"> 
                                                            <div class="col-md-6">
                                                                <div class="lrgawidget_ex_left">
                                                                    <div class="box">
                                                                        <div class="box-header with-border">
                                                                            <i class="fa fa-magic fa-fw"></i>												  
                                                                            <h3 class="box-title">Express Setup</h3>
                                                                        </div>
                                                                        <div class="box-body">
                                                                            <p>Click on "<b>Get Access Code</b>" button below, and a pop-up window will open, asking you to allow "<b>Lara, The Google Analytics Widget</b>" to <b>View your Google Analytics data</b>
                                                                                . Click <b>Allow</b>, then copy and paste the access code here, and click <b>Submit</b>.
                                                                                <br><br>If you were asked to login, be sure to use the same email account that is linked to your <b>Google Analytics</b>. 
                                                                                <br><br><a class="btn btn-primary" href="javascript:gauthWindow('https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=789117741534-frb075bn85jk68ufpjg56s08hf85r007.apps.googleusercontent.com&redirect_uri=urn:ietf:wg:oauth:2.0:oob&scope=https://www.googleapis.com/auth/analytics.readonly&access_type=offline&approval_prompt=force');" >Get Access Code</a>

                                                                            </p>

                                                                            <form id="express-lrgawidget-code" name="express-lrgawidget-code" role="form">
                                                                                <input name="action" type="hidden" value="getAccessToken">
                                                                                <input name="client_id" type="hidden" value="789117741534-frb075bn85jk68ufpjg56s08hf85r007.apps.googleusercontent.com">
                                                                                <input name="client_secret" type="hidden" value="ZkJpBFuNFwv65e36C6mwnihQ">
                                                                                <div class="form-group">
                                                                                    <label> Access Code</label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-addon">
                                                                                            <i class="fa fa-user fa-fw"></i>
                                                                                        </div>
                                                                                        <input class="form-control" name="code" required="" type="text">
                                                                                        <span class="input-group-btn">
                                                                                            <button type="submit" class="btn btn-primary btn-flat" >Submit</button>
                                                                                        </span>
                                                                                    </div><!-- /.input group -->
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div  class="col-md-6">
                                                                <div class="lrgawidget_ex_right">
                                                                    <div class="box">
                                                                        <div class="box-header with-border">
                                                                            <i class="fa fa-gears fa-fw"></i>												  
                                                                            <h3 class="box-title">Advanced Setup</h3>
                                                                        </div>
                                                                        <div class="box-body">
                                                                            <p>By clicking on "<b>Start Advanced Setup</b>" button below, The setup wizard will guide you through creating and/or configuring your own Google Application. 
                                                                                If you want a quick start, or just trying the widget, use the <b>Express Setup</b> on the left.
                                                                                <br><br><a class="btn btn-primary btn-block" href="#" data-reload="lrgawidget_go_advanced">Start Advanced Setup</a>
                                                                        </div>
                                                                    </div>											
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="lrgawidget_advanced_setup" style="display: none;">
                                                            <div class="col-md-6">
                                                                <form id="lrgawidget-credentials" name="lrgawidget-credentials" role="form">
                                                                    <input name="action" type="hidden" value="getAuthURL">
                                                                    <div class="form-group">
                                                                        <label>Client ID</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-user fa-fw"></i>
                                                                            </div><input class="form-control" name="client_id" required="" type="text" value="">
                                                                        </div><!-- /.input group -->
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Client Secret</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-lock fa-fw"></i>
                                                                            </div><input class="form-control" name="client_secret" required="" type="text" value="">
                                                                        </div><!-- /.input group -->
                                                                    </div>
                                                                    <div>
                                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h2 id="enable-oauth-20-api-access">Create Google APP</h2>
                                                                <p>To use the <b>Google Analytics</b> widget, you'll need to create a <b>Google App</b> as follows :</p>

                                                                <ol>
                                                                    <li>Open the <a target="_blank" href="//console.developers.google.com/apis/credentials?project=_">Google Developers Console</a>.</li>
                                                                    <li>Click on <b>Select a project</b> drop-down, and choose <b>Create a new project</b>.</li>
                                                                    <li>Enter "<b>Lara</b>" as the <b>Project name</b>, then click <b>Create</b>.</li>
                                                                    <li>Select <b>Create credentials</b> and choose <b>OAuth client ID</b>.</li>
                                                                    <li>Click on <b>Configure consent screen</b> and enter "<b>Lara, The Google Analytics Widget</b>" as the <b>Product Name</b>, then click <b>Save</b>.</li>
                                                                    <li>Under <b>Application type</b>, select <b>Other</b>, enter "<b>Lara</b>" then click <b>Create</b>.</li>
                                                                    <li>Take note of the <b>client ID</b> & <b>client secret</b> then click "<b>Ok</b>".</li>
                                                                    <li>Open "<b>Google Developers Console</b>" menu, by clicking on " <i class="fa fa-bars"></i> " and select "<b>API Manager</b>".</li>
                                                                    <li>Click "<b>Analytics API</b>", then click <b>Enable API</b>. 
                                                                </ol>
                                                                <p>When done, paste the <b>client ID</b> & <b>client secret</b> here and click <b>Submit</b>.</p>

                                                            </div>
                                                        </div>
                                                    </div>	
                                                </div>
                                                <div class="step-pane sample-pane bg-info alert" data-step="2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <form id="lrgawidget-code" name="lrgawidget-code" role="form">
                                                                <input name="action" type="hidden" value="getAccessToken">
                                                                <input name="client_id" type="hidden" value="">
                                                                <input name="client_secret" type="hidden" value="">
                                                                <div class="form-group">
                                                                    <label>Access Code</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-user fa-fw"></i>
                                                                        </div><input class="form-control" name="code" required="" type="text">
                                                                    </div><!-- /.input group -->
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h2 id="enable-oauth-20-api-access">Authorize App</h2>
                                                            <p>Click on "<b>Get Access Code</b>" button below, and a pop-up window will open, asking you to allow the <u>app you just created</u> to <b>View your Google Analytics data</b>
                                                                . <br><br>Be sure to use the same email account that is linked to your <b>Google Analytics</b>.
                                                                <br><br>Click <b>Allow</b>, then copy and paste the access code here, and click <b>Submit</b>.
                                                            </p>

                                                            <a class="btn btn-primary" href="#" id="code-btn">Get Access Code</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="step-pane sample-pane bg-info alert" data-step="3">
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <form id="lrgawidget-setProfileID" name="lrgawidget-setProfileID" role="form">
                                                                <input name="action" type="hidden" value="setProfileID">
                                                                <input name="profile_timezone" type="hidden" value="">
                                                                <div class="form-group">
                                                                    <label>Account</label> 
                                                                    <select class="form-control" style="width: 100%;" id="lrgawidget-accounts" name="account_id">
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Property</label> 
                                                                    <select class="form-control" style="width: 100%;" id="lrgawidget-properties" name="property_id">
                                                                    </select>
                                                                </div>									
                                                                <div class="form-group">
                                                                    <label>View</label> 
                                                                    <select class="form-control" style="width: 100%;" id="lrgawidget-profiles" name="profile_id">
                                                                    </select>
                                                                </div>
                                                                <div class="callout" style="padding: 5px;">
                                                                    <input name="enable_universal_tracking" checked="checked" type="checkbox" style="margin: 0px;"> Add "<b>Google Universal Analytics</b>" tracking code to all pages.
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div>
                                                                <h2 >Profile Details</h2>
                                                                <label>Account Name :</label> <i id="lrgawidget-accname"></i>
                                                                <br><label>Property Name :</label> <i id="lrgawidget-propname"></i>  
                                                                <br><label>Property WebsiteUrl :</label> <i id="lrgawidget-propurl"></i> 
                                                                <br><label>View Name :</label> <i id="lrgawidget-vname"></i>
                                                                <br><label>View Type :</label> <i id="lrgawidget-vtype"></i>
                                                                <br><label>View TimeZone :</label> <i id="lrgawidget-vtimezone"></i> <i id="lrgawidget-timezone-show-error" class="icon fa fa-warning" style="display:none; color: #f39c12;margin-left: 5px;cursor: pointer;"></i>
                                                                <div style="display:none; margin-top: 15px;" id="lrgawidget-timezone-error">
                                                                    <div class="alert alert-warning">
                                                                        <i class="icon fa fa-warning"></i>The selected view is using a different timezone than your <b>WordPress</b> timezone, which <u>may</u> cause inaccurate dates/values.
                                                                        <div style="margin-left: 25px;margin-top: 10px;"> 
                                                                            View timezone : <b id="lrgawidget-tz-error-vtimezone"></b>
                                                                            <br> WordPress timezone : <b id="lrgawidget-tz-error-stimezone"></b>
                                                                        </div>
                                                                    </div>
                                                                </div>											 

                                                            </div> 

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.tab-pane -->
                            <?php } ?>


                            <?php if (in_array("lrgawidget_perm_sessions", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_sessions_tab">
                                    <div id="lrgawidget_sessions_chartDiv" style="height: 350px; width: 100%;">
                                        <div class="overlay" id="lrgawidget_loading_big">
                                            <i class="fa fa-refresh fa-spin" style="top: 40%;"></i>
                                        </div>
                                    </div>
                                    <div id="lrga-legendholder"></div>
                                    <div class="box-footer hidden-xs hidden-sm" id="lrgawidget_sb-main">
                                        <div class="row">
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_sessions" data-lrgawidget-plot="sessions">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Sessions</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline" id="lrgawidget_spline_sessions"></div>
                                                </div><!-- /.description-block -->
                                            </div><!-- /.col -->
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_users" data-lrgawidget-plot="users">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Visitantes</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_users"></div>
                                                </div><!-- /.description-block -->
                                            </div><!-- /.col -->
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_pageviews" data-lrgawidget-plot="pageviews">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Visualizações de página</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_pageviews"></div>
                                                </div><!-- /.description-block -->
                                            </div><!-- /.col -->
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_pageviewsPerSession" data-lrgawidget-plot="pageviewsPerSession">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Páginas / Sessão</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_pageviewsPerSession"></div>
                                                </div><!-- /.description-block -->
                                            </div>
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_avgSessionDuration" data-lrgawidget-plot="avgSessionDuration">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Tempo médio sessão</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_avgSessionDuration"></div>
                                                </div><!-- /.description-block -->
                                            </div>
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_bounceRate" data-lrgawidget-plot="bounceRate">
                                                <div class="description-block border-right">
                                                    <span class="description-text">Bounce Rate</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_bounceRate"></div>
                                                </div><!-- /.description-block -->
                                            </div>
                                            <div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_percentNewSessions" data-lrgawidget-plot="percentNewSessions">
                                                <div class="description-block">
                                                    <span class="description-text">% New Sessions</span>
                                                    <h5 class="description-header"></h5>
                                                    <div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_percentNewSessions"></div>
                                                </div><!-- /.description-block -->
                                            </div>
                                        </div><!-- /.row -->
                                    </div>
                                </div>			<!-- /.tab-pane -->
                            <?php } ?>

                            <?php if (in_array("lrgawidget_perm_pages", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_pages_tab">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_pages_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" >
                                                    <thead><tr><th>ID</th><th>Pages</th><th>Pageviews</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>						
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_pages_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_pages_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>			

                            <?php if (in_array("lrgawidget_perm_browsers", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_browsers_tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_browsers_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" style="cursor:pointer">
                                                    <thead><tr><th>ID</th><th>Browser</th><th>Sessions</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_browsers_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_browsers_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php if (in_array("lrgawidget_perm_languages", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_languages_tab">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_languages_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" >
                                                    <thead><tr><th>ID</th><th>Language</th><th>Sessions</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>						
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_languages_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_languages_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php if (in_array("lrgawidget_perm_os", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_os_tab">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_os_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" style="cursor:pointer">
                                                    <thead><tr><th>ID</th><th>Operating System</th><th>Sessions</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>						
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_os_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_os_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (in_array("lrgawidget_perm_devices", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_devices_tab">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_devices_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" style="cursor:pointer">
                                                    <thead><tr><th>ID</th><th>Device Type</th><th>Sessions</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>						
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_devices_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_devices_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>			

                            <?php if (in_array("lrgawidget_perm_screenres", $globalWidgetPermissions)) { ?>
                                <div class="tab-pane" id="lrgawidget_screenres_tab">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <div>
                                                <table id="lrgawidget_screenres_dataTable" class="table table-bordered table-hover" cellspacing="0" width="100%" >
                                                    <thead><tr><th>ID</th><th>Screen Resolution</th><th>Sessions</th><th>Percentage</th></tr></thead>
                                                    <tbody></tbody>	
                                                </table>					
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden-xs hidden-sm" >
                                            <canvas id="lrgawidget_screenres_chartDiv" width="350px" height="350px"></canvas>
                                            <div  id='lrgawidget_screenres_legendDiv'></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <style>

                                #lrgawidget_gopro_tab .lrga_gpro_clr1 {	color: #eaeaea }
                                #lrgawidget_gopro_tab .lrga_gpro_clr2 {	color: #3987b4; }
                                #lrgawidget_gopro_tab .lrga_gpro_clr3 {	color: #FFF; }
                                #lrgawidget_gopro_tab .lrga_gpro_clr4 {	color: #fe2200 !important; }
                                #lrgawidget_gopro_tab .lrga_gpro_clr5 {	color: #282e4f }
                                #lrgawidget_gopro_tab .lrga_gpro_clr6 {	color: #7A7A7A }


                                #lrgawidget_gopro_tab .lrga_gpro_boxtopb {
                                    border-top: 3px solid #dd4b39;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_feature {
                                    background-color: #F8F8F8;
                                    border-bottom: 2px solid #fff;
                                    padding-top:10px;
                                    padding-bottom:10px;

                                }

                                #lrgawidget_gopro_tab .lrga_gpro_features{
                                    background-color: #F8F8F8;
                                    border-bottom: 2px solid #fff;
                                    padding: 25px;
                                    margin: 0px 1px 5px 1px;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_demo {
                                    background-color: #f8f8f8;
                                    padding-top:20px;
                                    padding-bottom:5px;

                                }

                                #lrgawidget_gopro_tab .lrga_gpro_header {
                                    color: #FFFFFF;
                                    background-color: #282C31;
                                    padding-top:20px;
                                    padding-bottom:5px;
                                    margin: 1px 1px 0px 1px;

                                }

                                #lrgawidget_gopro_tab .lrga_gpro_headerh {
                                    font-size: 25px;
                                    font-weight: bold;

                                }

                                #lrgawidget_gopro_tab .lrga_gpro_support {
                                    background-color: #F8F8F8;
                                    border: 2px solid #ededed;
                                    padding: 10px;
                                    border-radius: 15px;
                                    min-height: 270px;
                                    margin-bottom: 15px;  
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_support p{
                                    font-size: 14px;
                                    text-align: center;
                                    padding: 5px;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_who {
                                    background-color: #F8F8F8;
                                    border: 2px solid #ededed;
                                    padding: 10px;
                                    margin-bottom:15px;
                                    border-radius: 15px;
                                    background-image: url(<?php echo lrgawidget_plugin_dist_dir . '/img/xo_footer.png'; ?>);
                                    background-position: center bottom;
                                    background-repeat: no-repeat;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_who p{
                                    font-size: 14px;
                                    text-align: center;
                                    padding: 5px;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_demo p{
                                    font-size: 14px;
                                    text-align: center;
                                    padding: 5px;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_btn_dark {
                                    background-color: #272e38;
                                    color: #FFFFFF;
                                }

                                #lrgawidget_gopro_tab button i{
                                    margin-right:5px;

                                }

                                #lrgawidget_gopro_tab button#rating i{
                                    margin-right: -4px;
                                    color: #FDDC00;
                                }

                                #lrgawidget_gopro_tab button#rating i:first-child {
                                    margin-right: 0px !important;
                                }

                                #lrgawidget_gopro_tab .lrga_gpro_features i{
                                    margin-bottom:10px;

                                }


                            </style>


                        </div><!-- /.tab-content -->
                    </div>  
                </div>
            </div>

        </div><!-- /.id -->
    </div><!-- /.class -->
</div><!-- /.wrap -->
<!-- /.revise -->
<?php if (!empty($actLrgaTabs[0])) { ?>
    <script type="text/javascript">
        var actLrgaTabs = '<?php echo $actLrgaTabs[0]; ?>';
    </script>
<?php } ?>