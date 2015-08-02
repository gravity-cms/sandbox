Gravity CMS Bundle
==================

This bundle is the core Gravity CMS code.

## What is GravityCMS?
Gravity is an extension on SonataCMS and provides and easier method of crating node entities and fields in a simple
yaml configuration.

## What's in this bundle?
This bundle handles the core functionality:
- Node management (administration, routing, fields, search)
- Field management (administration)
- Form helpers

## What are Nodes and Fields?
A Node is an entity that resolves directly to a URL, for example a page or blog post.
A Field is any type of data that the user enter into a Node.

In Gravity, a Field has a Definition class and a Widget class. The Widget class will handle how the Field is displayed
on the CRUD forms.

## OK, so how does it work?
Lets say we had a `Page` entity. The `Page` will have a `title`, `body` and an `image` (The image field requires the
GravityMediaBundle, but the principle is the same). So, first, we need to create our entity:

```php
<?php

namespace Acme\DemoBundle\Entity;

use Gravity\CmsBundle\Entity\Node;    
    
/**
 * @ORM\Entity
 */
class Page extends Node 
{
    protected $title;
    
    protected $body;
    
    protected $image;
    
    // getters and setters
}
```

Next, we create our mapping file in `Resources/config/gravity/Page.node.yml`:

```yml
routing:
  path: /{title}
  extendable: true

search:
  handler: Gravity\CmsBundle\Search\Handler\NodeHandler

fields:
  title:  
    type: text
    options: 
      limit: 1
      required: true
      char_min: 10
    widget:
      type: text.unformatted
      options: ~
      
  body:
    type: text
    options:
      limit: 1
      required: true
      char_min: 100
      char_max: 10000
    widget:
      type: text.formatted
      options:
        default: 'Default Text'

  image:
    type: media
    options:
      limit: 1
    widget:
      limit: 1
      required: true
      entity: Gravity\MediaBundle\Entity\Media
      provider: sonata.media.provider.image
      provider_context: default
    widget:
      type: gravity.media
      options:
        image_preview: big
```

Then run:
```bash
./app/console cache:clear
./app/console doctrine:schema:update --force
```

And that is it! When you go into your admin dashboard, you will see that the new fields are displayed and ready to edit.
