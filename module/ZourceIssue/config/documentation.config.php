<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

return array(
    'ZourceIssue\\V1\\Rest\\Component\\Controller' => array(
        'description' => 'A service to manage components.',
        'collection' => array(
            'description' => 'A collection with components.',
            'GET' => array(
                'description' => 'Gets the components that exist within Zource.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component"
       },
       "first": {
           "href": "/api/issue/component?page={page}"
       },
       "prev": {
           "href": "/api/issue/component?page={page}"
       },
       "next": {
           "href": "/api/issue/component?page={page}"
       },
       "last": {
           "href": "/api/issue/component?page={page}"
       }
   }
   "_embedded": {
       "component": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/component[/:component_id]"
                   }
               }
              "id": "The identifier of the component.",
              "name": "The name of the component."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Creates a new component.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component[/:component_id]"
       }
   }
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a list of components.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component"
       },
       "first": {
           "href": "/api/issue/component?page={page}"
       },
       "prev": {
           "href": "/api/issue/component?page={page}"
       },
       "next": {
           "href": "/api/issue/component?page={page}"
       },
       "last": {
           "href": "/api/issue/component?page={page}"
       }
   }
   "_embedded": {
       "component": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/component[/:component_id]"
                   }
               }
              "id": "The identifier of the component.",
              "name": "The name of the component."
           }
       ]
   }
}',
            ),
            'PUT' => array(
                'description' => 'Updates a list with components.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component"
       },
       "first": {
           "href": "/api/issue/component?page={page}"
       },
       "prev": {
           "href": "/api/issue/component?page={page}"
       },
       "next": {
           "href": "/api/issue/component?page={page}"
       },
       "last": {
           "href": "/api/issue/component?page={page}"
       }
   }
   "_embedded": {
       "component": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/component[/:component_id]"
                   }
               }
              "id": "The identifier of the component.",
              "name": "The name of the component."
           }
       ]
   }
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a list with components.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component"
       },
       "first": {
           "href": "/api/issue/component?page={page}"
       },
       "prev": {
           "href": "/api/issue/component?page={page}"
       },
       "next": {
           "href": "/api/issue/component?page={page}"
       },
       "last": {
           "href": "/api/issue/component?page={page}"
       }
   }
   "_embedded": {
       "component": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/component[/:component_id]"
                   }
               }
              "id": "The identifier of the component.",
              "name": "The name of the component."
           }
       ]
   }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Represents a component.',
            'GET' => array(
                'description' => 'Gets the component with the given id.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component[/:component_id]"
       }
   }
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a component partially.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component[/:component_id]"
       }
   }
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
            ),
            'PUT' => array(
                'description' => 'Updates a component.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component[/:component_id]"
       }
   }
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a component.',
                'request' => '{
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/component[/:component_id]"
       }
   }
   "id": "The identifier of the component.",
   "name": "The name of the component."
}',
            ),
        ),
    ),
    'ZourceIssue\\V1\\Rest\\Field\\Controller' => array(
        'description' => 'A service to work with fields.',
        'collection' => array(
            'description' => 'A collection with fields.',
            'GET' => array(
                'description' => 'Gets a list with fields.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field"
       },
       "first": {
           "href": "/api/issue/field?page={page}"
       },
       "prev": {
           "href": "/api/issue/field?page={page}"
       },
       "next": {
           "href": "/api/issue/field?page={page}"
       },
       "last": {
           "href": "/api/issue/field?page={page}"
       }
   }
   "_embedded": {
       "field": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/field[/:field_id]"
                   }
               }
              "id": "The identifier of the field.",
              "type": "The type of the field.",
              "name": "The name of the field."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Creates a new field.',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field[/:field_id]"
       }
   }
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
            ),
            'PUT' => array(
                'description' => 'Updates a list with fields.',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field"
       },
       "first": {
           "href": "/api/issue/field?page={page}"
       },
       "prev": {
           "href": "/api/issue/field?page={page}"
       },
       "next": {
           "href": "/api/issue/field?page={page}"
       },
       "last": {
           "href": "/api/issue/field?page={page}"
       }
   }
   "_embedded": {
       "field": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/field[/:field_id]"
                   }
               }
              "id": "The identifier of the field.",
              "type": "The type of the field.",
              "name": "The name of the field."
           }
       ]
   }
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a list with fields partially.',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field"
       },
       "first": {
           "href": "/api/issue/field?page={page}"
       },
       "prev": {
           "href": "/api/issue/field?page={page}"
       },
       "next": {
           "href": "/api/issue/field?page={page}"
       },
       "last": {
           "href": "/api/issue/field?page={page}"
       }
   }
   "_embedded": {
       "field": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/field[/:field_id]"
                   }
               }
              "id": "The identifier of the field.",
              "type": "The type of the field.",
              "name": "The name of the field."
           }
       ]
   }
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a list with fields.',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field"
       },
       "first": {
           "href": "/api/issue/field?page={page}"
       },
       "prev": {
           "href": "/api/issue/field?page={page}"
       },
       "next": {
           "href": "/api/issue/field?page={page}"
       },
       "last": {
           "href": "/api/issue/field?page={page}"
       }
   }
   "_embedded": {
       "field": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/field[/:field_id]"
                   }
               }
              "id": "The identifier of the field.",
              "type": "The type of the field.",
              "name": "The name of the field."
           }
       ]
   }
}',
            ),
        ),
        'entity' => array(
            'description' => 'The representation of a field.',
            'GET' => array(
                'description' => 'Gets a field.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field[/:field_id]"
       }
   }
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a field partially.',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field[/:field_id]"
       }
   }
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
            ),
            'PUT' => array(
                'description' => 'Updates a field.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field[/:field_id]"
       }
   }
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a field.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field[/:field_id]"
       }
   }
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
                'request' => '{
   "id": "The identifier of the field.",
   "type": "The type of the field.",
   "name": "The name of the field."
}',
            ),
        ),
    ),
    'ZourceIssue\\V1\\Rest\\FieldType\\Controller' => array(
        'description' => 'The FieldType service gives all available field types.',
        'collection' => array(
            'description' => 'A collection with field types.',
            'GET' => array(
                'description' => 'Gets the field types that are available.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field-type"
       },
       "first": {
           "href": "/api/issue/field-type?page={page}"
       },
       "prev": {
           "href": "/api/issue/field-type?page={page}"
       },
       "next": {
           "href": "/api/issue/field-type?page={page}"
       },
       "last": {
           "href": "/api/issue/field-type?page={page}"
       }
   }
   "_embedded": {
       "field_type": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/field-type[/:field_type_id]"
                   }
               }
              "id": "The identifier of the field.",
              "name": "The name of the field.",
              "description": "The description of the field type."
           }
       ]
   }
}',
            ),
        ),
        'entity' => array(
            'description' => 'The representation of a field type.',
            'GET' => array(
                'description' => 'Gets a field type.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/field-type[/:field_type_id]"
       }
   }
   "id": "The identifier of the field.",
   "name": "The name of the field.",
   "description": "The description of the field type."
}',
            ),
        ),
    ),
    'ZourceIssue\\V1\\Rest\\Priority\\Controller' => array(
        'description' => 'A service to work with priorities.',
        'collection' => array(
            'description' => 'A collection of priorities.',
            'GET' => array(
                'description' => 'Gets the list with priorities.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority"
       },
       "first": {
           "href": "/api/issue/priority?page={page}"
       },
       "prev": {
           "href": "/api/issue/priority?page={page}"
       },
       "next": {
           "href": "/api/issue/priority?page={page}"
       },
       "last": {
           "href": "/api/issue/priority?page={page}"
       }
   }
   "_embedded": {
       "priority": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/priority[/:priority_id]"
                   }
               }
              "id": "The identifier of the priority.",
              "name": "The name of the priority.",
              "description": "The description of the priority.",
              "position": "The position of the priority."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Creates a new priority.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority[/:priority_id]"
       }
   }
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
            'PUT' => array(
                'description' => 'Updates a list with priorities.',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority"
       },
       "first": {
           "href": "/api/issue/priority?page={page}"
       },
       "prev": {
           "href": "/api/issue/priority?page={page}"
       },
       "next": {
           "href": "/api/issue/priority?page={page}"
       },
       "last": {
           "href": "/api/issue/priority?page={page}"
       }
   }
   "_embedded": {
       "priority": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/priority[/:priority_id]"
                   }
               }
              "id": "The identifier of the priority.",
              "name": "The name of the priority.",
              "description": "The description of the priority.",
              "position": "The position of the priority."
           }
       ]
   }
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a list with priorities partially.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority"
       },
       "first": {
           "href": "/api/issue/priority?page={page}"
       },
       "prev": {
           "href": "/api/issue/priority?page={page}"
       },
       "next": {
           "href": "/api/issue/priority?page={page}"
       },
       "last": {
           "href": "/api/issue/priority?page={page}"
       }
   }
   "_embedded": {
       "priority": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/priority[/:priority_id]"
                   }
               }
              "id": "The identifier of the priority.",
              "name": "The name of the priority.",
              "description": "The description of the priority.",
              "position": "The position of the priority."
           }
       ]
   }
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a list with priorities.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority"
       },
       "first": {
           "href": "/api/issue/priority?page={page}"
       },
       "prev": {
           "href": "/api/issue/priority?page={page}"
       },
       "next": {
           "href": "/api/issue/priority?page={page}"
       },
       "last": {
           "href": "/api/issue/priority?page={page}"
       }
   }
   "_embedded": {
       "priority": [
           {
               "_links": {
                   "self": {
                       "href": "/api/issue/priority[/:priority_id]"
                   }
               }
              "id": "The identifier of the priority.",
              "name": "The name of the priority.",
              "description": "The description of the priority.",
              "position": "The position of the priority."
           }
       ]
   }
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
        ),
        'entity' => array(
            'description' => 'The representation of a priority.',
            'GET' => array(
                'description' => 'Gets a priority.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority[/:priority_id]"
       }
   }
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates a priority partially.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority[/:priority_id]"
       }
   }
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
            'PUT' => array(
                'description' => 'Updates a priority.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority[/:priority_id]"
       }
   }
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes a priority.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/issue/priority[/:priority_id]"
       }
   }
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
                'request' => '{
   "id": "The identifier of the priority.",
   "name": "The name of the priority.",
   "description": "The description of the priority.",
   "position": "The position of the priority."
}',
            ),
        ),
    ),
);
