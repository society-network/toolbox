 The following describes the use cases for each directory as listed.

    application/: This directory contains your application. It will house the MVC system, as well as configurations, services used, and your bootstrap file.

        configs/: The application-wide configuration directory.

        controllers/, models/, and views/: These directories serve as the default controller, model or view directories. Having these three directories inside the application directory provides the best layout for starting a simple project as well as starting a modular project that has global controllers/models/views.

        controllers/helpers/: These directories will contain action helpers. Action helpers will be namespaced either as "Controller_Helper_" for the default module or "<Module>_Controller_Helper" in other modules.

        layouts/: This layout directory is for MVC-based layouts. Since Zend_Layout is capable of MVC- and non-MVC-based layouts, the location of this directory reflects that layouts are not on a 1-to-1 relationship with controllers and are independent of templates within views/.

        modules/: Modules allow a developer to group a set of related controllers into a logically organized group. The structure under the modules directory would resemble the structure under the application directory.

        services/: This directory is for your application specific web-service files that are provided by your application, or for implementing a » Service Layer for your models.

        Bootstrap.php: This file is the entry point for your application, and should implement Zend_Application_Bootstrap_Bootstrapper. The purpose for this file is to bootstrap the application and make components available to the application by initializing them.

    data/: This directory provides a place to store application data that is volatile and possibly temporary. The disturbance of data in this directory might cause the application to fail. Also, the information in this directory may or may not be committed to a subversion repository. Examples of things in this directory are session files, cache files, sqlite databases, logs and indexes.

    docs/: This directory contains documentation, either generated or directly authored.

    library/: This directory is for common libraries on which the application depends, and should be on the PHP include_path. Developers should place their application's library code under this directory in a unique namespace, following the guidelines established in the PHP manual's » Userland Naming Guide, as well as those established by Zend itself. This directory may also include Zend Framework itself; if so, you would house it in library/Zend/.

    public/: This directory contains all public files for your application. index.php sets up and invokes Zend_Application, which in turn invokes the application/Bootstrap.php file, resulting in dispatching the front controller. The web root of your web server would typically be set to this directory.

    scripts/: This directory contains maintenance and/or build scripts. Such scripts might include command line, cron, or phing build scripts that are not executed at runtime but are part of the correct functioning of the application.

    temp/: The temp/ folder is set aside for transient application data. This information would not typically be committed to the applications svn repository. If data under the temp/ directory were deleted, the application should be able to continue running with a possible decrease in performance until data is once again restored or recached.

    tests/: This directory contains application tests. These could be hand-written, PHPUnit tests, Selenium-RC based tests or based on some other testing framework. By default, library code can be tested by mimicing the directory structure of your library/ directory. Additionally, functional tests for your application could be written mimicing the application/ directory structure (including the application subdirectory).
