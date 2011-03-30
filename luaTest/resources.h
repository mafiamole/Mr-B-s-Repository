/*
    <one line to give the program's name and a brief idea of what it does.>
    Copyright (C) 2011  <copyright holder> <email>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/


#ifndef RESOURCES_H
#define RESOURCES_H
#include <SFML/Graphics.hpp>
#include <map>
#include <string>
class resources
{
protected:
  std::map<std::string,sf::Image> images;
  std::map<std::string,sf::Sprite> sprites;
public:
    resources();
    resources(const resources& other);
    void addImage(std::string name,std::string url);
    sf::Image& getImage(std::string name);
    virtual ~resources();
    virtual resources& operator=(const resources& other);
};

#endif // RESOURCES_H
