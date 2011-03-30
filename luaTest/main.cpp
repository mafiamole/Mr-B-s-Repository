extern "C" {
#include "lua5.1/lua.h"
#include "lua5.1/lualib.h"
#include "lua5.1/lauxlib.h"
}
#include <SFML/Graphics.hpp>
#include <string>
#include <iostream>
#include <list>
#include "drawing.h"



  static int resourcesAdd(lua_State *L) {
    
    int n = lua_gettop(L); /* number of arguments */
    if (!lua_isstring(L,0)) {
      lua_pushstring(L,"First argument is not a string!");
    }
    
  }
  



static const luaL_reg resources[] =
{
    { "add", resourcesAdd},
    { NULL, NULL }
};

void report_errors(lua_State *L, int status)
{
  if ( status!=0 ) {
    std::cerr << "-- " << lua_tostring(L, -1) << std::endl;
    lua_pop(L, 1); // remove error message
  }
}     
int main(int argc, char **argv) {

    // Create the main rendering window
    lua_State *L = lua_open();
    luaL_openlibs(L);
    luaL_register(L,"resource",resources);
    addFunctions(L);
    int s = luaL_dofile(L, "foo.lua");
    //run script function with no arguments
    lua_getfield(L,LUA_GLOBALSINDEX,"bob");
    lua_call(L,0,0);

   
    report_errors(L, s);
    // Start game loop
        sf::RenderWindow App(sf::VideoMode(800, 600, 32), "SFML Graphics");

    while (App.IsOpened())
    {
        // Process events
        sf::Event Event;
        while (App.GetEvent(Event))
        {
            // Close window : exit
            if (Event.Type == sf::Event::Closed)
                App.Close();
        }

        // Clear the screen (fill it with black color)
        App.Clear();
        renderPages(App);
        // Display window contents on screen
        App.Display();
    }
    lua_close(L);

    return EXIT_SUCCESS;

}
