import directive from "../../../../source/Fields/FieldsDirectives/saTextFieldDirective";
import parentDirective from "ng-admin/src/javascripts/ng-admin/Crud/field/maTextField";


describe('directive: text-field', function () {
    'use strict';

    angular.module('testapp_TextField', [])
        .directive('saTextField', directive)
        .directive('maTextField', parentDirective);

    var $compile,
        scope = {},
        directiveUsage = '<sa-text-field config="::config" key="::key" parent-name="::parentName" value="value"></sa-text-field>';

    var key = 'textname';
    var parentName = 'parentname'

    beforeEach(angular.mock.module('testapp_TextField'));

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
        scope.value = "text of textarea value";

    }));



    it("should contain an textarea tag", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        element = element.find('ma-text-field');
        expect(element.children()[0].nodeName).toBe('TEXTAREA');
    });

    it("should add any supplied attribute", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        element = element.find('ma-text-field');
        expect(element.children()[0].placeholder).toEqual('fill me!');
    });

    it("should contain the bounded value", function () {
        scope.value = "foobar";
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('textarea').val()).toBe('foobar');
        scope.value = "baz";
        scope.$digest();
        expect(element.find('textarea').val()).toBe('baz');
    });

    /*it("should contain the bounded class", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('textarea').hasClass('mysupperclass')).toBe(true);
    });*/

    it("should contain the bounded validation", function () {
        var element = $compile(directiveUsage)(scope);
        scope.$digest();
        expect(element.find('textarea')[0].attributes['required'].value).toBe('required');
        expect(element.find('textarea')[0].attributes['ng-minlength'].value).toBe('5');
        expect(element.find('textarea')[0].attributes['ng-maxlength'].value).toBe('800');
    });
})
;