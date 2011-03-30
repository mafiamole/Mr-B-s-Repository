#include "drawing.h"
#include <iostream>
std::vector<sf::Shape> shapes;

static int addPolygon(lua_State *L) {
    int n = lua_gettop(L);    /* number of arguments */
    // does nothing yet.
}

static int addLine(lua_State *L) {

    int n = lua_gettop(L);    /* number of arguments */
    bool fail = false;
    if (n < 4) {

        lua_pushstring(L,"draw.line requires at least four arguments");

        lua_error(L);

    }

    else {

        float values[5];

        for (int ct =0; ct < 5; ct++) {

            if (lua_isnumber(L,ct+1)) {

                values[ct] = lua_tonumber(L,ct+1);
            }
            else {

                lua_pushstring(L,"Argument is not an number.");

                lua_error(L);

                fail = true;

            }

        }

          sf::Shape line = sf::Shape::Line(values[0],values[1],values[2],values[3],values[4],sf::Color(255,255,255));
           shapes.push_back(line);
            
        }


    
    return 0;
}

static int addCircle(lua_State *L) {
    int n = lua_gettop(L);    /* number of arguments */
    bool fail = false;
    if ( n < 3) {
      
      lua_pushstring(L,"draw.circle requires three arguments");
      lua_error(L);
      
    }
    else {
      
      float values[3];
      
      for (int ct =0;ct < 3;ct++) {
        
            if (lua_isnumber(L,ct + 1)) {

                values[ct] = lua_tonumber(L,ct + 1);

            }
            else {

                lua_pushstring(L,"Argument is not an number.");

                lua_error(L);

                fail = true;

            }
        
      }
      
      if (!fail) {
         
          sf::Shape line = sf::Shape::Circle(values[0],values[1],values[2],sf::Color(255,255,255));
          
          shapes.push_back(line);        
        
      }
      
    }

}

static int addRect(lua_State *L) {
  
    int n = lua_gettop(L);    /* number of arguments */
    
    bool fail = false;
    
    std::cout << "monster trucks" << std::endl;
    
    if ( n < 4) {
      
      lua_pushstring(L,"draw.rect requires four arguments");
      lua_error(L);
      
    }
    else {
      
      float values[4];
      
      for (int ct =0;ct < 4;ct++) {
        
            if (lua_isnumber(L,ct)) {

                values[ct] = lua_tonumber(L,ct);

            }
            else {

                lua_pushstring(L,"Argument is not an number.");

                lua_error(L);

                fail = true;

            }
        
      }
      
      if (!fail) {
        
          sf::Shape line = sf::Shape::Rectangle(values[0],values[1],values[2],values[3],sf::Color(255,255,255));
          
          shapes.push_back(line);        
        
      }
      
    }
  
}

// kate: indent-mode cstyle; space-indent on; indent-width 0; 
static const luaL_reg draw[] =
{
    { "polygon", addPolygon},
    { "line", addLine},
    { "circle", addCircle},
    { "rect", addRect},
    { NULL, NULL }
};

void addFunctions(lua_State* L)
{
  luaL_register(L,"draw",draw);
}

void renderPages(sf::RenderWindow &win) {
  for (int i = 0; i < shapes.size(); i++) {
    win.Draw(shapes[i]);
  }
}

