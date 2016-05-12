import AuthorizationService from "./AuthorizationService";
import configHttpErrorProcessor from './configHttpErrorProcessor';

export default (function () {
    "use strict";
    angular
        .module('syagr.auth',
            [
                'ui.router'
            ]
        )
        .factory('syagr.auth.AuthorizationService', AuthorizationService)
        .config(configHttpErrorProcessor);
    ;
})();