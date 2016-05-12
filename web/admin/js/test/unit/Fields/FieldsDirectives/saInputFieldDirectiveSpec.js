import directive from "../../../../source/Fields/FieldsDirectives/saInputFieldDirective";
import parentDirective from "ng-admin/src/javascripts/ng-admin/Crud/field/maInputField";


describe('directive: input-field', function () {
    'use strict';

    angular.module('testapp_InputField', [])
        .directive('saInputField', directive)
        .directive('maInputField', parentDirective);

    var $compile,
        scope = {},
        directiveUsage = '<sa-input-field config="::config" key="::key" parent-name="::parentName" value="value"></sa-input-field>';

    var key = 'textname';
    var parentName = 'parentname'

    beforeEach(angular.mock.module('testapp_InputField'));

    beforeEach(inject(function (_$compile_, _$rootScope_) {
        $compile = _$compile_;
        scope    = _$rootScope_.$new();
        scope.config = {
            type: 'text',
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
        scope.value = "text of input value";

    }));



    it("should contain an input tag", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        element = element.find('ma-input-field');
        expect(element.children()[0].nodeName).toBe('INPUT');
    });

    it("should add any supplied attribute", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        element = element.find('ma-input-field');
        expect(element.children()[0].placeholder).toEqual('fill me!');
    });

    it("should contain the bounded value", function () {
        scope.value = "foobar";
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('input').val()).toBe('foobar');
        scope.value = "baz";
        scope.$digest();
        expect(element.find('input').val()).toBe('baz');
    });

    /*it("should contain the bounded class", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('input').hasClass('mysupperclass')).toBe(true);
    });*/

    it("should contain the bounded validation", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('input')[0].attributes['required'].value).toBe('required');
        expect(element.find('input')[0].attributes['ng-minlength'].value).toBe('5');
        expect(element.find('input')[0].attributes['ng-maxlength'].value).toBe('800');
    });
})
;