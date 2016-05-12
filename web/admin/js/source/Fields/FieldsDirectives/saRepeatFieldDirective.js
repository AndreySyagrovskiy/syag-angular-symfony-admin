/**
 * Created by andrey on 07.02.16.
 */

import CustomFields from "./../Fields/CustomField";

function repeatFieldDirective($compile, $timeout){
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
        if(!angular.isArray(scope.value)){
            scope.value = [];
            scope.addItem = false;
        }

        if (!scope.value.length)
            scope.addItem = false;
        else
            scope.addItem = true;

        scope.add = () => {
            scope.value.push({});
            scope.addItem = true;
        }

        scope.delete = (item) => {
            var index = scope.value.indexOf(item);
            if (!index)
                scope.addItem = false;
            if(index !== -1)
                scope.value.splice(index, 1);
        }

        scope.field = new CustomFields(scope.parentName + '_' + scope.key);

        element.append(`
            <div class="row">
                <label for="title" class="col-md-12 text-left">
                    <span data-ng-bind="::config.label"></span>
                </label>
            </div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row repeat-item" data-ng-repeat="item in value track by $index" data-ng-attr-name="{{::(field.name() + '_' + $index)}}">
                                <div class="col-md-11 no-padding-right">
                                    <sa-custom-field  field="::field" entity="::{}" config="::config['fields']" value="item"></sa-custom-field>
                                </div>
                                <div class="col-md-1 no-padding-left">
                                    <i data-ng-click="delete(item);" class="glyphicon glyphicon-remove close-button"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 no-padding-right">
                            <button data-ng-class="(addItem)?'pull-right':''" class="btn add-button" data-ng-click="add();">
                                <i class="glyphicon glyphicon-plus add-button-icon"></i>Add
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        `);

        $compile(element.contents())(scope)
    }
}

repeatFieldDirective.$inject = ["$compile", "$timeout"];

export default repeatFieldDirective;