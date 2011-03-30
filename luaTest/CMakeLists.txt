cmake_minimum_required(VERSION 2.8)
project(luatest)
add_executable(luatest drawing.cpp resources.cpp main.cpp)
Find_Package(SFML REQUIRED)
Find_Package(Lua51 REQUIRED)

target_link_libraries(luatest ${SFML_LIBRARY})
target_link_libraries(luatest ${LUA_LIBRARIES})
