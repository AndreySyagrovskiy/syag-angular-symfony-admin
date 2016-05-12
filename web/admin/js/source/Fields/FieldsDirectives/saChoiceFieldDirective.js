/**
 * Created by alex on 15.02.16.
 */

import ChoiceField from "admin-config/lib/Field/ChoiceField";
import configDirectiveHelper from "./configDirectiveHelper";

function saChoiceFieldDirective($compile){
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
        var field = new ChoiceField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;
        field.choices(scope.config.choices);

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <ma-choice-field field="::field" entry="entry" value="value"></ma-choice-field>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saChoiceFieldDirective.$inject = ["$compile"];

export default saChoiceFieldDirective;