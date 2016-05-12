/**
 * Created by alex on 15.02.16.
 */

import EmailField from "admin-config/lib/Field/EmailField";
import configDirectiveHelper from "./configDirectiveHelper";

function saEmailFieldDirective($compile){
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
        var field = new EmailField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <ma-input-field type="email" field="::field" value="value"></ma-input-field>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saEmailFieldDirective.$inject = ["$compile"];

export default saEmailFieldDirective;