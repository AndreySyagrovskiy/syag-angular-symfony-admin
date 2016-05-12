/*global describe,it,expect,$$,element,browser,by*/
describe('ListView', function () {
	'use strict';

    var domain = 'localhost';
    var port   = '8000';
    var token = null;
    var request = require( "superagent" );
    var entity = 'pages';

    beforeEach(function(done){
        request
            .post( `${domain}:${port}/api/authorization/login`)
            .send( {
                appToken: 'app2121d3ds34gg33asgr23e23ce2asa',
                login: 'admin',
                password: 'admin',
            })
            .end( (err, res) => {
                console.log('token=' + res.body.token);
                browser.driver
                    .get(`http://${domain}:${port}/login/`)
                    .then(
                        () => {
                            browser
                                .driver
                                .manage()
                                .addCookie(
                                    'token',
                                    res.body.token

                                )
                                .then(
                                    () => {
                                        done();
                                    }
                                )
                            ;
                        });
                    }
                );

    });

    beforeEach(function(done){
        browser
            .get(`http://${domain}:${port}/admin/#/${entity}/list`)
            .then( () => {
                setTimeout(done, 2000);
            })
        ;
    });

    xdescribe('Log on to a Pages list', function () {
        beforeEach(function(done){
            browser
                .get(`http://${domain}:${port}/admin/#/dashboard`)
                .then( () => {
                    setTimeout(done, 2000);
                })
            ;
        });      
        it('should display a correct url', function() {
            $$('.nav li a').first().click();
        	expect(browser.getCurrentUrl()).toEqual(`http://${domain}:${port}/admin/#/${entity}/list`);
        });
    });

    xdescribe('Testing a Pages list', function () {
        it('should display 3 headers in a Pages list', function() {
            $$('table thead tr th a').then(function (links) {
                expect(links.length).toBe(3);
                expect(links[0].getText()).toBe('Title');
                expect(links[1].getText()).toBe('Slug');
                expect(links[2].getText()).toBe('Text');
            });
        });
        it('should display 2 items in a Pages list', function() {
            let listItems = element.all(by.repeater('entry in entries'));
            expect(listItems.count()).toEqual(2);
        });
    });

    xdescribe('Show link', function () {
        it('should allow display of an entity', function () {
            $$('table tr:nth-child(1) ma-show-button a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('/pages/show');
            });
        });
    });

    xdescribe('Edition link', function () {
        it('should allow edition of an entity', function () {
            $('table tr:nth-child(1) ma-edit-button a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('/pages/edit/');
            });
        });
    });

    xdescribe('Delete link', function () {
        it('should allow a correct url', function () {
            $('table tr:nth-child(1) ma-delete-button a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('/pages/delete/');
            });
        });
    });

    xdescribe('Delete link', function () {
        it('should allow a correct url', function () {
            $('table tr:nth-child(1) ma-delete-button a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('/pages/delete/');
            });
        });
    });

    xdescribe('Create link', function () {
        it('should display a correct url', function () {
            $('ma-create-button a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('/pages/create');
            });
        });
    });

    xdescribe('work checkbox', function () {
        it('should display a new button which excrete all pages', function () {
            $('table thead tr ma-datagrid-multi-selector input').click();
            $$('table tbody tr').then(function(pages){
                let cnt = pages.length;
                let text = $('ma-view-batch-actions button').getText();
                expect(text).toBe(`${cnt} Selected`);
            });

        });
        it('should display a new button which choice specific pages', function () {
            $$('table tr ma-datagrid-item-selector input').then(function(item){
                item[0].click();
                let text = $('ma-view-batch-actions button').getText();
                expect(text).toBe(`1 Selected`);
                item[1].click();
                text = $('ma-view-batch-actions button').getText();
                expect(text).toBe(`2 Selected`);
            });
        });
    });

    describe('Sorting pages', function () {
        it('should display a sorting by title', function () {
            $('.ng-admin-column-title a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.title&sortDir=ASC');
            });
            $('.ng-admin-column-title a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.title&sortDir=DESC');
            });
        });
        it('should display a sorting by slug', function () {
            $('.ng-admin-column-slug a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.slug&sortDir=ASC');
            });
            $('.ng-admin-column-slug a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.slug&sortDir=DESC');
            });
        });
        it('should display a sorting by text', function () {
            $('.ng-admin-column-text a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.text&sortDir=ASC');
            });
            $('.ng-admin-column-text a').click();
            browser.getLocationAbsUrl().then(function(url) {
                expect(url).toContain('list?sortField=pages_ListView.text&sortDir=DESC');
            });
        });
    });

    xdescribe('Export link', function () {
        it('should be the next AJAX request url', function () {
            $$('table tr ma-datagrid-item-selector input').then(function(){

            });
        });
    });
});