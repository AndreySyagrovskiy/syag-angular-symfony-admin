configHttpErrorProcessor.$inject =['$httpProvider'];

function configHttpErrorProcessor($httpProvider){
    $httpProvider.interceptors.push(['$q', '$rootScope', function ($q, $rootScope) {
        return {
            'responseError': function (rejection) {
                if (rejection.status == 401 && !rejection.NoTryFix) {
                    return $q(function (resolve, reject) {
                        $rootScope.$broadcast('syagr.auth.AuthRequestErr', rejection);
                        $rootScope.$on('syagr.auth.AuthRequestErrResolved', function (event, response) {
                            resolve(response);
                        });

                        $rootScope.$on('syagr.auth.AuthRequestErrRejected', function (event, response) {
                            reject(response);
                        });
                    });
                } else if (rejection.status == 403) {
                    $rootScope.$broadcast('syagr.auth.AccessForbiddenError', rejection);
                } else if(rejection.status == 500){
                    rejection.data.error = 'Server error!';
                }
                return $q.reject(rejection);
            },
        };
    }]);

    interceptor.$inject = ['$q', '$rootScope',];

    function interceptor($q, $rootScope){

    }
}

export default configHttpErrorProcessor;
