<?php
return array(
    'ZourceProject\\V1\\Rest\\Project\\Controller' => array(
        'description' => 'The project service gets information about projects within Zource.',
        'collection' => array(
            'description' => 'A collection of projects within Zource.',
        ),
        'entity' => array(
            'description' => 'The representation of a project within Zource.',
        ),
    ),
    'ZourceProject\\V1\\Rest\\Category\\Controller' => array(
        'description' => 'The category service manages project categories within Zource.',
        'collection' => array(
            'description' => 'A collection with project categories.',
            'GET' => array(
                'description' => 'Gets the project categories.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category"
       },
       "first": {
           "href": "/api/project-category?page={page}"
       },
       "prev": {
           "href": "/api/project-category?page={page}"
       },
       "next": {
           "href": "/api/project-category?page={page}"
       },
       "last": {
           "href": "/api/project-category?page={page}"
       }
   }
   "_embedded": {
       "category": [
           {
               "_links": {
                   "self": {
                       "href": "/api/project-category[/:category_id]"
                   }
               }
              "id": "The identifier of the project category.",
              "name": "The name of the project category."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Creates a new project category.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category[/:category_id]"
       }
   }
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
                'request' => '{
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
            ),
        ),
        'entity' => array(
            'description' => 'The representation of a project category.',
            'GET' => array(
                'description' => 'Gets the project category.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category[/:category_id]"
       }
   }
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates the project category partially.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category[/:category_id]"
       }
   }
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
                'request' => '{
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
            ),
            'PUT' => array(
                'description' => 'Updates the project category.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category[/:category_id]"
       }
   }
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
                'request' => '{
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes the project category.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/project-category[/:category_id]"
       }
   }
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
                'request' => '{
   "id": "The identifier of the project category.",
   "name": "The name of the project category."
}',
            ),
        ),
    ),
);
