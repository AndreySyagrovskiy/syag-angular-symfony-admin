/**
 * Created by alex on 15.02.16.
 */

import FileField from "admin-config/lib/Field/FileField";
import configDirectiveHelper from "./configDirectiveHelper";

function saFileFieldDirective($compile){
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
        var field = new FileField(fieldName);
        configDirectiveHelper(scope, field);
        scope.field = field;

        scope.makeUrl = function(path, filter){
            console.log(path, filter);
            return Routing.generate('liip_imagine_filter', {path: path, filter: filter})
        };

        element.append(`
        <div ng-class="getFieldValidationClass(field)" class="row">
            <label for="title" class="col-md-12 text-left">
                <span data-ng-bind="::field.label()"></span><span ng-if="field.validation().required">&nbsp;*</span>
            </label>
            <div class="col-md-12">
                <ma-file-field field="::field" value="value"></ma-file-field>
                <img data-ng-src="{{makeUrl('syagr_local/default/2016/03/20/7609abc02b02e5ad1f4f32e7ef5c3734.jpeg', 'my_thumb_out')}}">
            </div>
        </div>
        `);
        $compile(element.contents())(scope);
    }
}

saFileFieldDirective.$inject = ["$compile"];

export default saFileFieldDirective;