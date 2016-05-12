/**
 * Created by alex on 15.02.16.
 */

import DateTimeField from "admin-config/lib/Field/DateTimeField";
import configDirectiveHelper from "./configDirectiveHelper";

function saDateTimeFieldDirective($compile){
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
        var field = new DateTimeField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <div class="datetime_widget">
                    <ma-date-field field="::field" value="value"></ma-date-field>
                </div>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saDateTimeFieldDirective.$inject = ["$compile"];

export default saDateTimeFieldDirective;