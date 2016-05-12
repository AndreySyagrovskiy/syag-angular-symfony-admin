/**
 * Created by alex on 15.02.16.
 */

import BooleanField from "admin-config/lib/Field/BooleanField";
import configDirectiveHelper from "./configDirectiveHelper";

function saBooleanFieldDirective($compile){
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
        var field = new BooleanField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <div class="row">
                    <ma-choice-field class="col-sm-4 col-md-3" ng-if="!field.validation().required" field="::field" value="$parent.value"></ma-choice-field>
                    <ma-checkbox-field class="col-sm-4 col-md-3" ng-if="!!field.validation().required" field="::field" value="$parent.value"></ma-checkbox-field>
                </div>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saBooleanFieldDirective.$inject = ["$compile"];

export default saBooleanFieldDirective;