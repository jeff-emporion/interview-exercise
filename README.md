# Address book

### Run
  - `docker-compose up`
  - Test (PHPStorm only) by right clicking on tests/main.http and `Run all`

### Requirements
  - Implement Address book management - persons, their contacts and addresses
  - REST API with at least 2 endpoints
  - Database
  - Symfony
  - **When done**, create PR to https://github.com/jeff-emporion/interview-exercise

### Assumptions
  - We are making PoC
  - No authorisation required
  - Person has many Contacts, and Contact has many types of fields(email, work phone, personal phone, etc)
  - Because it's a PoC, we're going to do testing with PHPStorm HTTPClient

### ToDo's or possible improvements
  - Move Controller to some kind of generic handler
  - Project probably is database agnostic?
  - Fine tune serializer DateTime and etc.

### Resources
  - https://github.com/dunglas/symfony-docker
