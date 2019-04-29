# Laravel Memo

## My Project
- Project Resource
- Csv Import(Insert, Update, Delete, Validation)
  - [LOAD DATA LOCAL INFILE](https://qiita.com/hondy12345/items/ca5fdc4573292f3fcf5d)
- Csv Download(chunk)
- Excel Batch Import|Import|Download(Laravel-excel)
- Pdf Download(Laravel-dompdf) 
- Intervention Image
- Multiple Authentication
- Event-Listener-Subscribe
- Vue.js[Invoice](https://github.com/codekerala/laravel-vuejs-invoice) 

## Memo
- Article CRUD[/]
- Table Relationship:Category-Post-Comment[/posts]
- php artisan make:auth
- CustomValidator[CustomValidator.php]
- SearchForm And Paginate[/]
- Image Upload: intervention/image library[/photos]
- CustomService And Design: Flat UI (Bootstrap)[/bmi/form]
- Students-Courses(ManyToMany)[/students]
- Seeder作成：Faker[CourseStudentSeeder.php]
- Vue.js[/todo]
- Custom Directive[/welcome]
- lang[/welcome]
- authentication[/home]
- authorize(add role to user)[/posts][/students]
- DB::listen(output sql:AppServiceProvider.php)
- Query Builder[/user]
- Eloquent(Scope,Observe)[/clover]
- Relation(hasMany manyToMany hasManyThrough Polymorphic)[/clover/{clover_name}]
  - Clover -> RelationHm hasMany
  - Clover -> RelationMtm manyToMany
  - Clover -> RelationHmt hasManyThrough
  - Image -> RelationHm RelationHmt Polymorphic 1:1
  - Thought -> RelationHm RelationHmt  Polymorphic 1:many
  - Category -> RelationHm RelationMtm Polymorphic many:many
- Relation check
  - has whereHas doesntHave whereDoesntHave [/clover] 
- withCount [/clover]
- Eager Loading
  - ::with(relation) [/relationHmt]
  - Lazy Eager Loading:load(relation) loadMissing(relation) [/clover/{clover_name}]
- Touching Parent Timestamps:[/RelationNullable]
- Accessors & Mutators[/RelationNullable]
- Attribute Casting[/clover/{clover_name}]
- Serializing
  - toJson[/clover_json]
  - makeVisible[/clover_makejson]
- Resource & Collection [App\Http\Resource]
- Pagination[/relationNullable]
  - Customize Pagination View: Paginator::defaultView('view-name');
- Event & Listener & Subscriber[posts/create]
- Queue(ProcessPost job):[/posts/{$id}]  
- File Storage[/file]
- View: Share Composer[/home]

  
