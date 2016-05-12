import "./authorization/AuthorizationModule";
import "./customs.module";
import initPageEntity from "./initPageEntity";
import hasPermission from "./hasPermission";
import CustomField from "./Fields/Fields/CustomField";

angular
    .module('syagradmin.app', [
        'ng-admin',
        'syagr.auth',
        'syagr.customs',
    ])
;

(function () {
    "use strict";
    angular
        .module('syagradmin.app')
        .config(configAdmin);
    ;

    configAdmin.$inject = ['NgAdminConfigurationProvider'];

    function configAdmin(NgAdminConfigurationProvider){
        var nga = NgAdminConfigurationProvider;
        nga.registerFieldType('custom', CustomField);


        var admin = nga.application('Test admin', false);
        admin.baseApiUrl('/api/v1/');


        var pageEntity = nga.entity('pages');

        admin.menu(nga.menu()
            .addChild(nga.menu(pageEntity).icon('<span class="glyphicon glyphicon-duplicate"></span>'))
        );
        
        initPageEntity(pageEntity, nga);
        admin.addEntity(pageEntity);


        nga.configure(admin);
    }
})();

(function () {
    "use strict";
    angular
        .module('syagradmin.app')
        .run(runWithAuthorization)
    ;

    runWithAuthorization.$inject = ['syagr.auth.AuthorizationService', '$window', '$rootScope',];

    function runWithAuthorization(AuthorizationService, $window, $rootScope){
        $rootScope.$on('syagr.auth.UnAuthenticatedError', function(){
            $window.location = '/login/';
        });

        $rootScope.$on('syagr.auth.UnAuthenticatedError', function(){
            throw new Error('You don`t have permission for this action! Try Re login with right permissions, please!');
        });

        AuthorizationService.init();

        $rootScope.makeUrl = function(path, filter){ 
            console.log(path, filter);
            return Routing.generate('liip_imagine_filter', {path: path, filter: filter})
        };
    }
})();