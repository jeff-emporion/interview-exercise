# Address book

## Requirements
  - Implement Address book management - persons, their contacts and addresses
  - REST API with at least 2 endpoints
  - Database
  - Symfony
  - **When done**, create PR to https://github.com/jeff-emporion/interview-exercise

## Design

### Assumptions
- We are making PoC
- No authorisation required
- Person has many Contacts, and Contact has many types of fields(email, work phone, personal phone, etc)
- Because it's a PoC, we're going to do testing with PHPStorm HTTPClient

### Entities
  - Person
    - id
    - name
    - contacts oneToMany(Contact)
    - createdAt
    - updatedAt
  - Contact
    - id
    - name
    - person manyToOne(Person)
    - fields oneToMany(Field)
    - createdAt
    - updatedAt
  - Field
    - id 
    - value
    - createdAt
    - updatedAt
  - EmailField: Field
  - PhoneField: Field
  - NoteField: Field
  - AddressField: Field
    - country
    - city
    - postCode
    - value - for address, no validation

### Todo (for now)
  - PHP 8.1
  - Symfony 6
  - Doctrine with migrations
  - docker-compose.yml (maybe there is dedicated nice image for symfony 6 + docker + db)
  - HTTPClient tests
  - MySQL8/SQLite
  - *Show-off something, maybe RoadRunner or OpenSwoole http workers*
