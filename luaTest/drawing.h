
#ifndef DRAWING_H
#define DRAWING_H
extern "C" {
#include "lua5.1/lua.h"
#include "lua5.1/lualib.h"
#include "lua5.1/lauxlib.h"
}
#include <vector>
#include <SFML/Graphics.hpp>
static int addPolygon(lua_State *L);
static int addLine(lua_State *L);
static int addCircle(lua_State *L);
static int addRect(lua_State *L);
void addFunctions(lua_State *L);
void renderPages(sf::RenderWindow &win);
#endif

