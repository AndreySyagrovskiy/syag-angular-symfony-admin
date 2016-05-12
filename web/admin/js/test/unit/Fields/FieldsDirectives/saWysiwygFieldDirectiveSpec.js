import directive from "../../../../source/Fields/FieldsDirectives/saWysiwygFieldDirective";
import parentDirective from "ng-admin/src/javascripts/ng-admin/Crud/field/maWysiwygField"


describe('directive: wysiwyg-field', function () {
    'use strict';

    angular.module('testapp_WysiwygField', ['textAngular'])
        .directive('saWysiwygField', directive)
        .directive('maWysiwygField', parentDirective);

    var $compile,
        scope = {},
        directiveUsage = '<sa-wysiwyg-field config="::config" key="::key" parent-name="::parentName" value="value"></sa-wysiwyg-field>';

    var key = 'textname';
    var parentName = 'parentname'

    beforeEach(angular.mock.module('testapp_WysiwygField'));

    beforeEach(inject(function (_$compile_, _$rootScope_) {
        $compile = _$compile_;
        scope    = _$rootScope_.$new();
        scope.config = {
            type: 'wysiwyg',
            validation: {
                required: true,
                minlength: 5,
                maxlength: 800,
            },
            classes: 'mysupperclass',
            label:   'Strange text',
            attributes: {
                placeholder: 'fill me!'
            },
        };

        scope.key = key;
        scope.parentName = parentName;
        scope.value = "text of textarea value";

    }));


    it("is exist element ma-wysiwyg-field with text-angular", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();

        element = element.find('ma-wysiwyg-field');

        expect(element.length).toEqual(1);
        expect(element.children().attr('text-angular')).toEqual('');
    });


    it("should contain the  validation", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        var elementCh = element.find('ma-wysiwyg-field').children();
        expect(elementCh.hasClass('ng-valid')).toEqual(true);
    });
})
;