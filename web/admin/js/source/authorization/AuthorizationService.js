
AuthorizationService.$inject = ['$http', "$rootScope", "$window"];

function AuthorizationService($http, $rootScope, $window) {
    var user = null;
    var token = null;

    return {
        getUser: getUser,
        init: init,
    };

    function init() {

        try {
            if ($window.userAuthorizationData) {
                user = $window.userAuthorizationData.user;
                token = $window.userAuthorizationData.token;
                setAuthorizationToken(token);
            }else{
                $rootScope.$broadcast('syagr.auth.UnAuthenticatedError');
            }
        } catch (er) {
            $rootScope.$broadcast('syagr.auth.UnAuthenticatedError');
        }

        handleAuthorizationError();
        handleAccessError();
    }

    function setAuthorizationToken(token) {
        $http.defaults.headers.common['X-AUTH-TOKEN'] = token;
    }

    function handleAuthorizationError() {
        $rootScope.$on('syagr.auth.AuthRequestErr', function () {
            $rootScope.$broadcast('syagr.auth.UnAuthenticatedError');
            $rootScope.$broadcast('syagr.auth.AuthRequestErrRejected');
        });
    }

    function handleAccessError() {
        $rootScope.$on('syagr.auth.AccessRequestErr', function () {
            $rootScope.$broadcast('syagr.auth.AccessForbiddenError');
        });
    }

    function getUser() {
        return user;
    }
}

export default AuthorizationService;