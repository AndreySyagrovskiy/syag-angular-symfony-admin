/**
 * Created by andrey on 23.01.16.
 */

function getConfig(category){
    if(window.customconfig && window.customconfig[category])
        return window.customconfig[category]

    return null;
}

export default getConfig;