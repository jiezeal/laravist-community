#使用ModelFactory生成测试数据

php artisan make:migration create_discussions_table --create=discussions
php artisan make:model Discussion

2014_10_12_000000_create_users_table.php
```
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('avatar');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

2017_03_04_063259_create_discussions_table.php
```
public function up()
{
    Schema::create('discussions', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('body');
        $table->integer('user_id')->unsigned();
        $table->integer('last_user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}
```

php artisan migrate

User.php
```
protected $fillable = [
    'name', 'email', 'password', 'avatar'
];
```

Discussion.php
```
protected $fillable = ['title', 'body', 'user_id', 'last_user_id'];
```

database/factories/ModelFactory.php
```
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl(256, 256),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
```

php artisan tinker
namespace App;
factory(User::class, 30)->create();

database/factories/ModelFactory.php
```
$factory->define(App\Discussion::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->toArray();

    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'last_user_id' => $faker->randomElement($user_ids),
    ];
});
```

php artisan tinker
namespace App;
factory(Discussion::class, 30)->create();



















