/*global angular,inject,describe,it,expect,beforeEach*/

xdescribe('Dashboard', function() {
    'use strict';

    var domain = 'localhost';
    var port   = '8000';
    var token = null;
    var request = require( "superagent" );

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
            .get(`http://${domain}:${port}/admin/#/dashboard`)
            .then( () => {
                setTimeout(done, 2000);
            })
        ;
    });

    it('should display a correct title', function() {
        expect(browser.getTitle()).toEqual('Admin');
    });

    it('should display a navigation menu linking to all entities', function() {
        $$('.nav li').then(function (items) {
            expect(items.length).toBe(1);
            expect(items[0].getText()).toBe('Pages');
        });
    });

    it('should display a correct name for admin page', function() {
        let nameAdminPage = element(by.css('.navbar-brand')).getText();
        expect(nameAdminPage).toEqual('Test admin');     
    });

    it('should display a panel for each entity with a list of recent items', function() {
        $$('.panel').then(function (panels) {
            expect(panels.length).toBe(1);
            expect(panels[0].all(by.css('.panel-heading')).first().getText()).toBe('Pages');
        });
    });
});