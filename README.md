# Photon

An Extension for the Lumen for SRP (Single Responsibility Principle).

### How to use

1. install the package using the following command

```bash
composer require moeen-basra/photon-lumen
```

2. Open the file `bootstrap/app.php` and register `Photon\Foundation\Providers\HttpServiceProvider`

```
$app->register(Photon\Foundation\Providers\HttpServiceProvider::class);
```

3. Open the file `app/Http/Controllers/Controller.php` and replace the following code

`use Laravel\Lumen\Routing\Controller as BaseController;`

with this

`use Photon\Foundation\Controller as BaseController;`

4. Open the file `app\Exceptions\Handler` extend it from `\Photon\Foundation\Exceptions\Handler\Handler`

5. Now you have to can create the following directories in the `app` folder.

```
|-- app
|  |-- Domains
|  |-- Features
|  |-- Operations
```

Great now you are good to go.

Here is a sample code for a controller serving the feature.

```php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Photon\Foundation\Controller;
use App\Features\Api\Auth\RegisterFeature;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['only' => 'me', 'logout', 'refresh']);
    }

    /**
     * Register user
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        return $this->serve(RegisterFeature::class);
    }
}

```

Here is sample code for Feature running the jobs and operations

```php
namespace App\Features\Api\Auth;

use Photon\Foundation\Feature;
use App\Operations\Auth\RegisterOperation;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Domains\Auth\Jobs\Register\ValidateRegisterRequestJob;

class RegisterFeature extends Feature
{
    public function handle()
    {
        $input = $this->run(ValidateRegisterRequestJob::class);

        $data = $this->run(RegisterOperation::class, compact('input'));

        return $this->run(new JsonResponseJob($data));
    }
}
```
