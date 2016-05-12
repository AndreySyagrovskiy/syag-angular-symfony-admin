function hasPermission(enity, action){
    return (
                window.userAuthorizationData
                && window.userAuthorizationData.permissions
                && window.userAuthorizationData.permissions[enity]
                && window.userAuthorizationData.permissions[enity].indexOf(action) != -1
            )? true : false;
}

export default hasPermission;