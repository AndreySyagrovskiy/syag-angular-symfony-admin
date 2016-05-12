/**
 * Created by andrey on 24.01.16.
 */

import TextField from "admin-config/lib/Field/TextField";
import configDirectiveHelper from "./configDirectiveHelper";

function saTextFieldDirective($compile){
    return {
        link: link,
        scope: {
            config: "=",
            key   : "=",
            value : "=",
            parentName: "=parentName",
        },
        restrict: 'E',

    };

    function link(scope, element, attrs){
        var fieldName = scope.parentName + '_' + scope.key;
        var field = new TextField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <ma-text-field field="::field" value="value"></ma-text-field>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saTextFieldDirective.$inject = ["$compile"];

export default saTextFieldDirective;
