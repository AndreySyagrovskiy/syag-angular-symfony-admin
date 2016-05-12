/**
 * Created by andrey on 23.01.16.
 */

function configDirective(scope, field ){
    if(scope.config.validation)
        field.validation(scope.config.validation);

    if(scope.config.label)
        field.label(scope.config.label);

    if(scope.config.classes)
        field.cssClasses(scope.config.classes);

    if(scope.config.attributes)
        field.attributes(scope.config.attributes);
}

export default configDirective;