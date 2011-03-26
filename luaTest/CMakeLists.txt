cmake_minimum_required(VERSION 2.8)
project(luatest)
add_executable(luatest main.cpp)

Find_Package(SFML REQUIRED)

target_link_libraries(luatest ${SFML_LIBRARY})

