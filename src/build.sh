#/usr/bin/env bash

# Test-Build & Test
export LD_LIBRARY_PATH=`pwd`/lib:$LD_LIBRARY_PATH
export PATH=`pwd`/roma_root:$PATH
make clean
if [ "$WITH_TEST" == "1" ];then
    make bin/rmcc_test DEBUG=1 CXXFLAGS='-DWITH_NORMAL_TEST -DWITH_PROTOCOL_TEST -DWITH_LOOP_CONN_TEST'
    if [ "$M64" == "1" ]; then
        ./bin/rmcc_test64d
    else
        ./bin/rmcc_testd
    fi
fi
# Build
make rmcc
# valgrind -v --leak-check=yes --track-origins=yes ./bin/rmcc_testd
