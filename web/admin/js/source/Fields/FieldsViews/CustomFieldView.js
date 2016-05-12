/**
 * Created by andrey on 22.01.16.
 */
module.exports =  {
    getReadWidget:   () => '<div>Customs</div>',
    getLinkWidget:   () => '<a ng-click="gotoDetail()">' + module.exports.getReadWidget() + '</a>',
    getFilterWidget: () => '<ma-input-field type="number" step="any" field="::field" value="values[field.name()]"></ma-input-field>',
    getWriteWidget:  () => '<sa-custom-field field="::field" entry="entry" config="null" value="entry.values[field.name()]"></sa-custom-field>'
};