import saCustomFieldDirective   from "./Fields/FieldsDirectives/saCustomFieldDirective";
import saWysiwygFieldDirective  from "./Fields/FieldsDirectives/saWysiwygFieldDirective";
import saTextFieldDirective     from "./Fields/FieldsDirectives/saTextFieldDirective";
import saInputFieldDirective     from "./Fields/FieldsDirectives/saInputFieldDirective";
import saRepeatFieldDirective    from "./Fields/FieldsDirectives/saRepeatFieldDirective";
import saFileFieldDirective    from "./Fields/FieldsDirectives/saFileFieldDirective";
import saEmailFieldDirective    from "./Fields/FieldsDirectives/saEmailFieldDirective";
import saDateTimeFieldDirective    from "./Fields/FieldsDirectives/saDateTimeFieldDirective";
import saBooleanFieldDirective    from "./Fields/FieldsDirectives/saBooleanFieldDirective";
import saChoiceFieldDirective    from "./Fields/FieldsDirectives/saChoiceFieldDirective";

angular
    .module('syagr.customs', [
        'ng-admin',
    ])
    .config(['FieldViewConfigurationProvider', function(fvp) {
        fvp.registerFieldView('custom', require('./Fields/FieldsViews/CustomFieldView'));
    }])
    .directive('saCustomField' , saCustomFieldDirective)
    .directive('saWysiwygField', saWysiwygFieldDirective)
    .directive('saTextField'   , saTextFieldDirective)
    .directive('saInputField'  , saInputFieldDirective)
    .directive('saRepeatField'  , saRepeatFieldDirective)
    .directive('saFileField'  , saFileFieldDirective)
    .directive('saEmailField'  , saEmailFieldDirective)
    .directive('saDateTimeField'  , saDateTimeFieldDirective)
    .directive('saBooleanField'  , saBooleanFieldDirective)
    .directive('saChoiceField'  , saChoiceFieldDirective)
;