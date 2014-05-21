#!/usr/bin/env bash
cd `dirname $0`
export LD_LIBRARY_PATH=`pwd`/../lib:$LD_LIBRARY_PATH
export TZ=Asia/Tokyo 
if [ "$M64" == "1" ]; then
    pecl-gen -f rmcc64.xml
else
    pecl-gen -f rmcc.xml
fi
cd phprmcc
phpize
if [ "$WITH_CONFIGURE" == "1" ];then
    ./configure CPPFLAGS="-I`pwd`/../../include"
    mv Makefile Makefile.org
    sed -e "s/\$(PHP_EXECUTABLE) -n -c \$(top_builddir)\/tmp-php\.ini \$(PHP_TEST_SETTINGS) \$(top_srcdir)\/run-tests\.php -n -c \$(top_builddir)\/tmp-php\.ini -d extension_dir=\$(top_builddir)\/modules\/ \$(PHP_TEST_SHARED_EXTENSIONS) \$(TESTS); \\\/\$(PHP_EXECUTABLE) -n \$(PHP_TEST_SETTINGS) \$(top_srcdir)\/run-tests\.php -n -c \$(top_builddir)\/tmp-php\.ini -d extension_dir=\$(top_builddir)\/modules\/ \$(PHP_TEST_SHARED_EXTENSIONS) \$(TESTS); \\\/" Makefile.org > Makefile
fi
make clean all test LDFLAGS=-L../../lib
cd ..
if [ "$WITH_TEST" == "1" ];then
    `which phpunit` --coverage-html xdebug PhpunitEnv
    source php.env
    cp -f $PHP_EXT_DIR/* `pwd`/phprmcc/modules/
    echo "extension_dir=`pwd`/phprmcc/modules" > php.ini 
    #echo "extension_dir=/usr/lib/php/modules"
    echo "extension=phprmcc.so" >> php.ini 
    echo "zend_extension=`pwd`/xdebug/xdebug.so" >> php.ini 
    php -c php.ini `which phpunit` --coverage-html xdebug test/AllTest
fi
# sudo make install
