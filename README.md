# Detective

Eloquent extension for advanced filtering. Designed to be used with URL parameters in API context.

## Installation 

As the repository is not on packagist yet, you must add a custom repository field to your composer.json file.

```json
"repositories": [
    {
        "type": "package",
        "package": {
            "name": "lucasbedout/detective",
            "version": "dev-master",
            "source": {
                "url": "git://github.com/lucasbedout/detective.git",
                "type": "git",
                "reference": "master"
            },
            "autoload": {
                "psr-4" : {
                    "Detective\\" : "src"
                }
            }
        }
    }
]
```

Then add a line to the `require` section.

	"lucasbedout/detective": "dev-master"

And install it.

	composer update 


## Configuration

Just replace Eloquent by the detective model in your model files.

```php 

use \Detective\Model as Detective;

class YourModel extends Detective 
{
	// Classic eloquent class
}

``` 

If you need relationship filtering, just list your relationship methods like this.

```php 

use \Detective\Model as Detective;

class YourModel extends Detective 
{
	public static $relationships = ['relation1', 'relation2'];

	public function relation1() 
	{
		return $this->belongsTo('Relation1');
	}

	public function relation2() 
	{
		return $this->belongsToMany('Relation2');
	}
}

```

## Usage example

You can use the test laravel server provided with the package to test it, you have products, categories and stores table with configured relationships.

*You can see the list of all valid syntaxes at the bottom of this file.*

Add the corresponding route 

```php

	Route::get('/products', function() {
		$products = Product::filter(Input::all())->get();

		return response()->json($products);
	});
```

Then just query it 

	/GET /products?name=iPhone*

Will return a list of products with their name starting with `iPhone` (caution, the search is case sensitive).

You can also query a relationship

	/GET /products?category-name=Laptop

And even a pivot value 

	/GET /products/?category-name=Laptop&stores-pivot-quantity=>5 

*This query will return all products in the Laptop category with at least one store where the quantity of products is > 5*

You can also use the filter method with a custom array

```php 

$array = ['name' => 'Home*', 'created_at' => '<2015-06-11'];

$products = Product::filter($array)->get(); // Products in the Home% categories, created before the 11/06/2015.


```

The filter method returns a query builder, so you can chain any builder method you need.

```php 

$products = Product::filter($data)->groupBy('category_id')->paginate(10);

```

## Advanced informations

The Detective\Model class create a class context when you call the Detective::filter() method, it retrieves all fields and types from the database, then check your $relationships array and if there is one, it retrieves also your relationships informations (keys, type, ...).

The array passed to `Detective::filter()` is parsed, the Detective\Filters\Builder class make a correspondance between your array and the table informations, then the query is builded.

The Detective\Database\Context class has a lot of useful public methods, just check the code !

## Valid filter syntaxes

### 3 atomic types 

- number `'int', 'double', 'float', 'decimal', 'tinyint'`
- string `'varchar', 'text', 'blob', 'longtext'`
- date `'date', 'datetime', 'timestamp', 'time'`

### Filtering parameter name 

You can use multiple syntaxe, each one corresponding to a model attribute or relation.

- `property` : filter by object property (ex : name=yourname)
- `relation` : filter by relation primary key (ex : category=1)
- `relation-property` : filter by relation property (ex : category-name=Laptop)
- `relation-property-last` : filter by relation property of the last relation object(ex : category-name-last=Laptop), also works with first
- `relation-pviot-property`: filter by relation pivot property (ex : stores-pivot-quantity=10)

### Filtering value format

Once you've named your parameter, you can provide the following values (all syntaxes work for relations or fields)

**Number**

- `id=1` : get model with id=1
- `id=1,2` : get model with id=1 OR id=2 
- `id=10,<5` : get model with id=10 OR id<5
- `id=5-10` : get model with id between 5 and 10 (SQL BETWEEN operator)

You can combine 

- `id=>5,1-10,<12,5` is a valid syntax

**String**

- `name=toto` : get model with name LIKE toto
- `name=toto*` : get model with name LIKE 'toto%'
- `name=toto*,*ta*ta*` : get model with name LIKE 'toto%' OR name LIKE '%ta%ta%'

**Date**

- `date=2015-03-03` : get model with date LIKE 2015-03-03
- `date=2015-03-03*` : get model with date LIKE 2015-03-03%
- `date=2015-03-03*,>2015-05-05` : get model with date LIKE 2015-03-03% OR date > 2015-05-05

### Order 

You can also provide an `orderby` parameter.

- orderby=name : order your results by name 
- orderby=name,created_at : order your results by name and creation date
- direction=asc / direction=desc : direction of your orderby parameters (will move in the future)

