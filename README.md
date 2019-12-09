# Simple login application

## Requirements

# Basic development rules during the implementation

- Use Git for versioning
    - Use branches and clear commits
    - Create pull-requests
    - Use clear commit messages (commits *SHOULD NOT* contains changes what not belongs the description)
- Use Continuous Integration (CI) (ie: TravisCI)
- Use some tool for code-formatting, which helps the team co-work. (ie: php-cs-fixer, PSR2) 
- Use Ubiquity language for better communication between the Product Owner and the developers
- Separate application and domain code
- Use some basic tool for code quality improvement (ie: php-md, etc)
- Program in TDD, cover the code
- Use ORM (DataMapper instead of ActiveRecord)

## Steps

- Install the framework
- Add Doctrine (DataMapper ORM) to project 
- Add php-cs-fixer
- Add Laravel default authentication module
- Customize the table to fit domain requirements (use username instead of email for login)
    - Use migrations to change to scheme
- Create the User entity
- Change Auth driver from `eloquent` to `doctrine`
- `User` entity implements `Authenticatable` interface
- Create `UserRepository`, `RepositoryServiceProvider`, `RegistrationService`

# Issues

1. `laravel-doctrine/orm` ***has a bug*** in `DoctrineUserProvider::retrieveById`, so I need to open a PR to fix this
 Because of the problem described above, I needed to override some class from vendor.
 Files can be removed after LaravelDoctrine community merge the fix:
    - `\App\Infrastructure\Auth\DoctrineUserProvider`
    - `\App\Infrastructure\Providers\DoctrineServiceProvider`

