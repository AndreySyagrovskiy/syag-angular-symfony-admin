/**
 * Created by andrey on 23.01.16.
 */
import WysiwygField from "admin-config/lib/Field/WysiwygField"
import configDirectiveHelper from "./configDirectiveHelper";

function saWysiwygFieldDirective($compile){

    return {
        link: link,
        scope: {
            config: "=config",
            key   : "=key",
            value : "=value",
            parentName: "=parentName",
        },
        restrict: 'E',
    };

    function link(scope, element, attrs){
        var fieldName = scope.parentName + '_' + scope.key;
        var field = new WysiwygField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                    <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div ng-class="getClassesForField(field, entry)" class="col-md-12 ">

                <ma-wysiwyg-field field="::field" value="value"></ma-wysiwyg-field>
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saWysiwygFieldDirective.$inject = ["$compile"];

export default saWysiwygFieldDirective;
