<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models {
	/**
	 * App\Models\Cart
	 *
	 * @property int $id
	 * @property string $cart_id
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
	 * @property-read int|null $products_count
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCartUid($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
	 */
	class Cart extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\Feedback
	 *
	 * @property int $id
	 * @property string $name
	 * @property string $message
	 * @property string|null $ip
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereIp($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereMessage($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
	 */
	class Feedback extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\Item
	 *
	 * @property int $id
	 * @property string $name
	 * @property string|null $photo
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
	 * @property-read int|null $products_count
	 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemPhoto($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
	 */
	class Item extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\Product
	 *
	 * @property int $id
	 * @property string $name
	 * @property float $price
	 * @property float $discount
	 * @property string|null $photo
	 * @property int $item_id
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
	 * @property-read int|null $carts_count
	 * @property-read \App\Models\Item $item
	 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereItemId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductDiscount($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductPhoto($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductPrice($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
	 */
	class Product extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\Setting
	 *
	 * @property int $id
	 * @property string|null $store_name
	 * @property string|null $store_logo
	 * @property string|null $store_currency
	 * @property string|null $home_title
	 * @property string|null $whatsapp_phone
	 * @property string|null $contact_phone1
	 * @property string|null $contact_phone2
	 * @property string|null $contact_address
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereContactAddress($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereContactPhone1($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereContactPhone2($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereHomeTitle($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereStoreCurrency($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereStoreLogo($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereStoreName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereWhatsappPhone($value)
	 */
	class Setting extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\User
	 *
	 * @property int $id
	 * @property string $name
	 * @property string $password
	 * @property string|null $photo
	 * @property \Illuminate\Support\Carbon|null $email_verified_at
	 * @property string|null $remember_token
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
	 * @property-read int|null $notifications_count
	 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
	 * @property-read int|null $tokens_count
	 * @method static \Database\Factories\UserFactory factory(...$parameters)
	 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|User query()
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
	 */
	class User extends \Eloquent
	{
	}
}

namespace App\Models {
	/**
	 * App\Models\Vistor
	 *
	 * @property int $id
	 * @property string $ip
	 * @property int|null $hits
	 * @property string|null $user_agent
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor query()
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereHits($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereIp($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereUpdatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|Vistor whereUserAgent($value)
	 */
	class Vistor extends \Eloquent
	{
	}
}
