<?php

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

if (!function_exists('customPaginate')) {
    /**
     * Custom pagination for index endpoints with a default limit of 10.
     *
     * @param Model|Builder $model
     * @param array $collectionInfo An array containing properties to modify the model and collection (Currently accepted properties: sort_by_property, relations, resource, property_name).
     * @param int $limit
     * @param array $filters
     * @return array An array containing the paginated data and pagination details.
     */
    function customPaginate(Model|Builder $model, array $collectionInfo, int $limit, array $filters = []): array
    {
        $sortByProperty = $collectionInfo['sort_by_property'] ?? 'created_at';
        $sortedItems = $model->orderBy($sortByProperty, $collectionInfo['order_direction'] ?? 'asc');

        if (array_key_exists('relations', $collectionInfo)) {
            $sortedItems->with($collectionInfo['relations']);
        }

        if ($filters) {
            $sortedItems->filters($filters);
        }

        $paginatedItems = $sortedItems->paginate($limit);
        $items = $paginatedItems->items();

        $paginationData = array_diff_key($paginatedItems->toArray(), ['data' => null]);

        $resource = $collectionInfo['resource'];
        $propertyName = $collectionInfo['property_name'];

        return [
            $propertyName => $resource::collection($items),
            'pagination' => $paginationData,
        ];
    }
}

if (!function_exists('paginateCollection')) {
    /**
     * Paginate a collection of items.
     *
     * @param \Illuminate\Support\Collection $results
     * @param mixed $page
     * @param mixed $perPage
     * @param mixed $path
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginateCollection(Collection $collection, mixed $page = null, mixed $limit = null, mixed $path = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $perPage = $limit ?? 10;

        $items = array_values($collection->flatten()->forPage($page, $perPage)->toArray());

        $paginator = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page
        );

        if ($path != null) {
            $paginator->setPath($path);
        }

        return $paginator;
    }
}

if (!function_exists('paginateArray')) {
    /**
     * Paginate a collection of items.
     *
     * @param \Illuminate\Support\Collection $results
     * @param mixed $page
     * @param mixed $perPage
     * @param mixed $path
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function paginateArray(array $array, mixed $page = null, mixed $limit = null, mixed $path = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $perPage = $limit ?? 10;

        $collection = collect($array);

        $items = array_values($collection->forPage($page, $perPage)->toArray());

        $paginator = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page
        );

        if ($path != null) {
            $paginator->setPath($path);
        }

        return $paginator;
    }
}

if (!function_exists('generateReferralCode')) {
    /**
     * Generate a referral code.
     *
     * @param int $length
     * @return string
     */
    function generateReferralCode($length = 8): string
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $referralCode = '';
        for ($i = 0; $i < $length; $i++) {
            $referralCode .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $referralCode;
    }
}

if (!function_exists('generateRandomString')) {
    /**
     * Generate a random string.
     *
     * @param int $length.
     * @param bool $alphaOnly Whether to include only alphabets or only numbers.
     * @param string $alphabetType The type of alphabets to include in the string.
     *                             Accepted values: 'uppercase', 'lowercase', 'mix' (default).
     * @return string
     */
    function generateRandomString(int $length = 8, bool $alphaOnly = false, string $alphabetType = 'mix'): string
    {
        if (
            $alphabetType != 'uppercase' &&
            $alphabetType != 'lowercase' &&
            $alphabetType != 'mix'
        ) {
            throw new \InvalidArgumentException('Invalid alphabet type.');
        }

        $numbers = '0123456789';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';

        switch ($alphabetType) {
            case 'uppercase':
                $alphabets = $uppercase;
                break;
            case 'lowercase':
                $alphabets = $lowercase;
                break;
            case 'mix':
            default:
                $alphabets = $uppercase . $lowercase;
                break;
        }

        $characters = $alphaOnly ? $alphabets : $alphabets . $numbers;
        $randString = '';

        for ($i = 0; $i < $length; $i++) {
            $randString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $randString;
    }
}

if (!function_exists('csvToArray')) {
    /**
     * Return array from file csv, skipping the first row
     */
    function csvToArray(array $headers, string $filename, string $delimiter = ';', int $chunkSize = 1000): array
    {
        $data = [];

        if (!file_exists($filename) || !is_readable($filename)) {
            return $data;
        }

        $handle = fopen($filename, 'r');
        if ($handle !== false) {

            // Skip the first row of the csv file
            fgetcsv($handle, 1000, $delimiter);

            // While file has not yet reached the end of file, run the logic inside the loop
            while (!feof($handle)) {
                $chunk = [];
                for ($i = 0; $i < $chunkSize && ($row = fgetcsv($handle, 1000, $delimiter)) !== false; $i++) {
                    $chunk[] = array_combine($headers, $row);
                }

                $data = array_merge($data, $chunk);
            }
            fclose($handle);
        }

        return $data;
    }
}

if (!function_exists('generateInvoiceNumber')) {
    /**
     * Generate a random numbers sequence for orders invoice number.
     *
     * @return string
     */
    function generateInvoiceNumber(): string
    {
        $prefix = 'INVOICE';
        $day = strtoupper(now()->format('D'));
        $timestamp = now()->timestamp;

        // Combine parts to form the invoice number
        $invoiceNumber = sprintf('%s-%s-%s', $prefix, $day, $timestamp);

        return $invoiceNumber;
    }
}

if (!function_exists('generateReceiptNumber')) {
    /**
     * Generate a random numbers sequence for delivery orders receipt number.
     *
     * @return string
     */
    function generateReceiptNumber(): string
    {
        $maxValue = pow(10, 16) - 1;
        $receiptNumber = Str::padLeft(random_int(0, $maxValue), 16, '0');

        return $receiptNumber;
    }
}

if (!function_exists('generateInvoiceNumberUser')) {
    /**
     * Generate a random numbers sequence for orders invoice number.
     *
     * @return string
     */
    function generateInvoiceNumberUser(): string
    {
        $prefix = 'INVOICE';
        $timestamp = now()->timestamp;

        // Combine parts to form the invoice number
        $invoiceNumber = sprintf('%s-%s', $prefix, $timestamp);

        return $invoiceNumber;
    }
}


if (!function_exists('generateOTP')) {
    /* Generate Random OTP */
    function generateOTP()
    {
        $otp =  rand(100000, 999999);
        // updateCacheOtp($email, $otp);

        return $otp;
    }
}

if (!function_exists('updateCacheOtp')) {
    function updateCacheOtp($email, $otp, $time = 5)
    {
        $cache = Cache::put('otp:' . $email, $otp, now()->addMinutes($time));
        return $cache;
    }
}

if (!function_exists('getCacheOtp')) {
    function getCacheOtp($email)
    {
        $cache = Cache::get('otp:' . $email);
        return $cache;
    }
}

if (!function_exists('forgetCacheOtp')) {
    function forgetCacheOtp($email)
    {
        $cache = Cache::forget('otp:' . $email);
        return $cache;
    }
}

if (!function_exists('splitName')) {
    function splitName($fullName)
    {
        $nameParts = explode(' ', trim($fullName));
        $firstName = array_shift($nameParts); // Ambil kata pertama sebagai first_name
        $lastName = implode(' ', $nameParts); // Gabungkan sisanya sebagai last_name

        return [
            'first_name' => $firstName,
            'last_name'  => $lastName ?: $firstName, // Jika tidak ada last name, duplikasi first_name
        ];
    }
}
