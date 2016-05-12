import getConfig from "./getConfig";
console.log(getConfig("page"));
function initPageEntity(pageEntity, nga){
    pageEntity
        .listView()
        .fields([
            nga.field('title'),
            nga.field('slug'),
            nga.field('text', 'wysiwyg')
                .map(function truncate(value) {
                    if (!value) return '';
                    return value.length > 90 ? value.substr(0, 90) + '...' : value;
                })
        ])
        .listActions(['show', 'edit', 'delete'])
    ;

    pageEntity.creationView().fields([
        nga.field('title')
            .validation({required: true, minlength: 2, maxlength: 255}),
        nga.field('slug'),
        nga.field('text', 'wysiwyg')
            .validation({ required: true})
        ,
        nga.field('style', 'choice')
            .choices([
                { label: 'style1', value: 'style1' },
                { label: 'style2', value: 'style2' }
            ])
            .validation(
                {required: true}
            )
        ,
        nga.field('customs', 'custom')
            .config(getConfig("page"))
        ,

    ]);

    pageEntity.showView().fields(pageEntity.creationView().fields());

    pageEntity.editionView().fields(pageEntity.creationView().fields());

    pageEntity.deletionView();
}

export default initPageEntity;