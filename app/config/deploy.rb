set :application, "syag-angular-symfony-admin"
set :domain,      "vps-14156.vps-ukraine.com.ua"
set :deploy_to,   "/home/admin/web/newcms.your-niceweb.com.ua/"
set :app_path,    "app"
set :symfony_console,       "bin/console"

set :repository,  "git@bitbucket.org:syagr/syag-angular-symfony-admin.git"
set :branch, "dev"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
role :db,         domain, :primary => true

set  :keep_releases,  3

set :interactive_mode, false
set :dump_assetic_assets, false

set :use_sudo, false
set :user, "root"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :composer_options,  "--verbose -o"

set :deploy_via, :rsync_with_remote_cache

set :shared_files,                      ["app/config/parameters.yml"]

#set :current, "public_html"
#before "symfony:assetic:dump", "symfony:node_install"
#before "symfony:assetic:dump", "symfony:chmod_app_777"
after "deploy:create_symlink", "symfony:install_admin_app"
after "deploy:create_symlink", "symfony:chmod_var_777"

namespace :symfony do
  desc "Node install assets modules"
  task :node_install do
    capifony_pretty_print "--> Node assets install"
    run "#{try_sudo} sh -c 'cd #{latest_release} && npm install'"
    capifony_puts_ok
  end
end


namespace :symfony do
  desc "Chmod 777 var"
  task :chmod_var_777 do
    capifony_pretty_print "--> Chmod 777 var"
    run "#{try_sudo} sh -c 'cd #{latest_release} && chmod 777 -R var && chmod 777 -R var/cache && chmod 555 -R web && chmod 555 -R app'"
    capifony_puts_ok
  end
end

namespace :symfony do
  desc "Gulp style"
  task :gulp_style do
    capifony_pretty_print "--> Gulp style"
    run "#{try_sudo} sh -c 'cd #{latest_release} && node_modules/gulp/bin/gulp.js styles'"
    capifony_puts_ok
  end
end

namespace :symfony do
  desc "Init admin aplication"
  task :install_admin_app do
    capifony_pretty_print "--> Init admin aplication"
    run " sh -c 'cd #{latest_release} && cd web/admin  && npm install && bower install --allow-root'"
    capifony_puts_ok
  end
end

