<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//====================================================================================================

//----------- ------------ ------------ ---------- BACK END ---------- ---------- --------- ----------

//====================================================================================================

Route::group(['prefix' => 'manage'], function () {
    #========== ========== ========== LOGIN ========== ========== ==========
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', ['as' => 'tf.m.login.get', 'uses' => 'Manage\Login\LoginController@getLogin']);
        Route::post('/', ['as' => 'tf.m.login.post', 'uses' => 'Manage\Login\LoginController@postLogin']);
    });

    #========== ========== ========== LOGOUT ========== ========== ==========
    Route::get('logout', ['as' => 'tf.m.logout.get', 'uses' => 'Manage\ManageController@getLogout']);

    #========== ========== ========== BUILD ========== ========== ==========
    Route::group(['prefix' => 'build', 'middleware' => 'ManageBuildMiddleware'], function () {

        //----------- ---------- ---------- MAP ---------- ---------- ----------
        Route::group(['prefix' => 'map'], function () {
            //---------- ----------  mini map ---------- ----------
            Route::group(['prefix' => 'mini-map'], function () {
                // get project list
                Route::get('content/{provinceId?}', ['as' => 'tf.m.build.map.miniMap.content.get', 'uses' => 'Manage\Build\BuildController@getMiniMapContent']);
            });

            //---------- ---------- Tool ---------- ----------
            Route::group(['prefix' => 'tool'], function () {
                //---------- manage tool ----------
                Route::group(['prefix' => 'manage'], function () {
                    // get project list
                    Route::get('project-menu/{provinceAccess?}/{provinceFilterId?}', ['as' => 'tf.m.build.map.tool.manage.project.get', 'uses' => 'Manage\Build\BuildController@getProjectMenu']);
                    // get project publish
                    Route::get('project-publish/{provinceAccess?}/{provinceFilterId?}', ['as' => 'tf.m.build.map.tool.manage.project.publish.get', 'uses' => 'Manage\Build\BuildController@getProjectPublish']);
                });

                //---------- build tool ----------
                Route::group(['prefix' => 'build'], function () {
                    // banner tool
                    Route::get('banner', ['as' => 'tf.m.build.map.tool.build.banner.get', 'uses' => 'Manage\Build\BuildController@getBannerTool']);
                    // land tool
                    Route::get('land', ['as' => 'tf.m.build.map.tool.build.land.get', 'uses' => 'Manage\Build\BuildController@getLandTool']);

                    //background tool
                    Route::get('background', ['as' => 'tf.m.build.map.tool.build.project-background.get', 'uses' => 'Manage\Build\BuildController@getBackgroundTool']);
                    Route::get('background-view/{backgroundId?}', ['as' => 'tf.m.build.map.tool.build.project-background.view', 'uses' => 'Manage\Build\BuildController@viewProjectBackground']);
                    Route::get('background-select/{backgroundId?}/{projectSetupId?}', ['as' => 'tf.m.build.map.tool.build.project-background.select', 'uses' => 'Manage\Build\BuildController@selectProjectBackground']);
                    Route::get('background-drop/{projectSetupId?}', ['as' => 'tf.m.build.map.tool.build.project-background.drop', 'uses' => 'Manage\Build\BuildController@dropProjectBackground']);

                    //sample project
                    Route::get('project', ['as' => 'tf.m.build.map.tool.build.project.get', 'uses' => 'Manage\Build\BuildController@getProjectTool']);
                    Route::get('project-view/{projectSampleId?}', ['as' => 'tf.m.build.map.tool.build.project.view', 'uses' => 'Manage\Build\BuildController@viewProjectSample']);
                    Route::get('project-select/{projectSampleId?}/{projectSetupId?}', ['as' => 'tf.m.build.map.tool.build.project.select', 'uses' => 'Manage\Build\BuildController@selectProjectSample']);

                    // public tool
                    Route::get('public/{publicTypeId?}', ['as' => 'tf.m.build.map.tool.build.public.get', 'uses' => 'Manage\Build\BuildController@getPublicTool']);
                });
            });
        });

        // country
        //Route::get('country}',['as'=>'tf.m.share.country.get','uses'=>'Manage\Build\BuildController@getCountry']);

        ##---------- ---------- ---------- PROVINCE ---------- ---------- ----------
        Route::group(['prefix' => 'country'], function () {
            Route::get('/{countryId?}', ['as' => 'tf.m.build.country.get', 'uses' => 'Manage\Build\Country\CountryController@index']);
        });

        ##---------- ---------- ---------- PROVINCE ---------- ---------- ----------
        Route::group(['prefix' => 'province'], function () {
            Route::get('/{provinceId?}/{areaId?}', ['as' => 'tf.m.build.province.get', 'uses' => 'Manage\Build\Province\ProvinceController@getProvince']);
        });

        ##---------- ---------- ---------- AREA ---------- ---------- ----------
        Route::group(['prefix' => 'area'], function () {
            // get area
            Route::get('coordinates/{provinceAccessId?}/{areaX?}/{areaY?}', ['as' => 'tf.m.build.area.coordinates.get', 'uses' => 'Manage\Build\Area\AreaController@getLoadCoordinates']);
            // set area when load map
            Route::get('load-map/{areaId?}', ['as' => 'tf.m.build.area.position.get', 'uses' => 'Manage\Build\Area\AreaController@setPosition']);
            // get area
            Route::get('/{provinceAccess?}/{areaAccess?}', ['as' => 'tf.m.build.area.get', 'uses' => 'Manage\Build\Area\AreaController@getArea']);
        });

        ##---------- ---------- ---------- BANNER ---------- ---------- ----------
        Route::group(['prefix' => 'banner'], function () {
            // set position
            Route::get('set-position/{bannerID?}/{topPosition?}/{leftPosition?}/{zindex?}', ['as' => 'tf.m.build.banner.position.set', 'uses' => 'Manage\Build\Banner\BannerController@setPosition']);
            // add new
            Route::get('add/{projectId?}/{sampleId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.build.banner.add.get', 'uses' => 'Manage\Build\Banner\BannerController@getAddBanner']);
            Route::post('add', ['as' => 'tf.m.build.banner.add.post', 'uses' => 'Manage\Build\Banner\BannerController@postAddBanner']);
            // delete when does not publish
            Route::get('setup-delete/{bannerID?}', ['as' => 'tf.m.build.banner.setup.delete', 'uses' => 'Manage\Build\Banner\BannerController@getSetupDelete']);
        });

        ##---------- ---------- ---------- LAND ---------- ---------- ----------
        Route::group(['prefix' => 'land'], function () {
            // set position
            Route::get('set-position/{landId?}/{topPosition?}/{leftPosition?}/{zindex?}', ['as' => 'tf.m.build.land.position.set', 'uses' => 'Manage\Build\Land\LandController@setPosition']);

            // add new
            Route::get('add/{projectId?}/{sizeId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.build.land.add.get', 'uses' => 'Manage\Build\Land\LandController@getAddLand']);
            Route::post('add', ['as' => 'tf.m.build.land.add.post', 'uses' => 'Manage\Build\Land\LandController@postAddLand']);

            // delete when does not publish
            Route::get('setup-delete/{landID?}', ['as' => 'tf.m.build.land.setup.delete', 'uses' => 'Manage\Build\Land\LandController@getSetupDelete']);
        });

        ##---------- ---------- ---------- PROJECT ---------- ---------- ----------
        Route::group(['prefix' => 'project'], function () {
            // setup
            Route::get('setup/open/{provinceAccess?}/{areaAccess?}', ['as' => 'tf.m.build.project.setup.open', 'uses' => 'Manage\Build\Project\ProjectController@openSetup']);
            Route::get('setup/close/{provinceAccess?}/{areaAccess?}', ['as' => 'tf.m.build.project.setup.close', 'uses' => 'Manage\Build\Project\ProjectController@closeSetup']);

            // finish share
            Route::get('build/finish/{projectId?}/{buildId?}', ['as' => 'tf.m.build.project.build.finish', 'uses' => 'Manage\Build\Project\ProjectController@finishBuild']);

            // agree publish
            Route::get('publish/yes/{projectId?}/{buildId?}', ['as' => 'tf.m.build.project.publish.yes.get', 'uses' => 'Manage\Build\Project\ProjectController@getPublishYes']);
            Route::post('publish/yes', ['as' => 'tf.m.build.project.publish.yes.post', 'uses' => 'Manage\Build\Project\ProjectController@postPublishYes']);

            // does not agree publish
            Route::get('publish/no/{projectId?}/{publishId?}', ['as' => 'tf.m.build.project.publish.no.get', 'uses' => 'Manage\Build\Project\ProjectController@getPublishNo']);

            // add new
            Route::get('add/check/{name?}', ['as' => 'tf.m.build.project.add.name.check', 'uses' => 'Manage\Build\Project\ProjectController@checkExistName']);
            Route::get('add/{provinceId?}/{areaId?}', ['as' => 'tf.m.build.project.add.get', 'uses' => 'Manage\Build\Project\ProjectController@getAddProject']);
            Route::post('add/{provinceId?}/{areaId?}', ['as' => 'tf.m.build.project.add.post', 'uses' => 'Manage\Build\Project\ProjectController@postAddProject']);

            //---------- ---------- project icon ---------- ----------
            Route::group(['prefix' => 'icon'], function () {
                // edit icon
                Route::get('edit/{iconID?}/{iconSampleId?}', ['as' => 'tf.m.build.project.icon.edit.get', 'uses' => 'Manage\Build\Project\ProjectIconController@getIconEdit']);
                Route::post('edit/{iconID?}/{iconSampleId?}', ['as' => 'tf.m.build.project.icon.edit.post', 'uses' => 'Manage\Build\Project\ProjectIconController@postIconEdit']);
                // set position
                Route::get('set-position/{iconId?}/{topPosition?}/{leftPosition?}/{zIndex?}', ['as' => 'tf.m.build.project.icon.position.set', 'uses' => 'Manage\Build\Project\ProjectIconController@setPosition']);
            });
        });

        ##---------- ---------- ---------- PUBLIC ---------- ---------- ----------
        Route::group(['prefix' => 'public'], function () {
            // set position
            Route::get('set-position/{publicId?}/{topPosition?}/{leftPosition?}/{zIndex?}', ['as' => 'tf.m.build.publics.position.set', 'uses' => 'Manage\Build\Publics\PublicController@setPosition']);
            // add new
            Route::get('add/{projectId?}/{sampleId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.build.publics.add.get', 'uses' => 'Manage\Build\Publics\PublicController@getAddPublic']);

            // delete when project does not publish
            Route::get('setup-delete/{publicId?}', ['as' => 'tf.m.build.publics.setup.delete', 'uses' => 'Manage\Build\Publics\PublicController@getSetupDelete']);
        });

        Route::get('/{name?}', ['as' => 'tf.m.build.map', 'uses' => 'Manage\Build\BuildController@index']);
    });

    #========== ========== ========== MANAGE CONTENT ========== ========== ==========
    Route::group(['prefix' => 'content', 'middleware' => 'ManageContentMiddleware'], function () {

        ##========== ========== SYSTEM =========== ==========
        Route::group(['prefix' => 'system', 'middleware' => 'ContentSystemMiddleware'], function () {
            ###----------- ---------- Building-service type ----------- ----------
            Route::group(['prefix' => 'building-service-type'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.building-service-type.list', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@index']);
                //view
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.building-service-type.view', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@viewBuildingServiceType']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.system.building-service-type.add.get', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.building-service-type.add.post', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@postAdd']);

                //Edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.building-service-type.edit.get', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.building-service-type.edit.post', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@postEdit']);

                // Delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.system.building-service-type.delete', 'uses' => 'Manage\Content\System\BuildingServiceType\BuildingServiceTypeController@deleteBuildingServiceType']);
            });

            ###----------- ---------- Notification---------- ----------
            Route::group(['prefix' => 'notify'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.notify.list', 'uses' => 'Manage\Content\System\Notify\NotifyController@index']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.system.notify.add.get', 'uses' => 'Manage\Content\System\Notify\NotifyController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.notify.add.post', 'uses' => 'Manage\Content\System\Notify\NotifyController@postAdd']);

                // edit info
                Route::get('edit/{aboutId?}', ['as' => 'tf.m.c.system.notify.edit.get', 'uses' => 'Manage\Content\System\Notify\NotifyController@getEdit']);
                Route::post('edit/{aboutId?}', ['as' => 'tf.m.c.system.notify.edit.post', 'uses' => 'Manage\Content\System\Notify\NotifyController@postEdit']);

                //view
                Route::get('view/{id?}', ['as' => 'tf.m.c.system.notify.view', 'uses' => 'Manage\Content\System\Notify\NotifyController@viewNotify']);

                //delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.notify.delete', 'uses' => 'Manage\Content\System\Notify\NotifyController@deleteNotify']);
            });

            ###----------- ---------- About system---------- ----------
            Route::group(['prefix' => 'about'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.about.list', 'uses' => 'Manage\Content\System\About\AboutController@getList']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.system.about.add.get', 'uses' => 'Manage\Content\System\About\AboutController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.about.add.post', 'uses' => 'Manage\Content\System\About\AboutController@postAdd']);

                // edit info
                Route::get('edit/{aboutId?}', ['as' => 'tf.m.c.system.about.edit.get', 'uses' => 'Manage\Content\System\About\AboutController@getEdit']);
                Route::post('edit/{aboutId?}', ['as' => 'tf.m.c.system.about.edit.post', 'uses' => 'Manage\Content\System\About\AboutController@postEdit']);

                //view
                Route::get('view/{id?}', ['as' => 'tf.m.c.system.about.view', 'uses' => 'Manage\Content\System\About\AboutController@viewAbout']);
            });

            ###----------- ---------- Advisory ----------- ----------
            Route::group(['prefix' => 'advisory'], function () {
                Route::get('list', ['as' => 'tf.m.c.system.advisory.list', 'uses' => 'Manage\Content\System\Advisory\AdvisoryController@index']);

                Route::get('view/{advisoryId?}', ['as' => 'tf.m.c.system.advisory.view', 'uses' => 'Manage\Content\System\Advisory\AdvisoryController@viewAdvisory']);
                Route::get('delete/{advisoryId?}', ['as' => 'tf.m.c.system.advisory.delete', 'uses' => 'Manage\Content\System\Advisory\AdvisoryController@deleteAdvisory']);

            });

            ###----------- ---------- Bank ---------- ----------
            Route::group(['prefix' => 'bank'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.bank.list', 'uses' => 'Manage\Content\System\Bank\BankController@index']);

                Route::get('view/{bankId?}', ['as' => 'tf.m.c.system.bank.view', 'uses' => 'Manage\Content\System\Bank\BankController@viewBank']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.bank.add.get', 'uses' => 'Manage\Content\System\Bank\BankController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.bank.add.post', 'uses' => 'Manage\Content\System\Bank\BankController@postAdd']);
                // edit info
                Route::get('edit/{bankId?}', ['as' => 'tf.m.c.system.bank.edit.get', 'uses' => 'Manage\Content\System\Bank\BankController@getEdit']);
                Route::post('edit/{bankId?}', ['as' => 'tf.m.c.system.bank.edit.post', 'uses' => 'Manage\Content\System\Bank\BankController@postEdit']);
                // update status
                Route::get('status/{bankId?}', ['as' => 'tf.m.c.system.bank.status', 'uses' => 'Manage\Content\System\Bank\BankController@statusUpdate']);
                // Delete
                Route::get('delete/{bankId?}', ['as' => 'tf.m.c.system.bank.delete', 'uses' => 'Manage\Content\System\Bank\BankController@deleteBank']);
            });

            ###----------- ---------- Business type ----------- ----------
            Route::group(['prefix' => 'business-type'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.business-type.list', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@index']);
                //view
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.business-type.view', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@viewBusinessType']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.system.business-type.add.get', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.business-type.add.post', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@postAdd']);
                //Edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.business-type.edit.get', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.business-type.edit.post', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@postEdit']);
                //update Status
                Route::get('status/{typeId?}', ['as' => 'tf.m.c.system.business-type.status', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@statusUpdate']);
                // Delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.system.business-type.delete', 'uses' => 'Manage\Content\System\BusinessType\BusinessTypeController@deleteBusinessType']);
            });

            ###----------- ---------- Business ----------- ----------
            Route::group(['prefix' => 'business'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.business.list', 'uses' => 'Manage\Content\System\Business\BusinessController@index']);
                //view
                Route::get('view/{businessId?}', ['as' => 'tf.m.c.system.business.view', 'uses' => 'Manage\Content\System\Business\BusinessController@viewBusiness']);
                // Filter
                Route::get('filter/{typeId?}', ['as' => 'tf.m.c.system.business.filter', 'uses' => 'Manage\Content\System\Business\BusinessController@getFilter']);
                // Add new
                Route::get('add', ['as' => 'tf.m.c.system.business.add.get', 'uses' => 'Manage\Content\System\Business\BusinessController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.business.add.post', 'uses' => 'Manage\Content\System\Business\BusinessController@postAdd']);
                // Edit info
                Route::get('edit/{businessId?}', ['as' => 'tf.m.c.system.business.edit.get', 'uses' => 'Manage\Content\System\Business\BusinessController@getEdit']);
                Route::post('edit/{businessId?}', ['as' => 'tf.m.c.system.business.edit.post', 'uses' => 'Manage\Content\System\Business\BusinessController@postEdit']);
                // update status
                Route::get('status/{businessId?}', ['as' => 'tf.m.c.system.business.status', 'uses' => 'Manage\Content\System\Business\BusinessController@statusUpdate']);
                // Delete
                Route::get('delete/{businessId?}', ['as' => 'tf.m.c.system.business.delete', 'uses' => 'Manage\Content\System\Business\BusinessController@deleteBusiness']);
            });

            ###----------- ---------- Bad info ----------- ----------
            Route::group(['prefix' => 'bad-info'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.badInfo.list', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@index']);
                //view
                Route::get('view/{id?}', ['as' => 'tf.m.c.system.badInfo.view', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@viewBadInfo']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.badInfo.add.get', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.badInfo.add.post', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@postAdd']);
                // edit
                Route::get('edit/{id?}', ['as' => 'tf.m.c.system.badInfo.edit.get', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@getEdit']);
                Route::post('edit/{id?}', ['as' => 'tf.m.c.system.badInfo.edit.post', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@postEdit']);
                // delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.badInfo.delete', 'uses' => 'Manage\Content\System\BadInfo\BadInfoController@deleteBadInfo']);
            });

            ###----------- ---------- Country ---------- -----------
            Route::group(['prefix' => 'country'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.country.list', 'uses' => 'Manage\Content\System\Country\CountryController@index']);
                //view
                Route::get('view/{countryId?}', ['as' => 'tf.m.c.system.country.view', 'uses' => 'Manage\Content\System\Country\CountryController@viewCountry']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.system.country.add.get', 'uses' => 'Manage\Content\System\Country\CountryController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.country.add.post', 'uses' => 'Manage\Content\System\Country\CountryController@postAdd']);
                // edit
                Route::get('edit/{countryId?}', ['as' => 'tf.m.c.system.country.edit.get', 'uses' => 'Manage\Content\System\Country\CountryController@getEdit']);
                Route::post('edit/{countryId?}', ['as' => 'tf.m.c.system.country.edit.post', 'uses' => 'Manage\Content\System\Country\CountryController@postEdit']);
                // share 3d
                Route::get('build3d/{countryId?}', ['as' => 'tf.m.c.system.country.build3d.get', 'uses' => 'Manage\Content\System\Country\CountryController@getBuild3d']);
                Route::post('build3d/{countryId?}', ['as' => 'tf.m.c.system.country.build3d.post', 'uses' => 'Manage\Content\System\Country\CountryController@postBuild3d']);
                // update status
                Route::get('status/{countryId?}', ['as' => 'tf.m.c.system.country.status', 'uses' => 'Manage\Content\System\Country\CountryController@statusUpdate']);
                // delete
                Route::get('delete/{countryId?}', ['as' => 'tf.m.c.system.country.delete', 'uses' => 'Manage\Content\System\Country\CountryController@deleteCountry']);
            });

            //----------- ---------- convert point ---------- -----------
            Route::group(['prefix' => 'convert-point'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.convert-point.list', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@index']);
                //view
                Route::get('view/{convertId?}', ['as' => 'tf.m.c.system.convert-point.view', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@viewConvertPoint']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.convert-point.add.get', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.convert-point.add.post', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@postAdd']);
                // edit
                Route::get('edit/{convertId?}', ['as' => 'tf.m.c.system.convert-point.edit.get', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@getEdit']);
                Route::post('edit/{convertId?}', ['as' => 'tf.m.c.system.convert-point.edit.post', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@postEdit']);
                // delete
                Route::get('delete/{convertId?}', ['as' => 'tf.m.c.system.convert-point.delete', 'uses' => 'Manage\Content\System\ConvertPoint\ConvertPointController@deleteConvertPoint']);
            });

            //----------- ---------- convert type ---------- -----------
            Route::group(['prefix' => 'convert-type'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.convert-type.list', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@index']);
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.convert-type.view', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@viewPointType']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.convert-type.add.get', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.convert-type.add.post', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@postAdd']);
                // edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.convert-type.edit.get', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.convert-type.edit.post', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@postEdit']);
                // delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.system.convert-type.delete', 'uses' => 'Manage\Content\System\ConvertType\ConvertTypeController@deleteConvertType']);
            });

            //----------- ---------- link run  ----------- ----------
            Route::group(['prefix' => 'link-run'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.link-run.list', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@index']);

                Route::get('view/{linkId?}', ['as' => 'tf.m.c.system.link-run.view', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@viewLink']);

                // Add new
                Route::get('add', ['as' => 'tf.m.c.system.link-run.add.get', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.link-run.add.post', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@postAdd']);
                // Edit info
                Route::get('edit/{linkId?}', ['as' => 'tf.m.c.system.link-run.edit.get', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@getEdit']);
                Route::post('edit/{linkId?}', ['as' => 'tf.m.c.system.link-run.edit.post', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@postEdit']);
                // update Status
                Route::get('status/{linkId?}', ['as' => 'tf.m.c.system.link-run.status', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@statusUpdate']);
                // Delete
                Route::get('delete/{linkId?}', ['as' => 'tf.m.c.system.link-run.delete', 'uses' => 'Manage\Content\System\LinkRun\LinkRunController@deleteLink']);
            });

            //----------- ---------- payment type ----------- ----------
            Route::group(['prefix' => 'payment-type'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.payment-type.list', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@index']);
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.payment-type.view', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@viewPaymentType']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.payment-type.add.get', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.payment-type.add.post', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@postAdd']);
                // edit
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.payment-type.edit.get', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.payment-type.edit.post', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@postEdit']);
                // update status
                Route::get('status/{typeId?}/{status?}', ['as' => 'tf.m.c.system.payment-type.status', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@statusUpdate']);
                // delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.system.payment-type.delete', 'uses' => 'Manage\Content\System\PaymentType\PaymentTypeController@deletePaymentType']);
            });

            //----------- ---------- payment ----------- ----------
            Route::group(['prefix' => 'payment'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.payment.list', 'uses' => 'Manage\Content\System\Payment\PaymentController@index']);
                Route::get('view/{paymentId?}', ['as' => 'tf.m.c.system.payment.view', 'uses' => 'Manage\Content\System\Payment\PaymentController@viewPayment']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.payment.add.get', 'uses' => 'Manage\Content\System\Payment\PaymentController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.payment.add.post', 'uses' => 'Manage\Content\System\Payment\PaymentController@postAdd']);
                // edit info
                Route::get('edit/{paymentId?}', ['as' => 'tf.m.c.system.payment.edit.get', 'uses' => 'Manage\Content\System\Payment\PaymentController@getEdit']);
                Route::post('edit/{paymentId?}', ['as' => 'tf.m.c.system.payment.edit.post', 'uses' => 'Manage\Content\System\Payment\PaymentController@postEdit']);
                // update status
                Route::get('status/{paymentId?}', ['as' => 'tf.m.c.system.payment.status', 'uses' => 'Manage\Content\System\Payment\PaymentController@statusUpdate']);
                // delete
                Route::get('delete/{paymentId?}', ['as' => 'tf.m.c.system.payment.delete', 'uses' => 'Manage\Content\System\Payment\PaymentController@deletePayment']);
            });

            //----------- ---------- point type ----------- ----------
            Route::group(['prefix' => 'point-type'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.point-type.list', 'uses' => 'Manage\Content\System\PointType\PointTypeController@index']);
                //view
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.point-type.view', 'uses' => 'Manage\Content\System\PointType\PointTypeController@viewPointType']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.point-type.add.get', 'uses' => 'Manage\Content\System\PointType\PointTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.point-type.add.post', 'uses' => 'Manage\Content\System\PointType\PointTypeController@postAdd']);
                // edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.point-type.edit.get', 'uses' => 'Manage\Content\System\PointType\PointTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.point-type.edit.post', 'uses' => 'Manage\Content\System\PointType\PointTypeController@postEdit']);
                // update status
                Route::get('status/{typeId?}', ['as' => 'tf.m.c.system.point-type.status', 'uses' => 'Manage\Content\System\PointType\PointTypeController@statusUpdate']);
                // delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.system.point-type.delete', 'uses' => 'Manage\Content\System\PointType\PointTypeController@deletePointType']);
            });

            //----------- ---------- Point transaction ----------- ----------
            Route::group(['prefix' => 'point-transaction'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.point-transaction.list', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@index']);
                //view
                Route::get('view/{id?}', ['as' => 'tf.m.c.system.point-transaction.view', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@viewPointTransaction']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.point-transaction.add.get', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.point-transaction.add.post', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@postAdd']);
                // edit
                Route::get('edit/{id?}', ['as' => 'tf.m.c.system.point-transaction.edit.get', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@getEdit']);
                Route::post('edit/{id?}', ['as' => 'tf.m.c.system.point-transaction.edit.post', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@postEdit']);
                // delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.point-transaction.delete', 'uses' => 'Manage\Content\System\PointTransaction\PointTransactionController@deletePointTransaction']);
            });

            //----------- ---------- province type ----------- ----------
            Route::group(['prefix' => 'province-type'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.province-type.list', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@index']);

                Route::get('view/{typeId?}', ['as' => 'tf.m.c.system.province-type.view', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@viewProvinceType']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.province-type.add.get', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.province-type.add.post', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@postAdd']);
                // edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.system.province-type.edit.get', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.system.province-type.edit.post', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@postEdit']);
                // update status
                Route::get('status/{typeId?}', ['as' => 'tf.m.c.system.province-type.status', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@statusUpdate']);
                // delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.province-type.delete', 'uses' => 'Manage\Content\System\ProvinceType\ProvinceTypeController@deleteProvinceType']);
            });

            //----------- ---------- province ----------- ----------
            Route::group(['prefix' => 'province'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.province.list', 'uses' => 'Manage\Content\System\Province\ProvinceController@index']);
                //view
                Route::get('view/{provinceId?}', ['as' => 'tf.m.c.system.province.view', 'uses' => 'Manage\Content\System\Province\ProvinceController@viewProvince']);

                // Filter
                Route::get('filter/{countryId?}', ['as' => 'tf.m.c.system.province.filter', 'uses' => 'Manage\Content\System\Province\ProvinceController@getFilter']);
                // Add new
                Route::get('add', ['as' => 'tf.m.c.system.province.add.get', 'uses' => 'Manage\Content\System\Province\ProvinceController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.province.add.post', 'uses' => 'Manage\Content\System\Province\ProvinceController@postAdd']);
                // Edit info
                Route::get('edit/{provinceId?}', ['as' => 'tf.m.c.system.province.edit.get', 'uses' => 'Manage\Content\System\Province\ProvinceController@getEdit']);
                Route::post('edit/{provinceId?}', ['as' => 'tf.m.c.system.province.edit.post', 'uses' => 'Manage\Content\System\Province\ProvinceController@postEdit']);
                // share 3d
                Route::get('build3d/{provinceId?}', ['as' => 'tf.m.c.system.province.build3d.get', 'uses' => 'Manage\Content\System\Province\ProvinceController@getBuild3d']);
                Route::post('build3d/{provinceId?}', ['as' => 'tf.m.c.system.province.build3d.post', 'uses' => 'Manage\Content\System\Province\ProvinceController@postBuild3d']);
                // Update status
                Route::get('status/{provinceId?}', ['as' => 'tf.m.c.system.province.status', 'uses' => 'Manage\Content\System\Province\ProvinceController@statusUpdate']);
                // Delete
                Route::get('delete/{provinceId?}', ['as' => 'tf.m.c.system.province.delete', 'uses' => 'Manage\Content\System\Province\ProvinceController@deleteProvince']);
            });

            //----------- ---------- department ----------- ----------
            Route::group(['prefix' => 'department'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.system.department.list', 'uses' => 'Manage\Content\System\Department\DepartmentController@index']);
                //view
                Route::get('view/{departmentId?}', ['as' => 'tf.m.c.system.department.view', 'uses' => 'Manage\Content\System\Department\DepartmentController@viewDepartment']);

                // Add new
                Route::get('add', ['as' => 'tf.m.c.system.department.add.get', 'uses' => 'Manage\Content\System\Department\DepartmentController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.department.add.post', 'uses' => 'Manage\Content\System\Department\DepartmentController@postAdd']);
                // Edit info
                Route::get('edit/{departmentId?}', ['as' => 'tf.m.c.system.department.edit.get', 'uses' => 'Manage\Content\System\Department\DepartmentController@getEdit']);
                Route::post('edit/{departmentId?}', ['as' => 'tf.m.c.system.department.edit.post', 'uses' => 'Manage\Content\System\Department\DepartmentController@postEdit']);
                // update status
                Route::get('status/{departmentId?}', ['as' => 'tf.m.c.system.department.status', 'uses' => 'Manage\Content\System\Department\DepartmentController@statusUpdate']);
                //Delete
                Route::get('delete/{departmentId?}', ['as' => 'tf.m.c.system.department.delete', 'uses' => 'Manage\Content\System\Department\DepartmentController@deleteDepartment']);
            });

            //----------- ---------- Department contact ----------- ----------
            Route::group(['prefix' => 'department-contact'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.system.department-contact.list', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@index']);

                Route::get('view/{contactId?}', ['as' => 'tf.m.c.system.department-contact.view', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@viewContact']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.department-contact.add.get', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.department-contact.add.post', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@postAdd']);
                // edit info
                Route::get('edit/{contactId?}', ['as' => 'tf.m.c.system.department-contact.edit.get', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@getEdit']);
                Route::post('edit/{contactId?}', ['as' => 'tf.m.c.system.department-contact.edit.post', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@postEdit']);
                // delete
                Route::get('delete/{contactId?}', ['as' => 'tf.m.c.system.department-contact.delete', 'uses' => 'Manage\Content\System\DepartmentContact\DepartmentContactController@deleteContact']);
            });

            //----------- ---------- staff ----------- ----------
            Route::group(['prefix' => 'staff'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.staff.list', 'uses' => 'Manage\Content\System\Staff\StaffController@getList']);

                // view
                Route::get('view/{staffId?}', ['as' => 'tf.m.c.system.staff.view', 'uses' => 'Manage\Content\System\Staff\StaffController@viewStaff']);

                // select manage staff
                Route::get('add/select-manage/{departmentId?}', ['as' => 'tf.m.c.system.staff.manager.select', 'uses' => 'Manage\Content\System\Staff\StaffController@selectMangeStaff']);
                // select province
                Route::get('add/select-province/{countryId?}', ['as' => 'tf.m.c.system.staff.province.select', 'uses' => 'Manage\Content\System\Staff\StaffController@selectProvince']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.system.staff.add.get', 'uses' => 'Manage\Content\System\Staff\StaffController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.staff.add.post', 'uses' => 'Manage\Content\System\Staff\StaffController@postAdd']);

                // edit info
                Route::get('edit/{staffId?}', ['as' => 'tf.m.c.system.staff.edit.get', 'uses' => 'Manage\Content\System\Staff\StaffController@getEdit']);
                Route::post('edit/{staffId?}', ['as' => 'tf.m.c.system.staff.edit.post', 'uses' => 'Manage\Content\System\Staff\StaffController@postEdit']);

                // confirm account
                Route::get('confirm-account', ['as' => 'tf.m.c.system.staff.account.confirm.get', 'uses' => 'Manage\Content\System\Staff\StaffController@getConfirmAccount']);
                Route::post('confirm-account', ['as' => 'tf.m.c.system.staff.account.confirm.post', 'uses' => 'Manage\Content\System\Staff\StaffController@postConfirmAccount']);

                // update status
                Route::get('status/{staffId?}', ['as' => 'tf.m.c.system.staff.status', 'uses' => 'Manage\Content\System\Staff\StaffController@updateStatus']);

                // delete
                Route::get('delete/{staffId?}', ['as' => 'tf.m.c.system.staff.delete', 'uses' => 'Manage\Content\System\Staff\StaffController@deleteStaff']);
            });

            //----------- ---------- staff access ----------- ----------
            Route::group(['prefix' => 'staff-access'], function () {
                Route::get('list', ['as' => 'tf.m.c.system.staff-access.list', 'uses' => 'Manage\Content\System\StaffAccess\StaffAccessController@getList']);
            });

            //----------- ---------- wallet ----------- ----------
            Route::group(['prefix' => 'wallet'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.wallet.list', 'uses' => 'Manage\Content\System\Wallet\WalletController@index']);

                Route::get('view', ['as' => 'tf.m.c.system.wallet.view', 'uses' => 'Manage\Content\System\Wallet\WalletController@viewWallet']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.system.wallet.add.get', 'uses' => 'Manage\Content\System\Wallet\WalletController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.wallet.add.post', 'uses' => 'Manage\Content\System\Wallet\WalletController@postAdd']);
                //edit info
                Route::get('edit/{id?}', ['as' => 'tf.m.c.system.wallet.edit.get', 'uses' => 'Manage\Content\System\Wallet\WalletController@getEdit']);
                Route::post('edit/{id?}', ['as' => 'tf.m.c.system.wallet.edit.post', 'uses' => 'Manage\Content\System\Wallet\WalletController@postEdit']);
                // delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.wallet.delete', 'uses' => 'Manage\Content\System\Wallet\WalletController@deleteWallet']);
            });

            //----------- ---------- warning ----------- ----------
            Route::group(['prefix' => 'warning'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.system.warning.list', 'uses' => 'Manage\Content\System\Warning\WarningController@index']);

                Route::get('view/{id?}', ['as' => 'tf.m.c.system.warning.view', 'uses' => 'Manage\Content\System\Warning\WarningController@viewWarning']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.system.warning.add.get', 'uses' => 'Manage\Content\System\Warning\WarningController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.system.warning.add.post', 'uses' => 'Manage\Content\System\Warning\WarningController@postAdd']);
                // edit info
                Route::get('edit/{id?}', ['as' => 'tf.m.c.system.warning.edit.get', 'uses' => 'Manage\Content\System\Warning\WarningController@getEdit']);
                Route::post('edit/{id?}', ['as' => 'tf.m.c.system.warning.edit.post', 'uses' => 'Manage\Content\System\Warning\WarningController@postEdit']);
                // delete
                Route::get('delete/{id?}', ['as' => 'tf.m.c.system.warning.delete', 'uses' => 'Manage\Content\System\Warning\WarningController@deleteWarning']);
            });

            Route::get('/{object?}', ['as' => 'tf.m.c.system', 'uses' => 'Manage\Content\ContentController@getSystem']);
        });

        ##=========== =========== USER PAGE =========== ===========
        Route::group(['prefix' => 'user', 'middleware' => 'ContentUserMiddleware'], function () {
            //user
            Route::group(['prefix' => 'user'], function () {
                Route::get('list', ['as' => 'tf.m.c.user.user.list', 'uses' => 'Manage\Content\User\User\UserController@index']);

                Route::get('view/{userId?}', ['as' => 'tf.m.c.user.user.view', 'uses' => 'Manage\Content\User\User\UserController@viewUser']);

                //update status && delete
                Route::get('status/{userId?}', ['as' => 'tf.m.c.user.user.status', 'uses' => 'Manage\Content\User\User\UserController@updateStatus']);
                Route::get('delete/{userId?}', ['as' => 'tf.m.c.user.user.delete', 'uses' => 'Manage\Content\User\User\UserController@deleteUser']);

            });

            //access
            Route::group(['prefix' => 'user-access'], function () {
                Route::get('list', ['as' => 'tf.m.c.user.access.list', 'uses' => 'Manage\Content\User\Access\UserAccessController@index']);

                Route::get('view/{accessId?}', ['as' => 'tf.m.c.user.access.view', 'uses' => 'Manage\Content\User\Access\UserAccessController@viewAccess']);

            });

            //recharge
            Route::group(['prefix' => 'recharge'], function () {
                Route::get('list', ['as' => 'tf.m.c.user.recharge.list', 'uses' => 'Manage\Content\User\Recharge\RechargeController@index']);
                Route::get('view/{rechargeId?}', ['as' => 'tf.m.c.user.recharge.view', 'uses' => 'Manage\Content\User\Recharge\RechargeController@viewRecharge']);
                // add
                Route::get('add', ['as' => 'tf.m.c.user.recharge.add.get', 'uses' => 'Manage\Content\User\Recharge\RechargeController@getAddRecharge']);
                Route::post('add', ['as' => 'tf.m.c.user.recharge.add.post', 'uses' => 'Manage\Content\User\Recharge\RechargeController@postAddRecharge']);
            });

            //recharge
            Route::group(['prefix' => 'nganluong'], function () {
                Route::get('list', ['as' => 'tf.m.c.user.nganluong.list', 'uses' => 'Manage\Content\User\NganLuong\NganLuongController@index']);
                Route::get('view/{orderId?}', ['as' => 'tf.m.c.user.nganluong.view', 'uses' => 'Manage\Content\User\NganLuong\NganLuongController@viewOrder']);
            });

            //image
            Route::group(['prefix' => 'image'], function () {
                Route::get('list', ['as' => 'tf.m.c.user.image.list', 'uses' => 'Manage\Content\User\Image\ImageController@index']);

                Route::get('view/{imageId?}', ['as' => 'tf.m.c.user.image.view', 'uses' => 'Manage\Content\User\Image\ImageController@viewImage']);

                //delete
                Route::get('delete/{imageId?}', ['as' => 'tf.m.c.user.image.delete', 'uses' => 'Manage\Content\User\Image\ImageController@deleteImage']);

            });

            //image type
            Route::group(['prefix' => 'image-type'], function () {
                // get list
                Route::get('list', ['as' => 'tf.m.c.user.image-type.list', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@getList']);

                // Add new
                Route::get('add', ['as' => 'tf.m.c.user.image-type.add.get', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.user.image-type.add.post', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@postAdd']);

                // Edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.user.image-type.edit.get', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.user.image-ype.edit.post', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@postEdit']);

                // view
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.user.image-type.view', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@viewImageType']);

                // Delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.user.image-type.delete', 'uses' => 'Manage\Content\User\ImageType\UserImageTypeController@deleteImageType']);

            });

            Route::get('/{object?}', ['as' => 'tf.m.c.user', 'uses' => 'Manage\Content\ContentController@getUser']);
        });

        ## =========== ===========  MAP PAGE =========== ===========
        Route::group(['prefix' => 'map', 'middleware' => 'ContentMapMiddleware'], function () {
            //----------- ---------- area ----------- ----------
            Route::group(['prefix' => 'area'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.area.getList', 'uses' => 'Manage\Content\Map\Area\AreaController@getList']);
            });

            //----------- ---------- Banner ----------- ----------
            Route::group(['prefix' => 'banner'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.banner.list', 'uses' => 'Manage\Content\Map\Banner\BannerController@index']);
                //view
                Route::get('view/{bannerId?}', ['as' => 'tf.m.c.map.banner.view', 'uses' => 'Manage\Content\Map\Banner\BannerController@viewBanner']);
                //delete
                Route::get('delete/{bannerId?}', ['as' => 'tf.m.c.map.banner.delete', 'uses' => 'Manage\Content\Map\Banner\BannerController@deleteBanner']);
            });
            //image of banner
            Route::group(['prefix' => 'banner-image'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.banner.image.list', 'uses' => 'Manage\Content\Map\Banner\Image\BannerImageController@index']);
                //view
                Route::get('view/{imageId?}', ['as' => 'tf.m.c.map.banner.image.view', 'uses' => 'Manage\Content\Map\Banner\Image\BannerImageController@viewBannerImage']);
                //delete
                Route::get('delete/{imageId?}', ['as' => 'tf.m.c.map.banner.image.delete', 'uses' => 'Manage\Content\Map\Banner\Image\BannerImageController@deleteBannerImage']);
            });

            Route::group(['prefix' => 'banner-image-visit'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.banner.image.visit.list', 'uses' => 'Manage\Content\Map\Banner\ImageVisit\BannerImageVisitController@index']);
                Route::get('view/{visitId?}', ['as' => 'tf.m.c.map.banner.image.visit.view', 'uses' => 'Manage\Content\Map\Banner\ImageVisit\BannerImageVisitController@viewVisitImage']);
            });

            //license of banner
            Route::group(['prefix' => 'banner-license'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.banner.license.list', 'uses' => 'Manage\Content\Map\Banner\License\BannerLicenseController@index']);
                Route::get('view/{licenseId?}', ['as' => 'tf.m.c.map.banner.license.view', 'uses' => 'Manage\Content\Map\Banner\License\BannerLicenseController@viewBannerLicense']);
            });

            //share of banner
            Route::group(['prefix' => 'banner-share'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.banner.share.list', 'uses' => 'Manage\Content\Map\Banner\Share\BannerShareController@index']);
                Route::get('view/{imageId?}', ['as' => 'tf.m.c.map.banner.share.view', 'uses' => 'Manage\Content\Map\Banner\Share\BannerShareController@viewBannerShare']);
            });

            //----------- ---------- Land ----------- ----------
            Route::group(['prefix' => 'land'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.land.list', 'uses' => 'Manage\Content\Map\Land\LandController@index']);
                Route::get('view/{landId?}', ['as' => 'tf.m.c.map.land.view', 'uses' => 'Manage\Content\Map\Land\LandController@viewLand']);
                Route::get('delete/{landId?}', ['as' => 'tf.m.c.map.land.delete', 'uses' => 'Manage\Content\Map\Land\LandController@deleteLand']);
            });

            //license of land
            Route::group(['prefix' => 'land-license'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.land.license.list', 'uses' => 'Manage\Content\Map\Land\License\LandLicenseController@index']);
                Route::get('view/{licenseId?}', ['as' => 'tf.m.c.map.land.license.view', 'uses' => 'Manage\Content\Map\Land\License\LandLicenseController@viewLandLicense']);
            });

            //share of land
            Route::group(['prefix' => 'land-share'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.land.share.list', 'uses' => 'Manage\Content\Map\Land\Share\LandShareController@index']);
                Route::get('view/{shareId?}', ['as' => 'tf.m.c.map.land.share.view', 'uses' => 'Manage\Content\Map\Land\Share\LandShareController@viewLandShare']);
            });

            //----------- ---------- Public ----------- ----------
            Route::group(['prefix' => 'public'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.public.list', 'uses' => 'Manage\Content\Map\Publics\PublicController@index']);
                Route::get('view/{publicId?}', ['as' => 'tf.m.c.map.public.view', 'uses' => 'Manage\Content\Map\Publics\PublicController@viewPublic']);
                Route::get('delete/{publicId?}', ['as' => 'tf.m.c.map.public.delete', 'uses' => 'Manage\Content\Map\Publics\PublicController@deletePublic']);
            });

            //----------- ---------- rank ----------- ----------
            Route::group(['prefix' => 'rank'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.rank.getList', 'uses' => 'Manage\Content\Map\Rank\RankController@getList']);
            });

            //----------- ---------- request build price ----------- ----------
            Route::group(['prefix' => 'request-build-price'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.request_build_price.list', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@getList']);
                // Filter
                Route::get('filter/{sizeId?}', ['as' => 'tf.m.c.map.request_build_price.filter', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@getFilter']);

                Route::get('view/{price?}', ['as' => 'tf.m.c.map.request_build_price.view', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@viewDetail']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.map.request_build_price.add.get', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.map.request_build_price.add.post', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@postAdd']);
                // edit info
                Route::get('edit/{price?}', ['as' => 'tf.m.c.map.request_build_price.edit.get', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@getEdit']);
                Route::post('edit/{price?}', ['as' => 'tf.m.c.map.request_build_price.edit.post', 'uses' => 'Manage\Content\Map\RequestBuildPrice\RequestBuildPriceController@postEdit']);
            });

            //----------- ---------- rule of banner rank ----------- ----------
            Route::group(['prefix' => 'rule-banner-rank'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.rule_banner_rank.list', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@getList']);
                // Filter
                Route::get('filter/{sizeId?}', ['as' => 'tf.m.c.map.rule_banner_rank.filter', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@getFilter']);

                Route::get('view/{ruleId?}', ['as' => 'tf.m.c.map.rule_banner_rank.view', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@viewDetail']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.map.rule_banner_rank.add.get', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.map.rule_banner_rank.add.post', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@postAdd']);
                // edit info
                Route::get('edit/{ruleId?}', ['as' => 'tf.m.c.map.rule_banner_rank.edit.get', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@getEdit']);
                Route::post('edit/{rankId?}', ['as' => 'tf.m.c.map.rule_banner_rank.edit.get', 'uses' => 'Manage\Content\Map\RuleBannerRank\RuleBannerRankController@postEdit']);
            });

            //----------- ---------- rule of land rank ----------- ----------
            Route::group(['prefix' => 'rule-land-rank'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.rule_land_rank.list', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@getList']);
                // Filter
                Route::get('filter/{sizeId?}', ['as' => 'tf.m.c.map.rule_land_rank.filter', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@getFilter']);

                Route::get('view/{ruleId?}', ['as' => 'tf.m.c.map.rule_land_rank.view', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@viewDetail']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.map.rule_land_rank.add.get', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.map.rule_land_rank.add.post', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@postAdd']);
                // edit info
                Route::get('edit/{ruleId?}', ['as' => 'tf.m.c.map.rule_land_rank.edit.get', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@getEdit']);
                Route::post('edit/{rankId?}', ['as' => 'tf.m.c.map.rule_land_rank.edit.post', 'uses' => 'Manage\Content\Map\RuleLandRank\RuleLandRankController@postEdit']);
            });

            //----------- ---------- rule of project rank ----------- ----------
            Route::group(['prefix' => 'rule-project-rank'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.rule_project_rank.list', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@index']);
                //view
                Route::get('view/{rankId?}', ['as' => 'tf.m.c.map.rule_project_rank.view', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@viewDetail']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.map.rule_project_rank.add.get', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.map.rule_project_rank.add.post', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@postAdd']);
                // edit info
                Route::get('edit', ['as' => 'tf.m.c.map.rule_project_rank.edit.get', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@getEdit']);
                Route::post('edit', ['as' => 'tf.m.c.map.rule_project_rank.edit.post', 'uses' => 'Manage\Content\Map\RuleProjectRank\RuleProjectRankController@postEdit']);
            });

            //----------- ---------- Province ----------- ----------
            //province
            Route::group(['prefix' => 'province'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.province.list', 'uses' => 'Manage\Content\Map\Province\ProvinceController@index']);

                Route::get('view/{provinceId?}', ['as' => 'tf.m.c.map.province.view', 'uses' => 'Manage\Content\Map\Province\ProvinceController@viewProvince']);
            });
            // Province property
            Route::group(['prefix' => 'province-property'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.province-property.list', 'uses' => 'Manage\Content\Map\ProvinceProperty\ProvincePropertyController@index']);

                Route::get('view/{propertyId?}', ['as' => 'tf.m.c.map.province-property.view', 'uses' => 'Manage\Content\Map\ProvinceProperty\ProvincePropertyController@viewProvinceProperty']);
            });

            //----------- ---------- project ----------- ----------
            Route::group(['prefix' => 'project'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.project.list', 'uses' => 'Manage\Content\Map\Project\ProjectController@index']);
                //view
                Route::get('view/{projectId?}', ['as' => 'tf.m.c.map.project.view', 'uses' => 'Manage\Content\Map\Project\ProjectController@viewProject']);
                //update status
                Route::get('status/{projectId?}', ['as' => 'tf.m.c.map.project.status', 'uses' => 'Manage\Content\Map\Project\ProjectController@updateStatus']);
                //delete
                Route::get('delete/{projectId?}', ['as' => 'tf.m.c.map.project.delete', 'uses' => 'Manage\Content\Map\Project\ProjectController@deleteProject']);
            });
            // project property
            Route::group(['prefix' => 'project-property'], function () {
                Route::get('list', ['as' => 'tf.m.c.map.project-property.list', 'uses' => 'Manage\Content\Map\Project\Property\ProjectPropertyController@index']);

                Route::get('view/{propertyId?}', ['as' => 'tf.m.c.map.project-property.view', 'uses' => 'Manage\Content\Map\Project\Property\ProjectPropertyController@viewProjectProperty']);
            });

            //----------- ---------- transaction status ----------- ----------
            Route::group(['prefix' => 'transaction-status'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.map.transactionStatus.list', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@getList']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.map.transactionStatus.add.get', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.map.transactionStatus.add.post', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@postAdd']);

                // edit info
                Route::get('edit/{transactionStatusId?}', ['as' => 'tf.m.c.map.transactionStatus.edit.get', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@getEdit']);
                Route::post('edit/{transactionStatusId?}', ['as' => 'tf.m.c.map.transactionStatus.edit.post', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@postEdit']);

                // update status
                Route::get('status/{transactionStatusId?}', ['as' => 'tf.m.c.map.transactionStatus.status', 'uses' => 'Manage\Content\Map\Transaction\TransactionStatusController@statusUpdate']);
            });

            Route::get('/{object?}', ['as' => 'tf.m.c.map', 'uses' => 'Manage\Content\ContentController@getMap']);
        });

        ##=========== ===========  BUILDING PAGE =========== ===========
        Route::group(['prefix' => 'building', 'middleware' => 'ContentBuildingMiddleware'], function () {

            Route::group(['prefix' => 'banner'], function () {
                //building info
                Route::get('list', ['as' => 'tf.m.c.building.banner.list', 'uses' => 'Manage\Content\Building\Banner\BannerController@index']);
                Route::get('view/{bannerId?}', ['as' => 'tf.m.c.building.banner.view', 'uses' => 'Manage\Content\Building\Banner\BannerController@getView']);
                Route::get('delete/{bannerId?}', ['as' => 'tf.m.c.building.banner.delete', 'uses' => 'Manage\Content\Building\Banner\BannerController@deleteBanner']);
            });

            //---------- posts ---------
            //post
            Route::group(['prefix' => 'post'], function () {
                //post info
                Route::get('list', ['as' => 'tf.m.c.building.post.list', 'uses' => 'Manage\Content\Building\Post\PostController@index']);
                Route::get('view/{postId?}', ['as' => 'tf.m.c.building.post.view', 'uses' => 'Manage\Content\Building\Post\PostController@viewPost']);
                Route::get('delete/{postId?}', ['as' => 'tf.m.c.building.post.delete', 'uses' => 'Manage\Content\Building\Post\PostController@deletePost']);
            });

            //post - comment
            Route::group(['prefix' => 'post-comment'], function () {
                //post info
                Route::get('list', ['as' => 'tf.m.c.building.post.comment.list', 'uses' => 'Manage\Content\Building\PostComment\PostCommentController@index']);
                Route::get('view/{commentId?}', ['as' => 'tf.m.c.building.post.comment.view', 'uses' => 'Manage\Content\Building\PostComment\PostCommentController@viewComment']);
                Route::get('delete/{commentId?}', ['as' => 'tf.m.c.building.post.comment.delete', 'uses' => 'Manage\Content\Building\PostComment\PostCommentController@deleteComment']);
            });

            //---------- comment ---------
            Route::group(['prefix' => 'comment'], function () {
                Route::get('list', ['as' => 'tf.m.c.building.comment.list', 'uses' => 'Manage\Content\Building\Comment\CommentController@index']);
                Route::get('view/{commentId?}', ['as' => 'tf.m.c.building.comment.view', 'uses' => 'Manage\Content\Building\Comment\CommentController@viewComment']);
                Route::get('delete/{commentId?}', ['as' => 'tf.m.c.building.comment.delete', 'uses' => 'Manage\Content\Building\Comment\CommentController@deleteComment']);
            });

            //---------- Share ---------
            Route::group(['prefix' => 'share'], function () {
                Route::get('list', ['as' => 'tf.m.c.building.share.list', 'uses' => 'Manage\Content\Building\Share\ShareController@index']);
                Route::get('view/{shareId?}', ['as' => 'tf.m.c.building.share.view', 'uses' => 'Manage\Content\Building\Share\ShareController@viewShare']);
            });

            //----------- building info ----------
            Route::get('list', ['as' => 'tf.m.c.building.building.list', 'uses' => 'Manage\Content\Building\Building\BuildingController@index']);

            Route::get('view/{buildingId?}', ['as' => 'tf.m.c.building.building.view', 'uses' => 'Manage\Content\Building\Building\BuildingController@viewBuilding']);

            //update status && delete
            Route::get('status/{buildingId?}', ['as' => 'tf.m.c.building.building.status', 'uses' => 'Manage\Content\Building\Building\BuildingController@updateStatus']);
            Route::get('delete/{buildingId?}', ['as' => 'tf.m.c.building.building.delete', 'uses' => 'Manage\Content\Building\Building\BuildingController@deleteBuilding']);

            Route::get('/{object?}', ['as' => 'tf.m.c.building', 'uses' => 'Manage\Content\ContentController@getBuilding']);
        });

        ##=========== ===========  DESIGN PAGE ========== ===========
        Route::group(['prefix' => 'design', 'middleware' => 'ContentDesignMiddleware'], function () {
            // request
            Route::group(['prefix' => 'request'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.design.request.getList', 'uses' => 'Manage\Content\Design\DesignRequestController@getList']);
                // delete
                Route::get('delete/{requestID}', ['as' => 'tf.m.c.design.request.getDelete', 'uses' => 'Manage\Content\Design\DesignRequestController@getDelete']);
            });

            // receive
            Route::group(['prefix' => 'receive'], function () {
                // receive
                Route::get('list', ['as' => 'tf.m.c.design.receive.getList', 'uses' => 'Manage\Content\Design\DesignReceiveController@getList']);
                //delete
                Route::get('delete/{requestID}', ['as' => 'tf.m.c.design.receive.getDelete', 'uses' => 'Manage\Content\Design\DesignReceiveController@getDelete']);
            });

            // direct
            Route::group(['prefix' => 'direct'], function () {
                // receive
                Route::get('list', ['as' => 'tf.m.c.design.direct.getList', 'uses' => 'Manage\Content\Design\DesignDirectController@getList']);
                //delete
                Route::get('delete/{designID}', ['as' => 'tf.m.c.design.direct.getDelete', 'uses' => 'Manage\Content\Design\DesignDirectController@getDelete']);
            });

            // store
            Route::group(['prefix' => 'store'], function () {
                // receive
                Route::get('list', ['as' => 'tf.m.c.design.store.getList', 'uses' => 'Manage\Content\Design\DesignStoreController@getList']);
                //delete
                Route::get('delete/{designID}', ['as' => 'tf.m.c.design.store.getDelete', 'uses' => 'Manage\Content\Design\DesignStoreController@getDelete']);
            });
            // end store

            Route::get('/{object?}', ['as' => 'tf.m.c.design', 'uses' => 'Manage\Content\ContentController@getDesign']);
        });

        ##=========== ===========  SAMPLE PAGE ========== ===========
        Route::group(['prefix' => 'sample', 'middleware' => 'ContentSampleMiddleware'], function () {
            //----------- ---------- Banner ----------- ----------
            Route::group(['prefix' => 'banner'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.banner.list', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@index']);

                Route::get('view/{sampleId?}', ['as' => 'tf.m.c.sample.banner.view', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@viewSample']);

                // select manage staff
                Route::get('add/select-image/{sizeId?}', ['as' => 'tf.m.c.sample.banner.image.select', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@selectImage']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.banner.add.get', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.banner.add.post', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@postAdd']);

                // edit info
                Route::get('edit/{sampleId?}', ['as' => 'tf.m.c.sample.banner.edit.get', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@getEdit']);
                Route::post('edit/{sampleId?}', ['as' => 'tf.m.c.sample.banner.edit.post', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@postEdit']);

                // update status
                Route::get('status/{sampleId?}', ['as' => 'tf.m.c.sample.banner.status', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@statusUpdate']);
                // delete
                Route::get('delete/{sampleId?}', ['as' => 'tf.m.c.sample.banner.delete', 'uses' => 'Manage\Content\Sample\Banner\BannerSampleController@deleteSample']);
            });

            //----------- ---------- Building ----------- ----------
            Route::group(['prefix' => 'building'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.building.list', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@index']);
                //view
                Route::get('view/{sampleId?}', ['as' => 'tf.m.c.sample.building.view', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@viewSample']);

                // Filter
                Route::get('filter/{typeId?}', ['as' => 'tf.m.c.sample.building.filter', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@getFilter']);
                // select manage staff
                Route::get('add/select-image/{sizeId?}', ['as' => 'tf.m.c.sample.building.image.select', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@selectImage']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.building.add.get', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.building.add.post', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@postAdd']);
                // edit info
                Route::get('edit/{sampleId?}', ['as' => 'tf.m.c.sample.building.edit.get', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@getEdit']);
                Route::post('edit/{sampleId?}', ['as' => 'tf.m.c.sample.building.edit.post', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@postEdit']);
                // update status
                Route::get('status/{sampleId?}/{status?}', ['as' => 'tf.m.c.sample.building.status', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@statusUpdate']);
                // delete
                Route::get('delete/{sampleId?}', ['as' => 'tf.m.c.sample.building.delete', 'uses' => 'Manage\Content\Sample\Building\BuildingSampleController@deleteSample']);
            });

            //----------- ---------- Building - copyright ----------- ----------
            Route::group(['prefix' => 'building-copyright'], function () {
                Route::get('list', ['as' => 'tf.m.c.sample.buildingCopyright.getList', 'uses' => 'Manage\Content\Sample\Buildings\BuildingCopyrightController@getList']);
            });

            //----------- ---------- land icon ----------- ----------
            Route::group(['prefix' => 'land-icon'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.land-icon.list', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@index']);

                Route::get('view/{sampleId?}', ['as' => 'tf.m.c.sample.land-icon.view', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@viewSample']);

                // select manage staff
                Route::get('add/select-image/{sizeId?}', ['as' => 'tf.m.c.sample.land-icon.image.select', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@selectImage']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.land-icon.add.get', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.land-icon.add.post', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@postAdd']);
                // edit info
                Route::get('edit/{sampleId?}', ['as' => 'tf.m.c.sample.land-icon.edit.get', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@getEdit']);
                Route::post('edit/{sampleId?}', ['as' => 'tf.m.c.sample.land-icon.edit.post', 'uses' => 'Manage\Content\Sample\LandIcon\LandIconSampleController@postEdit']);
                // delete
                //Route::get('delete/{sampleId?}', ['as' => 'tf.m.c.sample.land-icon.delete', 'uses' => 'Manage\Content\Sample\Land\LandIconSampleController@deleteSample']);
            });
            //----------- ---------- land request build ----------- ----------
            Route::group(['prefix' => 'land-request-build'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.land_request_build.list', 'uses' => 'Manage\Content\Sample\LandRequestBuild\LandRequestBuildController@index']);

                Route::get('view/{requestId?}', ['as' => 'tf.m.c.sample.land_request_build.view', 'uses' => 'Manage\Content\Sample\LandRequestBuild\LandRequestBuildController@viewRequest']);

                // edit info
                Route::get('assignment/{requestId?}', ['as' => 'tf.m.c.sample.land_request_build.assignment.get', 'uses' => 'Manage\Content\Sample\LandRequestBuild\LandRequestBuildController@getAssignment']);
                Route::post('assignment/{requestId?}', ['as' => 'tf.m.c.sample.land_request_build.assignment.post', 'uses' => 'Manage\Content\Sample\LandRequestBuild\LandRequestBuildController@postAssignment']);

            });

            Route::group(['prefix' => 'land-request-build-design'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.land_request_build_design.list', 'uses' => 'Manage\Content\Sample\LandRequestBuildDesign\LandRequestBuildDesignController@index']);

                Route::get('view/{designId?}', ['as' => 'tf.m.c.sample.land_request_build_design.view', 'uses' => 'Manage\Content\Sample\LandRequestBuildDesign\LandRequestBuildDesignController@viewDesign']);

                // up design
                Route::get('design/{designId?}', ['as' => 'tf.m.c.sample.land_request_build_design.design.get', 'uses' => 'Manage\Content\Sample\LandRequestBuildDesign\LandRequestBuildDesignController@getUpDesign']);
                Route::post('design/{designId?}', ['as' => 'tf.m.c.sample.land_request_build_design.design.post', 'uses' => 'Manage\Content\Sample\LandRequestBuildDesign\LandRequestBuildDesignController@postDesign']);

                //publish design
                Route::get('publish/{designId?}/{confirm?}', ['as' => 'tf.m.c.sample.land_request_build_design.publish.confirm', 'uses' => 'Manage\Content\Sample\LandRequestBuildDesign\LandRequestBuildDesignController@confirmDesign']);

            });

            //----------- ---------- Project background ----------- ----------
            Route::group(['prefix' => 'project-background'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.sample.project-background.list', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@index']);

                Route::get('view/{projectId?}', ['as' => 'tf.m.c.sample.project-background.view', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@viewProjectBackground']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.project-background.add.get', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.project-background.add.post', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@postAdd']);

                // edit info
                Route::get('edit/{backgroundId?}', ['as' => 'tf.m.c.sample.project-background.edit.get', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@getEdit']);
                Route::post('edit/{backgroundId?}', ['as' => 'tf.m.c.sample.project-background.edit.post', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@postEdit']);

                // update status
                Route::get('status/{backgroundId?}/{status?}', ['as' => 'tf.m.c.sample.project-background.status', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@statusUpdate']);

                //delete
                Route::get('delete/{backgroundId?}', ['as' => 'tf.m.c.sample.project-background.delete', 'uses' => 'Manage\Content\Sample\ProjectBackground\ProjectBackgroundController@deleteProjectBackground']);
            });

            //----------- ---------- Project icon ----------- ----------
            Route::group(['prefix' => 'project-icon'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.project-icon.list', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@index']);
                //view
                Route::get('view/{sampleId?}', ['as' => 'tf.m.c.sample.project-icon.view', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@viewSample']);
                // select manage staff
                Route::get('add/select-image/{sizeId?}', ['as' => 'tf.m.c.sample.project-icon.image.select', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@selectImage']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.project-icon.add.get', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.project-icon.add.post', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@postAdd']);
                // edit info
                Route::get('edit/{sampleId?}', ['as' => 'tf.m.c.sample.project-icon.edit.get', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@getEdit']);
                Route::post('edit/{sampleId?}', ['as' => 'tf.m.c.sample.project-icon.edit.post', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@postEdit']);
                // update status
                Route::get('status/{sampleId?}/{status?}', ['as' => 'tf.m.c.sample.project-icon.status', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@statusUpdate']);
                // delete
                Route::get('delete/{sampleId?}', ['as' => 'tf.m.c.sample.project-icon.delete', 'uses' => 'Manage\Content\Sample\ProjectIcon\ProjectIconSampleController@deleteSample']);
            });

            //----------- ---------- Project sample ----------- ----------
            Route::group(['prefix' => 'project'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.sample.project.list', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@index']);

                Route::get('view/{projectId?}', ['as' => 'tf.m.c.sample.project.view', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@viewProject']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.project.add.get', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.project.add.post', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@postAdd']);

                // edit info
                Route::get('edit/{projectId?}', ['as' => 'tf.m.c.sample.project.edit.get', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@getEdit']);
                Route::post('edit/{projectId?}', ['as' => 'tf.m.c.sample.project.edit.post', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@postEdit']);

                // build
                Route::group(['prefix' => 'build'], function () {
                    //land
                    Route::group(['prefix' => 'background'], function () {
                        Route::get('view/{backgroundId?}', ['as' => 'tf.m.c.sample.project.build.background.view', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@viewBackground']);

                        Route::get('add/{projectId?}/{backgroundId?}', ['as' => 'tf.m.c.sample.project.build.background.add', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@addBackground']);

                        Route::get('drop/{projectId?}', ['as' => 'tf.m.c.sample.project.build.background.drop', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@dropBackground']);

                        Route::get('/{projectId?}', ['as' => 'tf.m.c.sample.project.build.background', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@buildProjectBackground']);
                    });

                    Route::group(['prefix' => 'public'], function () {
                        //public
                        Route::get('add/{projectId?}/{sampleId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.c.sample.project.build.publics.add', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@addPublic']);
                        // set position
                        Route::get('set-position/{publicId?}/{topPosition?}/{leftPosition?}/{zIndex?}', ['as' => 'tf.m.c.sample.project.build.public.position.set', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@setPositionPublic']);

                        // delete
                        Route::get('setup-delete/{publicId?}', ['as' => 'tf.m.c.sample.project.build.public.delete', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@deletePublic']);

                        Route::get('/{projectId?}/{publicTypeId?}', ['as' => 'tf.m.c.sample.project.build.public', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@buildProjectPublic']);
                    });

                    //land
                    Route::group(['prefix' => 'land'], function () {
                        Route::get('add/{projectId?}/{sizeId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.c.sample.project.build.land.add.get', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@getAddLand']);
                        Route::post('add', ['as' => 'tf.m.c.sample.project.build.land.add.post', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@postAddLand']);

                        // set position
                        Route::get('set-position/{landId?}/{topPosition?}/{leftPosition?}/{zIndex?}', ['as' => 'tf.m.c.sample.project.build.land.position.set', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@setPositionLand']);

                        // delete
                        Route::get('setup-delete/{landId?}', ['as' => 'tf.m.c.sample.project.build.land.delete', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@deleteLand']);

                        Route::get('/{projectId?}', ['as' => 'tf.m.c.sample.project.build.land', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@buildProjectLand']);
                    });

                    //banner
                    Route::group(['prefix' => 'banner'], function () {
                        Route::get('add/{projectId?}/{sampleId?}/{topPosition?}/{leftPosition?}', ['as' => 'tf.m.c.sample.project.build.banner.add.get', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@getAddBanner']);
                        Route::post('add', ['as' => 'tf.m.c.sample.project.build.banner.add.post', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@postAddBanner']);

                        // set position
                        Route::get('set-position/{bannerId?}/{topPosition?}/{leftPosition?}/{zIndex?}', ['as' => 'tf.m.c.sample.project.build.banner.position.set', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@setPositionBanner']);

                        // delete
                        Route::get('setup-delete/{bannerId?}', ['as' => 'tf.m.c.sample.project.build.banner.delete', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@deleteBanner']);

                        Route::get('/{projectId?}', ['as' => 'tf.m.c.sample.project.build.banner', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@buildProjectBanner']);
                    });

                });

                //finish build
                Route::get('finish-build/{projectId?}', ['as' => 'tf.m.c.sample.project.build.finish', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@finishBuild']);

                //publish
                Route::get('publish/yes/{projectId?}', ['as' => 'tf.m.c.sample.project.build.publish.yes', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@publishYes']);
                Route::get('publish/no/{projectId?}', ['as' => 'tf.m.c.sample.project.build.publish.no', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@publishNo']);

                // update status
                Route::get('status/{projectId?}/{status?}', ['as' => 'tf.m.c.sample.project.status', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@statusUpdate']);
                // delete
                Route::get('delete/{projectId?}', ['as' => 'tf.m.c.sample.project.delete', 'uses' => 'Manage\Content\Sample\Project\ProjectSampleController@deleteProject']);
            });

            //----------- ---------- public sample ----------- ----------
            Route::group(['prefix' => 'public'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.public.list', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@index']);
                //view
                Route::get('view/{sampleId?}', ['as' => 'tf.m.c.sample.public.view', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@viewSample']);

                // Filter
                Route::get('filter/{typeId?}', ['as' => 'tf.m.c.sample.public.filter', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@getFilter']);
                // select manage staff
                Route::get('add/select-image/{sizeId?}', ['as' => 'tf.m.c.sample.public.image.select', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@selectImage']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.public.add.get', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.public.add.post', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@postAdd']);
                // edit info
                Route::get('edit/{sampleId?}', ['as' => 'tf.m.c.sample.public.edit.get', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@getEdit']);
                Route::post('edit/{sampleId?}', ['as' => 'tf.m.c.sample.public.edit.post', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@postEdit']);
                // update status
                Route::get('status/{sampleId?}/{status?}', ['as' => 'tf.m.c.sample.public.status', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@statusUpdate']);
                // delete
                Route::get('delete/{sampleId?}', ['as' => 'tf.m.c.sample.public.delete', 'uses' => 'Manage\Content\Sample\Publics\PublicSampleController@deleteSample']);
            });

            //----------- ---------- Public type ----------- ----------
            Route::group(['prefix' => 'public-type'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.public-type.list', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@index']);
                //view
                Route::get('view/{typeId?}', ['as' => 'tf.m.c.sample.public-type.view', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@viewPublicType']);

                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.public-type.add.get', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.public-type.add.post', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@postAdd']);
                // edit info
                Route::get('edit/{typeId?}', ['as' => 'tf.m.c.sample.public-type.edit.get', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@getEdit']);
                Route::post('edit/{typeId?}', ['as' => 'tf.m.c.sample.public-type.edit.post', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@postEdit']);
                // update status
                Route::get('status/{typeId?}', ['as' => 'tf.m.c.sample.public-type.status', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@statusUpdate']);
                // delete
                Route::get('delete/{typeId?}', ['as' => 'tf.m.c.sample.public-type.delete', 'uses' => 'Manage\Content\Sample\PublicType\PublicTypeController@deletePublicType']);
            });

            //----------- ---------- size ----------- ----------
            Route::group(['prefix' => 'size'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.size.list', 'uses' => 'Manage\Content\Sample\Size\SizeController@index']);
                //view
                Route::get('view/{sizeId?}', ['as' => 'tf.m.c.sample.size.view', 'uses' => 'Manage\Content\Sample\Size\SizeController@viewSize']);
                // Filter
                Route::get('filter/{standardId?}', ['as' => 'tf.m.c.sample.size.filter', 'uses' => 'Manage\Content\Sample\Size\SizeController@getFilter']);
                // add new
                Route::get('add', ['as' => 'tf.m.c.sample.size.add.get', 'uses' => 'Manage\Content\Sample\Size\SizeController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.sample.size.add.post', 'uses' => 'Manage\Content\Sample\Size\SizeController@postAdd']);
                // edit info
                Route::get('edit/{sizeId?}', ['as' => 'tf.m.c.sample.size.edit.get', 'uses' => 'Manage\Content\Sample\Size\SizeController@getEdit']);
                Route::post('edit/{sizeId?}', ['as' => 'tf.m.c.sample.size.edit.post', 'uses' => 'Manage\Content\Sample\Size\SizeController@postEdit']);
                // update status
                Route::get('status/{sizeId?}', ['as' => 'tf.m.c.sample.size.status', 'uses' => 'Manage\Content\Sample\Size\SizeController@statusUpdate']);
                // delete
                Route::get('delete/{sizeId?}', ['as' => 'tf.m.c.sample.size.delete', 'uses' => 'Manage\Content\Sample\Size\SizeController@deleteSize']);
            });

            //----------- ---------- standard ----------- ----------
            Route::group(['prefix' => 'standard'], function () {
                // list
                Route::get('list', ['as' => 'tf.m.c.sample.standard.list', 'uses' => 'Manage\Content\Sample\Standard\StandardController@index']);
                // update status
                Route::get('status/{standardId?}', ['as' => 'tf.m.c.sample.standard.status', 'uses' => 'Manage\Content\Sample\Standard\StandardController@updateStatus']);
            });

            Route::get('/{object?}', ['as' => 'tf.m.c.sample', 'uses' => 'Manage\Content\ContentController@getSample']);
        });

        ##=========== ===========   HELP PAGE ========== ===========
        Route::group(['prefix' => 'help', 'middleware' => 'ContentHelpMiddleware'], function () {
            //---------- object ----------
            Route::group(['prefix' => 'object'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.help.object.list.get', 'uses' => 'Manage\Content\Help\Object\ObjectController@getList']);

                //add new
                Route::get('add', ['as' => 'tf.m.c.help.object.add.get', 'uses' => 'Manage\Content\Help\Object\ObjectController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.help.object.add.post', 'uses' => 'Manage\Content\Help\Object\ObjectController@postAdd']);

                //view
                Route::get('view/{objectId?}', ['as' => 'tf.m.c.help.object.view.get', 'uses' => 'Manage\Content\Help\Object\ObjectController@getView']);

                //edit
                Route::get('edit/{objectId?}', ['as' => 'tf.m.c.help.object.edit.get', 'uses' => 'Manage\Content\Help\Object\ObjectController@getEdit']);
                Route::post('edit/{objectId?}', ['as' => 'tf.m.c.help.object.edit.post', 'uses' => 'Manage\Content\Help\Object\ObjectController@postEdit']);

                //delete
                Route::get('delete/{objectId?}', ['as' => 'tf.m.c.help.object.delete', 'uses' => 'Manage\Content\Help\Object\ObjectController@getDelete']);
            });

            //---------- action ----------
            Route::group(['prefix' => 'action'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.help.action.list.get', 'uses' => 'Manage\Content\Help\Action\ActionController@getList']);

                //add new
                Route::get('add', ['as' => 'tf.m.c.help.action.add.get', 'uses' => 'Manage\Content\Help\Action\ActionController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.help.action.add.post', 'uses' => 'Manage\Content\Help\Action\ActionController@postAdd']);

                //view
                Route::get('view/{actionId?}', ['as' => 'tf.m.c.help.action.view.get', 'uses' => 'Manage\Content\Help\Action\ActionController@getView']);

                //edit
                Route::get('edit/{actionId?}', ['as' => 'tf.m.c.help.action.edit.get', 'uses' => 'Manage\Content\Help\Action\ActionController@getEdit']);
                Route::post('edit/{actiontId?}', ['as' => 'tf.m.c.help.action.edit.post', 'uses' => 'Manage\Content\Help\Action\ActionController@postEdit']);

                //delete
                Route::get('delete/{actionId?}', ['as' => 'tf.m.c.help.action.delete', 'uses' => 'Manage\Content\Help\Action\ActionController@getDelete']);
            });

            //---------- detail ----------
            Route::group(['prefix' => 'detail'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.help.detail.list.get', 'uses' => 'Manage\Content\Help\Detail\DetailController@getList']);

                //add new
                Route::get('add', ['as' => 'tf.m.c.help.detail.add.get', 'uses' => 'Manage\Content\Help\Detail\DetailController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.help.detail.add.post', 'uses' => 'Manage\Content\Help\Detail\DetailController@postAdd']);

                //view
                Route::get('view/{actionId?}', ['as' => 'tf.m.c.help.detail.view.get', 'uses' => 'Manage\Content\Help\Detail\DetailController@getView']);

                //edit
                Route::get('edit/{actionId?}', ['as' => 'tf.m.c.help.detail.edit.get', 'uses' => 'Manage\Content\Help\Detail\DetailController@getEdit']);
                Route::post('edit/{actionId?}', ['as' => 'tf.m.c.help.detail.edit.post', 'uses' => 'Manage\Content\Help\Detail\DetailController@postEdit']);

                //delete
                Route::get('delete/{actiontId?}', ['as' => 'tf.m.c.help.detail.delete', 'uses' => 'Manage\Content\Help\Detail\DetailController@getDelete']);
            });

            //---------- content ----------
            Route::group(['prefix' => 'content'], function () {
                //list
                Route::get('list', ['as' => 'tf.m.c.help.content.list.get', 'uses' => 'Manage\Content\Help\Content\ContentController@getList']);

                //add new
                Route::get('add', ['as' => 'tf.m.c.help.content.add.get', 'uses' => 'Manage\Content\Help\Content\ContentController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.help.content.add.post', 'uses' => 'Manage\Content\Help\Content\ContentController@postAdd']);

                //view
                Route::get('view/{actionId?}', ['as' => 'tf.m.c.help.content.view.get', 'uses' => 'Manage\Content\Help\Content\ContentController@getView']);

                //edit
                Route::get('edit/{actionId?}', ['as' => 'tf.m.c.help.content.edit.get', 'uses' => 'Manage\Content\Help\Content\ContentController@getEdit']);
                Route::post('edit/{actionId?}', ['as' => 'tf.m.c.help.content.edit.post', 'uses' => 'Manage\Content\Help\Content\ContentController@postEdit']);

                //delete
                Route::get('delete/{actiontId?}', ['as' => 'tf.m.c.help.content.delete', 'uses' => 'Manage\Content\Help\Content\ContentController@getDelete']);
            });

            Route::get('/{object?}', ['as' => 'tf.m.c.help', 'uses' => 'Manage\Content\ContentController@getHelp']);
        });

        ##=========== ===========   ADS PAGE ========== ===========
        Route::group(['prefix' => 'ads', 'middleware' => 'ContentAdsMiddleware'], function () {
            ###----------- ---------- PAGE ----------- ----------
            Route::group(['prefix' => 'page'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.ads.page.list', 'uses' => 'Manage\Content\Ads\Page\PageController@index']);
                //view
                Route::get('view/{pageId?}', ['as' => 'tf.m.c.ads.page.view', 'uses' => 'Manage\Content\Ads\Page\PageController@viewPage']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.ads.page.add.get', 'uses' => 'Manage\Content\Ads\Page\PageController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.ads.page.add.post', 'uses' => 'Manage\Content\Ads\Page\PageController@postAdd']);
                //Edit info
                Route::get('edit/{pageId?}', ['as' => 'tf.m.c.ads.page.edit.get', 'uses' => 'Manage\Content\Ads\Page\PageController@getEdit']);
                Route::post('edit/{pageId?}', ['as' => 'tf.m.c.ads.page.edit.post', 'uses' => 'Manage\Content\Ads\Page\PageController@postEdit']);

                //update Status
                Route::get('status/{pageId?}', ['as' => 'tf.m.c.ads.page.status', 'uses' => 'Manage\Content\Ads\Page\PageController@statusUpdate']);

                // Delete
                Route::get('delete/{pageId?}', ['as' => 'tf.m.c.ads.page.delete', 'uses' => 'Manage\Content\Ads\Page\PageController@deletePage']);
            });

            ###----------- ---------- POSITION ----------- ----------
            Route::group(['prefix' => 'position'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.ads.position.list', 'uses' => 'Manage\Content\Ads\Position\PositionController@index']);
                //view
                Route::get('view/{pageId?}', ['as' => 'tf.m.c.ads.position.view', 'uses' => 'Manage\Content\Ads\Position\PositionController@viewPosition']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.ads.position.add.get', 'uses' => 'Manage\Content\Ads\Position\PositionController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.ads.position.add.post', 'uses' => 'Manage\Content\Ads\Position\PositionController@postAdd']);
                //Edit info
                Route::get('edit/{positionId?}', ['as' => 'tf.m.c.ads.position.edit.get', 'uses' => 'Manage\Content\Ads\Position\PositionController@getEdit']);
                Route::post('edit/{positionId?}', ['as' => 'tf.m.c.ads.position.edit.post', 'uses' => 'Manage\Content\Ads\Position\PositionController@postEdit']);

                //update Status
                Route::get('status/{positionId?}', ['as' => 'tf.m.c.ads.position.status', 'uses' => 'Manage\Content\Ads\Position\PositionController@statusUpdate']);

                // Delete
                Route::get('delete/{positionId?}', ['as' => 'tf.m.c.ads.position.delete', 'uses' => 'Manage\Content\Ads\Position\PositionController@deletePosition']);
            });

            ###----------- ---------- BANNER ----------- ----------
            Route::group(['prefix' => 'banner'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.ads.banner.list', 'uses' => 'Manage\Content\Ads\Banner\BannerController@index']);
                //view
                Route::get('view/{bannerId?}', ['as' => 'tf.m.c.ads.banner.view', 'uses' => 'Manage\Content\Ads\Banner\BannerController@viewBanner']);

                //Add new
                Route::get('add/width/{positionId?}', ['as' => 'tf.m.c.ads.banner.add.width.get', 'uses' => 'Manage\Content\Ads\Banner\BannerController@getPositionWidth']);
                Route::get('add', ['as' => 'tf.m.c.ads.banner.add.get', 'uses' => 'Manage\Content\Ads\Banner\BannerController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.ads.banner.add.post', 'uses' => 'Manage\Content\Ads\Banner\BannerController@postAdd']);

                //Edit info
                Route::get('edit/{bannerId?}', ['as' => 'tf.m.c.ads.banner.edit.get', 'uses' => 'Manage\Content\Ads\Banner\BannerController@getEdit']);
                Route::post('edit/{bannerId?}', ['as' => 'tf.m.c.ads.banner.edit.post', 'uses' => 'Manage\Content\Ads\Banner\BannerController@postEdit']);

                //update Status
                Route::get('status/{bannerId?}', ['as' => 'tf.m.c.ads.banner.status', 'uses' => 'Manage\Content\Ads\Banner\BannerController@statusUpdate']);

                // Delete
                Route::get('delete/{bannerId?}', ['as' => 'tf.m.c.ads.banner.delete', 'uses' => 'Manage\Content\Ads\Banner\BannerController@deleteBanner']);
            });
            ###----------- ---------- BANNER IMAGE ----------- ----------
            Route::group(['prefix' => 'banner-image'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.ads.banner-image.list', 'uses' => 'Manage\Content\Ads\BannerImage\AdsBannerImageController@index']);
                //view
                Route::get('view/{imageId?}', ['as' => 'tf.m.c.ads.banner-image.view', 'uses' => 'Manage\Content\Ads\BannerImage\AdsBannerImageController@viewBannerImage']);
                // Delete
                Route::get('delete/{imageId?}', ['as' => 'tf.m.c.ads.banner-image.delete', 'uses' => 'Manage\Content\Ads\BannerImage\AdsBannerImageController@deleteBannerImage']);
            });

            Route::get('/{object?}', ['as' => 'tf.m.c.ads', 'uses' => 'Manage\Content\ContentController@getAds']);
        });
        //end ads field

        ##=========== ===========   AFFILIATE PAGE ========== ===========
        Route::group(['prefix' => 'affiliate', 'middleware' => 'ContentSellerMiddleware'], function () {
            ###----------- ---------- Guide-object ----------- ----------
            Route::group(['prefix' => 'guide-object'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.seller.guide.object.list', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@index']);
                //view
                Route::get('view/{objectId?}', ['as' => 'tf.m.c.seller.guide-object.view', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@viewDetail']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.seller.guide-object.add.get', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.seller.guide-object.add.post', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@postAdd']);
                //Edit info
                Route::get('edit/{objectId?}', ['as' => 'tf.m.c.seller.guide-object.edit.get', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@getEdit']);
                Route::post('edit/{objectId?}', ['as' => 'tf.m.c.seller.guide-object.edit.post', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@postEdit']);

                //update Status
                Route::get('status/{objectId?}', ['as' => 'tf.m.c.seller.guide-object.status', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@statusUpdate']);

                // Delete
                Route::get('delete/{objectId?}', ['as' => 'tf.m.c.seller.guide-object.delete', 'uses' => 'Manage\Content\Seller\GuideObject\GuideObjectController@deleteObject']);
            });

            ###----------- ---------- Guide ----------- ----------
            Route::group(['prefix' => 'guide'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.seller.guide.list', 'uses' => 'Manage\Content\Seller\Guide\GuideController@index']);
                //view
                Route::get('view/{objectId?}', ['as' => 'tf.m.c.seller.guide.view', 'uses' => 'Manage\Content\Seller\Guide\GuideController@viewDetail']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.seller.guide.add.get', 'uses' => 'Manage\Content\Seller\Guide\GuideController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.seller.guide.add.post', 'uses' => 'Manage\Content\Seller\Guide\GuideController@postAdd']);
                //Edit info
                Route::get('edit/{objectId?}', ['as' => 'tf.m.c.seller.guide.edit.get', 'uses' => 'Manage\Content\Seller\Guide\GuideController@getEdit']);
                Route::post('edit/{objectId?}', ['as' => 'tf.m.c.seller.guide.edit.post', 'uses' => 'Manage\Content\Seller\Guide\GuideController@postEdit']);

                //update Status
                Route::get('status/{objectId?}', ['as' => 'tf.m.c.seller.guide.status', 'uses' => 'Manage\Content\Seller\Guide\GuideController@statusUpdate']);

                // Delete
                Route::get('delete/{objectId?}', ['as' => 'tf.m.c.seller.guide.delete', 'uses' => 'Manage\Content\Seller\Guide\GuideController@deleteGuide']);
            });

            ###----------- ---------- Guide-payment-price ----------- ----------
            Route::group(['prefix' => 'payment-price'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.seller.payment-price.list', 'uses' => 'Manage\Content\Seller\PaymentPrice\PaymentPriceController@index']);
                //view
                Route::get('view/{objectId?}', ['as' => 'tf.m.c.seller-payment.price.view', 'uses' => 'Manage\Content\Seller\PaymentPrice\PaymentPriceController@viewDetail']);

                //Add new
                Route::get('add', ['as' => 'tf.m.c.seller.payment-price.add.get', 'uses' => 'Manage\Content\Seller\PaymentPrice\PaymentPriceController@getAdd']);
                Route::post('add', ['as' => 'tf.m.c.seller.payment-price.add.post', 'uses' => 'Manage\Content\Seller\PaymentPrice\PaymentPriceController@postAdd']);

            });

            ###----------- ---------- Seller ----------- ----------
            Route::group(['prefix' => 'affiliate'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.seller.seller.list', 'uses' => 'Manage\Content\Seller\Seller\SellerController@index']);
                //view
                Route::get('view/{sellerId?}', ['as' => 'tf.m.c.seller.seller.view', 'uses' => 'Manage\Content\Seller\Seller\SellerController@viewDetail']);

                //update Status
                Route::get('status/{sellerId?}', ['as' => 'tf.m.c.seller.seller.status', 'uses' => 'Manage\Content\Seller\Seller\SellerController@statusUpdate']);

                // Delete
                Route::get('delete/{sellerId?}', ['as' => 'tf.m.c.seller.seller.delete', 'uses' => 'Manage\Content\Seller\Seller\SellerController@deleteSeller']);
            });

            ###----------- ---------- Payment ----------- ----------
            Route::group(['prefix' => 'payment'], function () {
                // List
                Route::get('list', ['as' => 'tf.m.c.seller.payment.list', 'uses' => 'Manage\Content\Seller\Payment\PaymentController@index']);
                // List
                Route::get('filter/{payStatus?}/{code?}', ['as' => 'tf.m.c.seller.payment.filter', 'uses' => 'Manage\Content\Seller\Payment\PaymentController@getFilter']);
                //view
                Route::get('view/{paymentId?}', ['as' => 'tf.m.c.seller.payment.view', 'uses' => 'Manage\Content\Seller\Payment\PaymentController@viewDetail']);

                //confirm
                Route::get('confirm/{paymentId?}', ['as' => 'tf.m.c.seller.payment.confirm', 'uses' => 'Manage\Content\Seller\Payment\PaymentController@confirmPay']);

            });

            Route::get('/{object?}', ['as' => 'tf.m.c.seller', 'uses' => 'Manage\Content\ContentController@getSeller']);
        });
        //end seller field
    });

    Route::get('/{name?}', ['as' => 'tf.m.index', 'uses' => 'Manage\ManageController@index']);
});


//===================================================================================================
//----------- ----------- ---------- ------------ FRONT END --------- --------- --------- ----------

//===================================================================================================

#======== ========== =========== REGISTER PAGE ========== ========== ==========
Route::group(['prefix' => 'register'], function () {
    //facebook
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('redirect', ['as' => 'tf.register.facebook.get', 'uses' => 'Register\SocialiteController@redirectToProviderFacebook']);
        Route::get('callback', ['as' => 'tf.register.facebook.callback', 'uses' => 'Register\SocialiteController@handleProviderCallbackFacebook']);
        Route::post('connect', ['as' => 'tf.register.facebook.connect', 'uses' => 'Register\SocialiteController@handleProviderConnectFacebook']);
    });

    //google
    Route::group(['prefix' => 'google'], function () {
        Route::get('redirect', ['as' => 'tf.register.google.get', 'uses' => 'Register\SocialiteController@redirectToProviderGoogle']);
        Route::get('callback', ['as' => 'tf.register.google.callback', 'uses' => 'Register\SocialiteController@handleProviderCallbackGoogle']);
        Route::post('connect', ['as' => 'tf.register.google.connect', 'uses' => 'Register\SocialiteController@handleProviderConnectGoogle']);
    });

    // verify account
    Route::get('verify/{nameCode?}', ['as' => 'tf.register.account.verify', 'uses' => 'Register\RegisterController@verifyAccount']);

    // new register
    Route::get('/{fromObject?}/{fromObjectId?}', ['as' => 'tf.register.get', 'uses' => 'Register\RegisterController@getRegister']);
    Route::post('/', ['as' => 'tf.register.post', 'uses' => 'Register\RegisterController@postRegister']);
});

#========== ========== ========== LOGIN ========== ========== ==========
Route::group(['prefix' => 'login'], function () {
    //check login status
    Route::get('status', ['as' => 'tf.login.status.check', 'uses' => 'Login\LoginController@checkStatus']);

    //forget password
    Route::get('forget-password', ['as' => 'tf.login.forget-pass.get', 'uses' => 'Login\LoginController@getForgetPassword']);
    Route::post('forget-password', ['as' => 'tf.login.forget-pass.post', 'uses' => 'Login\LoginController@postForgetPassword']);

    // login
    Route::get('form/{returnUrl?}', ['as' => 'tf.login.get', 'uses' => 'Login\LoginController@getLogin']);
    //Route::post('/', ['as' => 'tf.login.post', 'uses' => 'Login\LoginController@postLogin']);

    //---temporary solution
    Route::get('/{account?}/{password?}', ['as' => 'tf.login.post', 'uses' => 'Login\LoginController@postLogin']);
});

#========== ========== ========== LOGOUT ========== ========== ==========
Route::group(['prefix' => 'logout'], function () {
    Route::get('/', ['as' => 'tf.logout.get', 'uses' => 'MainController@logout']);
});

#========== ========== ========== USER PAGE ========= ========= ==========
Route::group(['prefix' => 'user'], function () {


    ##----------- ----------- Activity ----------- -----------
    Route::group(['prefix' => 'activity'], function () {
        Route::group(['prefix' => 'post'], function () {
            //comment
            Route::group(['prefix' => 'comment'], function () {
                //view more
                Route::get('more/{postId?}/{take?}/{dateTake?}', ['as' => 'tf.user.activity.post.comment.more.get', 'uses' => 'User\Activity\Post\Comment\PostCommentController@moreComment']);
                //add
                Route::post('add/{postId?}', ['as' => 'tf.user.activity.post.comment.add.post', 'uses' => 'User\Activity\Post\Comment\PostCommentController@postAddComment']);
                //edit
                Route::get('edit/{commentId?}', ['as' => 'tf.user.activity.post.comment.edit.get', 'uses' => 'User\Activity\Post\Comment\PostCommentController@getEditComment']);
                Route::post('edit/{commentId?}', ['as' => 'tf.user.activity.post.comment.edit.post', 'uses' => 'User\Activity\Post\Comment\PostCommentController@postEditComment']);

                //delete
                Route::get('delete/{commentId?}', ['as' => 'tf.user.activity.post.comment.delete', 'uses' => 'User\Activity\Post\Comment\PostCommentController@deleteComment']);
            });
            //detail
            Route::get('/{code?}', ['as' => 'tf.user.activity.post.detail.get', 'uses' => 'User\Activity\Post\PostController@detailInfo']);
            //full image
            Route::get('view-image/{postId?}', ['as' => 'tf.user.activity.post.image.view.get', 'uses' => 'User\Activity\Post\PostController@viewImage']);
            //love
            Route::get('love/{postId?}/{loveStatus?}', ['as' => 'tf.user.activity.post.love', 'uses' => 'User\Activity\Post\PostController@lovePost']);

            //add
            Route::get('add/{userWallId?}', ['as' => 'tf.user.activity.form_post.get', 'uses' => 'User\Activity\Post\PostController@getPostForm']);
            Route::post('add/{userWallId?}', ['as' => 'tf.user.activity.form_post.post', 'uses' => 'User\Activity\Post\PostController@addPost']);

            //edit
            Route::get('edit/{postId?}', ['as' => 'tf.user.activity.post.edit.get', 'uses' => 'User\Activity\Post\PostController@getEditPost']);
            Route::post('edit/{postId?}', ['as' => 'tf.user.activity.post.edit.post', 'uses' => 'User\Activity\Post\PostController@postEditPost']);

            //delete
            Route::get('delete/{postId?}', ['as' => 'tf.user.activity.post.delete', 'uses' => 'User\Activity\Post\PostController@deletePost']);
        });

        //comment
        Route::group(['prefix' => 'comment'], function () {
            //view more
            Route::get('more/{activityId?}/{take?}/{dateTake?}', ['as' => 'tf.user.activity.comment.more.get', 'uses' => 'User\Activity\Comment\ActivityCommentController@moreComment']);
            //add
            Route::post('add/{activityId?}', ['as' => 'tf.user.activity.comment.add.post', 'uses' => 'User\Activity\Comment\ActivityCommentController@postAddComment']);
            //edit
            Route::get('edit/{commentId?}', ['as' => 'tf.user.activity.comment.edit.get', 'uses' => 'User\Activity\Comment\ActivityCommentController@getEditComment']);
            Route::post('edit/{commentId?}', ['as' => 'tf.user.activity.comment.edit.post', 'uses' => 'User\Activity\Comment\ActivityCommentController@postEditComment']);

            //delete
            Route::get('delete/{commentId?}', ['as' => 'tf.user.activity.comment.delete', 'uses' => 'User\Activity\Comment\ActivityCommentController@deleteComment']);
        });
        //love
        Route::get('love/{postId?}/{loveStatus?}', ['as' => 'tf.user.activity.love', 'uses' => 'User\Activity\ActivityController@love']);

        //activity info
        Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.activity.more.get', 'uses' => 'User\Activity\ActivityController@moreActivity']);
        Route::get('/{alias?}', ['as' => 'tf.user.activity.get', 'uses' => 'User\Activity\ActivityController@index']);
    });

    ##----------- ----------- banner on profile ----------- -----------
    Route::group(['prefix' => 'title'], function () {
        ###----------- Banner ----------
        Route::group(['prefix' => 'banner'], function () {
            // Edit banner
            Route::get('edit', ['as' => 'tf.user.title.banner.edit.get', 'uses' => 'User\UserController@getTitleBanner']);
            Route::post('edit', ['as' => 'tf.user.title.banner.edit.post', 'uses' => 'User\UserController@postTitleBanner']);

            //view
            Route::get('view/{imageId?}', ['as' => 'tf.user.title.banner.view.get', 'uses' => 'User\UserController@viewDetailTitleBanner']);
            // delete
            Route::get('delete/{imageId?}', ['as' => 'tf.user.title.banner.delete.get', 'uses' => 'User\UserController@deleteTitleBanner']);
        });
        ###----------- Avatar ----------
        Route::group(['prefix' => 'avatar'], function () {
            // Edit banner
            Route::get('edit', ['as' => 'tf.user.title.avatar.edit.get', 'uses' => 'User\UserController@getTitleAvatar']);
            Route::post('edit', ['as' => 'tf.user.title.avatar.edit.post', 'uses' => 'User\UserController@postTitleAvatar']);

            //view
            Route::get('view/{imageId?}', ['as' => 'tf.user.title.avatar.view.get', 'uses' => 'User\UserController@viewDetailAvatar']);
            // delete
            Route::get('delete/{imageId?}', ['as' => 'tf.user.title.avatar.delete.get', 'uses' => 'User\UserController@deleteTitleAvatar']);
        });
    });

    ##----------- ----------- love user ----------- -----------
    Route::group(['prefix' => 'love'], function () {
        Route::get('plus/{loveUserId?}', ['as' => 'tf.user.friend.love.plus', 'uses' => 'User\UserController@plusLoveUser']);
        Route::get('minus/{loveUserId?}', ['as' => 'tf.user.friend.love.minus', 'uses' => 'User\UserController@minusLoveUser']);
    });

    ##----------- ----------- info ----------- -----------
    Route::group(['prefix' => 'info'], function () {
        // basic info
        Route::get('basic', ['as' => 'tf.user.info.basic.edit.get', 'uses' => 'User\Information\InformationController@getInfoBasicEdit']);
        Route::post('basic', ['as' => 'tf.user.info.basic.edit.post', 'uses' => 'User\Information\InformationController@postInfoBasicEdit']);

        // contact info
        Route::get('contact/province/{countryId?}', ['as' => 'tf.user.info.contact.province.get', 'uses' => 'User\Information\InformationController@contactGetProvince']);
        Route::get('contact', ['as' => 'tf.user.info.contact.edit.get', 'uses' => 'User\Information\InformationController@getInfoContactEdit']);
        Route::post('contact', ['as' => 'tf.user.info.contact.edit.post', 'uses' => 'User\Information\InformationController@postInfoContactEdit']);

        // account
        Route::get('password', ['as' => 'tf.user.info.password.edit.get', 'uses' => 'User\Information\InformationController@getInfoPasswordEdit']);
        Route::post('password', ['as' => 'tf.user.info.password.edit.post', 'uses' => 'User\Information\InformationController@postInfoPasswordEdit']);

        // user info
        Route::get('/{userId?}', ['as' => 'tf.user.info.get', 'uses' => 'User\Information\InformationController@index']);
    });

    ##----------- ----------- image ----------- -----------
    Route::group(['prefix' => 'image'], function () {
        // all image
        Route::group(['prefix' => 'all'], function () {
            //view more comment
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.image.all.more', 'uses' => 'User\Image\ImageController@moreAllImage']);

            //delete
            Route::get('delete/{imageId?}', ['as' => 'tf.user.image.all.delete', 'uses' => 'User\Image\ImageController@deleteAllImage']);
        });

        //avatar image
        Route::group(['prefix' => 'avatar'], function () {
            //view more
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.image.avatar.more', 'uses' => 'User\Image\ImageController@moreAvatarImage']);

            //delete
            Route::get('delete/{imageId?}', ['as' => 'tf.user.image.avatar.delete', 'uses' => 'User\Image\ImageController@deleteAvatarImage']);

            Route::get('/{userId?}', ['as' => 'tf.user.image.avatar.get', 'uses' => 'User\Image\ImageController@getAvatarImage']);
        });

        //avatar image
        Route::group(['prefix' => 'banner'], function () {
            //view more
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.image.banner.more', 'uses' => 'User\Image\ImageController@moreBannerImage']);

            //delete
            Route::get('delete/{imageId?}', ['as' => 'tf.user.image.banner.delete', 'uses' => 'User\Image\ImageController@deleteBannerImage']);

            Route::get('/{userId?}', ['as' => 'tf.user.image.banner.get', 'uses' => 'User\Image\ImageController@getBannerImage']);
        });

        //view image
        Route::get('view/{imageId?}', ['as' => 'tf.user.image.view.get', 'uses' => 'User\Image\ImageController@getViewImage']);

        Route::get('/{userId?}', ['as' => 'tf.user.image.get', 'uses' => 'User\Image\ImageController@index']);

    });

    ##----------- ----------- friend ----------- -----------
    Route::group(['prefix' => 'friend'], function () {
        // friend request
        Route::group(['prefix' => 'request'], function () {
            // sent request
            Route::group(['prefix' => 'sent'], function () {
                // view more
                Route::get('more/{skip?}/{take?}', ['as' => 'tf.user.friend.request.sent.more', 'uses' => 'User\Friend\FriendController@moreSentFriendRequest']);

                Route::get('/', ['as' => 'tf.user.friend.request.sent.list', 'uses' => 'User\Friend\FriendController@listSentFriendRequest']);
            });

            // received request
            Route::group(['prefix' => 'received'], function () {
                // view more
                Route::get('more/{skip?}/{take?}', ['as' => 'tf.user.friend.request.received.more', 'uses' => 'User\Friend\FriendController@moreReceivedFriendRequest']);

                // confirm friend request
                // agree
                Route::get('confirm/yes/{userId?}', ['as' => 'tf.user.friend.request.confirm.yes', 'uses' => 'User\Friend\FriendController@confirmFriendRequestYes']);
                // don't agree
                Route::get('confirm/no/{userId?}', ['as' => 'tf.user.friend.request.confirm.no', 'uses' => 'User\Friend\FriendController@confirmFriendRequestNo']);

                Route::get('/', ['as' => 'tf.user.friend.request.received', 'uses' => 'User\Friend\FriendController@listReceivedFriendRequest']);
            });

            // send friend request
            Route::get('send/{userId?}', ['as' => 'tf.user.friend.request.send', 'uses' => 'User\Friend\FriendController@sendFriendRequest']);

            // cancel request
            Route::get('cancel/{requestUserId?}', ['as' => 'tf.user.friend.request.cancel', 'uses' => 'User\Friend\FriendController@cancelFriendRequest']);

        });

        // lock user
        Route::get('lock/{userId?}', ['as' => 'tf.user.friend.lock.get', 'uses' => 'User\Friend\FriendController@getFriendLock']);

        // view more
        Route::get('more/{accessUserId?}/{skip?}/{take?}', ['as' => 'tf.user.friend.more', 'uses' => 'User\Friend\FriendController@moreFriend']);

        // delete friend
        Route::get('delete/{userId?}', ['as' => 'tf.user.friend.delete', 'uses' => 'User\Friend\FriendController@deleteFriend']);

        // get list
        Route::get('/{userId?}', ['as' => 'tf.user.friend.list', 'uses' => 'User\Friend\FriendController@index']);
    });

    ##----------- ----------- building ----------- -----------
    Route::group(['prefix' => 'building'], function () {
        // view more
        Route::get('more/{accessUserId?}/{skip?}/{take?}', ['as' => 'tf.user.building.more', 'uses' => 'User\Building\BuildingController@moreBuilding']);

        Route::get('/{userId?}', ['as' => 'tf.user.building.get', 'uses' => 'User\Building\BuildingController@index']);
    });

    ##----------- ----------- banner ----------- -----------
    Route::group(['prefix' => 'banner'], function () {
        Route::group(['prefix' => 'invited'], function () {
            //view more follow
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.banner.invited.more.get', 'uses' => 'User\Banner\BannerController@getMoreBannerInvited']);

            Route::get('cancel/{inviteId?}', ['as' => 'tf.user.banner.invited.cancel', 'uses' => 'User\Banner\BannerController@cancelInvited']);

            Route::get('/{userId?}', ['as' => 'tf.user.banner.invited.get', 'uses' => 'User\Banner\BannerController@getBannerInvited']);
        });

        // view more
        Route::get('more/{accessUserId?}/{skip?}/{take?}', ['as' => 'tf.user.banner.more', 'uses' => 'User\Banner\BannerController@moreBanner']);

        //list banner
        Route::get('/{userId?}', ['as' => 'tf.user.banner.get', 'uses' => 'User\Banner\BannerController@index']);
    });

    ##----------- ----------- land ----------- -----------
    Route::group(['prefix' => 'land'], function () {
        Route::group(['prefix' => 'invited'], function () {
            //view more follow
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.land.invited.more.get', 'uses' => 'User\Land\LandController@getMoreLandInvited']);

            Route::get('cancel/{inviteId?}', ['as' => 'tf.user.land.invited.cancel', 'uses' => 'User\Land\LandController@cancelInvited']);

            Route::get('/{userId?}', ['as' => 'tf.user.land.invited.get', 'uses' => 'User\Land\LandController@getLandInvited']);
        });

        // view more
        Route::get('more/{accessUserId?}/{skip?}/{take?}', ['as' => 'tf.user.land.more', 'uses' => 'User\Land\LandController@moreLand']);

        //list land
        Route::get('/{userId?}', ['as' => 'tf.user.land.get', 'uses' => 'User\Land\LandController@index']);
    });

    ##----------- ----------- Project ----------- -----------
    Route::group(['prefix' => 'project'], function () {
        Route::get('/{userId?}', ['as' => 'tf.user.project.get', 'uses' => 'User\UserController@getProject']);
    });

    ##----------- ----------- Follow ----------- -----------
    Route::group(['prefix' => 'follow'], function () {
        //view more follow
        Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.follow.more.get', 'uses' => 'User\Follow\FollowController@getMoreFollow']);

        Route::get('/{userId?}', ['as' => 'tf.user.follow.get', 'uses' => 'User\Follow\FollowController@index']);
    });

    ##----------- ----------- Share ----------- -----------
    Route::group(['prefix' => 'share'], function () {
        //share banner
        Route::group(['prefix' => 'banner'], function () {
            //detail share
            Route::get('detail/{shareId?}', ['as' => 'tf.user.share.banner.detail', 'uses' => 'User\Share\Banner\BannerShareController@getDetail']);
            //view more info
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.share.banner.more.get', 'uses' => 'User\Share\Banner\BannerShareController@getMoreBannerShare']);

            Route::get('/{userId?}', ['as' => 'tf.user.share.banner.get', 'uses' => 'User\Share\Banner\BannerShareController@index']);
        });

        //share land
        Route::group(['prefix' => 'land'], function () {
            //detail share
            Route::get('detail/{shareId?}', ['as' => 'tf.user.share.land.detail', 'uses' => 'User\Share\Land\LandShareController@getDetail']);

            //view more info
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.share.land.more.get', 'uses' => 'User\Share\Land\LandShareController@getMoreLandShare']);

            Route::get('/{userId?}', ['as' => 'tf.user.share.land.get', 'uses' => 'User\Share\Land\LandShareController@index']);
        });

        //share building
        Route::group(['prefix' => 'building'], function () {
            //detail share
            Route::get('detail/{shareId?}', ['as' => 'tf.user.share.building.detail', 'uses' => 'User\Share\Building\BuildingShareController@getDetail']);

            //view more info
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.share.building.more.get', 'uses' => 'User\Share\Building\BuildingShareController@getMoreBuildingShare']);

            Route::get('/{userId?}', ['as' => 'tf.user.share.building.get', 'uses' => 'User\Share\Building\BuildingShareController@index']);
        });

    });

    ##----------- ----------- Point ----------- -----------
    Route::group(['prefix' => 'point'], function () {
        //recharge
        Route::group(['prefix' => 'recharge'], function () {
            //detail share
            Route::get('detail/{rechargeId?}', ['as' => 'tf.user.point.recharge.detail', 'uses' => 'User\Point\Recharge\RechargeController@getDetail']);

            //view more info
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.point.recharge.more.get', 'uses' => 'User\Point\Recharge\RechargeController@getMoreRecharge']);

            Route::get('/{userId?}', ['as' => 'tf.user.point.recharge.get', 'uses' => 'User\Point\Recharge\RechargeController@index']);
        });

        //nganluong.vn
        Route::group(['prefix' => 'nganluong'], function () {
            //detail share
            Route::get('detail/{orderId?}', ['as' => 'tf.user.point.nganluong.detail', 'uses' => 'User\Point\NganLuong\NganLuongController@getDetail']);

            //view more info
            Route::get('more/{userId?}/{take?}/{dateTake?}', ['as' => 'tf.user.point.nganluong.more.get', 'uses' => 'User\Point\NganLuong\NganLuongController@getMoreNganLuong']);

            Route::get('/{userId?}', ['as' => 'tf.user.point.nganluong.get', 'uses' => 'User\Point\NganLuong\NganLuongController@index']);
        });

    });

    ##----------- ----------- Banner ----------- -----------
    Route::group(['prefix' => 'ads'], function () {
        Route::group(['prefix' => 'set-image'], function () {
            route::get('/{licenseName?}', ['as' => 'tf.user.ads.set-image.get', 'uses' => 'User\Ads\AdsBannerController@getSetImage']);
            route::post('/{licenseName?}', ['as' => 'tf.user.ads.set-image.post', 'uses' => 'User\Ads\AdsBannerController@postSetImage']);
        });
        // view more ads banner
        Route::get('more/{userId?}/{skip?}/{take?}', ['as' => 'tf.user.ads.more', 'uses' => 'User\Ads\AdsBannerController@moreAdsBanner']);

        //list Ads banner
        Route::get('/{userCode?}', ['as' => 'tf.user.ads.get', 'uses' => 'User\Ads\AdsBannerController@index']);
    });

    ##----------- ----------- Affiliate ----------- -----------
    Route::group(['prefix' => 'affiliate'], function () {

        //statistic
        Route::group(['prefix' => 'statistic'], function () {

            Route::get('view/{object?}/{fromDate?}/{toDate?}', ['as' => 'tf.user.seller.statistic.view', 'uses' => 'User\Seller\SellerController@getDetailStatistic']);

            Route::get('/', ['as' => 'tf.user.seller.statistic.get', 'uses' => 'User\Seller\SellerController@getStatistic']);
        });

        //payment
        Route::group(['prefix' => 'payment'], function () {
            Route::get('view/{code?}', ['as' => 'tf.user.seller.payment.view', 'uses' => 'User\Seller\SellerController@getDetailPayment']);
            Route::get('view-more/{object?}/{fromDate?}/{toDate?}', ['as' => 'tf.user.seller.payment.view.more', 'uses' => 'User\Seller\SellerController@getDetailPaymentMore']);
            //view more info
            Route::get('more/{take?}/{dateTake?}', ['as' => 'tf.user.seller.payment.more.get', 'uses' => 'User\Seller\SellerController@getMorePayment']);

            Route::get('/', ['as' => 'tf.user.seller.payment.get', 'uses' => 'User\Seller\SellerController@getPayment']);
        });

    });


    Route::get('/{alias?}', ['as' => 'tf.user.home', 'uses' => 'User\UserController@index']);
});

#========== ========== ========== SYSTEM PAGE ========= ========= ==========
Route::group(['prefix' => '3dtf'], function () {
    //about
    Route::group(['prefix' => 'about'], function () {
        Route::get('/', ['as' => 'tf.system.about.get', 'uses' => 'System\SystemController@getAbout']);
    });

    //notify
    Route::group(['prefix' => 'notify'], function () {
        //view more
        Route::get('view-more/{take?}/{dateTake?}', ['as' => 'tf.system.notify.more.get', 'uses' => 'System\SystemController@getMoreNotify']);

        //detail
        Route::get('view/{notifyId?}', ['as' => 'tf.system.notify.view.get', 'uses' => 'System\SystemController@viewNotify']);

        Route::get('/', ['as' => 'tf.system.notify.get', 'uses' => 'System\SystemController@getNotify']);

    });

    //contact
    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', ['as' => 'tf.system.contact.get', 'uses' => 'System\SystemController@getContact']);
        // add contact
        Route::post('add', ['as' => 'tf.system.contact.add.post', 'uses' => 'System\SystemController@addContact']);
    });
});

#========== ========== ========== BUILDING PAGE ========== ========== ==========
Route::group(['prefix' => 'building'], function () {
    //information
    Route::group(['prefix' => 'information'], function () {
        //name
        Route::get('sample/{buildingId?}/{privateStatus?}', ['as' => 'tf.building.info.sample.edit.get', 'uses' => 'Building\Information\InformationController@getEditSample']);
        Route::get('sample-select/{buildingId?}/{sampleId?}', ['as' => 'tf.building.info.sample.edit.select', 'uses' => 'Building\Information\InformationController@changeSample']);

        //name
        Route::get('name/{buildingId?}', ['as' => 'tf.building.info.name.edit.get', 'uses' => 'Building\Information\InformationController@getEditName']);
        Route::post('name/{buildingId?}', ['as' => 'tf.building.info.name.edit.post', 'uses' => 'Building\Information\InformationController@postEditName']);

        //phone
        Route::get('phone/{buildingId?}', ['as' => 'tf.building.info.phone.edit.get', 'uses' => 'Building\Information\InformationController@getEditPhone']);
        Route::post('phone/{buildingId?}', ['as' => 'tf.building.info.phone.edit.post', 'uses' => 'Building\Information\InformationController@postEditPhone']);

        //email
        Route::get('email/{buildingId?}', ['as' => 'tf.building.info.email.edit.get', 'uses' => 'Building\Information\InformationController@getEditEmail']);
        Route::post('email/{buildingId?}', ['as' => 'tf.building.info.email.edit.post', 'uses' => 'Building\Information\InformationController@postEditEmail']);

        //website
        Route::get('website/{buildingId?}', ['as' => 'tf.building.info.website.edit.get', 'uses' => 'Building\Information\InformationController@getEditWebsite']);
        Route::post('website/{buildingId?}', ['as' => 'tf.building.info.website.edit.post', 'uses' => 'Building\Information\InformationController@postEditWebsite']);


        //address
        Route::get('address/{buildingId?}', ['as' => 'tf.building.info.address.edit.get', 'uses' => 'Building\Information\InformationController@getEditAddress']);
        Route::post('address/{buildingId?}', ['as' => 'tf.building.info.address.edit.post', 'uses' => 'Building\Information\InformationController@postEditAddress']);

        //short description
        Route::get('short-description/{buildingId?}', ['as' => 'tf.building.info.short-description.edit.get', 'uses' => 'Building\Information\InformationController@getEditShortDescription']);
        Route::post('short-description/{buildingId?}', ['as' => 'tf.building.info.short-description.edit.post', 'uses' => 'Building\Information\InformationController@postEditShortDescription']);

        //description
        Route::get('description/{buildingId?}', ['as' => 'tf.building.info.description.edit.get', 'uses' => 'Building\Information\InformationController@getEditDescription']);
        Route::post('description/{buildingId?}', ['as' => 'tf.building.info.description.edit.post', 'uses' => 'Building\Information\InformationController@postEditDescription']);


        Route::get('/{alias?}', ['as' => 'tf.building.information.get', 'uses' => 'Building\Information\InformationController@index']);
    });

    //report
    Route::group(['prefix' => 'report'], function () {
        Route::get('/{buildingId?}', ['as' => 'tf.building.report.bad-info.get', 'uses' => 'Building\BuildingController@getReport']);
        Route::post('/', ['as' => 'tf.building.report.bad-info.post', 'uses' => 'Building\BuildingController@sendReport']);
    });

    // banner of building
    Route::group(['prefix' => 'banner'], function () {
        // add banner
        Route::get('add/{buildingId?}', ['as' => 'tf.building.banner.add.get', 'uses' => 'Building\Banner\BuildingBannerController@getAddBanner']);
        Route::post('add/{buildingId?}', ['as' => 'tf.building.banner.add.post', 'uses' => 'Building\Banner\BuildingBannerController@postAddBanner']);

        //view
        Route::get('view/{bannerId?}', ['as' => 'tf.building.banner.view.get', 'uses' => 'Building\Banner\BuildingBannerController@viewFullBanner']);

        // delete
        Route::get('delete/{bannerId?}', ['as' => 'tf.building.banner.delete.get', 'uses' => 'Building\Banner\BuildingBannerController@deleteBanner']);
    });

    // love
    Route::group(['prefix' => 'love'], function () {
        Route::get('plus/{buildingId?}', ['as' => 'tf.building.love.plus', 'uses' => 'Building\BuildingController@plusLove']);
        Route::get('minus/{buildingId?}', ['as' => 'tf.building.love.minus', 'uses' => 'Building\BuildingController@minusLove']);
    });

    // visit
    Route::group(['prefix' => 'visit'], function () {
        Route::get('home/{buildingId?}', ['as' => 'tf.building.visit.home.plus', 'uses' => 'Building\BuildingController@plusVisitHome']);
        Route::get('website/{buildingId?}', ['as' => 'tf.building.visit.web.plus', 'uses' => 'Building\BuildingController@plusVisitWebsite']);
    });

    //follow
    Route::group(['prefix' => 'follow'], function () {
        Route::get('plus/{buildingId?}', ['as' => 'tf.building.follow.plus', 'uses' => 'Building\BuildingController@plusFollow']);
        Route::get('minus/{buildingId?}', ['as' => 'tf.building.follow.minus', 'uses' => 'Building\BuildingController@minusFollow']);
    });

    //posts
    Route::group(['prefix' => 'posts'], function () {
        //detail
        Route::get('detail/{postCode?}', ['as' => 'tf.building.posts.detail.get', 'uses' => 'Building\Posts\PostsController@detail']);

        //report
        Route::group(['prefix' => 'report'], function () {
            Route::get('/{postId?}', ['as' => 'tf.building.posts.report.get', 'uses' => 'Building\Posts\PostsController@getReport']);
            Route::post('/', ['as' => 'tf.building.posts.report.post', 'uses' => 'Building\Posts\PostsController@sendReport']);
        });

        //turn on\off highlight
        Route::get('highlight/{postId?}/{highlightStatus?}', ['as' => 'tf.building.posts.highlight.update', 'uses' => 'Building\Posts\PostsController@updateHighlight']);

        //grant to post
        Route::get('grant/{buildingId?}/{postsRelation?}', ['as' => 'tf.building.posts.grant', 'uses' => 'Building\Posts\PostsController@grantPost']);

        // introduction building
        Route::get('building-intro', ['as' => 'tf.building.posts.building-intro.get', 'uses' => 'Building\Posts\PostsController@getBuildingIntro']);

        //get form content
        Route::get('form-content/{buildingId?}', ['as' => 'tf.building.posts.add.form.get', 'uses' => 'Building\Posts\PostsController@getPostFormContent']);

        // add posts
        Route::post('add/{buildingId?}', ['as' => 'tf.building.posts.add.post', 'uses' => 'Building\Posts\PostsController@addPost']);

        // edit posts
        Route::group(['prefix' => 'edit'], function () {
            // introduction building
            Route::get('building-intro', ['as' => 'tf.building.posts.edit.building-intro.get', 'uses' => 'Building\Posts\PostsController@getEditBuildingIntro']);

            Route::get('/{postsId?}', ['as' => 'tf.building.posts.edit.get', 'uses' => 'Building\Posts\PostsController@getEditPost']);
            Route::post('post/{postsId?}', ['as' => 'tf.building.posts.edit.post', 'uses' => 'Building\Posts\PostsController@postEditPost']);
        });


        // love
        Route::group(['prefix' => 'love'], function () {
            Route::get('/{postsId?}/{loveStatus?}', ['as' => 'tf.building.posts.love', 'uses' => 'Building\Posts\PostsController@lovePost']);
        });

        // comment
        Route::group(['prefix' => 'comment'], function () {
            //edit
            Route::get('edit/{commentId?}', ['as' => 'tf.building.posts.comment.edit.get', 'uses' => 'Building\Posts\PostsController@getEditComment']);
            Route::post('edit/{commentId?}', ['as' => 'tf.building.posts.comment.edit.post', 'uses' => 'Building\Posts\PostsController@postEditComment']);

            //delete
            Route::get('delete/{commentId?}', ['as' => 'tf.building.posts.comment.delete', 'uses' => 'Building\Posts\PostsController@deleteComment']);

            // get more old comment
            Route::get('more/{postId?}/{take?}/{dateTake?}', ['as' => 'tf.building.posts.comment.more', 'uses' => 'Building\Posts\PostsController@moreComment']);

            Route::post('/{postsId?}', ['as' => 'tf.building.posts.comment.add.post', 'uses' => 'Building\Posts\PostsController@postAddComment']);
        });

        //view full image
        Route::get('view-image/{imageId?}', ['as' => 'tf.building.posts.image.view', 'uses' => 'Building\Posts\PostsController@viewPostImage']);

        //delete
        Route::get('delete/{postId?}', ['as' => 'tf.building.posts.delete', 'uses' => 'Building\Posts\PostsController@deletePost']);
    });
    Route::group(['prefix' => 'activity'], function () {
        // view more activity
        Route::get('more/{buildingId?}/{take?}/{dateTake?}', ['as' => 'tf.building.activity.more.get', 'uses' => 'Building\Activity\ActivityController@moreActivity']);

        Route::get('/{alias?}', ['as' => 'tf.building.activity', 'uses' => 'Building\Activity\ActivityController@index']);
    });

    //Service
    Route::group(['prefix' => 'services'], function () {
        //tool
        Route::group(['prefix' => 'tool'], function () {
            Route::group(['prefix' => 'article'], function () {
                //add
                Route::group(['prefix' => 'add'], function () {
                    Route::get('/{buildingId?}', ['as' => 'tf.building.services.article.add.get', 'uses' => 'Building\Services\ArticlesController@getAddArticle']);
                    Route::post('/{buildingId?}', ['as' => 'tf.building.services.article.add.post', 'uses' => 'Building\Services\ArticlesController@postAddArticle']);
                });
                //edit
                Route::group(['prefix' => 'edit'], function () {
                    Route::get('/{articleId?}', ['as' => 'tf.building.services.tool.article.edit.get', 'uses' => 'Building\Services\ArticlesController@getEditArticle']);
                    Route::post('/{articleId?}', ['as' => 'tf.building.services.tool.article.edit.post', 'uses' => 'Building\Services\ArticlesController@postEditArticle']);
                });
                //delete
                Route::get('delete/{articlesId?}', ['as' => 'tf.building.services.tool.article.delete', 'uses' => 'Building\Services\ArticlesController@deleteArticles']);
                //view more
                Route::get('more/{buildingId?}/{take?}/{takeDate?}/{typeId?}/{keyword?}', ['as' => 'tf.building.services.article.tool.view_more', 'uses' => 'Building\Services\ArticlesController@moreArticles']);
                //home
                Route::get('/{buildingId?}/{typeId?}/{keyword?}', ['as' => 'tf.building.services.article.tool.get', 'uses' => 'Building\Services\ArticlesController@articles']);
            });
            //add comment
            Route::group(['prefix' => 'detail-comment'], function () {
                Route::post('add', ['as' => 'tf.building.services.article.detail.comment.add', 'uses' => 'Building\Services\ArticlesController@addComment']);
                //edit
                Route::get('edit/{commentId?}', ['as' => 'tf.building.services.article.detail.comment.edit.get', 'uses' => 'Building\Services\ArticlesController@getEditComment']);
                Route::post('edit', ['as' => 'tf.building.services.article.detail.comment.edit.post', 'uses' => 'Building\Services\ArticlesController@saveEditComment']);

                //delete
                Route::get('delete/{commentId?}', ['as' => 'tf.building.services.article.detail.comment.delete', 'uses' => 'Building\Services\ArticlesController@deleteComment']);

                Route::get('more/{articlesId?}/{take?}/{takeDate?}', ['as' => 'tf.building.services.article.detail.comment.view_more', 'uses' => 'Building\Services\ArticlesController@moreComment']);
            });
            //love
            Route::group(['prefix' => 'love'], function () {
                Route::get('plus/{articlesId?}', ['as' => 'tf.building.services.article.love.plus', 'uses' => 'Building\Services\ArticlesController@loveArticles']);
                Route::get('minus/{articlesId?}', ['as' => 'tf.building.services.article.love.minus', 'uses' => 'Building\Services\ArticlesController@unLoveArticles']);
            });

            Route::group(['prefix' => 'embed'], function () {
                Route::get('share/{articlesId?}', ['as' => 'tf.building.services.article.detail.embed.share', 'uses' => 'Building\Services\ArticlesController@embedShareArticles']);
                Route::get('/{articleAlias?}', ['as' => 'tf.building.services.article.detail.embed', 'uses' => 'Building\Services\ArticlesController@embedArticles']);
            });

            Route::get('/{articleAlias?}', ['as' => 'tf.building.services.article.detail.get', 'uses' => 'Building\Services\ArticlesController@detailArticle']);
        });

        //edit
        Route::group(['prefix' => 'articles'], function () {
            //edit
            Route::group(['prefix' => 'edit'], function () {
                Route::get('/{articleId?}', ['as' => 'tf.building.services.article.edit.get', 'uses' => 'Building\Services\ServicesController@getEditArticle']);
                Route::post('/', ['as' => 'tf.building.services.article.edit.post', 'uses' => 'Building\Services\ServicesController@postEditArticle']);
            });
            //comment
            Route::group(['prefix' => 'comment'], function () {
                Route::post('add', ['as' => 'tf.building.services.article.comment.add', 'uses' => 'Building\Services\ServicesController@addComment']);
                //edit
                Route::get('edit/{commentId?}', ['as' => 'tf.building.services.article.comment.edit.get', 'uses' => 'Building\Services\ServicesController@getEditComment']);
                Route::post('edit', ['as' => 'tf.building.services.article.comment.edit.post', 'uses' => 'Building\Services\ServicesController@saveEditComment']);

                //delete
                Route::get('delete/{commentId?}', ['as' => 'tf.building.services.article.comment.delete', 'uses' => 'Building\Services\ServicesController@deleteComment']);

                Route::get('more/{articlesId?}/{take?}/{takeDate?}', ['as' => 'tf.building.services.article.comment.view_more', 'uses' => 'Building\Services\ServicesController@moreComment']);
            });
        });

        //delete
        Route::get('delete/{articlesId?}', ['as' => 'tf.building.services.article.delete', 'uses' => 'Building\Services\ServicesController@deleteArticles']);

        //view more
        Route::get('more/{buildingId?}/{take?}/{takeDate?}/{typeId?}/{keyword?}', ['as' => 'tf.building.services.view_more.get', 'uses' => 'Building\Services\ServicesController@moreArticles']);

        Route::get('/{alias?}/{typeId?}/{keyword?}', ['as' => 'tf.building.services.get', 'uses' => 'Building\Services\ServicesController@index']);
    });

    // about
    Route::group(['prefix' => 'about'], function () {
        Route::get('edit/{buildingId?}', ['as' => 'tf.building.about.content.edit.get', 'uses' => 'Building\About\AboutController@getEditContent']);
        Route::post('edit', ['as' => 'tf.building.about.content.edit.post', 'uses' => 'Building\About\AboutController@postEditContent']);

        Route::get('/{alias?}', ['as' => 'tf.building.about.get', 'uses' => 'Building\About\AboutController@getAbout']);
    });

    //default
    Route::get('/{alias?}', ['as' => 'tf.building', 'uses' => 'Building\BuildingController@index']);
});

#==========  ========== ========== MAP PAGE ========== ========= ==========
Route::group(['prefix' => 'map'], function () {
    //---------- ----------  mini map ---------- ----------
    Route::group(['prefix' => 'mini-map'], function () {
        Route::get('/{provinceId?}', ['as' => 'tf.map.miniMap.get', 'uses' => 'Map\MapController@getMiniMap']);
    });

    //---------- ---------- COUNTRY ---------- ----------
    Route::group(['prefix' => 'country'], function () {
        // access map on country
        Route::get('/{countryId?}', ['as' => 'tf.map.country.access', 'uses' => 'Map\Country\CountryController@accessCountry']);
    });

    //---------- ---------- PROVINCE ---------- ----------
    Route::group(['prefix' => 'province'], function () {
        // access map on province
        Route::get('/{provinceId?}/{areaId?}', ['as' => 'tf.map.province.access', 'uses' => 'Map\Province\ProvinceController@accessProvince']);
    });

    //----------- ---------- AREA ------------ -----------
    Route::group(['prefix' => 'area'], function () {
        //zoom
        Route::get('zoom/{provinceId?}/{areaId?}/{provinceTop?}/{provinceLeft?}', ['as' => 'tf.map.area.zoom.get', 'uses' => 'Map\Area\AreaController@getZoom']);

        // get area
        Route::get('coordinates/{provinceAccessId?}/{areaX?}/{areaY?}', ['as' => 'tf.map.area.coordinates.get', 'uses' => 'Map\Area\AreaController@getLoadCoordinates']);

        // set area when load map
        Route::get('load-map/{areaId?}', ['as' => 'tf.area.position.set', 'uses' => 'Map\Area\AreaController@setPosition']);

        // get area
        Route::get('/{provinceAccessId?}/{areaAccessId?}', ['as' => 'tf.map.area.get', 'uses' => 'Map\Area\AreaController@getArea']);
    });

    //----------- ---------- PROJECT ------------ -----------
    Route::group(['prefix' => 'project'], function () {
        Route::get('avatar/{projectId?}', ['as' => 'tf.map.project.avatar.getEdit', 'uses' => 'Map\Project\ProjectController@getEditAvatar']);
    });

    //----------- ---------- BANNER ------------ -----------
    Route::group(['prefix' => 'banner'], function () {
        //---------- information -------------
        Route::get('m-information/{bannerId?}', ['as' => 'm.tf.map.banner.information.get', 'uses' => 'Map\Banner\BannerController@m_getInformation']);

        //---------- image of banner ---------
        Route::group(['prefix' => 'image'], function () {
            // report bad info
            Route::get('report/{imageId?}', ['as' => 'tf.map.banner.image.report.get', 'uses' => 'Map\Banner\BannerImageController@getReport']);
            Route::post('report', ['as' => 'tf.map.banner.image.report.post', 'uses' => 'Map\Banner\BannerImageController@sendReport']);

            // add new image for banner
            Route::get('add/{bannerId?}', ['as' => 'tf.map.banner.image.add.get', 'uses' => 'Map\Banner\BannerImageController@getAddImage']);
            Route::post('add', ['as' => 'tf.map.banner.image.add.post', 'uses' => 'Map\Banner\BannerImageController@postAddImage']);

            // edit image info of banner
            Route::get('edit/{imageId?}', ['as' => 'tf.map.banner.image.edit.get', 'uses' => 'Map\Banner\BannerImageController@getEditImage']);
            Route::post('edit', ['as' => 'tf.map.banner.image.edit.post', 'uses' => 'Map\Banner\BannerImageController@postEditImage']);

            //view
            Route::get('detail/{imageId?}', ['as' => 'tf.map.banner.image.detail.get', 'uses' => 'Map\Banner\BannerImageController@detailImage']);
            // visit banner
            Route::get('visit/{imageId?}', ['as' => 'tf.map.banner.image.visit.get', 'uses' => 'Map\Banner\BannerImageController@visitWebsite']);

            // delete image
            Route::get('delete/{imageId?}', ['as' => 'tf.map.banner.image.delete', 'uses' => 'Map\Banner\BannerImageController@deleteImage']);
        });

        //----------- transaction ---------
        // select buy
        Route::group(['prefix' => 'buy-select'], function () {
            Route::get('/{bannerId?}', ['as' => 'tf.map.banner.buy.get', 'uses' => 'Map\Banner\BannerController@getBuy']);
            Route::post('/{bannerId?}', ['as' => 'tf.map.banner.buy.post', 'uses' => 'Map\Banner\BannerController@postBuy']);
        });

        // select free
        Route::group(['prefix' => 'free-select'], function () {
            Route::get('/{bannerId?}', ['as' => 'tf.map.banner.free.get', 'uses' => 'Map\Banner\BannerController@getFree']);
            Route::post('/{bannerId?}', ['as' => 'tf.map.banner.free.post', 'uses' => 'Map\Banner\BannerController@postFree']);
        });

        // share
        Route::group(['prefix' => 'share'], function () {
            //outside the system
            Route::get('link/{bannerId?}/{shareCode?}', ['as' => 'tf.map.banner.share.link', 'uses' => 'Map\Banner\BannerShareController@shareLink']);

            //on system
            Route::get('/{bannerId?}', ['as' => 'tf.map.banner.share.get', 'uses' => 'Map\Banner\BannerShareController@getShare']);
            Route::post('/{bannerId?}', ['as' => 'tf.map.banner.share.post', 'uses' => 'Map\Banner\BannerShareController@postShare']);
        });

        // Invite
        Route::group(['prefix' => 'invite'], function () {
            //access banner from outside the system
            Route::get('access/{inviteCode?}', ['as' => 'tf.map.banner.invite.access', 'uses' => 'Map\Banner\BannerInviteController@accessInvite']);

            //invite confirm
            Route::get('confirm/{inviteId?}', ['as' => 'tf.map.banner.invite.confirm.get', 'uses' => 'Map\Banner\BannerInviteController@getInviteConfirm']);
            Route::post('confirm/{inviteId?}', ['as' => 'tf.map.banner.invite.confirm.post', 'uses' => 'Map\Banner\BannerInviteController@postInviteConfirm']);

            //on system
            Route::get('/{bannerId?}', ['as' => 'tf.map.banner.invite.get', 'uses' => 'Map\Banner\BannerInviteController@getInvite']);
            Route::post('/{bannerLicenseId?}', ['as' => 'tf.map.banner.invite.post', 'uses' => 'Map\Banner\BannerInviteController@postInvite']);

        });

        // visit banner
        Route::get('visit/{bannerId?}', ['as' => 'tf.map.banner.visit', 'uses' => 'Map\Banner\BannerController@visitBanner']);

        //get banner
        Route::get('/{bannerId?}/{shareCode?}', ['as' => 'tf.map.banner.access', 'uses' => 'Map\Banner\BannerController@accessBanner']);
    });

    //----------- ---------- BUILDING ------------ -----------
    Route::group(['prefix' => 'building'], function () {
        //delete
        Route::get('m-menu/{buildingId?}', ['as' => 'tf.map.building.m-menu.get', 'uses' => 'Map\Building\BuildingController@getMobileMenu']);

        // comment
        Route::group(['prefix' => 'comment'], function () {
            //view full content
            Route::get('content/{commentId?}', ['as' => 'tf.map.building.comment.content.get', 'uses' => 'Map\Building\Comment\CommentController@getContent']);

            // add comment
            Route::post('/{buildingId?}', ['as' => 'tf.map.building.comment.add.post', 'uses' => 'Map\Building\Comment\CommentController@postAddComment']);

            // edit comment
            Route::get('edit/{buildingId?}', ['as' => 'tf.map.building.comment.edit.get', 'uses' => 'Map\Building\Comment\CommentController@getEditComment']);
            Route::post('edit/{buildingId?}', ['as' => 'tf.map.building.comment.edit.post', 'uses' => 'Map\Building\Comment\CommentController@postEditComment']);


            //view more comment
            Route::get('more/{buildingId?}/{take?}/{dateTake?}', ['as' => 'tf.map.building.comment.more', 'uses' => 'Map\Building\Comment\CommentController@moreComment']);

            //delete
            Route::get('delete/{commentId?}', ['as' => 'tf.map.building.comment.delete', 'uses' => 'Map\Building\Comment\CommentController@deleteComment']);

            Route::get('/{buildingId?}', ['as' => 'tf.map.building.comment.index', 'uses' => 'Map\Building\Comment\CommentController@index']);
        });

        //follow
        Route::group(['prefix' => 'follow'], function () {
            //add follow
            Route::get('plus/{buildingId?}', ['as' => 'tf.map.building.follow.plus', 'uses' => 'Map\Building\BuildingController@plusFollow']);

            //delete follow
            Route::get('minus/{buildingId?}', ['as' => 'tf.map.building.follow.minus', 'uses' => 'Map\Building\BuildingController@minusFollow']);
        });

        // love
        Route::group(['prefix' => 'love'], function () {
            Route::get('plus/{buildingId?}', ['as' => 'tf.map.building.love.plus', 'uses' => 'Map\Building\BuildingController@plusLove']);
            Route::get('minus/{buildingId?}', ['as' => 'tf.map.building.love.minus', 'uses' => 'Map\Building\BuildingController@minusLove']);
        });

        // share
        Route::group(['prefix' => 'share'], function () {
            //outside the system
            Route::get('link/{buildingId?}/{shareCode?}', ['as' => 'tf.map.building.share.link', 'uses' => 'Map\Building\BuildingController@shareLink']);
            //in system
            Route::get('/{buildingId?}', ['as' => 'tf.map.building.share.get', 'uses' => 'Map\Building\BuildingController@getShare']);
            Route::post('/{buildingId?}', ['as' => 'tf.map.building.share.post', 'uses' => 'Map\Building\BuildingController@postShare']);
        });

        // edit info
        Route::group(['prefix' => 'info'], function () {
            Route::get('edit/{buildingId?}', ['as' => 'tf.map.building.info.edit.get', 'uses' => 'Map\Building\Information\InformationController@getEditInfo']);
            Route::post('edit/{buildingId?}', ['as' => 'tf.map.building.info.edit.post', 'uses' => 'Map\Building\Information\InformationController@postEditInfo']);
        });

        //edit sample
        Route::group(['prefix' => 'sample'], function () {
            Route::get('list/{buildingId?}/{privateStatus?}', ['as' => 'tf.map.building.sample.edit.get', 'uses' => 'Map\Building\Information\InformationController@getEditSample']);
            Route::get('check-point/{sampleId?}', ['as' => 'tf.map.building.sample.edit.check-point', 'uses' => 'Map\Building\Information\InformationController@checkPointEditSample']);
            Route::get('select/{buildingId?}/{sampleId?}', ['as' => 'tf.map.building.sample.edit.select', 'uses' => 'Map\Building\Information\InformationController@changeSample']);
        });

        //delete
        Route::get('delete/{buildingId?}', ['as' => 'tf.map.building.delete.get', 'uses' => 'Map\Building\BuildingController@deleteBuilding']);

    });

    ##----------- ---------- LAND ------------ -----------
    Route::group(['prefix' => 'land'], function () {
        //menu get
        Route::get('menu/{landId?}', ['as' => 'tf.map.land.menu.get', 'uses' => 'Map\Land\LandController@getMenu']);

        ###---------- build ----------
        Route::group(['prefix' => 'build'], function () {
            // get buildings sample
            Route::get('sample/{landId?}/{privateStatus?}/{businessTypeId?}', ['as' => 'tf.map.land.build.sample.get', 'uses' => 'Map\Land\LandController@getBuildingSample']);

            // add new
            Route::get('add/{landId?}/{buildingSampleId?}', ['as' => 'tf.map.land.building.add.get', 'uses' => 'Map\Land\LandController@getAddBuilding']);
            Route::post('add/{landId?}/{buildingSampleId?}', ['as' => 'tf.map.land.building.add.post', 'uses' => 'Map\Land\LandController@postAddBuilding']);
        });

        ###---------- request build ----------
        Route::group(['prefix' => 'request-build'], function () {
            Route::get('cancel/{requestId?}', ['as' => 'tf.map.land.request-build.cancel', 'uses' => 'Map\Land\LandController@cancelRequestBuild']);
            // add new
            Route::get('/{licenseId?}', ['as' => 'tf.map.land.request-build.get', 'uses' => 'Map\Land\LandController@getRequestBuild']);
            Route::post('/{licenseId?}', ['as' => 'tf.map.land.request-build.send', 'uses' => 'Map\Land\LandController@sendRequestBuild']);
        });

        ###----------- transaction ---------
        // select buy
        Route::group(['prefix' => 'buy-select'], function () {
            Route::get('/{landId?}', ['as' => 'tf.map.land.buy.get', 'uses' => 'Map\Land\LandController@getBuy']);
            Route::post('/{landId?}', ['as' => 'tf.map.land.buy.post', 'uses' => 'Map\Land\LandController@postBuy']);
        });

        // select free
        Route::group(['prefix' => 'free-select'], function () {
            Route::get('/{landId?}', ['as' => 'tf.map.land.free.get', 'uses' => 'Map\Land\LandController@getFree']);
            Route::post('/{landId?}', ['as' => 'tf.map.land.free.post', 'uses' => 'Map\Land\LandController@postFree']);
        });
        ###---------- share ---------
        Route::group(['prefix' => 'share'], function () {
            //outside the system
            Route::get('link/{landId?}/{shareCode?}', ['as' => 'tf.map.land.share.link', 'uses' => 'Map\Land\LandShareController@shareLink']);

            //on system
            Route::get('form/{landId?}', ['as' => 'tf.map.land.share.get', 'uses' => 'Map\Land\LandShareController@getShare']);
            Route::post('form/{landId?}', ['as' => 'tf.map.land.share.post', 'uses' => 'Map\Land\LandShareController@postShare']);
        });

        ###---------- share ---------
        // Invite
        Route::group(['prefix' => 'invite'], function () {
            //outside the system
            Route::get('access/{inviteCode?}', ['as' => 'tf.map.land.invite.access', 'uses' => 'Map\Land\LandInviteController@accessInvite']);

            //invite confirm
            Route::get('confirm/{inviteCode?}', ['as' => 'tf.map.land.invite.confirm.get', 'uses' => 'Map\Land\LandInviteController@getInviteConfirm']);
            Route::post('confirm/{inviteCode?}', ['as' => 'tf.map.land.invite.confirm.post', 'uses' => 'Map\Land\LandInviteController@postInviteConfirm']);

            //on system
            Route::get('/{landLicenseId?}', ['as' => 'tf.map.land.invite.get', 'uses' => 'Map\Land\LandInviteController@getInvite']);
            Route::post('/{landLicenseId?}', ['as' => 'tf.map.land.invite.post', 'uses' => 'Map\Land\LandInviteController@postInvite']);

        });

        //access land
        Route::get('/{landId?}/{shareCode?}', ['as' => 'tf.map.land.access', 'uses' => 'Map\Land\LandController@accessLand']);
    });

    //----------- ---------- MARKET ------------ -----------
    Route::group(['prefix' => 'market'], function () {
        // get sale land
        Route::get('land-sale/{countryId?}/{provinceId?}', ['as' => 'tf.map.market.land.sale.get', 'uses' => 'Map\Market\MarketController@getSaleLand']);

        // get free land
        Route::get('land-free/{countryId?}/{provinceId?}', ['as' => 'tf.map.market.land.free.get', 'uses' => 'Map\Market\MarketController@getFreeLand']);

        // get sale banner
        Route::get('banner-sale/{countryId?}/{provinceId?}', ['as' => 'tf.map.market.banner.sale.get', 'uses' => 'Map\Market\MarketController@getSaleBanner']);

        // get free banner
        Route::get('banner-free/{countryId?}/{provinceId?}', ['as' => 'tf.map.market.banner.free.get', 'uses' => 'Map\Market\MarketController@getFreeBanner']);
    });

    //----------- ---------- Filter ------------ -----------
    Route::group(['prefix' => 'filter'], function () {
        //business type
        Route::get('business-type/list', ['as' => 'tf.search.filter.business-type.list', 'uses' => 'Map\MapController@listFilterBusinessType']);
        Route::get('business-type/{typeId?}', ['as' => 'tf.map.filter.business-type.get', 'uses' => 'Map\MapController@getFilterBusinessType']);

    });
});

#========== ========== ========== DESIGN PAGE ========== ========== ==========
Route::group(['prefix' => 'design'], function () {
    //store
    Route::group(['prefix' => 'store'], function () {
        Route::get('/{nameStore?}/{objectId?}', ['as' => 'tf.design.store.get', 'uses' => 'Design\DesignController@getStore']);
    });

    //shop
    Route::get('shop/{nameTypeBusiness?}/{objectId?}', ['as' => 'tf.shopDesign', 'uses' => 'Design\DesignController@getShop']);
    Route::get('system/{nameSystem?}/{objectId?}', ['as' => 'tf.systemDesign', 'uses' => 'Design\DesignController@getSystem']);

    //up design
    Route::get('upload/{nameUpload?}/{areaId?}', ['as' => 'tf.uploadDesign', 'uses' => 'Design\DesignController@getUpload']);

    // request design
    Route::get('request/{nameRequest?}/{areaId?}', ['as' => 'tf.requestDesign', 'uses' => 'Design\DesignController@getRequest']);

    //
    Route::get('confirm/{nameConfirm?}', ['as' => 'tf.confirmDesign', 'uses' => 'Design\DesignController@getConfirm']);
    Route::get('/{name?}/{id?}', ['as' => 'tf.design', 'uses' => 'Design\DesignController@index']);
});

#========== ==========  ========== POINT PAGE ========== ========== ==========
Route::group(['prefix' => 'point'], function () {
    Route::group(['prefix' => 'online'], function () {
        //get package
        Route::get('select-package/{point?}', ['as' => 'tf.point.online.package.get', 'uses' => 'Point\PointController@getPackage']);

        //get wallet
        Route::get('select-wallet/{point?}/{wallet?}', ['as' => 'tf.point.online.wallet.get', 'uses' => 'Point\PointController@getWallet']);

        //nganluong.vn
        Route::group(['prefix' => 'nganluong'], function () {
            //get detail
            Route::get('payment-detail/{point?}/{wallet?}', ['as' => 'tf.point.online.nganluong.payment-detail.get', 'uses' => 'Point\Wallet\NganLuong\NganLuongController@getPaymentDetail']);

            //return url
            Route::get('payment/{point?}/{walletId?}/{transactionId?}/{cardId?}', ['as' => 'tf.point.online.nganluong.payment.get', 'uses' => 'Point\Wallet\NganLuong\NganLuongController@getPayment']);
            Route::get('payment-cancel', ['as' => 'tf.point.online.nganluong.payment.cancel', 'uses' => 'Point\Wallet\NganLuong\NganLuongController@getPaymentCancel']);


        });

    });

    Route::get('direct', ['as' => 'tf.point.direct.get', 'uses' => 'Point\PointController@getDirect']);
});

#========== ==========  ========== AFFILIATE PAGE ========== ========== ==========
Route::group(['prefix' => 'affiliate'], function () {
    Route::group(['prefix' => 'sign-up'], function () {
        Route::get('/', ['as' => 'tf.seller.sign-up.get', 'uses' => 'Seller\SellerController@getSignUp']);
        Route::post('/', ['as' => 'tf.seller.sign-up.post', 'uses' => 'Seller\SellerController@postSignUp']);

    });

    Route::get('guide/{object?}', ['as' => 'tf.seller.guide.get', 'uses' => 'Seller\SellerController@getGuide']);
    Route::get('payment', ['as' => 'tf.seller.payment.get', 'uses' => 'Seller\SellerController@getPayment']);
});

//========== ==========  ========== Ads PAGE ========== ========== ==========
Route::group(['prefix' => 'ads'], function () {
    Route::group(['prefix' => 'report'], function () {
        Route::get('badInfo/{imageName?}', ['as' => 'tf.ads.report.bad-info.get', 'uses' => 'Ads\AdsController@getReport']);

        //list
        Route::post('badInfo/{imageName?}', ['as' => 'tf.ads.report.bad-info.post', 'uses' => 'Ads\AdsController@sendReport']);

    });

    Route::group(['prefix' => 'banner'], function () {
        Route::group(['prefix' => 'order'], function () {
            // view
            Route::get('detail/{name?}', ['as' => 'tf.ads.order.detail.get', 'uses' => 'Ads\AdsController@detailOrder']);

            //list
            Route::post('pay/{name?}', ['as' => 'tf.ads.order.pay.post', 'uses' => 'Ads\AdsController@payOrder']);

        });

        // view
        Route::get('view/{bannerId?}', ['as' => 'tf.ads.banner.view.get', 'uses' => 'Ads\AdsController@viewBanner']);

        //list
        Route::get('/', ['as' => 'tf.ads.banner.list.get', 'uses' => 'Ads\AdsController@getList']);

    });

    Route::group(['prefix' => 'banner-image'], function () {
        //visit
        Route::get('visit/{imageId?}', ['as' => 'tf.ads.banner-image.visit', 'uses' => 'Ads\AdsController@visitImage']);
        //prevent
        Route::get('prevent/{imageId?}', ['as' => 'tf.ads.banner-image.prevent', 'uses' => 'Ads\AdsController@preventImage']);
    });
});

#========== ========== =========== HELP PAGE ========== ========== ==========
Route::get('help/{objectAlias?}/{actionAlias?}', ['as' => 'tf.help', 'uses' => 'Help\HelpController@index']);

//----------- ---------- Owned ------------ -----------
Route::group(['prefix' => 'owned'], function () {
    // get building
    Route::get('building', ['as' => 'tf.owned.building.get', 'uses' => 'MainController@getBuildingOwned']);
    // get land
    Route::get('land', ['as' => 'tf.owned.land.get', 'uses' => 'MainController@getLandOwned']);
    // get banner
    Route::get('banner', ['as' => 'tf.owned.banner.get', 'uses' => 'MainController@getBannerOwned']);

});
#------------ ------------- Notify ------------- ---------
Route::group(['prefix' => 'notify'], function () {
    Route::group(['prefix' => 'friend'], function () {
        // hide friend
        Route::get('hide/{userFriendId?}', ['as' => 'tf.notify.friend.hide', 'uses' => 'MainController@hideNotifyFriendObject']);

        // get friend
        Route::get('/', ['as' => 'tf.notify.friend.get', 'uses' => 'MainController@getNotifyFriend']);

    });

    //action
    Route::group(['prefix' => 'action'], function () {
        // hide new building
        Route::get('hide-building-new/{buildingId?}', ['as' => 'tf.notify.action.hide.building-new', 'uses' => 'MainController@hideNotifyActionBuildingNew']);

        // hide comment
        Route::get('hide-comment/{commentId?}', ['as' => 'tf.notify.action.hide.comment', 'uses' => 'MainController@hideNotifyActionComment']);

        // hide share building
        Route::get('hide-building-share/{shareId?}', ['as' => 'tf.notify.action.hide.building-share', 'uses' => 'MainController@hideNotifyActionBuildingShare']);

        // hide love building
        Route::get('hide-building-love/{loveId?}', ['as' => 'tf.notify.action.hide.building-love', 'uses' => 'MainController@hideNotifyActionBuildingLove']);

        // hide share banner
        Route::get('hide-banner-share/{shareId?}', ['as' => 'tf.notify.action.hide.banner-share', 'uses' => 'MainController@hideNotifyActionBannerShare']);

        // hide share land
        Route::get('hide-land-share/{shareId?}', ['as' => 'tf.notify.action.hide.land-share', 'uses' => 'MainController@hideNotifyActionLandShare']);

        //hide the post of building
        Route::get('hide-building-post/{postId?}', ['as' => 'tf.notify.action.hide.building-post', 'uses' => 'MainController@hideNotifyActionBuildingPost']);

        // get action
        Route::get('/', ['as' => 'tf.notify.action.get', 'uses' => 'MainController@getNotifyAction']);
    });
});
//Guide build
Route::get('guide', ['as' => 'tf.guide.basic.build.get', 'uses' => 'MainController@getGuideBasicBuild']);

#----------- ---------- SEARCH ------------ -----------
Route::group(['prefix' => 'search'], function () {
    //---------- small --------
    // get involved keyword
    Route::get('small/involved/{keyword?}', ['as' => 'tf.search.small.involved.get', 'uses' => 'Search\SearchController@smallInvolvedKeyword']);

    // get search
    Route::get('small/info/{keyword?}/{businessTypeId?}', ['as' => 'tf.search.small.info.get', 'uses' => 'Search\SearchController@getSmallSearchInfo']);
    Route::get('small/more/{keyword?}/{skip?}/{take?}/{businessTypeId?}', ['as' => 'tf.search.small.info.more', 'uses' => 'Search\SearchController@moreSmallSearchInfo']);
    Route::get('small/', ['as' => 'tf.search.small.get', 'uses' => 'Search\SearchController@getSmallSearch']);

    //----------- normal -------
    Route::get('involved/{keyword?}', ['as' => 'tf.search.involved.get', 'uses' => 'Search\SearchController@involvedKeyword']);

    Route::get('more/{keyword?}/{skip?}/{take?}/{businessTypeId?}', ['as' => 'tf.search.info.more', 'uses' => 'Search\SearchController@moreSearchInfo']);
    Route::get('info/{keyword?}/{businessTypeId?}', ['as' => 'tf.search.info.get', 'uses' => 'Search\SearchController@getSearchInfo']);
});
//default- fw
Route::get('home', 'HomeController@index');

Route::get('center', ['as' => 'tf.home.center', 'uses' => 'MainController@homeCenter']);
Route::get('/{alias?}/{object?}', ['as' => 'tf.home', 'uses' => 'MainController@index']);//go to: building\block\banner


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
