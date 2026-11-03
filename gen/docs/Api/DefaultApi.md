# OpenAPI\Client\DefaultApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**deleteV1DeleteAuthor()**](DefaultApi.md#deleteV1DeleteAuthor) | **DELETE** /api/v1/authors/{id} |  |
| [**deleteV1DeleteBook()**](DefaultApi.md#deleteV1DeleteBook) | **DELETE** /api/v1/books/{id} |  |
| [**getV1GetAuthor()**](DefaultApi.md#getV1GetAuthor) | **GET** /api/v1/authors/{id} |  |
| [**getV1GetAuthors()**](DefaultApi.md#getV1GetAuthors) | **GET** /api/v1/authors |  |
| [**getV1GetBook()**](DefaultApi.md#getV1GetBook) | **GET** /api/v1/books/{id} |  |
| [**getV1GetBooks()**](DefaultApi.md#getV1GetBooks) | **GET** /api/v1/books |  |
| [**postV1CreateAuthor()**](DefaultApi.md#postV1CreateAuthor) | **POST** /api/v1/authors |  |
| [**postV1CreateBook()**](DefaultApi.md#postV1CreateBook) | **POST** /api/v1/books |  |
| [**putV1UpdateAuthor()**](DefaultApi.md#putV1UpdateAuthor) | **PUT** /api/v1/authors/{id} |  |
| [**putV1UpdateBook()**](DefaultApi.md#putV1UpdateBook) | **PUT** /api/v1/books/{id} |  |


## `deleteV1DeleteAuthor()`

```php
deleteV1DeleteAuthor($id)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->deleteV1DeleteAuthor($id);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->deleteV1DeleteAuthor: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteV1DeleteBook()`

```php
deleteV1DeleteBook($id)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->deleteV1DeleteBook($id);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->deleteV1DeleteBook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getV1GetAuthor()`

```php
getV1GetAuthor($id)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->getV1GetAuthor($id);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getV1GetAuthor: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getV1GetAuthors()`

```php
getV1GetAuthors()
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->getV1GetAuthors();
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getV1GetAuthors: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getV1GetBook()`

```php
getV1GetBook($id)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $apiInstance->getV1GetBook($id);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getV1GetBook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getV1GetBooks()`

```php
getV1GetBooks()
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->getV1GetBooks();
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getV1GetBooks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postV1CreateAuthor()`

```php
postV1CreateAuthor($create_author_request)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$create_author_request = new \OpenAPI\Client\Model\CreateAuthorRequest(); // \OpenAPI\Client\Model\CreateAuthorRequest

try {
    $apiInstance->postV1CreateAuthor($create_author_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->postV1CreateAuthor: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_author_request** | [**\OpenAPI\Client\Model\CreateAuthorRequest**](../Model/CreateAuthorRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postV1CreateBook()`

```php
postV1CreateBook($create_book_request)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$create_book_request = new \OpenAPI\Client\Model\CreateBookRequest(); // \OpenAPI\Client\Model\CreateBookRequest

try {
    $apiInstance->postV1CreateBook($create_book_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->postV1CreateBook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_book_request** | [**\OpenAPI\Client\Model\CreateBookRequest**](../Model/CreateBookRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `putV1UpdateAuthor()`

```php
putV1UpdateAuthor($id, $update_author_request)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$update_author_request = new \OpenAPI\Client\Model\UpdateAuthorRequest(); // \OpenAPI\Client\Model\UpdateAuthorRequest

try {
    $apiInstance->putV1UpdateAuthor($id, $update_author_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->putV1UpdateAuthor: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **update_author_request** | [**\OpenAPI\Client\Model\UpdateAuthorRequest**](../Model/UpdateAuthorRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `putV1UpdateBook()`

```php
putV1UpdateBook($id, $update_book_request)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string
$update_book_request = new \OpenAPI\Client\Model\UpdateBookRequest(); // \OpenAPI\Client\Model\UpdateBookRequest

try {
    $apiInstance->putV1UpdateBook($id, $update_book_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->putV1UpdateBook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |
| **update_book_request** | [**\OpenAPI\Client\Model\UpdateBookRequest**](../Model/UpdateBookRequest.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
