/**
 * Created by andrey on 22.01.16.
 */

function saCustomFieldDirective($compile, $timeout) {

    return {
        link: function (scope, element, attrs) {
            if(!scope.config) {
                scope.$watch('entry.values.style', function () {
                    if(scope.entry.values.style)
                        scope.config = scope.field.config()[scope.entry.values.style].fields;
                });
                scope.parentName = scope.field.name();
            } else {
                scope.parentName = scope.field.name() + '_' + Math.round(Math.random() * 1000000);
            }

            if(!scope.value){
                scope.value = {};
            }

            element.append(`
                <div data-ng-if="config">
                    <div data-ng-repeat="(key, item) in config track by key">
                        <div ng-switch="item.type">
                          <div ng-switch-when="input">
                                <sa-input-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-input-field>
                          </div>
                          <div ng-switch-when="text">
                                <sa-text-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-text-field>
                          </div>
                          <div ng-switch-when="wysiwyg">
                                <sa-wysiwyg-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-wysiwyg-field>
                          </div>
                          <div ng-switch-when="repeat">
                                <sa-repeat-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-repeat-field>
                          </div>
                          <div ng-switch-when="file">
                                <sa-file-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-file-field>
                          </div>
                          <div ng-switch-when="email">
                                <sa-email-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-email-field>
                          </div>
                          <div ng-switch-when="datetime">
                                <sa-date-time-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-date-time-field>
                          </div>
                          <div ng-switch-when="boolean">
                                <sa-boolean-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-boolean-field>
                          </div>
                          <div ng-switch-when="choice">
                                <sa-choice-field class="sa_custom_field clearfix" config="::item" key="::item.name" parent-name="::parentName" value="value[item.name]"></sa-choice-field>
                          </div>
                        </div>
                    </div>
                </div>
            `);
            $compile(element.contents())(scope);
        },
        scope: {
            value: "=",
            field: "=",
            entry: "=",
            config: "=",
        },
        restrict: 'E',
    }
}

saCustomFieldDirective.$inject = ['$compile', '$timeout'];

export default saCustomFieldDirective;
